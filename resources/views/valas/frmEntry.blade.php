<div class="panel panel-default">
    <div class="panel-body">
    
    @if (session('success'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Pesan:</strong> {{ session('success') }}
        </div>
    @endif
        <form id="frmEntryValas" action="{{ route('postentry.valas') }}" method="POST" role="form">
            {{ csrf_field() }}
            <legend>Entry Data Valas</legend>
            <div class="form-group">
                <label for="">Prefix</label>
                <input type="text" class="form-control" id="prefix" placeholder="Prefix" name="prefix">
            </div>
            <div class="form-group">
                <label for="">Nama Valas</label>
                <input type="text" class="form-control" id="" placeholder="Nama Valas" name="nama_valas">
            </div>
            <div class="form-group">
                <label for="">Nama Valas</label>
                <input type="text" class="form-control" id="" placeholder="Deskripsi" name="deskripsi">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-primary">Batal</button>
        </form>
    </div>
</div>