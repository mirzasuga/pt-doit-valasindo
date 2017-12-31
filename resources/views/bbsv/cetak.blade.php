<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <title>Berita Acara Pembelian Stok Valas</title>
</head>
<body>
<style>
.kontent_cetak {
    background:white;
}
.kop {
    padding:30px;
    border: dashed grey;
    min-height:100px;
}
.body_cetak {
    padding: 50px 100px !important;
}
.body_heading {
    margin-bottom : 30px !important;
}
.footer_cetak {
    padding-top:180px;
    padding-bottom:90px;
    font-size:1.1em;
}

</style>
    <div class="container">
    
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="kontent_cetak">
                    <div class="kop">
                        <img src="/public/images/kop.png" alt="">
                    </div>
                    <div class="container">
                        <div class="col-lg-12 body_cetak">
                            <h3 class="text-center"><strong>BERITA ACARA PEMBELIAN STOK VALAS</strong></h3>
                            <hr>
                            <div class="row body_heading">
                            
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <p>No: BBSV/{{ $bbsv->bbsv_id }}/2017;</p>
                                    <br>
                                </div>
                                <div class="col-xs-8 col-sm-6 col-md-8 col-lg-8">
                                    <p class="pull-right">Jakart, {{ date('d-m-Y') }}</p>
                                </div>
                            </div>
                                <p align="left" style="padding-left:30px;">
                                    Pada tanggal {{ $bbsv->tgl_bbsv }} telah dilakukan pembelian stok valas berdasarkan nomor permintaan <b>#{{ $bbsv->ppsv->ppsv_id }}</b> yang telah disetujui dengan rincian sebagai berikut:
                                </p>
                                <label align="left" style="padding-left:30px;" for="">Rincian Pembelian</label>                                
                                <div class="row">
                                  <div class="col-lg-offset-1 col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                    <table class="table table-bordered table-hover">
                                      <thead>
                                        <tr>
                                          <th>Mitra</th>
                                          <th>Valas</th>
                                          <th>Amount</th>
                                          <th>Rate</th>
                                          <th>Rupiah / Equivalent</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($ppsv as $p)
                                        <tr>
                                          <td>{{ $p->mitra->nama }}</td>
                                          <td>{{ $p->valas->prefix }}</td>
                                          <td>{{ $p->pivot->amount }}</td>
                                          <td>{{ $p->pivot->rate }}</td>
                                          <td><span class="pull-right">{{ $p->pivot->nominal_rupiah }}</span></td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                          <td colspan="4"><strong class="pull-right">Total</strong></td>
                                          <td><strong class="pull-right"> {{ $bbsv->ppsv->total_rupiah }}</strong></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>

                                <p>Demikian berita acara ini dibuat sebagai bukti telah dilakukan pembelian stok valas.</p>
                        </div>
                    </div>
                    <div class="container">
                        <div class="col-lg-12 footer_cetak">
                            <div class="col-lg-6 text-center">
                                <p>( {{ $bbsv->ppsv->stafPembelian->nama_user }} )</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</body>
</html>