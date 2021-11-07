$(function () {

    function dynamic() {
        const table_html = $('#dt_basic');
        table_html.dataTable().fnDestroy()
        const new_table = table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>referral/pencairan/ajax_data/",
                "data": null,
                "type": 'POST'
            },
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "lengthChange": true,
            "autoWidth": false,
            "columns": [
                { "data": null },
                {
                    "data": "id", render(data, type, full, meta) {
                        return full.status == 0 ? `<div class="pull-right">
									<button class="btn btn-primary btn-xs"
                                    data-id="${full.id}"
                                    data-status="1"
                                    data-title="Cairkan Pengajuan"
                                    data-toggle="modal" data-target="#tambahModal"
                                    onclick="Ubah(this)">
										<i class="fa fa-check"></i> Cairkan
									</button>
									<button class="btn btn-danger btn-xs"
                                    data-id="${full.id}"
                                    data-status="2"
                                    data-title="tolak Pencairan"
                                    data-toggle="modal" data-target="#tambahModal"
                                    onclick="Ubah(this)">
                                        <i class="fa fa-times"></i> Tolak
									</button>
								</div > `: ''
                    }, className: "nowrap"
                },
                {
                    "data": "status", render(data, type, full, meta) {
                        let color = 'success';
                        color = data == 0 ? 'warning' : color;
                        color = data == 1 ? 'success' : color;
                        color = data == 2 ? 'danger' : color;
                        color = data == 3 ? 'dark' : color;
                        return `<span class="text-${color} font-weight-bold">${full.status_str}</span>`;
                    }
                },
                { "data": "nama_bank" },
                { "data": "no_rekening" },
                { "data": "atas_nama" },
                { "data": "tanggal" },
                { "data": "jumlah_dana" },
                {
                    "data": "foto", render(data, type, full, meta) {
                        return (data == '' || data == 'null' || data == null) ? '' : `<button
                        class="btn btn-success btn-sm btn-gambar"
                        data-toggle="modal"
                        data-data="${data}"
                        data-target="#gambar_modal"
                        onclick="view_gambar(this)"
                        id="btn-gambar"><i class="fas fa-eye"></i></button>|
                        <a href="<?= base_url() ?>files/bukti_pembayaran/${data}" target="_blank" download>Download</a>
                        `
                    }, className: "nowrap"
                },
                { "data": "catatan" },
                { "data": "diubah_oleh" },

            ],
            order: [
                [1, 'asc']
            ],
            columnDefs: [{
                orderable: false,
                targets: [0, 1]
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

    // tambah dan ubah
    $("#fmain").submit(function (ev) {
        ev.preventDefault();
        const form = new FormData(this);
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>referral/pencairan/simpan',
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
        }).always(() => {
            $.LoadingOverlay("hide");
            $('#tambahModal').modal('toggle')
        })
    });
})

// Click Ubah
const Ubah = (datas) => {
    const data = datas.dataset;
    $('#id').val(data.id);
    $('#status').val(data.status)
    if (data.status == 1) {
        $("#foto_con").removeAttr('style');
        $("#foto").attr('required', '');
    } else {
        $("#foto_con").attr('style', 'display:none');
        $("#foto").removeAttr('required');
    }
    $('#catatan').val('')
    $("#tambahModalTitle").text(data.title);
}

const view_gambar = (datas) => {
    $("#img-view").attr('src', `<?= base_url() ?>/files/bukti_pencairan/${datas.dataset.data}`)
}