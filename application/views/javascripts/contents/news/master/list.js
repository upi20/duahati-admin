let global_dynamic = '';
$(function () {
    function dynamic(){
        const table_html = $('#dt_basic');
        table_html.dataTable().fnDestroy()
        const new_table = table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>news/master/ajax_data/",
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
                { "data": "judul" },
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
                {
                    "data": "id", render(data, type, full, meta) {
                        return `<button
                        class="btn btn-success btn-sm btn-gambar"
                        data-toggle="modal"
                        data-data="${data}"
                        data-target="#deskripsi_modal"
                        onclick="view_deskripsi(this)"
                        id="btn-deskripsi"><i class="fas fa-eye"></i></button>`
                    }, className: "nowrap"
                },
                { "data": "tanggal_terbit" },
                { 
                    "data": "status", render(data, type, full, meta) {
                        return full.status == 2 ? (
                        `<div class="d-flex justify-content-center"><input type="checkbox" class="form-check-input" data-id="${full.id}" data-st="${full.status}" id="dipublish" name="dipublish-${full.id}" onclick="Dipublish(this)" checked></div>`
                        ) :
                        (`<div class="d-flex justify-content-center"><input type="checkbox" class="form-check-input" data-id="${full.id}" data-st="${full.status}" id="dipublish" name="dipublish-${full.id}" onclick="Dipublish(this)"></div>`)
                    }, className: "nowrap"
                },
                { "data": "status_str" },
                {
                    "data": "id", render(data, type, full, meta) {
                        return `<div class="pull-right">
									<button class="btn btn-primary btn-xs"
                                        data-id="${data}"
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
    global_dynamic = dynamic;

    // hapus
    $('#OkCheck').click(() => {
        let id = $("#idCheck").val()
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>news/master/delete',
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
    $("#img-view").attr('src', `<?= base_url() ?>/files/news/master/${datas.dataset.data}`)
}

const view_deskripsi = (datas) => {
    id = datas.dataset.data
    $.LoadingOverlay("show");
        $.ajax({
            method: 'get',
            url: '<?= base_url() ?>news/master/getDeskripsi',
            data: {
                id: id
            }
        }).done((data) => {
            data = data[0]
            $("#isi-deskripsi").html(`${data.deskripsi}`)
        }).fail(($xhr) => {
            Toast.fire({
                icon: 'error',
                title: 'Data gagal didapatkan'
            })
        }).always(() => {
            $('#deskripsi_modal').modal('toggle')
            $.LoadingOverlay("hide");
        })
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
    window.location.replace("<?= base_url() ?>news/master/tambah/"+data.id)
}

// ketika dipublish di klik
const Dipublish = (datas) => {
    $.LoadingOverlay("show");
    const data = datas.dataset;
    let id = data.id
    let st = data.st
    console.log(id)
    console.log(st)
    $.ajax({
        method: 'post',
        url: '<?= base_url() ?>news/master/updatePublish',
        data: {
            id:id,
            st:st
        }
    }).done((data) => {
        Toast.fire({
            icon: 'success',
            title: 'Data berhasil diubah'
        })
        global_dynamic();
    }).fail(($xhr) => {
        Toast.fire({
            icon: 'error',
            title: 'Data gagal diubah'
        })
        st == 2 ? $( `[name=dipublish-${id}]` ).prop( "checked", true ) : $( `[name=dipublish-${id}]` ).prop( "checked", false );
    }).always(() => {
        $.LoadingOverlay("hide");
    })
}