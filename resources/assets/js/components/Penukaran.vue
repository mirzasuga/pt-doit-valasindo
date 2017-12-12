<template>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        
        <div class="panel panel-default">
              
              <div class="panel-heading">
                    <h3 class="panel-title">Entry Penukaran</h3>
              </div>
              <div class="panel-body">
              
                <div class="row" style="margin-bottom:20px;">
                    
                    <div class="container">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <form class="form-inline" role="form">
                                <div class="form-group">
                                    <label class="sr-only" for="">label</label>
                                    <input type="date" class="form-control" id="" placeholder="Input field">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="">label</label>
                                    
                                    <select class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option value="">Jual</option>
                                        <option value="">Beli</option>
                                    </select>
                                    
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-success pull-right" @click="simpan">
                                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                        Selesai
                                    </button>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-success pull-right" @click="addRow">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                        Tambah
                                    </button>
                                </div>
                            </form>
                        </div>
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
                            <tbody>
                                <tr v-for="(row,idx) in rows">
                                    <td style="width:15%;">
                                        <input v-model="row.prefix" :disabled="prefixOnRequest==true" v-on:keyup="setPrefix(idx)" maxlength="3" type="text" class="form-control" required="required" width="60%" placeholder="ex:USD">
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">{{ row.prefix }}</span>
                                            <input v-model="row.amount" v-on:keyup="hitungRupiah(idx)" type="text" class="form-control" placeholder="0" aria-describedby="basic-addon1">
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
                            <button type="button" class="btn btn-success text-center" @click="addRow">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                Tambah
                            </button>
                        </div>
                    </div>
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
                URLS: [],
                rows:[],
                valas: {
                    prefix:'',
                },
                jenis:'jual',
                prefixOnRequest : false,
                total:0,
            }
        },
        created() {
            this.$http.get(configURLs).then(res => {
                this.URLS = res.data.urls;
            });
        },
        methods: {
            addRow() {
                var elm = document.createElement('tr');
                this.rows.push({
                    prefix: '',
                    amount:0,
                    rate:0,
                    rupiah:0
                });
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
                    this.fetchValasRate(
                        idx,
                        this.rows[idx].prefix
                    );
                }
            },
            fetchValasRate(idx,prefix) {
                let url = this.URLS.put_valas_rate + '/' + prefix;

                this.$http.get(url,
                    { before:this.prefixHttpOnRequest() }
                ).then(res => {
                    console.log(res.data);
                    if(res.data.status == 200) {
                        this.setRate(idx,res.data.data);
                    }
                    else {
                        this.clearPrefix(idx);
                        alert(res.data.message);
                    }
                    this.prefixHttpOnSuccess();
                });
            },
            prefixHttpOnRequest() {
                this.prefixOnRequest = true;
            },
            prefixHttpOnSuccess() {
                this.prefixOnRequest = false;
            },
            disableInput(idx) {

            },
            enableInput(idx) {

            },
            setRate(idx,val) {
                if(this.jenis == 'jual') {
                    this.rows[idx].rate = val.jual;
                }
                else if(this.jenis == 'beli') {
                    this.rows[idx].rate = jal.beli;
                }
            },
            hitungRupiah(idx) {
                let rate    = this.rows[idx].rate;
                let amount  = this.rows[idx].amount;
                let rupiah  = amount * rate;
                this.rows[idx].rupiah = rupiah;
                this.hitungTotal();
            },
            hitungTotal() {
                if(this.rows.length > 1) {
                    this.rows.map(row => {
                        this.total += row.rupiah;
                    });
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
                console.log(this.rows);
            },
        },
    }
</script>