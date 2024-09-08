<div class="row">
    <center>
        <h2>Pesanan</h2>
    </center>
    <div class="col-lg-5">
        <div class="panel panel-primary">
            <div class="panel-heading">Form Pesanan</div>
            <div class="panel-body">
                <form action="">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">ID Pelanggan</label>
                            <input type="text" name="" class="form-control" readonly="readonly" value="PLGN001">
                        </div>

                        <div class="form-group">
                            <label for="ID Pelanggan">Nama Pelanggan</label>
                            <input type="text" name="" class="form-control" value="PLGN001">
                        </div>

                        <div class="form-group">
                            <label for="ID Pelanggan">Jenis Kelamin</label>
                            <select name="" id="" class="form-control">
                                <option value=""> ~ Jenis Kelamin ~ </option>
                                <option value="">Laki-laki</option>
                                <option value="">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">No. Telepon</label>
                            <input type="number" name="" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea name="" id="" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Barang</label>
                            <select name="" id="" class="form-control">
                                <option value=""> ~ Pilih Barang ~ </option>
                            </select>
                        </div>    

                        <div class="form-group">
                            <label for="">Jumlah</label>
                            <input type="number" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                Daftar Pesanan Hari Ini
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Pelanggan</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>