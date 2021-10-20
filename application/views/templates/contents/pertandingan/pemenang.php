<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between w-100">
            <h3 class="card-title">List Kursi</h3>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div id="kursi-ubah" style="display: none;">
            <form action="" id="kursi-form">
                <h3 class="h5">Jadikan Pemenang</h3>
                <div class="d-md-flex justify-content-start w-100">
                    <input type="hidden" name="id" id="kursi-id">
                    <div class="form-group mr-md-3">
                        <input type="text" class="form-control" id="kursi-nama" name="nama" placeholder="Nama" required readonly />
                    </div>
                    <div class="form-group mr-md-3">
                        <input type="number" class="form-control" id="kursi-menang" name="menang" placeholder="Juara Ke" />
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class=" mr-md-3">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                        <div>
                            <button class="btn btn-danger" type="button" onclick="$('#kursi-ubah').fadeOut()">Close</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <table id="tbl_kursi" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="max-width: 25px;">No</th>
                    <th>Nama</th>
                    <th style="max-width: 50px;">Kursi</th>
                    <th style="max-width: 50px;">Waktu</th>
                    <th style="max-width: 50px;">Peringkat</th>
                    <th style="max-width: 100px;">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /.card-body -->
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between w-100">
            <h3 class="card-title">List Pemenang Men of the match (Pemain: <?= $data['motm'] ?>)</h3>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div id="mot-ubah" style="display: none;">
            <form action="" id="mot-form">
                <h3 class="h5">Jadikan Pemenang</h3>
                <div class="d-md-flex justify-content-start w-100">
                    <input type="hidden" name="id" id="mot-id">
                    <div class="form-group mr-md-3">
                        <input type="text" class="form-control" id="mot-nama" name="nama" placeholder="Nama" required readonly />
                    </div>
                    <div class="form-group mr-md-3">
                        <input type="number" class="form-control" id="mot-menang" name="menang" placeholder="Juara Ke" />
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class=" mr-md-3">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                        <div>
                            <button class="btn btn-danger" type="button" onclick="$('#mot-ubah').fadeOut()">Close</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <table id="tbl_mot" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="max-width: 25px;">No</th>
                    <th>Nama</th>
                    <th style="max-width: 50px;">Waktu</th>
                    <th style="max-width: 50px;">Peringkat</th>
                    <th style="max-width: 100px;">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /.card-body -->
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between w-100">
            <h3 class="card-title">List Pemenang Tebak Skor (Skor: <?= $data['hasil_team_1'] ?> vs <?= $data['hasil_team_2'] ?>) </h3>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div id="skor-ubah" style="display: none;">
            <form action="" id="skor-form">
                <h3 class="h5">Jadikan Pemenang</h3>
                <div class="d-md-flex justify-content-start w-100">
                    <input type="hidden" name="id" id="skor-id">
                    <div class="form-group mr-md-3">
                        <input type="text" class="form-control" id="skor-nama" name="nama" placeholder="Nama" required readonly />
                    </div>
                    <div class="form-group mr-md-3">
                        <input type="number" class="form-control" id="skor-menang" name="menang" placeholder="Juara Ke" />
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class=" mr-md-3">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                        <div>
                            <button class="btn btn-danger" type="button" onclick="$('#skor-ubah').fadeOut()">Close</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <table id="tbl_skor" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="max-width: 25px;">No</th>
                    <th>Nama</th>
                    <th style="max-width: 50px;">Waktu</th>
                    <th style="max-width: 50px;">Peringkat</th>
                    <th style="max-width: 100px;">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /.card-body -->
</div>

<script>
    const global_id_pertandingan = "<?= $id_pertandingan ?>";
    const global_skor_1 = "<?= $data['hasil_team_1'] ?>";
    const global_skor_2 = "<?= $data['hasil_team_2'] ?>";
    const global_id_mot = "<?= $data['man_of_the_match'] ?>";
</script>