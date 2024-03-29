$("#team").select2({ dropdownParent: $('#myModal') });
$("#posisi").select2({ dropdownParent: $('#myModal') });
$(function () {
    function dynamic() {
        const table_html = $('#dt_basic');
        table_html.dataTable().fnDestroy()
        table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>master/pemain/ajax_data/",
                "data": null,
                "type": 'POST'
            },
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "columns": [
                { "data": "team" },
                { "data": "posisi" },
                { "data": "nama" },
                {
                    "data": "photo", render(data, type, full, meta) {
                        return `<button
                    class="btn btn-success btn-sm btn-photo"
                    data-toggle="modal"
                    data-data="${data}"
                    data-target="#photo"
                    onclick="view_photo(this)"
                    id="btn-photo"><i class="fas fa-search"></i></button>`
                    }, className: "nowrap"
                },
                { "data": "status_str" },
                {
                    "data": "updated_at", render(data, type, full, meta) {
                        return data == null || data == '' ? full.created_at : full.updated_at;

                    }, className: "nowrap"
                },
                {
                    "data": "id", render(data, type, full, meta) {
                        return `<div class="pull-right">
									<button class="btn btn-primary btn-xs" onclick="Ubah(${data})">
										<i class="fa fa-edit"></i> Ubah
									</button>
									<button class="btn btn-danger btn-xs" onclick="Hapus(${data})">
										<i class="fa fa-trash"></i> Hapus
									</button>
								</div>`
                    }, className: "nowrap"
                }
            ],
        });
    }
    dynamic();

    $("#btn-tambah").click(() => {
        $("#myModalLabel").text("Tambah Pemain");
        ajax_select({ id: '#btn-tambah', pretext: 'Tambah', text: '<i class="fa fa-plus"></i> Tambah' }, '#team', '<?= base_url(); ?>/master/pemain/ajax_select_list_team', null, '#myModal', 'Pilih Team');
        ajax_select({ id: '#btn-tambah', pretext: 'Tambah', text: '<i class="fa fa-plus"></i> Tambah' }, '#posisi', '<?= base_url(); ?>/master/pemain/ajax_select_list_posisi', null, '#myModal', 'Pilih Posisi');
        $('#id').val("");
        $('#nama').val("");
        $('#logo').val("");
        $('#temp_logo').val("");
        $('#status').val("1");
    });

    // tambah dan ubah
    $("#form").submit(function (ev) {
        ev.preventDefault();
        const form = new FormData(this);
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>master/pemain/' + ($("#id").val() == "" ? 'insert' : 'update'),
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
            url: '<?= base_url() ?>master/pemain/delete',
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

const view_photo = (datas) => {
    $("#img-view").attr('src', `<?= base_url() ?>/files/pemain/${datas.dataset.data}`)
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
        url: '<?= base_url() ?>master/pemain/getPemain',
        data: {
            id: id
        }
    }).done((data) => {
        if (data.data) {
            data = data.data;
            $("#myModalLabel").text("Ubah Pemain");
            ajax_select(false, '#team', '<?= base_url(); ?>/master/pemain/ajax_select_list_team', null, '#myModal', 'Pilih Team', data.id_team);
            ajax_select(false, '#posisi', '<?= base_url(); ?>/master/pemain/ajax_select_list_posisi', null, '#myModal', 'Pilih Team', data.id_posisi);
            $('#id').val(data.id);
            $('#nama').val(data.nama);
            $('#logo').val(data.tmp_logo);
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