<div class="card card-info card-outline" id="filter">
    <div class="card-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-end  align-items-star w-100 flex-md-row flex-column">
                <h3 class="card-title align-self-center">Filter : </h3>
                <div class="form-group  mb-lg-0 ml-lg-2">
                    <select class="form-control" id="filter-kategori" name="filter-kategori" style=" min-width:200px" value="" style="width: 100%;"></select>
                </div>
                <div class="form-group  mb-lg-0 ml-lg-2">
                    <button type="button" class="btn btn-info btn" id="btn-filter" style="width: 100%;"><i class="fas fa-search"></i> Cari</button>
                </div>
                <div class="ml-lg-2">
                    <a class="btn btn-warning btn" href="" style="width: 100%;"><i class="fas fa-undo"></i> Reset filter</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-primary card-outline">
    <div class="card-header">
        <div class="d-flex justify-content-between w-100">
            <h3 class="card-title">List Kelas</h3>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal" id="btn-tambah"><i class="fa fa-plus"></i> Tambah</button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="dt_basic" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th>Icon</th>
                    <th>Tipe</th>
                    <th>Materi</th>
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
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select name="kategori_id" id="kategori_id" class="form-control" style="width: 100%;" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Kelas</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Kelas" required />
                    </div>
                    <div class="form-group">
                        <label for="foto">Icon</label>
                        <input type="file" class="form-control-file" id="foto" name="foto" accept="image/png, image/jpeg, image/JPG, image/PNG, image/JPEG">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea cols="3" rows="4" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipe">Tipe</label>
                                <select name="tipe" id="tipe" class="form-control">
                                    <option value="1">Premium</option>
                                    <option value="2">VIP</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
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

<div class="modal fade" id="gambar_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header outline-info">
                <h5 class="modal-title text-center">Icon</h5>
            </div>
            <div class="modal-body">
                <img src="<?= base_url() ?>\assets\images\student.png" class="img-fluid" alt="" id="img-view">
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Kembali</button>
            </div>
        </div>
    </div>
</div>