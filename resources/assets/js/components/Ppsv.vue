<template>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        
        <div class="panel panel-default">
              
              <div class="panel-heading">
                    <h3 class="panel-title">Entry Permintaan Pembelian Stok Valas</h3>
              </div>
              <div class="panel-body">
              
                <div class="row" style="margin-bottom:20px;">
                    
                    <div class="container">
                        <form class="form-horizontal" role="form">
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="margin-right:1%;">
                                <div class="form-group">
                                    <label for="">Tanggal Permintaan</label>
                                    <br>
                                    <input type="text" v-model="tgl_trx" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="margin-right:1%;">
                            <div class="form-group">
                                <label for="">Mitra</label>
                                <br>
                                <select v-model="mitra" class="form-control"  placeholder="Pilih Jenis">
                                    <option v-for="mitra in mitras" v-bind:value="mitra.mitra_id">{{ mitra.nama }}</option>
                                </select>
                            </div>
                            </div>
                            
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="margin-right:1%;">
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <br>
                                <textarea v-model="keterangan" cols="10" rows="1" class="form-control"></textarea>
                            </div>
                            </div>

                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="margin-right:1%;">
                            <div class="form-group">
                                <label for="">&nbsp;</label>
                                <br>
                                <button type="button" class="btn btn-success pull-right" @click="simpan"
                                :disabled="notYetReadySubmit()">
                                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                    Selesai
                                </button>
                            </div>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                            <div class="form-group">
                                <label for="">&nbsp;</label>
                                <br>
                                <button type="button" class="btn btn-success pull-right" @click="addRow"
                                    :disabled="notYetReadyRow()"
                                >
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    Tambah
                                </button>
                            </div>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-offset-1 col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        
                        <table class="table table-hover table-bordered text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">Valas</th>
                                    <th class="text-center">Jumlah Amount</th>
                                    <th class="text-center">Harga Satuan  Rate</th>
                                    <th class="text-center">Rupah  Equivalent</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody v-bind:class="dangerClass()">
                                <tr v-for="(row,idx) in rows">
                                    <td style="width:15%;">
                                        <input v-model="row.prefix" :disabled="prefixOnRequest==true" v-on:keyup="setPrefix(idx)" maxlength="3" type="text" class="form-control" required="required" width="60%" placeholder="ex:USD">
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">{{ row.prefix }}</span>
                                            <input v-model="row.amount" v-on:keyup="onChangeAmount" type="text" class="form-control" placeholder="0" aria-describedby="basic-addon1">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">IDR</span>
                                            <input v-model="row.rate" type="text" readonly class="form-control" placeholder="0" aria-describedby="basic-addon1">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Rp</span>
                                            <input v-model="row.rupiah" type="text" readonly class="form-control" placeholder="0" aria-describedby="basic-addon1">
                                        </div>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-danger" v-on:click="removeRow(idx)">
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>
                                        Jumlah Total
                                    </td>
                                    <td id="total" colspan="2">
                                        Total : Rp, {{ total }}
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                        <div class="form-group">
                            <button type="button" class="btn btn-success pull-right" @click="addRow"
                            :disabled="notYetReadyRow()">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                Tambah
                            </button>
                        </div>
                    </div>
                </div>
              </div>

        </div>

        <div class="panel panel-default">
            
            <div id="kuitansi" class="panel-body">
                <button v-if="templateKuitansi !== ''" class="btn btn-primary" onclick="printJS({ printable: 'kuitansi', type: 'html' })">
                    Cetak
                </button>
                <span v-html="templateKuitansi"></span>
            </div>
        </div>
    </div>
</div>
</template>


