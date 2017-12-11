<template>
    
<div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <form method="POST" role="form" v-on:submit.prevent="createMitra">
                    <div class="form-group">
                        <label for="">Nama Mitra</label>
                        <input type="text" class="form-control" v-model="mitra.nama">
                    </div>
                    <div class="form-group">
                        <label for="">Telepon</label>
                        <input type="text" class="form-control" v-model="mitra.telepon">
                    </div>
                    <div class="form-group">
                        <label for="">Fax</label>
                        <input type="text" class="form-control" v-model="mitra.fax">
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Mitra</label>
                        <textarea class="form-control" rows="3" required="required" v-model="mitra.alamat">
                        </textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <span class="btn btn-default" v-on:click="clearForm">Batal</span>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
        
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <div class="form-group has-feedback">
                        <input type="text" placeholder="cari" class="form-control" v-on:keyup="txtSearchKeyup" v-model="searchKeyword.q"/>
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Fax</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="mitra in mitras">
                            <td>{{ mitra.nama }}</td>
                            <td>{{ mitra.telepon }}</td>
                            <td>{{ mitra.fax }}</td>
                            <td>{{ mitra.alamat }}</td>
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
            return {
                mitras: [],
                mitra: {
                    nama_mitra: '',
                    telepon:'',
                    fax:'',
                    alamat:''
                },
                searchKeyword: {q:''},
            }
        },
        created() {
            this.fetchDataMitra();
        },
        methods: {
            fetchDataMitra() {
                this.$http.get('mitra/all').then(res => {
                    this.mitras = res.data.mitras;
                });
            },
            createMitra() {
                this.$http.post('mitra/store',this.mitra).then(res => {
                    this.mitras.push(res.data.mitra);
                    this.clearForm();
                });
            },
            clearForm() {
                this.mitra = {
                    nama:'',
                    telepon:'',
                    fax:'',
                    alamat:'',
                };
            },
            txtSearchKeyup(e) {
                if(e.code === "Enter") {
                    this.fetchSearch();
                }
                else {
                    if((this.searchKeyword.q.length <= 0)) {
                        this.fetchDataMitra();
                    }
                }
            },
            fetchSearch() {
                this.$http.get('mitra/search/'+this.searchKeyword.q).then(res => {
                    this.mitras = res.data.search_result;
                });
            },
        },
    }
</script>