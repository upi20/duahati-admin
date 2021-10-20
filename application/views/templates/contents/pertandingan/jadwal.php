<div class="card card-info card-outline" id="filter">
    <div class="card-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-end align-items-star w-100 flex-md-row flex-column">
                <input type="hidden" name="stfilter" id="stfilter" value="0">
                <h3 class="card-title align-self-center">Filter : </h3>
                <div class="ml-md-2">
                    <select class="form-control" id="filter-team_1" name="filter-team_1" style=" min-width:200px" value=""></select>
                </div>
                <div class="ml-md-2">
                    <select class="form-control" id="filter-team_2" name="filter-team_2" style=" min-width:200px" value=""></select>
                </div>
                <div class="ml-md-2">
                    <select class="form-control" id="filter-stadion" name="filter-stadion" style=" min-width:200px" value=""></select>
                </div>
                <div class="ml-md-2">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="filter_date" value="<?= date("m/d/Y"); ?> - <?= date("m/d/Y"); ?>">
                        </div>
                        <!-- /.input group -->
                    </div>
                </div>
                <div class="ml-md-2">
                    <button type="button" class="btn btn-info btn" id="btn-filter">Cari</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between w-100">
            <h3 class="card-title">List Jadwal</h3>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" id="btn-tambah"><i class="fa fa-plus"></i> Tambah</button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="dt_basic" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Team 1</th>
                    <th>Team 2</th>
                    <th>Stadion</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Score</th>
                    <th>MOTM Pemain</th>
                    <th>MOTM Data</th>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="team_1">Team 1</label>
                                <select class="form-control" id="team_1" name="team_1" style="width: 100%;" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="team_2">Team 2</label>
                                <select class="form-control" id="team_2" name="team_2" style="width: 100%;" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="stadion">Stadion</label>
                                <select class="form-control" id="stadion" name="stadion" style="width: 100%;" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_main">Tanggal Main</label>
                                <input type="date" class="form-control" name="tanggal_main" id="tanggal_main" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam_main">Jam Main</label>
                                <input type="time" class="form-control" name="jam_main" id="jam_main" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="0">Akan Datang</option>
                                    <option value="1">Tampilkan</option>
                                    <option value="2">Berlangsung</option>
                                    <option value="3">Selesai</option>
                                    <option value="4">Nonaktif</option>
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
</div>

<div class="modal fade" id="hasilPertandingan" tabindex="-1" role="dialog" aria-labelledby="hasilPertandinganLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="fhasil" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="hasilPertandinganLabel">Hasil Pertandingan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hasil_team_1">Hasil Team 1</label>
                                <input type="number" min="0" class="form-control" name="hasil_team_1" id="hasil_team_1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hasil_team_2">Hasil Team 2</label>
                                <input type="number" min="0" class="form-control" name="hasil_team_2" id="hasil_team_2">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="man_of_the_match">Man If The Match</label>
                                <select class="form-control" id="man_of_the_match" name="man_of_the_match" style="width: 100%;">
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
</div>


<div class="modal fade" id="Listvoting" tabindex="-1" role="dialog" aria-labelledby="ListvotingLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ListvotingLabel">Detail Voting Man of the match</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="tbl_vote" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_vote_body">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div>