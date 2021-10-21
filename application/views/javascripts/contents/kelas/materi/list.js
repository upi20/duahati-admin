$("#kelas").select2({ dropdownParent: $('#tambahModal') });
$(function () {
    ajax_select(false, '#kelas_id', '<?= base_url(); ?>kelas/master/getList', null, false, 'Pilih kelas');
    function dynamic() {
        const table_html = $('#dt_basic');
        table_html.dataTable().fnDestroy()
        const new_table = table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>kelas/materi/ajax_data/",
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
                { "data": "kelas" },
                { "data": "nama" },
                { "data": "keterangan" },
                {
                    "data": "url", render(data, type, full, meta) {
                        return `<button
                        class="btn btn-success btn-sm btn-video"
                        data-toggle="modal"
                        data-data="${data}"
                        data-target="#video_modal"
                        onclick="view_video(this)"
                        id="btn-video"><i class="fas fa-eye"></i></button>`
                    }, className: "nowrap"
                },
                { "data": "jumlah_ditonton" },
                { "data": "status_str" },
                {
                    "data": "id", render(data, type, full, meta) {
                        return `<div class="pull-right">
									<button class="btn btn-primary btn-xs"
                                        data-id="${data}"
                                        data-kelas_id="${full.kelas_id}"
                                        data-nama="${full.nama}"
                                        data-url="${full.url}"
                                        data-keterangan="${full.keterangan}"
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
        $("#tambahModalTitle").text("Tambah kelas");
        $('#id').val('');
        $('#nama').val('');
        $('#kelas_id').val('').trigger('change');
        $('#url').val('');
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
            url: '<?= base_url() ?>kelas/materi/' + ($("#id").val() == "" ? 'insert' : 'update'),
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
            url: '<?= base_url() ?>kelas/materi/delete',
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
    $("#img-view").attr('src', `<?= base_url() ?>/files/kelas/materi/${datas.dataset.data}`)
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
    $('#url').val(data.url);
    $('#kelas_id').val(data.kelas_id).trigger('change');
    $('#nama').val(data.nama);
    $('#keterangan').val(data.keterangan);
    $('#status').val(data.status);
    $("#tambahModalTitle").text("Ubah kelas");
}

const view_video = (datas) => {
    $("#video-view").html(youtube_embed_html_generate(datas.dataset.data))
    $('#video_modal').on('hidden.bs.modal', function (e) {
        $("#video-view").html('');
    })
}

function youtube_embed_html_generate(url) {
    const id = youtube_parser(url);
    return `<iframe
      frameborder="0"
      scrolling="no"
      marginheight="0"
      marginwidth="0"
      width="100%"
      height="400px"
      type="text/html"
      src="https://www.youtube.com/embed/${id}?autoplay=1&fs=1&iv_load_policy=1&showinfo=1&rel=0&cc_load_policy=1&start=0&end=0"></iframe>`
}

function youtube_parser(url) {
    var regExp = /^https?\:\/\/(?:www\.youtube(?:\-nocookie)?\.com\/|m\.youtube\.com\/|youtube\.com\/)?(?:ytscreeningroom\?vi?=|youtu\.be\/|vi?\/|user\/.+\/u\/\w{1,2}\/|embed\/|watch\?(?:.*\&)?vi?=|\&vi?=|\?(?:.*\&)?vi?=)([^#\&\?\n\/<>"']*)/i;
    var match = url.match(regExp);
    return (match && match[1].length == 11) ? match[1] : false;
}