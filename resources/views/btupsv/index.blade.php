@extends('layouts.dashboard')
@section('title','Bukti Terima Uang Pembelian Stok Valas')
@section('content')
<section id="btupsv">
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <btupsvform></btupsvform>
    </div>
</div>
</section>



@endsection




@section('readyJS')
<script>
    const v = new Vue({

    });
</script>
@endsection