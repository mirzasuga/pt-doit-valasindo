@extends('layouts.dashboard')
@section('title','Dashboard - Mitra')
@section('content')


<div class="row">
    <div class="col-lg-offset-2 col-xs-8 col-sm-8 col-md-8 col-lg-8">
        
        <div class="panel panel-default">
            <div class="panel-body">
                <form method="POST" role="form">
                    <div class="form-group">
                        <label for="">Nama Mitra</label>
                        <input type="text" class="form-control" v-model="">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" v-model="">
                    </div>
                    <div class="form-group">
                        <label for="">Telepon</label>
                        <input type="text" class="form-control" v-model="">
                    </div>
                    <div class="form-group">
                        <label for="">Fax</label>
                        <input type="text" class="form-control" v-model="">
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Mitra</label>
                        <textarea class="form-control" rows="3" required="required">
                        </textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        
        <div class="panel panel-default">
            <div class="panel-body">
                
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
        
    </div>
    
</div>


@endsection