<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between w-100">
            <h3 class="card-title">Backup & Reset</h3>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <div class="row">

            <div class="col-md-4">
                <div class="card-container">
                    <div class="card shadow-sm">
                        <div class="tile-body text-center tcol" style="border: 1px solid;">
                            <p style="text-align:center">
                            <h4 class="m-0">Data Loading</h4>
                            <br>
                            <a href="<?= base_url() ?>pengaturan/backupReset/backupLoading" target="_BLANK">
                                <i class="fa fa-download"></i>
                                <span class="text-muted">Backup</span>
                            </a>&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-link btn-md" onclick="Reset('Loading')">
                                <i class="fa fa-eraser"></i>
                                <span class="text-muted">Reset</span></button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-container">
                    <div class="card shadow-sm">
                        <div class="tile-body text-center tcol" style="border: 1px solid;">
                            <p style="text-align:center">
                            <h4 class="m-0">Data Penjualan</h4>
                            <br>
                            <a href="<?= base_url() ?>pengaturan/backupReset/backupPenjualan" target="_BLANK">
                                <i class="fa fa-download"></i>
                                <span class="text-muted">Backup</span>
                            </a>&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-link btn-md" onclick="Reset('Penjualan')">
                                <i class="fa fa-eraser"></i>
                                <span class="text-muted">Reset</span></button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-container">
                    <div class="card shadow-sm">
                        <div class="tile-body text-center tcol" style="border: 1px solid;">
                            <p style="text-align:center">
                            <h4 class="m-0">Data Pembayaran</h4>
                            <br>
                            <a href="<?= base_url() ?>pengaturan/backupReset/backupPembayaran" target="_BLANK">
                                <i class="fa fa-download"></i>
                                <span class="text-muted">Backup</span>
                            </a>&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-link btn-md" onclick="Reset('Pembayaran')">
                                <i class="fa fa-eraser"></i>
                                <span class="text-muted">Reset</span></button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- /.card-body -->
</div>