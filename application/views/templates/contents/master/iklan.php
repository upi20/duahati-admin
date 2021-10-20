<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between w-100">
            <h3 class="card-title">List Iklan</h3>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" id="btn-tambah"><i class="fa fa-plus"></i> Tambah</button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="dt_basic" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Nama Iklan</th>
                    <th>Pertandingan</th>
                    <th>Foto</th>
                    <th>Video</th>
                    <th>Jenis</th>
                    <th>Durasi</th>
                    <th>Dilihat</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade" id="gambar_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header outline-info">
                <h5 class="modal-title text-center">Photo</h5>
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

<div class="modal fade" id="video_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header outline-info">
                <h5 class="modal-title text-center">Lihat Iklan Video</h5>
            </div>
            <div class="modal-body" id="video-view">

            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Kembali</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama">Nama Iklan</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="pertandingan">Pertandingan</label>
                                <select class="form-control width-100" style="width: 100%;" id="pertandingan" name="pertandingan" required>
                                    <option value="">Pilih Pertandingan</option>
                                    <?php foreach ($pertandingan as $p) : ?>
                                        <option value="<?= $p['id']; ?>"><?= $p['text']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="gambar_view">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="gambar">Gambar</label>
                                <input type="hidden" id="temp_gambar" name="temp_gambar">
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" placeholder="gambar" />
                            </div>
                        </div>
                    </div>

                    <div class="row" id="url_view">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="url">Alamat Youtube</label>
                                <input type="text" class="form-control" id="url" name="url" placeholder="Alamat Youtube" />
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="durasi">Durasi Iklan (Satuan detik)</label>
                                <input type="number" class="form-control" id="durasi" name="durasi" min="10" placeholder="Durasi" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="1">Aktif</option>
                                    <option value="2">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="jenis">Jenis Iklan</label>
                                <select class="form-control" id="jenis" name="jenis" required>
                                    <option value="1" selected>Gambar</option>
                                    <option value="2">Video Youtube</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->