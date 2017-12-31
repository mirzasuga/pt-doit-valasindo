@extends('layouts.dashboard')
@section('title','Bukti Terima Uang Pembelian Stok Valas')
@section('content')
<style>
.hidden {
  display: none !important;
}
.padding-5 {
  padding: 0 5px !important;
}
</style>

<bbsv></bbsv>

@endsection

@section('readyJS')
<script>
// $("#file_kuitansi").on('change', function() {
//   readUrl(this);
// });

// function readUrl(input) {
//   console.log(input.files);
//   if(input.files && input.files[0]) {
//     var reader = new FileReader();
//     reader.onload = function(e) {
//       $("#prev_kuit").attr('src',e.target.result);
//     }
//     reader.readAsDataURL(input.files[0]);
//   }
// }
</script>
@endsection