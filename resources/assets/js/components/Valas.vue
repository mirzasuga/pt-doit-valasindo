<template>
<div class="row">
    
    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
        <div class="panel panel-default">
            <div class="panel-body">
            
                <form id="form_valas" method="POST" v-on:submit.prevent="createValas">
                    <legend>Entry Data Valas</legend>
                
                    <div class="form-group">
                        <label for="">Currencies</label>
                        <input type="text" class="form-control prefix" id="prefix" placeholder="" v-on:keyup="upperPrefix" v-model="valas.prefix">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Valas</label>
                        <input type="text" class="form-control nama_valas" id="nama_valas" placeholder="Nama Valas" v-model="valas.nama_valas">
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi</label>
                        <input type="text" class="form-control deskripsi" id="deskripsi" placeholder="Deskripsi" v-model="valas.deskripsi">
                    </div>
                    <div class="form-group">
                        <label for="">Stok</label>
                        <input type="text" class="form-control stok" id="stok" placeholder="Deskripsi" v-model="valas.stok">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    
    
    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <div class="form-group has-feedback">
                        <input type="text" placeholder="cari" class="form-control" v-on:keyup="cariValas" v-model="searchKeyword.q"/>
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Currencies</th>
                            <th>Nama Valas</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="valas in dataValas">
                            <td>{{ valas.prefix }}</td>
                            <td>{{ valas.nama_valas }}</td>
                            <td>{{ valas.stok }}</td>
                            <td>
                                <a href="#myModal" role="button" class="btn btn-large btn-primary" data-toggle="modal" v-on:click="editValas" v-bind:id="valas.valas_id">E</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" style="z-index:9999999999999999 !important;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Ubah Data Valas</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="form_edit"></form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" v-on:click="confirmUbah">Ubah</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return{
            dataValas:[],
            valas:{
                prefix:'',
                nama_valas:'',
                deskripsi:'',
                stok:0,
            },
            urls:[],
            searchKeyword : { q : ''},
            editedRow:{},
            
        }
    },
    created(){
        this.fetchDataValas();
        this.$http.get(configURLs).then(res => {
            console.log(res.data);
            this.urls = res.data.urls;
            
        });
    },
    methods: {
        cariValas(e) {
            
            if(e.code === "Enter") {
                this.$http.post('valas/cari',this.searchKeyword).then(res=> {
                    this.dataValas = res.data.search_result;
                });
            } else {
                if(this.searchKeyword.q.length <= 0) {
                    this.fetchDataValas();
                }
            }
        },
        createValas() {
            this.$http.post('valas/store',this.valas).then(res => {
                //this.dataValas.push(res.data.valas);
                this.fetchDataValas();
                this.clear();
            }, res => {
                let msg = '';
                if(res.status === 422) {
                    if(res.data.errors.nama_valas !== undefined) {
                        res.data.errors.nama_valas.map(er => {
                            msg += er + "\n";
                        });
                    }
                    if(res.data.errors.prefix !== undefined) {
                        res.data.errors.prefix.map(er => {
                            msg += er + "\n";
                        });
                    }
                    if(res.data.errors.stok !== undefined) {
                        res.data.errors.stok.map(er => {
                            msg += er + "\n";
                        });
                    }
                    alert(msg);
                }
            });
        },
        clear() {
            this.valas = {
                prefix:'',
                nama_valas:'',
                deskripsi:'',
                stok:0,
            };
        },
        editValas(e) {
            let row;
            this.dataValas.map(function(item){
                if(item.valas_id == e.target.id) {
                    row = {
                        valas_id: item.valas_id,
                        prefix: item.prefix,
                        deskripsi: item.deskripsi,
                        nama_valas:item.nama_valas,
                        stok: item.stok,
                    };
                }
            });
            this.showModalEdit(row);
            console.log(row);
        },
        showModalEdit(data) {
            let form = $("#form_valas").html();
            $("#form_edit").html(form);
            $("#form_edit").find("button").remove();
            $("#form_edit").find("legend").remove();
            $("#form_edit").append("<input type='hidden' value='"+data.valas_id+"' class='valas_id'>");
            let prefix      = $("#form_edit").find(".prefix").val(data.prefix);

            $("#form_edit").find(".prefix").attr("readonly",true);

            $("#form_edit").find(".nama_valas").val(data.nama_valas);
            $("#form_edit").find(".deskripsi").val(data.deskripsi);
            $("#form_edit").find(".stok").val(data.stok);
        },
        confirmUbah() {
            let url = this.urls.valas_edit;
            let post = {
                prefix      : $("#form_edit").find(".prefix").val(),
                nama_valas        : $("#form_edit").find(".nama_valas").val(),
                deskripsi   : $("#form_edit").find(".deskripsi").val(),
                stok        : $("#form_edit").find(".stok").val(),
                valas_id    : $("#form_edit").find(".valas_id").val(),
            };
            this.$http.post(url,post).then(res => {
                if(res.ok) {
                    this.fetchDataValas();
                    alert('Berhasil merubah data valas');
                }
            }, res => {
                console.log(res.data);
                if(res.data.errors.stok !== undefined) {
                    let msg = '';
                    res.data.errors.stok.map(er => {
                        msg += er + '\n';
                    });
                    alert(msg);
                }
                if(res.data.errors.nama_valas !== undefined) {
                    let msg = '';
                    res.data.errors.nama_valas.map(er => {
                        msg += er + '\n';
                    });
                    alert(msg);
                }
            });
        },
        fetchDataValas(){
            this.$http.get('valas/all').then(response => {
                this.dataValas = response.data.valas;
            });
        },
        onClickEdit() {

        },
        upperPrefix() {
            this.valas.prefix = this.valas.prefix.toUpperCase();
        },
    }
}
    
</script>