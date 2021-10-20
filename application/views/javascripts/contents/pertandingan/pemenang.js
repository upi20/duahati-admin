$(function () {
    // table kursi
    table_kursi();
    function table_kursi() {
        const table_html = $('#tbl_kursi');
        table_html.dataTable().fnDestroy()
        const table_render = table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>pertandingan/jadwal/ajax_kursi/",
                "data": {
                    id: global_id_pertandingan
                },
                "type": 'POST'
            },
            "processing": true,
            "serverSide": true,
            "responsive": false,
            "lengthChange": true,
            "autoWidth": false,
            "scrollX": true,
            "columns": [
                { "data": null },
                { "data": "nama" },
                { "data": "result" },
                { "data": "waktu" },
                { "data": "menang" },
                {
                    "data": "id", render(data, type, full, meta) {
                        return `<button class="btn btn-primary btn-xs"
                                    data-id="${data}"
                                    data-nama="${full.nama}"
                                    data-menang="${full.menang}"
                                    onclick="set_kursi(this)">
										<i class="fa fa-edit"></i> Pemenang
									</button>`
                    }, className: "nowrap"
                }
            ],
            columnDefs: [{
                orderable: false,
                targets: [0, 3]
            }],
            order: [
                [2, 'asc']
            ]
        });

        table_render.on('draw.dt', function () {
            var PageInfo = table_html.DataTable().page.info();
            table_render.column(0, {
                page: 'current'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });
    }

    // kursi submit
    $("#kursi-form").submit(function (ev) {
        ev.preventDefault();
        const data = new FormData(this);
        setBtnLoading('button[type=submit]', 'Submit');
        $.ajax({
            url: '<?= base_url()?>pertandingan/jadwal/simpan_kursi/',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: 'post',
            success: function (data) {
                setToast('success', 'primary', 'Sukses', 'Berhasil disimpan');
                $('#kursi-ubah').fadeOut();
                table_kursi();
            },
            error: function ($xhr) {
                if (!$xhr.responseText) {
                    setToast('danger', 'danger', 'Failed', "Mohon periksa koneksi anda.");
                    return;
                }
                const response = JSON.parse($xhr.responseText);
                setToast('danger', 'danger', 'Failed', response.message);
            },
            complete: function () {
                setBtnLoading('button[type=submit]', 'Submit', false);
            }
        });
    })


    // table mot
    table_mot();
    function table_mot() {
        const table_html = $('#tbl_mot');
        table_html.dataTable().fnDestroy()
        const table_render = table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>pertandingan/jadwal/ajax_mot/",
                "data": {
                    id: global_id_pertandingan,
                    id_pemain: global_id_mot
                },
                "type": 'POST'
            },
            "processing": true,
            "serverSide": true,
            "responsive": false,
            "lengthChange": true,
            "autoWidth": false,
            "scrollX": true,
            "columns": [
                { "data": null },
                { "data": "nama" },
                { "data": "waktu" },
                { "data": "menang" },
                {
                    "data": "id", render(data, type, full, meta) {
                        return `<button class="btn btn-primary btn-xs"
                                        data-id="${data}"
                                        data-nama="${full.nama}"
                                        data-menang="${full.menang}"
                                        onclick="set_mot(this)">
                                            <i class="fa fa-edit"></i> Pemenang
                                        </button>`
                    }, className: "nowrap"
                }
            ],
            columnDefs: [{
                orderable: false,
                targets: [0, 3]
            }],
            order: [
                [2, 'asc']
            ]
        });

        table_render.on('draw.dt', function () {
            var PageInfo = table_html.DataTable().page.info();
            table_render.column(0, {
                page: 'current'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });
    }

    // mot submit
    $("#mot-form").submit(function (ev) {
        ev.preventDefault();
        const data = new FormData(this);
        setBtnLoading('button[type=submit]', 'Submit');
        $.ajax({
            url: '<?= base_url()?>pertandingan/jadwal/simpan_mot/',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: 'post',
            success: function (data) {
                setToast('success', 'primary', 'Sukses', 'Berhasil disimpan');
                $('#mot-ubah').fadeOut();
                table_mot();
            },
            error: function ($xhr) {
                if (!$xhr.responseText) {
                    setToast('danger', 'danger', 'Failed', "Mohon periksa koneksi anda.");
                    return;
                }
                const response = JSON.parse($xhr.responseText);
                setToast('danger', 'danger', 'Failed', response.message);
            },
            complete: function () {
                setBtnLoading('button[type=submit]', 'Submit', false);
            }
        });
    })


    // table skor
    table_skor();
    function table_skor() {
        const table_html = $('#tbl_skor');
        table_html.dataTable().fnDestroy()
        const table_render = table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>pertandingan/jadwal/ajax_skor/",
                "data": {
                    id: global_id_pertandingan,
                    skor_1: global_skor_1,
                    skor_2: global_skor_2
                },
                "type": 'POST'
            },
            "processing": true,
            "serverSide": true,
            "responsive": false,
            "lengthChange": true,
            "autoWidth": false,
            "scrollX": true,
            "columns": [
                { "data": null },
                { "data": "nama" },
                { "data": "waktu" },
                { "data": "menang" },
                {
                    "data": "id", render(data, type, full, meta) {
                        return `<button class="btn btn-primary btn-xs"
                                        data-id="${data}"
                                        data-nama="${full.nama}"
                                        data-menang="${full.menang}"
                                        onclick="set_skor(this)">
                                            <i class="fa fa-edit"></i> Pemenang
                                        </button>`
                    }, className: "nowrap"
                }
            ],
            columnDefs: [{
                orderable: false,
                targets: [0, 3]
            }],
            order: [
                [2, 'asc']
            ]
        });

        table_render.on('draw.dt', function () {
            var PageInfo = table_html.DataTable().page.info();
            table_render.column(0, {
                page: 'current'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });
    }


    // skor submit
    $("#skor-form").submit(function (ev) {
        ev.preventDefault();
        const data = new FormData(this);
        setBtnLoading('button[type=submit]', 'Submit');
        $.ajax({
            url: '<?= base_url()?>pertandingan/jadwal/simpan_skor/',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: 'post',
            success: function (data) {
                setToast('success', 'primary', 'Sukses', 'Berhasil disimpan');
                $('#skor-ubah').fadeOut();
                table_skor();
            },
            error: function ($xhr) {
                if (!$xhr.responseText) {
                    setToast('danger', 'danger', 'Failed', "Mohon periksa koneksi anda.");
                    return;
                }
                const response = JSON.parse($xhr.responseText);
                setToast('danger', 'danger', 'Failed', response.message);
            },
            complete: function () {
                setBtnLoading('button[type=submit]', 'Submit', false);
            }
        });
    })
})

function set_mot(datas) {
    const data = datas.dataset;
    $('#mot-ubah').fadeIn();
    $('#mot-id').val(data.id);
    $('#mot-nama').val(data.nama);
    $('#mot-menang').val(data.menang);
}


function set_kursi(datas) {
    const data = datas.dataset;
    $('#kursi-ubah').fadeIn();
    $('#kursi-id').val(data.id);
    $('#kursi-nama').val(data.nama);
    $('#kursi-menang').val(data.menang);
}

function set_skor(datas) {
    const data = datas.dataset;
    $('#skor-ubah').fadeIn();
    $('#skor-id').val(data.id);
    $('#skor-nama').val(data.nama);
    $('#skor-menang').val(data.menang);
}