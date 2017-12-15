<template>
<section>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form class="form-horizontal" role="form">
                <div class="form-group col-md-3">
                    <input type="date" class="form-control" v-model="filter_tanggal">
                </div>
                <div class="form-group col-md-3">
                    <select v-model="filter_status" class="form-control">
                        <option v-for="status in statuses" :value="status.value">{{ status.name }}</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
    <div class="collapse-group" v-for="item in approvals">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" v-on:click="eventViewed(item.ppsv_id)" :href="buildHrefUrl(item.ppsv_id)" aria-expanded="true" aria-controls="collapseOne" class="trigger collapsed">
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
                            <div class="row" v-if="item.processed_at !== null">
                                <div class="col-xs-4">
                                    <p>Diproses Pada Tanggal</p>
                                </div>
                                <div class="col-xs-6">
                                    <label for="">: {{ item.processed_at }}</label>
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
                                    <label for="">: {{item.staf_pembelian.nama_user}}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    Status
                                </div>
                                <div class="col-xs-6">
                                    <label for="">: <i>{{ item.status }}</i></label>
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
                                        <td class="text-center">Rp. {{ item.total_rupiah }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="col-xs-offset-9 col-xs-1">
                                <div class="form-group">
                                    <a href="#myModal" role="button" class="btn btn-large btn-primary pull-right" data-toggle="modal" v-if="item.processed_at ==null"" v-on:click="showModal(item.ppsv_id,'a')">Approve</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <a href="#myModal" role="button" class="btn btn-large btn-danger pull-right" data-toggle="modal" v-if="item.processed_at ==null"" v-on:click="showModal(item.ppsv_id,'r')">Reject</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="myModal" class="modal fade" style="z-index:9999999999999999 !important;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Approval</h4>
                </div>
                <div class="modal-body">
                    <div v-if="jenis_approval == 'a'">
                        <input type="hidden" v-model="ppsv_id">
                        <p>Apakah anda yakin ingin menyetujui permintaan?</p>
                    </div>
                    <div class="form-group" v-if="jenis_approval =='r'">
                        <label for="">Alasan penolakan :</label>
                        <textarea cols="30" rows="10" class="form-control" v-model="alasanReject"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <div v-if="jenis_approval == 'a'">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" v-on:click="confirmApprove">YA</button>
                    </div>
                    <div v-if="jenis_approval == 'r'">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" v-on:click="confirmReject">Selesai</button>
                    </div>
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
                statuses:[
                {
                    value:'all',
                    name:'Semua Status'
                },
                {
                    value:'u',
                    name:'Menunggu Approval'
                },
                {
                    value:'a',
                    name:'Disetujui'
                },
                {
                    value:'r',
                    name:'Ditolak'
                },
                ],
                filter_status:'',
                filter_tanggal:'',
                jenis_approval:'',
                alasanReject: '',
            }
        },
        watch: {
            routerIsReady: function(val) {
                console.log(val);
                if(val) {
                    this.fetchPpsv();
                    console.log('router is ready');
                }
            },
            filter_status:function (val) {
                //console.log(val);
                this.filterPpsv();
            },
            filter_tanggal:function(val) {
                this.filterPpsv();
            }
        },
        created() {
            this.fetchUrls();
        },
        methods: {
            buildHrefUrl(id) {
                return '#'+id;
            },
            eventViewed(ppsv_id) {
                let is_viewed = true;
                if(this.approvals.length > 0) {
                    this.approvals.map(item => {
                        if(item.ppsv_id === ppsv_id) {
                            if(item.viewed_at === '' || item.viewed_at === null) {
                                is_viewed = false;
                            }
                        }
                    });
                }
                if(is_viewed) {
                    return true;
                }
                let url = this.urls.ppsv_viewed +'/'+ ppsv_id;
                this.$http.get(url).then(res => {
                    console.log(res.data.message);
                });
            },
            fetchPpsv() {
                let url = this.urls.ppsv_all+'u';
                this.$http.get(url).then(res => {
                    console.log(res.data.approvals);
                    this.approvals = res.data.approvals;
                });
            },
            filterPpsv() {
                console.log(this.filter_tanggal);
                console.log(this.urls.ppsv_filter);
                let status = (this.filter_status === '') ? 'all' : this.filter_status;
                let tgl = (this.filter_tanggal === '') ? '0000-00-00' : this.filter_tanggal;
                let url = this.urls.ppsv_filter + "/" + status +'/'+tgl;
                this.$http.get(url).then(res => {
                    this.setApprovals(res.data.ppsv);
                });
            },
            setApprovals(values) {
                this.approvals = values;
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
            showModal(id,jenis_approval) {
                this.ppsv_id = id;
                this.jenis_approval = jenis_approval;
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
            confirmReject() {
                let url = this.urls.ppsv_reject;
                let postData = {
                    ppsv_id : this.ppsv_id,
                    alasan  : this.alasanReject,
                };
                this.$http.post(url, postData).then(res => {
                    alert(res.data.message);
                    this.fetchPpsv();
                });
                console.log(this.alasanReject);
            },
            cancelApprov() {
                this.ppsv_id = '';
                this.alasan_reject='';
            }
        }

    }
</script>
