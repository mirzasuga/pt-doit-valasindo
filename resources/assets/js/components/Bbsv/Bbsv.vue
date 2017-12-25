<template>
    <app-bbsv-form></app-bbsv-form>
</template>

<script>
  // import Uploadkuitansi from './Uploadkuitansi.vue';
  import BbsvForm from './BbsvForm.vue';
  export default {
    data() {
      return {
        
      }
    },
    components: {
      'app-bbsv-form' : BbsvForm,
      // 'app-uploadkuitansi' : Uploadkuitansi
    },
    methods: {
      testd() {
        console.log('testd');
      }
    }
  }
</script>
