<div class="card card-primary card-outline">
    <div class="card-header">
        <div class="d-md-flex justify-content-between align-items-center w-100">
            <div>
                <a href="<?= base_url() ?>kelas/master" class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
            <div>
                <h3 class="card-title">List Materi Kelas <span class="font-weight-bold"><?= $detail['nama'] ?></span></h3>
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal" id="btn-tambah"><i class="fa fa-plus"></i> Tambah</button>
            </div>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="dt_basic" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="max-width: 60px;">No Urut</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th>Video</th>
                    <th>Submateri</th>
                    <th>Selesai</th>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header outline-info">
                <h5 class="modal-title text-center" id="tambahModalTitle"></h5>
            </div>
            <div class="modal-body">
                <form action="" id="fmain" method="post">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="temp_foto" name="temp_foto">
                    <input type="hidden" class="form-control" id="kelas_id" name="kelas_id" value="<?= $kelas_id ?>" placeholder="" required />
                    <div class="form-group">
                        <label for="nama">Nama Materi</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Materi" required />
                    </div>
                    <div class="form-group">
                        <label for="url">Alamat Youtube (Icon untuk submateri)</label>
                        <input type="text" class="form-control" id="url" name="url" placeholder="Alamat Youtube" required />
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea cols="3" rows="4" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md 6">
                            <div class="form-group">
                                <label for="no_urut">No Urut</label>
                                <input type="number" class="form-control" id="no_urut" name="no_urut" min="1" placeholder="Nomor Urutan Materi" required />
                            </div>
                        </div>
                        <div class="col-md 6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="submateri">
                        <label class="custom-control-label" for="submateri">Materi Ini Mempuyai Sub Materi</label>
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

<div class="modal fade" id="video_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header outline-info">
                <h5 class="modal-title text-center">Lihat Video</h5>
            </div>
            <div class="modal-body" id="video-view">

            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Kembali</button>
            </div>
        </div>
    </div>
</div>