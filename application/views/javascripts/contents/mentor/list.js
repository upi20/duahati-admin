$(function () {
    function dynamic() {
        const table_html = $('#dt_basic');
        table_html.dataTable().fnDestroy()
        const new_table = table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>mentor/data/ajax_data/",
                "data": null,
                "type": 'POST'
            },
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "columns": [
                { "data": null },
                { "data": "user_nama" },
                { "data": "user_email" },
                { "data": "user_phone" },
                {
                    "data": "user_foto", render(data, type, full, meta) {
                        return `<button
                        class="btn btn-success btn-sm btn-gambar"
                        data-toggle="modal"
                        data-data="${data}"
                        data-target="#gambar_modal"
                        onclick="view_gambar(this)"
                        id="btn-gambar"><i class="fas fa-eye"></i></button>`
                    }, className: "nowrap"
                },
                { "data": "jumlah_member" },
                { "data": "status_str" },
                {
                    "data": "updated_at", render(data, type, full, meta) {
                        return data == null || data == '' ? full.created_at : full.updated_at;

                    }, className: "nowrap"
                },
                {
                    "data": "user_id", render(data, type, full, meta) {
                        return `<div class="pull-right">
									<button class="btn btn-primary btn-xs"
                                        data-id="${data}"
                                        data-nama="${full.user_nama}"
                                        data-tanggal_lahir="${full.user_tgl_lahir}"
                                        data-jenis_kelamin="${full.user_jk}"
                                        data-temp_foto="${full.user_foto}"
                                        data-alamat="${full.alamat}"
                                        data-email="${full.user_email}"
                                        data-telepon="${String(full.user_phone).replace('+62', '')}"
                                        data-status="${full.user_status}"
                                        data-toggle="modal" data-target="#tambahModal"
                                    onclick="Ubah(this)">
										<i class="fa fa-edit"></i> Ubah
									</button>
									<button class="btn btn-danger btn-xs" onclick="Hapus(${data})">
										<i class="fa fa-trash"></i> Hapus
									</button>
								</div>`
                    }, className: "nowrap"
                }
            ],
            order: [
                [1, 'asc']
            ],
            columnDefs: [{
                orderable: false,
                targets: [0, 7]
            }],
        });
        new_table.on('draw.dt', function () {
            var PageInfo = table_html.DataTable().page.info();
            new_table.column(0, {
                page: 'current'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });
    }
    dynamic();

    $("#btn-tambah").click(() => {
        $("#tambahModalTitle").text("Tambah mentor");
        $('#id').val('');
        $('#nama').val('');
        $('#tanggal_lahir').val('');
        $('#jenis_kelamin').val('Laki-Laki');
        $('#foto').val('');
        $('#alamat').val('');
        $('#email').val('');
        $('#password').val('123456');
        $('#password').attr('required', '');
        $('#telepon').val('');
        $('#status').val('1');
    });

    // tambah dan ubah
    $("#fmain").submit(function (ev) {
        ev.preventDefault();
        const form = new FormData(this);
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>mentor/data/' + ($("#id").val() == "" ? 'insert' : 'update'),
            data: form,
            cache: false,
            contentType: false,
            processData: false,
        }).done((data) => {
            Toast.fire({
                icon: 'success',
                title: 'Data berhasil disimpan'
            })
            dynamic();
        }).fail(($xhr) => {
            Toast.fire({
                icon: 'error',
                title: 'Data gagal disimpan'
            })
        }).always(() => {
            $.LoadingOverlay("hide");
            $('#tambahModal').modal('toggle')
        })
    });

    // hapus
    $('#OkCheck').click(() => {
        let id = $("#idCheck").val()
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>mentor/data/delete',
            data: {
                id: id
            }
        }).done((data) => {
            Toast.fire({
                icon: 'success',
                title: 'Data berhasil dihapus'
            })
            dynamic();
        }).fail(($xhr) => {
            Toast.fire({
                icon: 'error',
                title: 'Data gagal dihapus'
            })
        }).always(() => {
            $('#ModalCheck').modal('toggle')
            $.LoadingOverlay("hide");
        })
    })

    $("#email").change(function () {
        emailCheck(this);
    })
})

const view_gambar = (datas) => {
    $("#img-view").attr('src', `<?= base_url() ?>/files/mentor/${datas.dataset.data}`)
}

// Click Hapus
const Hapus = (id) => {
    $("#idCheck").val(id)
    $("#LabelCheck").text('Form Hapus')
    $("#ContentCheck").text('Apakah anda yakin akan menghapus data ini?')
    $('#ModalCheck').modal('toggle')
}

// Click Ubah
const Ubah = (datas) => {
    const data = datas.dataset;
    $('#id').val(data.id);
    $('#nama').val(data.nama);
    $('#tanggal_lahir').val(data.tanggal_lahir);
    $('#jenis_kelamin').val(data.jenis_kelamin);
    $('#foto').val('');
    $('#temp_foto').val(data.temp_foto);
    $('#alamat').val(data.alamat);
    $('#email').val(data.email);
    $('#telepon').val(data.telepon);
    $('#status').val(data.status);
    $('#password').val('');
    $('#password').removeAttr('required');
    $("#tambahModalTitle").text("Ubah mentor");
}

function emailCheck(email_ele) {
    const email = $(email_ele);
    if (email.val() == '') {
        return;
    }

    email.attr('readonly', '')
    $.ajax({
        url: '<?= base_url() ?>mentor/data/emailCheck',
        data: {
            id_user: $('#id').val(),
            email: email.val()
        },
        type: 'post',
        success: function (data) {
            Toast.fire({
                icon: 'success',
                title: 'Success Email Belum Terdaftar'
            })
        },
        error: function (data) {
            Toast.fire({
                icon: 'error',
                title: data.responseJSON.message
            })
            email.val('');
            email.focus();
        },
        complete: function () {
            email.removeAttr('readonly');
        }
    });
}