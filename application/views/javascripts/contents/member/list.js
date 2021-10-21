$("#mentor_id").select2({ dropdownParent: $('#tambahModal') });
const config_max_refeal = 7;
$(function () {
    ajax_select(false, '#mentor_id', '<?= base_url(); ?>mentor/data/getList', null, false, 'Pilih Mentor');
    function dynamic() {
        const table_html = $('#dt_basic');
        table_html.dataTable().fnDestroy()
        const new_table = table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>member/data/ajax_data/",
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
                { "data": "mentor" },
                { "data": "nama" },
                { "data": "email" },
                {
                    "data": "foto", render(data, type, full, meta) {
                        return `<button
                        class="btn btn-success btn-sm btn-gambar"
                        data-toggle="modal"
                        data-data="${data}"
                        data-target="#gambar_modal"
                        onclick="view_gambar(this)"
                        id="btn-gambar"><i class="fas fa-eye"></i></button>`
                    }, className: "nowrap"
                },
                // { "data": "jumlah_kelas" },
                { "data": "status_str" },
                {
                    "data": "id", render(data, type, full, meta) {
                        return `<div class="pull-right">
									<button class="btn btn-primary btn-xs"
                                    data-id="${full.id}"
                                    data-foto="${full.foto}"
                                    data-mentor_id="${full.mentor_id}"
                                    data-nama="${full.nama}"
                                    data-email="${full.email}"
                                    data-no_telepon="${full.no_telepon == null ? '' : full.no_telepon}"
                                    data-alamat="${full.alamat}"
                                    data-status="${full.status}"
                                    data-kode_refeal="${full.kode_refeal}"
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
                targets: [0, 6]
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
        $("#tambahModalTitle").text("Tambah member");
        $('#id').val('');
        $('#mentor_id').val('').trigger('change');
        $('#nama').val('');
        $('#foto').val('');
        $('#email').val('');
        $('#no_telepon').val('');
        $('#password').val('123456');
        $('#password').attr('required', '');
        $('#alamat').val('');
        $('#status').val('1');
        generateRefeal(config_max_refeal, '#kode_refeal');
    });

    $("#kode_refeal").change(function () {
        const val = $(this).val();
        if (val == '') {
            Toast.fire({
                icon: 'error',
                title: 'Kode Refeal Tidak Boleh Kosong'
            })
            $(this).focus();
            return;
        }

        if (val.length > config_max_refeal) {
            Toast.fire({
                icon: 'error',
                title: `Kode Refeal Tidak boleh lebih dari ${config_max_refeal} huruf`
            })
            $(this).val((new String($(this).val())).substring(0, config_max_refeal + 1));
            $(this).focus();
            return;
        }

        checkKodeRefeal(val, false, this, true);
    })

    $('#kode_refeal').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });

    $("#kode_refeal").keyup(function () {
        $(this).val(new String(this.value).toLocaleUpperCase());
    })

    // tambah dan ubah
    $("#fmain").submit(function (ev) {
        ev.preventDefault();
        const form = new FormData(this);
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>member/data/' + ($("#id").val() == "" ? 'insert' : 'update'),
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
            url: '<?= base_url() ?>member/data/delete',
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
    $("#img-view").attr('src', `<?= base_url() ?>/files/member/${datas.dataset.data}`)
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
    $('#temp_foto').val(data.foto);
    $('#foto').val('');
    $('#id').val(data.id);
    $('#mentor_id').val(data.mentor_id).trigger('change');
    $('#nama').val(data.nama);
    $('#foto').val('');
    $('#email').val(data.email);
    $('#no_telepon').val(data.no_telepon);
    $('#kode_refeal').val(data.kode_refeal);
    $('#password').val('');
    $('#password').removeAttr('required');
    $('#alamat').val(data.alamat);
    $('#status').val(data.status);

    $("#tambahModalTitle").text("Ubah member");
}


function generatorString(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let result = ' ';
    const charactersLength = characters.length;
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

function generateRefeal(length, element) {
    const new_refeal = generatorString(length);
    checkKodeRefeal(new_refeal, length, element, false, true);
}


function checkKodeRefeal(kode, length, element = false, notif = false, init = false) {
    $.ajax({
        method: 'post',
        url: '<?= base_url() ?>member/data/cekKodeRefeal',
        data: {
            kode: kode,
            id: $("#id").val(),
        }
    }).done((data) => {
        if (notif) {
            Toast.fire({
                icon: 'success',
                title: 'Kode Refeal Belum Terdaftar'
            })
        }
        $(element).val(kode);
    }).fail(($xhr) => {
        if (notif) {
            Toast.fire({
                icon: 'error',
                title: 'Kode Refeal Sudah Terdaftar'
            })
        }
        $(element).val('');
        $(element).focus();
        if (init) {
            generateRefeal(length, element);
        }
    })
}

function emailCheck(email_ele) {
    const email = $(email_ele);
    if (email.val() == '') {
        return;
    }

    email.attr('readonly', '')
    $.ajax({
        url: '<?= base_url() ?>member/data/emailCheck',
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