<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <title>Bukti Terima Uang Pembelian Stok Valas</title>
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
                            <h3 class="text-center"><strong>BUKTI TERIMA UANG PEMBELIAN STOK VALAS</strong></h3>
                            <hr>
                            <div class="row body_heading">
                            
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <p>No: BKT/[NOMORSURAT]/2017;</p>
                                    <br>
                                    <label for="">To: </label>
                                    <p>
                                        [Penerima]
                                        <br>
                                        [Jenis staff]
                                    </p>
                                </div>
                                <div class="col-xs-8 col-sm-6 col-md-8 col-lg-8">
                                    <p class="pull-right">Jakart, {{ date('d-m-Y') }}</p>
                                </div>
                            </div>
                                <p align="left" style="padding-left:30px;">
                                    Pada (tanggal) berdasarkan Surat Permintaan Pembelian Stok Valas yang telah disetujui dengan nomor permintaan <strong>(nomor permintaan)</strong>,
                                    kami yang bertanda tangan dibawah ini :
                                </p>
                                <ol>
                                    <div class="row">
                                        <li>
                                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                                Nama<br>  
                                                NIK<br>
                                                Jabatan<br> 
                                                Alamat<br>
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                : (nama teller) <br>
                                                : (nik) <br>
                                                : TELLER <br>
                                                : (alamat teller) , yang selanjutnya disebut sebagai <u>PIHAK PERTAMA</u>
                                            </div>
                                        </li>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <li>
                                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                                Nama<br>  
                                                NIK<br>
                                                Jabatan<br> 
                                                Alamat<br>
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                : (Nama Staff Purchasing) <br>
                                                : (nik) <br>
                                                : Staf Purchasing <br>
                                                : (alamat staf purchasing) , yang selanjutnya disebut sebagai <u>PIHAK KEDUA</u>
                                            </div>
                                        </li>
                                    </div>
                                </ol>
                                <p>Dengan ini kedua belah pihak, mengadakan serah terima uang sebesar <b>Rp, 999.999.999</b> untuk pembelian stok valas oleh PIHAK KEDUA.</p>
                        </div>
                    </div>
                    <div class="container">
                        <div class="col-lg-12 footer_cetak">
                            <div class="col-lg-6 text-center">
                                <p>( MIRZA )</p>
                            </div>
                            <div class="col-lg-6 text-center">
                                <p>( MIRZA )</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</body>
</html>