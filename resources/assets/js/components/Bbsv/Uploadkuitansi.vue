<template @changeImage=changeImage($event)>
<div class="panel panel-default">
    <div class="panel-body">
      <label for="">Kuitansi Pembelian</label>
      <label class="btn btn-default"> 
          <img id="prev_kuit" :src="image" class="upload-pre-md" alt="Pilih File Kuitansi">
          <input type="file" name="kuitansi_pembelian" class="hidden" id="file_kuitansi" v-on:change="onFileChange">
          <input type="hidden">
          <!-- <input type="hidden" :value="isReadyToUpload"> -->
      </label>
    </div>
</div>
</template>

<script>
  export default {
    //name:'Uploadkuitansi',
    props:['img'],
    data() {
      return {
        urls:[],
        image:'https://www.metatube.com/assets/metatube/video/img/Upload.svg',
        uploadIsDone: false,
      }
    },
    
    created() {
      this.$http.get(configURLs).then(res => {
          this.urls = res.data.urls;
      });
    },
    events: {
      eventIsReadyToUpload: function(arg) {
        console.log('from events');
      }
    },
    methods: {
      onFileChange(e) {
        let files = e.target.files || e.dataTransfer.files;
        if(!files) {
          return;
        }
        this.createImage(files[0]);
        //this.$emit('eventIsReadyToUpload',this.image);
      },
      createImage(file) {
        let reader = new FileReader();
        let vm = this;
        reader.onload = (e) => {
          vm.image = e.target.result;
          this.$emit('eventIsReadyToUpload',e.target.result);
        };
        reader.readAsDataURL(file);
        //console.log(vm);
      },
      changeImage(event) {
        console.log(event);
      }
    }
  }
</script>