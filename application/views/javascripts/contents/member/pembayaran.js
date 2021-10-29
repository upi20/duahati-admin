$(function () {

    function dynamic() {
        const table_html = $('#dt_basic');
        table_html.dataTable().fnDestroy()
        const new_table = table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>member/pembayaran/ajax_data/",
                "data": {
                    member_id: $('#member_id').val()
                },
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
                                    data-jenis="${full.jenis}"
                                    data-status="1"
                                    data-title="Terima Pembayaran"
                                    data-toggle="modal" data-target="#tambahModal"
                                    onclick="Ubah(this)">
										<i class="fa fa-check"></i> Terima
									</button>
									<button class="btn btn-danger btn-xs"
                                    data-id="${full.id}"
                                    data-jenis="${full.jenis}"
                                    data-status="2"
                                    data-title="Tolak Pembayaran"
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
                        return `<span class="text-${color} font-weight-bold">${full.status_str}</span>`;
                    }
                },
                { "data": "jenis_str" },
                { "data": "bank_nama" },
                { "data": "no_rekening" },
                { "data": "atas_nama" },
                { "data": "tanggal" },
                { "data": "jumlah_pembayaran" },
                {
                    "data": "foto", render(data, type, full, meta) {
                        return `<button
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

    $("#btn-tambah").click(() => {
        $("#tambahModalTitle").text("Tambah member");
        $('#id').val('');
        $('#pembayaran_id').val('').trigger('change');
        $('#status').val('1');
    });

    // tambah dan ubah
    $("#fmain").submit(function (ev) {
        ev.preventDefault();
        const form = new FormData(this);
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>member/pembayaran/simpan',
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
    $('#jenis').val(data.jenis)
    $('#catatan').val('')
    $("#tambahModalTitle").text(data.title);
}

const view_gambar = (datas) => {
    $("#img-view").attr('src', `<?= base_url() ?>/files/bukti_pembayaran/${datas.dataset.data}`)
}