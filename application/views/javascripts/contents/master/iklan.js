$("#pertandingan").select2({ dropdownParent: $('#myModal') });
$(function () {
    function dynamic() {
        const table_html = $('#dt_basic');
        table_html.dataTable().fnDestroy()
        table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>master/iklan/ajax_data/",
                "data": null,
                "type": 'POST'
            },
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "columns": [
                { "data": "nama" },
                { "data": "pertandingan" },
                {
                    "data": "gambar", render(data, type, full, meta) {
                        return full.jenis == 1 ? `<button
                    class="btn btn-success btn-sm btn-gambar"
                    data-toggle="modal"
                    data-data="${data}"
                    data-target="#gambar_modal"
                    onclick="view_gambar(this)"
                    id="btn-gambar"><i class="fas fa-search"></i></button>`: ''
                    }, className: "nowrap"
                },
                {
                    "data": "url", render(data, type, full, meta) {
                        return full.jenis == 2 ? `<button
                    class="btn btn-success btn-sm btn-video"
                    data-toggle="modal"
                    data-data="${data}"
                    data-target="#video_modal"
                    onclick="view_video(this)"
                    id="btn-video"><i class="fas fa-search"></i></button>`: ''
                    }, className: "nowrap"
                },
                { "data": "jenis_str" },
                {
                    "data": "durasi", render(data, type, full, meta) {
                        return `${data} detik`;
                    }
                },
                {
                    "data": "dilihat", render(data, type, full, meta) {
                        return `${data} X`;
                    }
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
									<button class="btn btn-primary btn-xs"
                                        data-id="${full.id}"
                                        data-nama="${full.nama}"
                                        data-url="${full.url}"
                                        data-jenis="${full.jenis}"
                                        data-gambar="${full.gambar}"
                                        data-durasi="${full.durasi}"
                                        data-id_pertandingan="${full.id_pertandingan}"
                                        data-status="${full.status}"
                                        data-toggle="modal" data-target="#myModal"
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
        });
    }
    dynamic();

    $("#btn-tambah").click(() => {
        $("#myModalLabel").text("Tambah iklan");
        $('#id').val('');
        $('#nama').val('');
        $('#pertandingan').val('').trigger('change');
        $('#temp_gambar').val('');
        $('#gambar').val('');
        $('#durasi').val('10');
        $('#url').val('');
        $('#status').val('1');
        $('#jenis').val('1');
        setInputJenis();
    });

    // tambah dan ubah
    $("#form").submit(function (ev) {
        ev.preventDefault();
        const form = new FormData(this);
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>master/iklan/' + ($("#id").val() == "" ? 'insert' : 'update'),
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
            url: '<?= base_url() ?>master/iklan/delete',
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

    $('#jenis').change(() => {
        setInputJenis();
    })


})

const view_gambar = (datas) => {
    $("#img-view").attr('src', `<?= base_url() ?>/files/iklan/${datas.dataset.data}`)
}

const view_video = (datas) => {
    $("#video-view").html(youtube_embed_html_generate(datas.dataset.data))
    $('#video_modal').on('hidden.bs.modal', function (e) {
        $("#video-view").html('');
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
    $("#myModalLabel").text("Ubah iklan");
    $('#id').val(data.id);
    $('#nama').val(data.nama);
    $('#pertandingan').val(data.id_pertandingan).trigger('change');
    $('#temp_gambar').val(data.gambar);
    $('#gambar').val('');
    $('#durasi').val(data.durasi);
    $('#url').val(data.url);
    $('#status').val(data.status);
    $('#jenis').val(data.jenis);
    setInputJenis();
}

function setInputJenis() {
    const gambar = $('#gambar_view');
    const url = $('#url_view');
    if ($('#jenis').val() == 1) {
        gambar.fadeIn();
        url.fadeOut();
    } else {
        url.fadeIn();
        gambar.fadeOut();
    }
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