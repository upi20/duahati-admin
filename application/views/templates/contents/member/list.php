<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between w-100">
            <h3 class="card-title">List Data Member</h3>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="dt_basic" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>No Whatsapp</th>
                    <th>Photo</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /.card-body -->
</div>

<!-- view foto -->
<div class="modal fade" id="photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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