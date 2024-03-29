<div class="card card-primary card-outline">
    <div class="card-header">
        <div class="d-flex justify-content-between w-100">
            <h3 class="card-title">List Member</h3>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal" id="btn-tambah"><i class="fa fa-plus"></i> Tambah</button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="dt_basic" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mentor</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Foto</th>
                    <th>Whatsapp</th>
                    <th>K. Referral</th>
                    <th>Jml. Kel. VIP</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /.card-body -->
</div>


<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header outline-info">
                <h5 class="modal-title text-center" id="tambahModalTitle"></h5>
            </div>
            <div class="modal-body">
                <form action="" id="fmain" method="post">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="temp_foto" name="temp_foto">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="mentor_id">Mentor</label>
                                <select name="mentor_id" id="mentor_id" class="form-control" style="width: 100%;" required>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" required />
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="foto">Foto</label>
                                <input type="file" class="form-control-file" id="foto" name="foto" accept="image/png, image/jpeg, image/JPG, image/PNG, image/JPEG">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="kode_referral">Kode Referral (Member Baru)</label>
                                <input type="text" class="form-control" id="kode_referral" name="kode_referral" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required />
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <label for="no_telepon">No Whatsapp</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">+62</div>
                                </div>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" placeholder="No Whatsapp">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" id="password" name="password" placeholder="Password" value="123456" required />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                    <option value="2">Menunggu Pembayaran</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea cols="3" rows="4" class="form-control" id="alamat" name="alamat" placeholder="Alamat Lengkap"></textarea>
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
                <h5 class="modal-title text-center">Foto Member</h5>
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