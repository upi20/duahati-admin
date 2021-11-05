$(function () {
    function dynamic() {
        const table_html = $('#dt_basic');
        table_html.dataTable().fnDestroy()
        const new_table = table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>pengaturan/BiayaPendaftaran/ajax_data/",
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
                {
                    "data": "nominal", render(data, type, full, meta) {
                        return `Rp. ${format_rupiah(data)}`;
                    }, className: "text-right"
                },
                { "data": "keterangan" },
                {
                    "data": "status", render(data, type, full, meta) {
                        return full.status_str;
                    }
                },
                {
                    "data": "id", render(data, type, full, meta) {
                        let btn_render = '';

                        const btn_aktifkan = `
									<button class="btn btn-info btn-xs"
                                        data-id="${data}"
                                        data-nama="${full.nama}"
                                        data-nominal="${full.nominal}"
                                        data-toggle="modal" data-target="#aktfkan"
                                    onclick="Aktifkan(this)">
										<i class="fa fa-check"></i> Aktifkan
									</button>
                        `;
                        btn_render += full.status == 0 ? btn_aktifkan : '';

                        const btn_ubah = `
									<button class="btn btn-primary btn-xs"
                                        data-id="${data}"
                                        data-nama="${full.nama}"
                                        data-nominal="${full.nominal}"
                                        data-keterangan="${full.keterangan}"
                                        data-status="${full.status}"
                                        data-toggle="modal" data-target="#tambahModal"
                                    onclick="Ubah(this)">
										<i class="fa fa-edit"></i> Ubah
									</button>
                        `;
                        btn_render += (full.status == 0 || full.status == 1) ? btn_ubah : '';

                        const btn_hapus = `
									<button class="btn btn-danger btn-xs" onclick="Hapus(${data})">
										<i class="fa fa-trash"></i> Hapus
									</button>
                        `;
                        btn_render += full.status == 0 ? btn_hapus : '';


                        return `<div class="pull-right">${btn_render}</div>`
                    }, className: "nowrap"
                }
            ],
            order: [
                [1, 'asc']
            ],
            columnDefs: [{
                orderable: false,
                targets: [0, 5]
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
        $("#tambahModalTitle").text("Tambah Biaya Pendaftaran");
        $('#id').val('');
        $('#nama').val('');
        $('#nominal').val('');
        $('#keterangan').val('');
    });

    // tambah dan ubah
    $("#fmain").submit(function (ev) {
        ev.preventDefault();
        const form = new FormData(this);
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>pengaturan/BiayaPendaftaran/' + ($("#id").val() == "" ? 'insert' : 'update'),
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

    // tambah dan ubah
    $("#faktifkan").submit(function (ev) {
        ev.preventDefault();
        const form = new FormData(this);
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>pengaturan/BiayaPendaftaran/aktifkan',
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
            $('#aktfkan').modal('toggle')
        })
    });

    // hapus
    $('#OkCheck').click(() => {
        let id = $("#idCheck").val()
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>pengaturan/BiayaPendaftaran/delete',
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
    $('#nominal').val(data.nominal);
    $('#keterangan').val(data.keterangan);
    $("#tambahModalTitle").text("Ubah Biaya Pendaftaran");
}

// Click Aktifkan
const Aktifkan = (datas) => {
    const data = datas.dataset;
    $('#aktifkan_id').val(data.id);
    $('#aktifkan_nama').text(data.nama);
    $('#aktifkan_nominal').text(`Rp. ${format_rupiah(data.nominal)}`);
}