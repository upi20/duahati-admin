$(function () {
    function dynamic() {
        const table_html = $('#dt_basic');
        table_html.dataTable().fnDestroy()
        const new_table = table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>pengaturan/rekening/ajax_data/",
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
                { "data": "nama" },
                { "data": "nama_bank" },
                { "data": "no_rekening" },
                { "data": "atas_nama" },
                {
                    "data": "icon", render(data, type, full, meta) {
                        return `<button
                        class="btn btn-success btn-sm btn-gambar"
                        data-toggle="modal"
                        data-data="${data}"
                        data-target="#gambar_modal"
                        onclick="view_gambar(this)"
                        id="btn-gambar"><i class="fas fa-eye"></i></button>`
                    }, className: "nowrap"
                },
                { "data": "keterangan" },
                { "data": "status_str" },
                {
                    "data": "id", render(data, type, full, meta) {
                        return `<div class="pull-right">
									<button class="btn btn-primary btn-xs"
                                        data-id="${data}"
                                        data-nama="${full.nama}"
                                        data-nama_bank="${full.nama_bank}"
                                        data-no_rekening="${full.no_rekening}"
                                        data-atas_nama="${full.atas_nama}"
                                        data-keterangan="${full.keterangan}"
                                        data-foto="${full.icon}"
                                        data-status="${full.status}"
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
        $("#tambahModalTitle").text("Tambah Rekening");
        $('#id').val('');
        $('#nama').val('');
        $('#nama_bank').val('');
        $('#no_rekening').val('');
        $('#atas_nama').val('');
        $('#keterangan').val('');
        $('#status').val('1');
    });

    // tambah dan ubah
    $("#fmain").submit(function (ev) {
        ev.preventDefault();
        const form = new FormData(this);
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>pengaturan/rekening/' + ($("#id").val() == "" ? 'insert' : 'update'),
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
            url: '<?= base_url() ?>pengaturan/rekening/delete',
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

const view_gambar = (datas) => {
    $("#img-view").attr('src', `<?= base_url() ?>/files/icon_bank/${datas.dataset.data}`)
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
    $('#temp_foto').val(data.foto);
    $('#foto').val('');
    $('#nama_bank').val(data.nama_bank);
    $('#no_rekening').val(data.no_rekening);
    $('#atas_nama').val(data.atas_nama);
    $('#keterangan').val(data.keterangan);
    $("#tambahModalTitle").text("Ubah Rekening");
}