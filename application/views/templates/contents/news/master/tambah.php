<div class="card card-primary card-outline">
    <!-- /.card-header -->
    <div class="card-body">
        <form action="" id="fmain" method="post">
            <input type="hidden" id="id" name="id" value="<?= $isi['id'] ?>">
            <input type="hidden" id="temp_foto" name="temp_foto" value="<?= $isi['foto'] ?>">
            <input type="hidden" id="status" name="status" value="<?= $isi['status'] ?>">
            <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul" value="<?= $isi['judul'] ?>" required />
            </div>
            <div class="form-group">
                <label for="foto">Foto</label>
                <input type="file" class="form-control-file" id="foto" name="foto" accept="image/png, image/jpeg, image/JPG, image/PNG, image/JPEG">
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea cols="3" rows="4" class="form-control summernote" id="deskripsi" name="deskripsi" placeholder="Deskripsi" value="<?= $isi['deskripsi'] ?>" required></textarea>
                <script>
                    let deskripsi = "<?= $isi['deskripsi'] ?>"
                </script>
            </div>
            <div class="form-group">
                <label for="tanggal_terbit">Tanggal Terbit</label>
                <input type="datetime-local" class="form-control" id="tanggal_terbit" name="tanggal_terbit" placeholder="Tanggal Terbit" value="<?= $isi['tanggal_terbit'] != null ? str_replace(' ', 'T', $isi['tanggal_terbit']) : date('Y-m-d') . 'T' . date('H:i') ?>" required />
            </div>
            <div class="d-flex flex-row bd-highlight mb-3 justify-content-end">
                <button class="btn btn-primary btn-ef btn-ef-3 btn-ef-3c mx-1" type="submit" form="fmain"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" href="<?= base_url() ?>news/master"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
        </form>
    </div>
    <!-- /.card-body -->
</div>