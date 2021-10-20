$("#pertandingan").select2({ dropdownParent: $('#myModal') });
$("#member").select2({ dropdownParent: $('#myModal') });
$("#pemain").select2({ dropdownParent: $('#myModal') });
$(function () {
    function dynamic() {
        const table_html = $('#dt_basic');
        table_html.dataTable().fnDestroy()
        table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>pertandingan/tebakMOTM/ajax_data/",
                "data": null,
                "type": 'POST'
            },
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "columns": [
                { "data": "pertandingan" },
                { "data": "member" },
                { "data": "pemain" },
                { "data": "status_str" },
                {
                    "data": "id", render(data, type, full, meta) {
                        return `<div class="pull-right">
									<button class="btn btn-primary btn-xs" onclick="Ubah(${data})">
										<i class="fa fa-edit"></i> Ubah
                                        </button>`+
                            `<button class="btn btn-danger btn-xs" onclick="Hapus(${data})">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>`+
                            `</div>`
                    }, className: "nowrap"
                }
            ],
        });
    }
    dynamic();

    $('#team_1').change(() => {
        if ($('#team_1').val() != '') {
            if ($('#team_1').val() == $('#team_2').val()) {
                $('#team_1').val("").trigger('change');
                Toast.fire({
                    icon: 'error',
                    title: 'Kedua Team tidak boleh sama !'
                })
            }
        }
    })

    $('#team_2').change(() => {
        if ($('#team_2').val() != '') {
            if ($('#team_1').val() == $('#team_2').val()) {
                $('#team_2').val("").trigger('change');
                Toast.fire({
                    icon: 'error',
                    title: 'Kedua Team tidak boleh sama !'
                })
            }
        }
    })

    $("#btn-tambah").click(() => {
        $("#myModalLabel").text("Tambah Tebak MOTM");
        ajax_select({ id: '#btn-tambah', pretext: 'Tambah', text: '<i class="fa fa-plus"></i> Tambah' }, '#pertandingan', '<?= base_url(); ?>/pertandingan/tebakMOTM/ajax_select_list_pertandingan', null, '#myModal', 'Pilih Pertandingan');
        ajax_select({ id: '#btn-tambah', pretext: 'Tambah', text: '<i class="fa fa-plus"></i> Tambah' }, '#member', '<?= base_url(); ?>/pertandingan/tebakMOTM/ajax_select_list_member', null, '#myModal', 'Pilih Member');
        ajax_select({ id: '#btn-tambah', pretext: 'Tambah', text: '<i class="fa fa-plus"></i> Tambah' }, '#pemain', '<?= base_url(); ?>/pertandingan/tebakMOTM/ajax_select_list_pemain', null, '#myModal', 'Pilih Pemain');
        $('#id').val("");
        $('#status').val("1");
    });

    // tambah dan ubah
    $("#form").submit(function (ev) {
        ev.preventDefault();
        const form = new FormData(this);
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>pertandingan/tebakMOTM/' + ($("#id").val() == "" ? 'insert' : 'update'),
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
            $('#myModal').modal('toggle')
        })
    });

    // hapus
    $('#OkCheck').click(() => {
        let id = $("#idCheck").val()
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>pertandingan/tebakMOTM/delete',
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
})

const view_logo = (datas) => {
    $("#img-view").attr('src', `<?= base_url() ?>/files/tebakMOTM/${datas.dataset.data}`)
}

// Click Hapus
const Hapus = (id) => {
    $("#idCheck").val(id)
    $("#LabelCheck").text('Form Hapus')
    $("#ContentCheck").text('Apakah anda yakin akan menghapus data ini?')
    $('#ModalCheck').modal('toggle')
}

// Click Ubah
const Ubah = (id) => {
    $.LoadingOverlay("show");
    $.ajax({
        method: 'get',
        url: '<?= base_url() ?>pertandingan/tebakMOTM/getTebakMOTM',
        data: {
            id: id
        }
    }).done((data) => {
        if (data.data) {
            data = data.data;
            $("#myModalLabel").text("Ubah Tebak MOTM");
            ajax_select(false, '#pertandingan', '<?= base_url(); ?>/pertandingan/tebakMOTM/ajax_select_list_pertandingan', null, '#myModal', 'Pilih Pertandingan', data.id_pertandingan);
            ajax_select(false, '#member', '<?= base_url(); ?>/pertandingan/tebakMOTM/ajax_select_list_member', null, '#myModal', 'Pilih Member', data.id_member);
            ajax_select(false, '#pemain', '<?= base_url(); ?>/pertandingan/tebakMOTM/ajax_select_list_pemain', null, '#myModal', 'Pilih Pemain', data.id_pemain);
            $('#id').val(data.id);
            $('#status').val(data.status);
            $('#myModal').modal('toggle')
        } else {
            Toast.fire({
                icon: 'error',
                title: 'Data tidak valid.'
            })
        }
    }).fail(($xhr) => {
        Toast.fire({
            icon: 'error',
            title: 'Gagal mendapatkan data.'
        })
    }).always(() => {
        $.LoadingOverlay("hide");
    })
}