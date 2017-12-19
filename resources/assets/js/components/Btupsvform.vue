<template>
<div class="panel panel-default">
    <div class="panel-body">
        <form method="POST" role="form">
            <legend>Bukti Terima Uang Pembelian Stok Valas</legend>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Tanggal Terima</label>
                    <input type="date" class="form-control" id="" placeholder="Input field" v-model="tgl_terima">
                </div>
                <div class="form-group">
                    <label for="">Total Terima</label>
                    <input type="text" class="form-control" id="" placeholder="Input field" v-model="total_terima">
                </div>
                <div class="form-group">
                    <label for="">Diterima Oleh</label>
                    <br>
                    <select v-model="penerima" v-on:change="changePenerima" class="form-control" placeholder="Pilih Jenis">
                        <option v-for="purchasing in purchaser" v-bind:value="purchasing.user_id">{{ purchasing.nama_user }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Keperluan</label>
                    <textarea cols="30" rows="3" class="form-control" v-model="keperluan"></textarea>
                </div>
                <button type="button" class="btn btn-primary" v-on:click="simpanBtupsv">Submit</button>
            </div>
            <div class="col-md-6">
                <div class="form-group col-sm-8">
                    <label for="">No.PPSV</label>
                    <div class="input-group">
                        <input type="text" class="form-control" readonly v-model="ppsv_id">
                        <span class="input-group-btn">
                            <a href="#myModal" role="button" class="btn btn-primary" data-toggle="modal">Cari</a>
                        </span>
                    </div><!-- /input-group -->
                </div>
            </div>
        </form>
    </div>

<div id="myModal" class="modal fade" style="z-index:9999999999999999 !important;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Approval</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" name="" id="" class="form-control" v-model="q_ppsv">
                </div>
                <table class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No.PPSV</th>
                            <th>Status</th>
                            <th>Tanggal Permintaan</th>
                            <th>Total Rupiah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="ppsv in ppsvs" v-on:click="ppsvSelected(ppsv)">
                            <td>{{ppsv.ppsv_id}}</td>
                            <td>{{ ppsv.status }}</td>
                            <td>{{ ppsv.tgl_permintaan }}</td>
                            <td>{{ ppsv.total_rupiah }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<div id="modalCetak" class="modal fade" style="z-index:9999999999999999 !important;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Cetak BTUPSV</h4>
            </div>
            <div class="modal-body">
                <h4>Berhasil menyimpan Bukti Terima Uang Pembelian Stok Valas</h4>
            </div>
            <div class="modal-footer">
                <a v-bind:href="linkCetak" type="button" class="btn btn-primary" v-on:click="cetak" target="_blank">Cetak</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


</div>
</template>

<script>
    export default {
        data() {
            return {
                tgl_terima: '',
                total_terima:'',
                keperluan: '',
                penerima: '',
                ppsv_id:'',
                q_ppsv:'',
                ppsvs: [],
                purchaser:[],
                urls: [],
                rowClicks:0,
                last_insert:{},
                linkCetak:'',
            }
        },
        created() {
            this.$http.get(configURLs).then(res => {
                this.urls = res.data.urls;
            });
        },
        watch: {
            q_ppsv:function(val) {
                if(val !== '') {
                    this.fetchPpsv();
                }
            },
            urls: function(val) {
                if(val !== '') {
                    this.fetchPurchaserAll();
                }
            }
        },
        methods: {
            changePenerima() {
                console.log('changed');
            },
            fetchPpsv() {
                let url = this.urls.ppsv_approved+'/'+this.q_ppsv;
                this.$http.get(url).then(res => {
                    this.setPpsv(res.data.ppsv);
                });
                console.log();
            },
            fetchPurchaserAll() {
                let url = this.urls.put_user_all+'/4';
                this.$http.get(url).then(res => {
                    this.purchaser = res.data.purchaser;
                    console.log(res.data);
                });
            },
            setPpsv(ppsv) {
                this.ppsvs = ppsv;
            },
            setTotalTerima(val) {
                this.total_terima = val;
            },
            setPpsvId(val) {
                this.ppsv_id = val;
            },
            ppsvSelected(ppsv) {
                console.log(ppsv);

                this.setTotalTerima(ppsv.total_rupiah);
                this.setPpsvId(ppsv.ppsv_id);
                $('#myModal').modal('toggle');
            },
            simpanBtupsv() {
                let post = {
                    ppsv_id: this.ppsv_id,
                    receiver_id: this.penerima,
                    total_terima: this.total_terima,
                    keperluan: this.keperluan,
                    tgl_btupsv: this.tgl_btupsv
                };
                let url = this.urls.btupsv_store;
                this.$http.post(url,post).then(res => {
                    let data = res.data;
                    if(data.status === 200) {
                        let last_insert = {
                            id: data.last_insert,
                            inserted : data.data,
                        };
                        this.generateCetak(last_insert);
                    }
                });
            },

            generateCetak(data) {
                this.linkCetak = this.urls.btupsv_cetak+'/'+data.id;

                $("#modalCetak").modal("toggle");
            },
            cetak() {
                $("#modalCetak").modal("toggle");
                this.clearForm();
            },
            clearForm() {
                this.tgl_terima = '';
                this.total_terima = 0;
                this.keperluan = '';
                this.ppsv_id = '';
                this.penerima = '';
                this.ppsvs = [];
                this.q_ppsv = '';
                this.last_insert = {};
                this.linkCetak = '';
            },
        },

    }
</script>
