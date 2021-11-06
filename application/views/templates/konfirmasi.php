<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Konfrimasi Pembayaran</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/template/') ?>plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/template/') ?>dist/css/adminlte.min.css">
  <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url() ?>assets/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url() ?>assets/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url() ?>assets/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>assets/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url() ?>assets/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() ?>assets/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url() ?>assets/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() ?>assets/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>assets/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url() ?>assets/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url() ?>assets/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/favicon/favicon-16x16.png">
  <link rel="manifest" href="<?= base_url() ?>assets/favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#fff">
  <meta name="theme-color" content="#343a40">
  <meta name="msapplication-TileImage" content="<?= base_url() ?>assets/favicon/ms-icon-144x144.png">
  <style>
    .btn-danger {
      background-color: #ED6868;
    }

    .btn-danger:focus {
      background-color: #F97A7A;
    }

    .btn-danger:hover {
      background-color: #F97A7A;
    }

    .btn-indigo {
      background-color: #373459;
      color: white;
    }

    .btn-indigo:focus {
      background-color: #4C4592;
      color: white;
    }

    .btn-indigo:hover {
      background-color: #4C4592;
      color: white;
    }

    .bg-two {
      background-color: #DB4664;
    }

    <?php
    for ($i = 0; $i <= 100; $i++) {
      echo ".rounded-$i { border-radius: {$i}px; } ";
    }

    ?>
  </style>

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url('assets/template/') ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <?php if (!empty($plugin_styles)) : ?>
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <?php foreach ($plugin_styles as $style) : ?>
      <link href="<?= $style ?>" rel="stylesheet" type="text/css" />
    <?php endforeach; ?>
    <!-- END PAGE LEVEL PLUGINS -->
  <?php endif; ?>
</head>

