<div class="card card-primary card-outline">
    <div class="card-header">
        <div class="d-flex justify-content-between w-100">
            <h3 class="card-title">List Mentor</h3>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal" id="btn-tambah"><i class="fa fa-plus"></i> Tambah</button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="dt_basic" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /.card-body -->
</div>

<!-- view foto -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header outline-info">
                <h5 class="modal-title text-center" id="tambahModalTitle"></h5>
            </div>
            <div class="modal-body">
                <form action="" id="fmain" method="post">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required />
                    </div>
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="number" class="form-control" id="nominal" name="nominal" placeholder="Nominal Jumlah Pembayaran" required />
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea cols="3" rows="4" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-ef btn-ef-3 btn-ef-3c" type="submit" form="fmain"><i class="fa fa-save"></i> Simpan</button>
                <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Kembali</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="aktfkan" tabindex="-1" role="dialog" aria-labelledby="aktfkanLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header outline-info">
                <h5 class="modal-title text-center" id="aktfkanTitle">Aktifkan Biaya</h5>
            </div>
            <div class="modal-body">
                <form action="" id="faktifkan" method="post">
                    <input type="hidden" id="aktifkan_id" name="id">
                </form>
                <p>Apakah anda yakin akan mengaktifkan biaya
                    <span id="aktifkan_nama" class="font-weight-bold"></span> dengan nominal
                    <span id="aktifkan_nominal" class="font-weight-bold"></span> untuk pendaftaran member baru..?
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-ef btn-ef-3 btn-ef-3c" type="submit" form="faktifkan"><i class="fa fa-save"></i> Simpan</button>
                <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Kembali</button>
            </div>
        </div>
    </div>
</div>