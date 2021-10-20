<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between w-100">
            <h3 class="card-title">List Tebak Score</h3>
            <!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" id="btn-tambah"><i class="fa fa-plus"></i> Tambah</button> -->
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="dt_basic" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <!-- <th>Tanggal</th> -->
                    <!-- <th>Jam</th> -->
                    <th>Pertandingan</th>
                    <!-- <th>Stadion</th> -->
                    <th>Member</th>
                    <th>Score Team 1</th>
                    <th>Score Team 2</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /.card-body -->
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
                                <label for="pertandingan">Pertandingan</label>
                                <select class="form-control" id="pertandingan" name="pertandingan" style="width: 100%;" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="member">Member</label>
                                <select class="form-control" id="member" name="member" style="width: 100%;" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="score_team_1">Score Team 1</label>
                                <input type="number" min="0" class="form-control" name="score_team_1" id="score_team_1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="score_team_2">Score Team 2</label>
                                <input type="number" min="0" class="form-control" name="score_team_2" id="score_team_2" required>
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
                                    <option value="2">Tidak AKtif</option>
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