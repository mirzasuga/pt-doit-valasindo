<link rel="stylesheet" href="{{mix('css/app.css')}}">
<style>
    body{
  background:#EEE;
  /* font-size:0.9em !important; */
}
.invoice{
  width:970px !important;
  margin:50px auto;
  .invoice-header{
    padding:25px 25px 15px;
    h1{
      margin:0
    }
.media{
    font-size:0.2em;
    .media-body{
    font-size:.2em;
    margin:0;
    }
}
}
body > div > div.invoice-header > div > div.col-xs-4 > div > ul > li{
    font-size:0.2em !important;
}
  .invoice-body{
    border-radius:10px;
    padding:25px;
    background:#FFF;
  }
  .invoice-footer{
    padding:15px;
    font-size:0.9em;
    text-align:center;
    color:#999;
  }
}
.logo{
  max-height:70px;
  border-radius:10px;
}
.dl-horizontal{
  margin:0;
  dt{
        float: left;
        width: 80px;
        overflow: hidden;
        clear: left;
        text-align: right;
        text-overflow: ellipsis;
        white-space: nowrap;
  }
  dd{
    margin-left:90px;
  }
}
body > div > div.invoice-body > div.panel.panel-default > table > thead > tr > td {
    font-size:.8em !important;
}
.rowamount{
  padding-top:15px !important;
}
.rowtotal{
  font-size:1.3em;
}
.colfix{
  width:12%;
}
.mono{
  font-family:monospace;
}
body > div > div.invoice-body > i > div > div > div > table > thead > tr > td {
    font-size:0.7em;
}

</style>
<div class="container invoice">
<div class="invoice-header">
  <div class="row">
    <div class="col-xs-8">
      <h1>NOTA {{ $kwitansi['jenis_tukar'] }}<small></small></h1>
      <h4 class="text-muted">NO: {{ $kwitansi['no_kuitansi'] }} | Date: {{ $kwitansi['tanggal_cetak'] }}</h4>
    </div>
    <div class="col-xs-4">
      <div class="media">
        <div class="media-left">
          <img class="media-object logo" src="https://dummyimage.com/70x70/000/fff&text=ACME" />
        </div>
        <ul class="media-body list-unstyled">
          <li><strong>PT.DO IT VALASINDO</strong></li>
          <li><i>Authorized Money Changer</i></li>
          <li>Izin BI: BI 7/18/KEP.DIR.PM/2005</li>
          <li>Jl.ciledug raya no.103c Cipulir Jakarta Selatan</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="invoice-body">
  <div class="panel panel-default">
    <table class="table table-bordered table-condensed">
      <thead>
        <tr>
          <td class="text-center col-xs-1">JENIS VALUTA ASING</td>
          <td class="text-center col-xs-1">JUMLAH/AMOUNT</td>
          <td class="text-center col-xs-1">RATE</td>
          <td class="text-center col-xs-1">RUPIAH/EQUIVALENT</td>
        </tr>
      </thead>
      <tbody>
        @foreach($kwitansi['detil'] as $detil)
        <tr>
          <th class="text-center rowtotal mono">{{ $detil['jenis_valas'] }}</th>
          <th class="text-center rowtotal mono">{{ $detil['jumlah_amount'] }}</th>
          <th class="text-center rowtotal mono">{{ $detil['harga_satuan'] }}</th>
          <th class="text-center rowtotal mono">{{ $detil['nominal_rupiah'] }}</th>
        </tr>
        @endforeach
        <tr>
            <th colspan="2"></th>
            <th class="rowtotal mono"> <span class="pull-right">Jumlah:</span></th>
            <th class="text-center rowtotal mono">{{ $kwitansi['jumlah_total'] }}</th>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="row">
    <div class="col-xs-7">
      <div class="panel panel-default">
        <div class="panel-body">
          <i>Perhatian / Notice</i>
          <hr style="margin:3px 0 5px" />
            <u>Kekurangan Penerimaan uang tidak ditanggung setelah diluar loket kami</u>
            <br/>
            <i>Claim for shortage or cash after leaving our premises cannot be considered
        </div>
      </div>
    </div>
    <div class="col-xs-5">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Pengesahan/Legalization</h3>
        </div>
        <div class="panel-body">
            <div style="height:40px;"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
        <table class="table table-bordered table-condensed">
            <thead>
            <tr>
                <td class="text-center col-xs-1">SIGNATURE</td>
                <td class="text-center col-xs-1">CHECKER</td>
                <td class="text-center col-xs-1">KASIR/CASHIER</td>
                <td class="text-center col-xs-1">TELLER</td>
            </tr>
            </thead>
            <tbody>
            
            <tr height="80px">
                <th class="text-center rowtotal mono"></th>
                <th class="text-center rowtotal mono"></th>
                <th class="text-center rowtotal mono"></th>
                <th class="text-center rowtotal mono">( {{ $kwitansi['teller'] }} )</th>
            </tr>
            
            </tbody>
        </table>
        </div>
    </div>
  </div>

</div>

</div>