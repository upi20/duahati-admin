let check_no_urut = true;
let check_no_urut_check = true;
let no_urut_current = 0;
let kelas_id_current = 0;
$(function () {
    function dynamic() {
        const table_html = $('#dt_basic');
        table_html.dataTable().fnDestroy()
        const new_table = table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>kelas/materi/ajax_data_materi_kelas/",
                "data": {
                    kelas: $('#kelas_id').val(),
                },
                "type": 'POST'
            },
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "columns": [
                { "data": "no_urut" },
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
                { "data": "submateri_str" },
                { "data": "jumlah_ditonton" },
                { "data": "status_str" },
                {
                    "data": "id", render(data, type, full, meta) {
                        const btn_submateri = full.submateri == 1 ? `
                            <a href="<?= base_url()?>kelas/materi/sub/${data}" class="btn btn-xs btn-info">
                                <i class="fas fa-file-video"></i> Sub Materi
                            </a>
                        ` : '';
                        return `<div class="pull-right">
                                    ${btn_submateri}
									<button class="btn btn-primary btn-xs"
                                        data-id="${data}"
                                        data-kelas_id="${full.kelas_id}"
                                        data-nama="${full.nama}"
                                        data-url="${full.url}"
                                        data-keterangan="${full.keterangan}"
                                        data-status="${full.status}"
                                        data-submateri="${full.submateri}"
                                        data-no_urut="${full.no_urut}"
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
                [0, 'asc']
            ],
            columnDefs: [{
                orderable: false,
                targets: [6]
            }],
        });
        // new_table.on('draw.dt', function () {
        //     var PageInfo = table_html.DataTable().page.info();
        //     new_table.column(0, {
        //         page: 'current'
        //     }).nodes().each(function (cell, i) {
        //         cell.innerHTML = i + 1 + PageInfo.start;
        //     });
        // });
    }
    dynamic();

    $("#btn-filter").click(() => {
        $('#stfilter').val(1);
        const kategori = $('#filter-kategori').val();
        const kelas = $('#filter-kelas').val();
        dynamic({
            kategori: kategori,
            kelas: kelas,
        });
    });

    $("#btn-tambah").click(() => {
        $("#tambahModalTitle").text("Tambah kelas");
        $('#id').val('');
        $('#nama').val('');
        $('#url').val('');
        $('#keterangan').val('');
        $('#status').val('1');
        no_urut_get_new($("#kelas_id").val());
        stop_no_urut();
        document.getElementById('submateri').checked = false;
    });

    // tambah dan ubah
    $("#fmain").submit(function (ev) {
        ev.preventDefault();
        const submateri = document.querySelector('#submateri').checked ? 1 : 0;
        const form = new FormData(this);
        form.append('submateri', submateri);
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
    $("#kelas_id").change(function () {
        no_urut_get_new(this.value)
    })
    $("#no_urut").change(function () {
        no_urut_get_check($("#kelas_id").val(), this.value)
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
    stop_no_urut(2000);
    $('#id').val(data.id);
    $('#url').val(data.url);
    $('#no_urut').val(data.no_urut);
    no_urut_current = data.no_urut;
    kelas_id_current = data.kelas_id;
    $('#nama').val(data.nama);
    $('#keterangan').val(data.keterangan);
    $('#status').val(data.status);
    document.getElementById('submateri').checked = data.submateri == 1;
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


function no_urut_get_new(kelas_id) {
    if (!check_no_urut) {
        return;
    }
    $.ajax({
        method: 'post',
        url: '<?= base_url() ?>kelas/materi/noUrut',
        data: {
            kelas_id: kelas_id
        }
    }).done((data) => {
        $("#no_urut").val(data);
    }).fail(($xhr) => {
        console.log($xhr);
    })
}

function no_urut_get_check(kelas_id, no) {

    if (!check_no_urut || (no_urut_current == no && kelas_id_current == kelas_id)) {
        return;
    }
    $.ajax({
        method: 'post',
        url: '<?= base_url() ?>kelas/materi/cekNoUrut',
        data: {
            kelas_id: kelas_id,
            no: no,
        }
    }).done((data) => {
        if (data) {
            Toast.fire({
                icon: 'success',
                title: 'No Urut Belum Digunakan'
            })
        } else {
            Toast.fire({
                icon: 'error',
                title: 'No Urut Sudah Digunakan'
            })
            no_urut_get_new(kelas_id);
        }
    }).fail(($xhr) => {
        console.log($xhr);
    })
}

function stop_no_urut(time = 1000) {
    check_no_urut = false;
    setTimeout(() => {
        check_no_urut = true;
    }, time);
}

function stop_no_urut_check(time = 1000) {
    check_no_urut_check = false;
    setTimeout(() => {
        check_no_urut_check = true;
    }, time);
}