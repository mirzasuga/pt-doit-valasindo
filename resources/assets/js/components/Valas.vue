<template>
<div class="row">
    
    <div class="col-lg-offset-1 col-xs-5 col-sm-5 col-md-5 col-lg-5">
        <div class="panel panel-default">
            <div class="panel-body">
            
                <form method="POST" v-on:submit.prevent="createValas">
                    <legend>Entry Data Valas</legend>
                
                    <div class="form-group">
                        <label for="">Currencies</label>
                        <input type="text" class="form-control" id="" placeholder="" v-on:keyup="upperPrefix" v-model="valas.prefix">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Valas</label>
                        <input type="text" class="form-control" placeholder="Nama Valas" v-model="valas.nama_valas">
                    </div>
                    <div class="form-group">
                        <label for="">Deskripsi</label>
                        <input type="text" class="form-control" id="" placeholder="Deskripsi" v-model="valas.deskripsi">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    
    
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="valas in dataValas">
                            <td>{{ valas.prefix }}</td>
                            <td>{{ valas.nama_valas }}</td>
                            <td><button class="btn btn-small btn-default" v-on:click="editValas" v-bind:id="valas.valas_id">e</button></td>
                        </tr>
                    </tbody>
                </table>
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
            },
            searchKeyword : { q : ''},
        }
    },
    created(){
        this.fetchDataValas();
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
                this.dataValas.push(res.data.valas);
                this.clear();
            });
        },
        clear() {
            this.valas = {
                prefix:'',
                nama_valas:'',
                deskripsi:''
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
                        nama_valas:item.nama_valas
                    };
                }
            });
            console.log(row);
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