<body>
  <div id="loader"></div>
  <header class="container pt-3 pb-2">
    <div class="d-flex justify-content-center align-items-center flex-column text-center">
      <img src="<?= base_url('assets/images/duahati_warna.png') ?>" style="max-width: 135px;" class="my-3" alt="Logo Aplikasi">
      <h3>Konfirmasi pembayaran registrasi member baru</h3>
    </div>
  </header>

  <main class="container">

    <div class="d-md-flex justify-content-between align-items-center flex-row-reverse mb-3">
      <div class=" shadow-sm rounded-30">
        <button class="btn btn-danger w-100 px-4 py-2" data-target="#konfirmasi_modal" data-toggle="modal" style="border-radius: 30px;"><i class="fas fa-check"></i> Konfirmasi Pembayaran</button>
      </div>

      <div style="flex:1" class="mr-md-3 shadow-sm rounded-30">
        <form action="" id="fcari" method="post">
          <div class="input-group my-3 my-md-0">
            <input type="email" class="form-control" required name="email" id="cari_email" style="padding-top: 8px; padding-bottom: 8px; height: auto; padding-left: 30px; border-radius: 30px 0 0 30px;" placeholder="Masukan Email Untuk Mencari Riwayat Pembayaran" aria-label="Masukan Email Untuk Mencari Riwayat Pembayaran" aria-describedby="basic-addon2">
            <div class="input-group-append">
              <button class="btn btn-indigo w-100 w-md-auto  p-2 pl-3 pr-4" style="border-radius: 0 30px 30px 0; box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;" type="submit"><i class="fas fa-search mr-2"></i> Cari</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="card p-1" id="result" style="border-radius: 30px; display:none">
      <div class="card-body">
        <h5>Hasil Pencarian</h5>
        <table id="dt_basic" class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th style="max-width: 30px;">No</th>
              <th>Tgl. Bayar</th>
              <th>Tgl. Input</th>
              <th>Tgl. Respon</th>
              <th>Bukti</th>
              <th>Keterangan</th>
              <th>Status</th>
              <th>Detail</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </main>

  <div class="modal fade" id="gambar_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
      <div class="modal-content rounded-30 p-1">
        <div class="modal-header outline-info">
          <h5 class="modal-title text-center">Bukti Pembayaran</h5>
        </div>
        <div class="modal-body">
          <img src="" class="img-fluid" alt="" id="img-view">
        </div>
        <div class="modal-footer">
          <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c rounded-30" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Kembali</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="konfirmasi_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-lg">
      <div class="modal-content rounded-30 p-1">
        <div class="modal-header outline-info">
          <h5 class="modal-title text-center">Konfirmasi Pembayaran</h5>
        </div>
        <div class="modal-body">
          <form action="" id="fkonfirmasi">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="Email" class="form-control" id="email" name="email" placeholder="Email" required />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="atas_nama">Atas Nama</label>
                  <input type="text" class="form-control" id="atas_nama" name="atas_nama" placeholder="Atas Nama" required />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="nama_bank">Nama Bank</label>
                  <input type="text" class="form-control" id="nama_bank" name="nama_bank" placeholder="Nama Bank" required />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="no_rekening">No Rekening</label>
                  <input type="number" class="form-control" id="no_rekening" name="no_rekening" placeholder="No Rekening" required />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="nominal">Nominal</label>
                  <input type="number" class="form-control" id="nominal" name="nominal" placeholder="Nominal" required />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="tanggal">Tanggal</label>
                  <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal" value="<?= Date('Y-m-d') ?>" required />
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label for="file">Bukti</label>
                  <input type="file" class="form-control" id="file" name="file" placeholder="Bukti" required />
                </div>
              </div>

            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-indigo btn-ef btn-ef-3 btn-ef-3c rounded-30" type="submit" form="fkonfirmasi"><i class="far fa-save"></i> Simpan</button>
          <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c rounded-30" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Kembali</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="detail_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
      <div class="modal-content rounded-30 p-1">
        <div class="modal-header outline-info">
          <h5 class="modal-title text-center">Detail Pembayaran</h5>
        </div>
        <div class="modal-body">
          <table style="width: 100%;">
            <tr>
              <td>Email</td>
              <td>:</td>
              <td id="detail_email"></td>
            </tr>
            <tr>
              <td>Atas Nama</td>
              <td>:</td>
              <td id="detail_atas_nama"></td>
            </tr>
            <tr>
              <td>Nama Bank</td>
              <td>:</td>
              <td id="detail_nama_bank"></td>
            </tr>
            <tr>
              <td>No Rekening</td>
              <td>:</td>
              <td id="detail_no_rekening"></td>
            </tr>
            <tr>
              <td>Nominal</td>
              <td>:</td>
              <td id="detail_nominal"></td>
            </tr>
            <tr>
              <td>Tgl. Bayar</td>
              <td>:</td>
              <td id="detail_tgl_bayar"></td>
            </tr>
            <tr>
              <td>Tgl. Input</td>
              <td>:</td>
              <td id="detail_tgl_input"></td>
            </tr>
            <tr>
              <td>Tgl. Respon</td>
              <td>:</td>
              <td id="detail_tgl_respon"></td>
            </tr>
            <tr>
              <td>Keterangan</td>
              <td>:</td>
              <td id="detail_keterangan"></td>
            </tr>
            <tr>
              <td>Status</td>
              <td>:</td>
              <td id="detail_status"></td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c rounded-30" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Kembali</button>
        </div>
      </div>
    </div>
  </div>

  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?= base_url('assets/template/') ?>plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('assets/template/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/template/') ?>dist/js/adminlte.min.js"></script>
  <!-- loader -->

  <script src="<?= base_url('assets/template/') ?>plugins/loader/loadingoverlay.min.js"></script>

  <!-- SweetAlert2 -->
  <script src="<?= base_url('assets/template/') ?>plugins/sweetalert2/sweetalert2.min.js"></script>
  <script>
    const base_url = '<?= base_url() ?>';
  </script>
  <!-- PAGE RELATED PLUGIN(S) -->
  <?php if (!empty($plugin_scripts)) : ?>
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <?php foreach ($plugin_scripts as $script) : ?>
      <script src="<?= $script ?>" type="text/javascript"></script>
    <?php endforeach; ?>
    <!-- END PAGE LEVEL PLUGINS -->
  <?php endif; ?>
  <script src="<?= base_url('assets/plugins/') ?>jquery-validation/jquery.validate.min.js"></script>
  <script src="<?= base_url('assets/plugins/') ?>jquery-validation/additional-methods.min.js"></script>
  <?php if (file_exists(VIEWPATH . "javascripts/contents/{$content}.js")) : ?>
    <script src="<?= $this->plugin->build_url("javascripts/contents/{$content}.js") ?>" type="text/javascript"></script>
  <?php endif; ?>
  <script>
    $(document).ready(() => {
      $("#loader").LoadingOverlay('progress')

      function dynamic() {
        $("#result").fadeIn();
        const table_html = $('#dt_basic');
        table_html.dataTable().fnDestroy()
        const new_table = table_html.DataTable({
          "ajax": {
            "url": "<?= base_url() ?>member/konfirmasi/ajax_data/",
            "data": {
              email: $('#cari_email').val()
            },
            "type": 'POST'
          },
          "processing": true,
          "serverSide": true,
          "scrollX": true,
          "lengthChange": true,
          "autoWidth": false,
          "columns": [{
              "data": null
            },
            {
              "data": "tanggal"
            },
            {
              "data": "tanggal_input"
            },
            {
              "data": "tanggal_respon"
            },
            {
              "data": "foto",
              render(data, type, full, meta) {
                return `<button
                        class="btn btn-success btn-sm btn-gambar"
                        data-toggle="modal"
                        data-data="${data}"
                        data-target="#gambar_modal"
                        onclick="view_gambar(this)"
                        ><i class="fas fa-eye"></i></button>|
                        <a href="<?= base_url() ?>files/bukti_pembayaran/${data}" target="_blank" download>Download</a>
                        `
              },
              className: "nowrap"
            },
            {
              "data": "catatan"
            },
            {
              "data": "status",
              render(data, type, full, meta) {
                let color = 'success';
                color = data == 0 ? 'warning' : color;
                color = data == 1 ? 'success' : color;
                color = data == 2 ? 'danger' : color;
                return `<span class="text-${color} font-weight-bold">${full.status_str}</span>`;
              }
            },
            {
              "data": "id",
              render(data, type, full, meta) {
                return `<button
                        class="btn btn-info btn-sm btn-gambar"
                        data-toggle="modal"
                        data-email="${full.email}"
                        data-atas_nama="${full.atas_nama}"
                        data-nama_bank="${full.bank_nama}"
                        data-no_rekening="${full.no_rekening}"
                        data-nominal="${full.jumlah_pembayaran}"
                        data-tgl_bayar="${full.tanggal == null ? '':full.tanggal}"
                        data-tgl_input="${full.tanggal_input == null ? '':full.tanggal_input}"
                        data-tgl_respon="${full.tanggal_respon == null ? '':full.tanggal_respon}"
                        data-keterangan="${full.catatan}"
                        data-status_str="${full.status_str}"
                        data-status="${full.status}"
                        data-target="#detail_modal"
                        onclick="detail(this)"
                        ><i class="fas fa-eye"></i></button>
                        `
              },
              className: "nowrap"
            },

          ],
          order: [
            [1, 'asc']
          ],
          columnDefs: [{
            orderable: false,
            targets: [0, 6]
          }],
        });
        new_table.on('draw.dt', function() {
          var PageInfo = table_html.DataTable().page.info();
          new_table.column(0, {
            page: 'current'
          }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
          });
        });
      }

      // tambah dan ubah
      $("#fcari").submit(function(ev) {
        ev.preventDefault();
        dynamic();
      });

      $("#fkonfirmasi").submit(function(ev) {
        ev.preventDefault();
        const form = new FormData(this);
        $.LoadingOverlay("show");
        $.ajax({
          method: 'post',
          url: '<?= base_url() ?>member/konfirmasi/simpan',
          data: form,
          cache: false,
          contentType: false,
          processData: false,
        }).done((data) => {
          $.LoadingOverlay("hide");
          console.log(data);

          if (data.status) {
            Toast.fire({
              icon: 'success',
              title: 'Data berhasil disimpan'
            })
            $('#konfirmasi_modal').modal('toggle')
          } else {
            Toast.fire({
              icon: 'error',
              title: data.message
            })
          }

        }).fail(($xhr) => {
          $.LoadingOverlay("hide");
          if ($xhr.status == 409) {
            Toast.fire({
              icon: 'error',
              title: 'Kelas Sudah Ada'
            })
            return;
          }
          Toast.fire({
            icon: 'error',
            title: 'Data gagal disimpan'
          })
        })
      });

      // end
    })


    const view_gambar = (datas) => {
      $("#img-view").attr('src', `<?= base_url() ?>/files/bukti_pembayaran/${datas.dataset.data}`)
    }

    const detail = (datas) => {
      const detail = datas.dataset;
      console.log(detail);
      $('#detail_email').html(detail.email);
      $('#detail_atas_nama').html(detail.atas_nama);
      $('#detail_nama_bank').html(detail.nama_bank);
      $('#detail_no_rekening').html(detail.no_rekening);
      $('#detail_nominal').html(`Rp. ${format_rupiah(detail.nominal)}`);
      $('#detail_tgl_bayar').html(detail.tgl_bayar);
      $('#detail_tgl_input').html(detail.tgl_input);
      $('#detail_tgl_respon').html(detail.tgl_respon);
      $('#detail_keterangan').html(detail.keterangan);
      let color = 'success';
      color = detail.status == 0 ? 'warning' : color;
      color = detail.status == 1 ? 'success' : color;
      color = detail.status == 2 ? 'danger' : color;
      $('#detail_status').html(`<span class="text-${color} font-weight-bold">${detail.status_str}</span>`);
    }

    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    function format_rupiah(angka, format = 2, prefix) {
      angka = angka != "" ? angka : 0;
      angka = parseFloat(angka);
      angka_ = angka.toString().split('.');
      if (format) {
        if (angka_[1]) {
          const len = String(angka_[1]).length;

          angka = angka.toFixed(format > len ? len : format);
        }
      }
      const minus = angka < 0 ? "-" : "";
      angka = angka.toString().split('.');
      let suffix = angka[1] ? angka[1] : '';

      angka = angka[0];
      if (angka) {
        let number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
          split = number_string.split(','),
          sisa = split[0].length % 3,
          rupiah = split[0].substr(0, sisa),
          ribuan = split[0].substr(sisa).match(/\d{3}/gi)

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
          separator = sisa ? '.' : ''
          rupiah += separator + ribuan.join('.')
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah

        // return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '')
        const result = prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
        return minus + result + (suffix != '' ? ',' + suffix : '');
      } else {
        return 0
      }
    }
  </script>
</body>

</html>