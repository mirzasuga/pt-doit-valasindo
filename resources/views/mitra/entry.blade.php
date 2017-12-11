@extends('layouts.dashboard')
@section('title','Entry Data Valas')
@section('content')

<div class="row">
    <div class="col-lg-offset-2 col-xs-8 col-sm-8 col-md-8 col-lg-8">
        <div class="panel panel-default">
        <div class="panel-heading">
                <h3 class="panel-title">Entry Data Mitra</h3>
        </div>
        <div class="panel-body">
            <form action="#" method="POST" role="form">
                <div class="form-group">
                    <label for="">Nama Mitra</label>
                    <input type="text" class="form-control" id="" placeholder="Input field">
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" class="form-control" id="" placeholder="Input field">
                </div>
                <div class="form-group">
                    <label for="">Telepon</label>
                    <input type="text" class="form-control" id="" placeholder="Input field">
                </div>
                <div class="form-group">
                    <label for="">Fax</label>
                    <input type="text" class="form-control" id="" placeholder="Input field">
                </div>
                <div class="form-group">
                    <label for="">Alamat</label>
                    <textarea name="" id="input${1/(\w+)/\u\1/g}" class="form-control" rows="3" required="required"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    </div>
</div>

@endsection