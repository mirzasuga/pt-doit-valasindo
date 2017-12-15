<template>
<section>
    <div class="collapse-group" v-for="item in approvals">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" :href="buildHrefUrl(item.ppsv_id)" aria-expanded="true" aria-controls="collapseOne" class="trigger collapsed">
                        <div class="row">
                            <div class="col-md-8">
                                    <label for="">
                                        ID PPSV #{{ item.ppsv_id }}<br/>
                                        <small>{{ item.tgl_permintaan }}</small>
                                    </label>
                            </div>
                            <div class="col-md-4">
                                <label for=""><i>{{ item.status }}</i></label>
                                <span class="glyphicon glyphicon-menu-down pull-right" aria-hidden="true"></span>
                            </div>
                        </div>
                    </a>
                </h4>
                
            </div>
            <div :id="item.ppsv_id" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <legend>Permintaan Pembelian Stok Valas</legend>
                            <div class="row">
                                <div class="col-xs-4">
                                    <p>Tanggal Permintaan</p>
                                </div>
                                <div class="col-xs-6">
                                    <label for="">: {{ item.tgl_permintaan }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <p>Nama Mitra</p>
                                </div>
                                <div class="col-xs-6">
                                    <label for="">: {{ item.mitra.nama }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <p>Keterangan</p>
                                </div>
                                <div class="col-xs-6">
                                    <label for="">: {{ item.keterangan }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    Dibuat oleh
                                </div>
                                <div class="col-xs-6">
                                    <label for="">: ( MIRZA )</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    Status
                                </div>
                                <div class="col-xs-6">
                                    <label for="">: <i>Menunggu Persetujuan</i></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <legend>Detil Permintaan</legend>
                            <table class="table table-condensed table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Valas</th>
                                        <th>Amount</th>
                                        <th>Rate</th>
                                        <th>Rupiah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="detil in item.detil_ppsv">
                                        <td class="text-center">{{ detil.valas.prefix }}</td>
                                        <td class="text-center">{{ detil.pivot.amount }}</td>
                                        <td class="text-center">{{ detil.pivot.rate }}</td>
                                        <td class="text-center">{{ detil.pivot.nominal_rupiah }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><span class="pull-right">Total:</span></td>
                                        <td class="text-center">Rp. 250.000.000,00-</td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="#myModal" role="button" class="btn btn-large btn-primary pull-right" data-toggle="modal" v-on:click="testModal(item.ppsv_id)">Approve</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Approval</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" v-model="ppsv_id">
                    <p>Apakah anda yakin ingin menyetujui permintaan?</p>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" v-on:click="confirmApprove">YA</button>
                </div>
            </div>
        </div>
    </div>
</section>
</template>
<script>
    export default {
        data() {
            return {
                test:'',
                approvals: [],
                urls:[],
                routerIsReady: false,
                ppsv_id:'1',
            }
        },
        watch: {
            routerIsReady: function(val) {
                console.log(val);
                if(val) {
                    this.fetchPpsv();
                    console.log('router is ready');
                }
            }
        },
        created() {
            this.fetchUrls();
        },
        methods: {
            buildHrefUrl(id) {
                return '#'+id;
            },
            fetchPpsv() {
                let url = this.urls.ppsv_all+'u';
                this.$http.get(url).then(res => {
                    console.log(res.data.approvals);
                    this.approvals = res.data.approvals;
                });
            },
            fetchUrls() {
                this.$http.get(configURLs).then(res=> {
                    this.urls = res.data.urls;
                    this.setRouterIsReady(true);
                });
            },
            setRouterIsReady(statement) {
                this.routerIsReady = statement;
            },
            testModal(id) {
                this.ppsv_id = id;
            },
            confirmApprove() {
                let url = this.urls.ppsv_approve;
                let postD = {
                    ppsv_id : this.ppsv_id
                };
                this.$http.post(url,postD).then(res => {
                    console.log(res.data);
                    this.fetchPpsv();
                });
            },
            cancelApprov() {
                this.ppsv_id = '';
            }
        }

    }
</script>
