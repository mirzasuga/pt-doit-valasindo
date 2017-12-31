<template>
<form action="" method="POST" role="form">
    
  <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 padding-5">
        <div class="panel panel-default">
          <div class="panel-body">
              <legend>Form title</legend>
              <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"> 
                  <div class="form-group">
                    <label for="">Tanggal Bukti</label>
                    <input type="date" name="tgl_bbsv" v-model="tgl_bbsv" class="form-control" id="tgl_bbsv" placeholder="Input field">
                  </div>
                  <div class="form-group">
                    <label for="">Nomor Permintaan</label>
                    <div class="input-group">
                      <input type="text" name="no_permintaan" v-model="no_permintaan" class="form-control" id="no_permintaan" placeholder="Input field" readonly>
                      <span class="input-group-btn">
                        <button type="button" @click="toggleModal" class="btn btn-default">Cari Ppsv</button>
                      </span>
                    </div><!-- /input-group -->
                    
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"> 
                  <div class="form-group">
                    <label for="">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" v-model="keterangan" cols="30" rows="4" class="form-control"></textarea>
                  </div>
                </div>
              </div>
              
          </div>
        </div>
      </div>

      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <uploadkuitansi @eventIsReadyToUpload="listenerIsReadyToUpload($event)" :img="img"></uploadkuitansi>
      </div>
  </div>

  <div class="row">
    <div class="col-lg-12">

      <div class="panel panel-default">
        <div class="panel-body">
          <legend>Detil Permintaan Pembelian Stok Valas</legend>
          <table class="table table-condensed table-hover table-bordered">
            <thead>
                <tr>
                    <th>Valas</th>
                    <th>Amount</th>
                    <th>Rate</th>
                    <th>Rupiah / Equivalent</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="detil in detil_ppsv">
                    <td>{{detil.valas.prefix}}</td>
                    <td>{{ detil.pivot.amount }}</td>
                    <td>{{ detil.pivot.rate }}</td>
                    <td>{{ detil.pivot.nominal_rupiah }}</td>
                </tr>
            </tbody>
          </table>
          <button type="button" @click="store" v-if="formComplete" class="btn btn-primary">Simpan</button>
        </div>
      </div>

    </div>
  </div>

  <div id="mrModal" class="modal fade" style="z-index:9999999999999999 !important;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">(modaltitle)</h4>
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

            </div>
        </div>
    </div>
  </div>
  
  <div id="mrModalSuccess" class="modal fade" style="z-index:9999999999999999 !important;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Notifikasi</h4>
            </div>
            <div class="modal-body">
              <h4>Berhasil menyimpan data Bukti Pembelian Stok Valas denan nomor BBSV:#{{ storedData.bbsv_id }}</h4>
              <p>Untuk mencetak bukti serah stok valas, silahkan klik tombol cetak</p>
            </div>
            <div class="modal-footer">
              <a href="#" target="_blank" class="btn btn-primary">Cetak</a>
              <button type="button" class="btn btn-primary" @click="refresh">Tutup</button>
            </div>
        </div>
    </div>
  </div>


</form>
</template>
<script>
import Uploadkuitansi from './Uploadkuitansi.vue';

export default {
  components:{
    'uploadkuitansi': Uploadkuitansi,
  },
  created() {
    this.$http.get(configURLs).then(res => {
        this.urls = res.data.urls;
    });
    
  },
  data() {
    return {
      urls: [],
      ppsvs:[],
      q_ppsv:'',
      tgl_bbsv:'',
      keterangan:'',
      kuitansiWillUpload:'',
      kuitansiUploaded : '',
      no_permintaan:'',
      detil_ppsv:[],
      img: '',
      storedData:[],

      formComplete:false,
      storedComplete:false,
    }
  },
  mounted: function() {
    this.checkFormComplete();
  },
  watch: {
    q_ppsv:function(val) {
      if(val !== '') {
        this.fetchPpsv(val);
      }
    },
    storedComplete: function(val) {
      console.log(val);
      if(val) {
        this.clearForm();
        this.toggleModalSuccess();
      }
    },
    
    tgl_bbsv: function(val) {
      this.checkFormComplete();
    },
    no_permintaan: function(val) {
      this.checkFormComplete();
    },
    keterangan: function(val) {
      this.checkFormComplete();
    },
    kuitansiWillUpload: function(val) {
      this.checkFormComplete();
    },
  },
  methods: {
    store() {
      this.uploadKuitansi();
      this.storeBbsv();
    },
    clearForm() {
              this.keterangan   = '';
              this.url_kuitansi = '';
              this.detil_ppsv   = '';
              this.no_ppsv      = '';
              this.tgl_bbsv     = '';
              this.no_permintaan= '';
              this.ppsv         = [];
              this.storedComplete = false;
    },
    fetchPpsv(q) {
      let url = this.urls.ppsv_approved+'/'+q+'/detil';
      this.$http.get(url).then(res => {
          this.ppsvs = res.data.ppsv;
      });
    },
    checkFormComplete() {
      if(this.tgl_bbsv !== '' && this.no_permintaan !== '' && this.keterangan !== '' && this.kuitansiWillUpload !== '') {
        this.formComplete = true;
      }
      else {
        this.formComplete = false;
      }
    },
    keyupQPpsv(value) {
      console.log(value);
    },
    toggleModal() {
      $("#mrModal").modal('toggle');
    },
    toggleModalSuccess() {
      $("#mrModalSuccess").modal('toggle');
    },
    listenerIsReadyToUpload(file) {
      this.kuitansiWillUpload = file;
    },
    setUploadedKuit(name) {
      this.kuitansiUploaded = name;
    },
    uploadKuitansi() {
      let url = this.urls.bbsv_upload_kuitansi;
      let file = {
        kuitansi_pembelian: this.kuitansiWillUpload,
      };
      this.$http.post(url,file).then(res => {
        let data = res.data;
        if(data.status == 200) {
          this.setUploadedKuit( data.uploaded );
        }
        else {
          alert(data.message);
        }
      });
    },
    storeBbsv() {
      let that = this;
      setTimeout(function() {
        if(that.kuitansiUploadTried < 3 && that.kuitansiUploaded == '') {
          console.log('waiting file uploaded');
          console.log(that.kuitansiUploadTried);
          that.storeBbsv();
          that.kuitansiUploadTried +=1;
        }
        else {
          if(that.kuitansiUploaded == '' && that.kuitansiUploadTried > 3) {
            console.log('gagal upload');
          }
          else {
            let url = that.urls.bbsv_store;
            let data = {
              tgl_bbsv      : that.tgl_bbsv,
              keterangan    : that.keterangan,
              url_kuitansi  : that.kuitansiUploaded,
              detil_ppsv    : that.detil_ppsv,
              no_ppsv       : that.no_permintaan,
            };
            that.kuitansiUploadTried = 0;
            
            that.$http.post(url,data).then(res => {
              that.storedComplete = true;
              that.storedData = res.data.bbsv;
            });
          }
        }
      },1000);
    },
    ppsvSelected(el) {
      this.no_permintaan = el.ppsv_id;
      this.detil_ppsv = el.detil_ppsv;
      this.toggleModal();
    },
    refresh() {
      this.toggleModalSuccess();
    },
    
  },
}
</script>