<script>
    export default {
        data() {
            return {
                URLS: [],
                rows:[],
                mitras:[],
                mitra:'',
                valas: {
                    prefix:'',
                },
                keterangan:'',
                tgl_trx: TodayDate,
                jenis:'Jual',
                prefixOnRequest : false,
                total:0,
                hasErrors: false,
                errors: {
                    isRowsNull:false,
                },
                templateKuitansi:'',
            }
        },
        watch: {
            URLS: function(val) {
                if(val.length !== 0) {
                    this.fetchMitra();
                }
            },
            mitra: function(val) {
                this.fetchKursMitra(val);
            }
        },
        created() {
            this.$http.get(configURLs).then(res => {
                this.URLS = res.data.urls;
            });
        },
        computed: {
            classObject: function() {
                return (this.errors.isRowsNull) ? 'alert-danger' : '';
            }
        },
        methods: {
            dangerClass() {
                return{
                    'alert alert-danger':this.hasErrors,
                    'alert': !this.hasErrors
                }
            },
            notYetReadyRow() {
                if(this.mitra == '' || this.keterangan == '') {
                    return true;
                }
                else {
                    return false;
                }
            },
            notYetReadySubmit() {
                console.log(this.rows);
                if(this.mitra == '' || this.keterangan == '') {
                    return true;
                }
                else {
                    if(this.rows.length < 1) {
                        return true;
                    }
                    else {
                        let notYet = true
                        this.rows.map(row => {
                            if(row.prefix === '' || row.prefix.length !== 3) {
                                console.log('prefix is kosong');
                            }
                            else {
                                if(row.amount === '' || row.amount === 0 || row.amount === '0') {
                                }
                                else {
                                    notYet = false;
                                }
                            }
                        });
                        console.log(notYet);
                        return notYet;
                    }
                }
            },
            addRow() {
                var elm = document.createElement('tr');
                this.rows.push({
                    kurs_id:null,
                    prefix: '',
                    amount:0,
                    rate:0,
                    rupiah:0
                });
                this.hasErrors = false;
                this.errors.isRowsNull = false;
                this.templateKuitansi = '';
            },
            changeJenis() {
                console.log(this.jenis);
                this.hitungRupiah();
                this.hitungTotal();
            },
            onChangeAmount() {
                this.hitungRupiah();
                this.hitungTotal();
            },
            putAllValas() {
                
            },
            removeRow(idx) {
                this.rows.splice(idx,1);
                this.hitungTotal();
            },
            setPrefix(idx) {
                var prefix = this.rows[idx].prefix;
                this.rows[idx].prefix = prefix.toUpperCase();
                this.observePrefix(idx);
            },
            clearPrefix(idx) {
                this.rows[idx].prefix = '';
            },
            observePrefix(idx) {
                if(parseInt( this.rows[idx].prefix.length ) === 3) {
                    let founding = this.fetchValasRate(
                        idx,
                        this.rows[idx].prefix
                    );
                }
            },
            fetchValasRate(idx,prefix) {
                console.log(prefix);
                let founded = false;
                this.kurs_mitra.map(kurs => {
                    if(prefix === kurs.valas.prefix) {
                        this.setRate(idx,kurs.modal_jual);
                        this.setKursId(idx,kurs.kurs_id);
                        founded = true;
                    }
                });
                if(!founded) {
                    alert('Valas Pada Mitra Tidak ditemukan');
                    this.clearPrefix(idx);
                    this.setRate(idx,0);
                    this.setKursId(idx,null);
                }
                
            },
            fetchMitra() {
                let url = this.URLS.put_mitra_all
                this.$http.get(url).then(res => {
                    this.mitras = res.data.mitras;
                });
            },
            fetchKursMitra(mitra_id) {
                let url = this.URLS.get_kurs_mitra;
                this.$http.get(url+mitra_id).then(res => {
                    console.log(res.data.kurs_mitra);
                    this.kurs_mitra = res.data.kurs_mitra;
                });
            },
            prefixHttpOnRequest() {
                this.prefixOnRequest = true;
            },
            prefixHttpOnSuccess() {
                this.prefixOnRequest = false;
            },
            setRate(idx,val) {
                this.rows[idx].rate = val;
            },
            setKursId(idx,val) {
                this.rows[idx].kurs_id = val;
            },
            hitungRupiah() {
                if(this.rows.length >= 1) {
                    this.rows.map(row => {
                        row.rupiah = row.rate * row.amount;
                    });
                }
            },
            hitungTotal() {
                if(this.rows.length > 1) {
                    let total = 0;
                    this.rows.map(row => {
                         total += row.rupiah;
                    });
                    this.total = total;
                }
                else if (this.rows.length == 1) {
                    this.total = this.rows[0].rupiah;
                }
                else {
                    this.total = 0;
                }
                console.log(this.total);
            },
            simpan() {
                let url = this.URLS.ppsv_store;
                let postData = {
                    tanggal_permintaan: this.tgl_trx,
                    keterangan: this.keterangan,
                    total_rupiah: this.total,
                    kurs_ppsv : this.rows,
                    mitra_id : this.mitra
                };
                this.$http.post(url,postData).then(response => {
                    if(response.data.status === 200) {
                        this.clearForm();
                        //this.cetakKuitansi();
                        alert(response.data.message);
                        //this.requestKuitansi(response.data.tukar_id);
                        this.hasErrors = false;
                        console.log(response.data);
                    }
                    else {

                    }
                },response => {
                    if(response.status == 422) {
                        alert(response.body.errors.kurs_penukaran);
                        this.showErrors(response.body.errors);
                    }
                });
                console.log(url);
            },
            clearForm() {
                this.rows = [];
                this.valas.prefix = '';
                this.tgl_trx = TodayDate;
                this.jenis = 'Jual';
                this.total = 0;
            },
            showErrors(errors) {
                this.hasErrors = true;
                this.errors.isRowsNull = true;
                this.errors = errors;
            },
        },
    }
</script>