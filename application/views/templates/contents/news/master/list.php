<div class="card card-primary card-outline">
    <div class="card-header">
        <div class="d-flex justify-content-between w-100">
            <h3 class="card-title">List News</h3>
            <a class="btn btn-primary btn-sm" href="<?= base_url() ?>news/master/tambah"><i class="fa fa-plus"></i> Tambah</a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="dt_basic" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Foto</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Terbit</th>
                    <th>Diterbitkan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /.card-body -->
</div>

<!-- view foto -->
<div class="modal fade" id="gambar_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header outline-info">
                <h5 class="modal-title text-center">Foto</h5>
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

<!-- view deskripsi -->
<div class="modal fade" id="deskripsi_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header outline-info">
                <h5 class="modal-title text-center">Deskripsi</h5>
            </div>
            <div class="modal-body">
                <div class="card-deskripsi">
                    <p id="isi-deskripsi"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Kembali</button>
            </div>
        </div>
    </div>
</div>