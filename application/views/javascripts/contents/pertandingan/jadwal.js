$("#team_1").select2({ dropdownParent: $('#myModal') });
$("#team_2").select2({ dropdownParent: $('#myModal') });
$("#stadion").select2({ dropdownParent: $('#myModal') });
$("#filter-team_1").select2({ dropdownParent: $('#filter') });
$("#filter-team_2").select2({ dropdownParent: $('#filter') });
$("#filter-stadion").select2({ dropdownParent: $('#filter') });
$('#filter_date').daterangepicker();
$("#man_of_the_match").select2({ dropdownParent: $('#filter') });
$(function () {
    function dynamic(datas = {
        start: null,
        end: null,
        team_1: null,
        team_2: null,
        stadion: null,
    }) {
        let filter = null;
        if (datas.start != null && datas.end != null && datas.team_1 != null && datas.team_2 != null && datas.stadion != null) {
            filter = {
                date_start: datas.start,
                date_end: datas.end,
                team_1: datas.team_1,
                team_2: datas.team_2,
                stadion: datas.stadion,
            }
        }

        const table_html = $('#dt_basic');
        table_html.dataTable().fnDestroy()
        table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>pertandingan/jadwal/ajax_data/",
                "data": filter,
                "type": 'POST'
            },
            "processing": true,
            "serverSide": true,
            "responsive": false,
            "lengthChange": true,
            "autoWidth": false,
            "scrollX": true,
            "columns": [
                { "data": "team_1" },
                { "data": "team_2" },
                { "data": "stadion" },
                { "data": "tanggal_main" },
                { "data": "jam_main" },
                {
                    "data": "hasil_team_1", render(data, type, full, meta) {
                        return data == null ? '' : `${data} vs ${full.hasil_team_2}`;
                    }
                },
                {
                    "data": "motm", render(data, type, full, meta) {
                        return data ? `${data} (${full.vote} Vote)` : '';
                    }
                },
                {
                    "data": "id", render(data, type, full, meta) {
                        return `<button class="btn btn-primary btn-xs" onclick="Voted(${data})">
                                    <i class="fa fa-edit"></i> Lihat
                                </button>`;
                    }
                },
                { "data": "status_str" },
                {
                    "data": "id", render(data, type, full, meta) {
                        return `<div class="pull-right">
                                    <a href="<?= base_url() ?>pertandingan/jadwal/pemenang/${data}" class="btn btn-info btn-xs"><i class="fa fa-trophy"></i> Pemenang</a>
									<button
                                    data-id="${full.id}"
                                    data-hasil_team_1="${full.hasil_team_1}"
                                    data-hasil_team_2="${full.hasil_team_2}"
                                    data-man_of_the_match="${full.man_of_the_match}"
                                    class="btn btn-warning btn-xs" onclick="hasilPertandingan(this)">
										<i class="fa fa-list"></i> Hasil Pertandingan
									</button>
									<button
                                    data-id="${full.id}"
                                    data-id_team_1="${full.id_team_1}"
                                    data-id_team_2="${full.id_team_2}"
                                    data-id_stadion="${full.id_stadion}"
                                    data-tanggal_main="${full.tanggal_main}"
                                    data-jam_main="${full.jam_main}"
                                    class="btn btn-primary btn-xs" onclick="Ubah(this)">
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
    // initial ajax select
    ajax_select({ id: '#btn-tambah', pretext: 'Tambah', text: '<i class="fa fa-plus"></i> Tambah' }, '#filter-team_1', '<?= base_url(); ?>/pertandingan/jadwal/ajax_select_list_team', null, false, 'Pilih Team 1');
    ajax_select({ id: '#btn-tambah', pretext: 'Tambah', text: '<i class="fa fa-plus"></i> Tambah' }, '#filter-team_2', '<?= base_url(); ?>/pertandingan/jadwal/ajax_select_list_team', null, false, 'Pilih Team 2');
    ajax_select({ id: '#btn-tambah', pretext: 'Tambah', text: '<i class="fa fa-plus"></i> Tambah' }, '#filter-stadion', '<?= base_url(); ?>/pertandingan/jadwal/ajax_select_list_stadion', null, false, 'Pilih Stadion');
    ajax_select({ id: '#btn-tambah', pretext: 'Tambah', text: '<i class="fa fa-plus"></i> Tambah' }, '#team_1', '<?= base_url(); ?>/pertandingan/jadwal/ajax_select_list_team', null, false, 'Pilih Team 1');
    ajax_select({ id: '#btn-tambah', pretext: 'Tambah', text: '<i class="fa fa-plus"></i> Tambah' }, '#team_2', '<?= base_url(); ?>/pertandingan/jadwal/ajax_select_list_team', null, false, 'Pilih Team 2');
    ajax_select({ id: '#btn-tambah', pretext: 'Tambah', text: '<i class="fa fa-plus"></i> Tambah' }, '#stadion', '<?= base_url(); ?>/pertandingan/jadwal/ajax_select_list_stadion', null, false, 'Pilih Stadion');
    ajax_select({ id: '#btn-tambah', pretext: 'Tambah', text: '<i class="fa fa-plus"></i> Tambah' }, '#man_of_the_match', '<?= base_url(); ?>/pertandingan/jadwal/ajax_select_list_pemain', null, false, 'Pilih Man If The Match');


    $("#btn-filter").click(() => {
        $('#stfilter').val(1);
        const date = $('#filter_date').data('daterangepicker');
        const team_1 = $('#filter-team_1').val();
        const team_2 = $('#filter-team_2').val();
        const stadion = $('#filter-stadion').val();
        dynamic({
            start: date.startDate.format('YYYY-MM-DD'),
            end: date.endDate.format('YYYY-MM-DD'),
            team_1: team_1,
            team_2: team_2,
            stadion: stadion,
        });
    });

    $('#team_1').change(() => {
        if ($('#team_1').val() != '') {
            if ($('#team_1').val() == $('#team_2').val()) {
                $('#team_1').val("").trigger('change');
                Toast.fire({
                    icon: 'error',
                    title: 'Kedua Team tidak boleh sama !'
                })
            }
        }
    })

    $('#team_2').change(() => {
        if ($('#team_2').val() != '') {
            if ($('#team_1').val() == $('#team_2').val()) {
                $('#team_2').val("").trigger('change');
                Toast.fire({
                    icon: 'error',
                    title: 'Kedua Team tidak boleh sama !'
                })
            }
        }
    })

    $("#btn-tambah").click(() => {
        $("#myModalLabel").text("Tambah Jadwal");
        $('#id').val("");
        $('#team_1').val("").trigger('change');
        $('#team_2').val("").trigger('change');
        $('#stadion').val("").trigger('change');
        $('#tanggal_main').val("");
        $('#jam_main').val("");
        $('#status').val("0");
    });

    // tambah dan ubah
    $("#form").submit(function (ev) {
        ev.preventDefault();
        const form = new FormData(this);
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>pertandingan/jadwal/' + ($("#id").val() == "" ? 'insert' : 'update'),
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

    // tambah dan ubah
    $("#fhasil").submit(function (ev) {
        ev.preventDefault();
        const form = new FormData(this);
        form.append('id', $("#id").val())
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>pertandingan/jadwal/hasil_pertandingan',
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
            $('#hasilPertandingan').modal('toggle')
        })
    });

    // hapus
    $('#OkCheck').click(() => {
        let id = $("#idCheck").val()
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>pertandingan/jadwal/delete',
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

const view_logo = (datas) => {
    $("#img-view").attr('src', `<?= base_url() ?>/files/jadwal/${datas.dataset.data}`)
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
    $("#myModalLabel").text("Ubah Jadwal");
    $('#id').val(data.id);
    $('#tanggal_main').val(data.tanggal_main);
    $('#jam_main').val(data.jam_main);
    $('#team_1').val(data.id_team_1).trigger('change');
    $('#team_2').val(data.id_team_2).trigger('change');
    $('#stadion').val(data.id_stadion).trigger('change');
    $('#status').val(data.status);
    $('#myModal').modal('toggle')
}
// Click Ubah
const hasilPertandingan = (datas) => {
    const data = datas.dataset;
    $('#id').val(data.id);
    $('#hasil_team_1').val(data.hasil_team_1);
    $('#hasil_team_2').val(data.hasil_team_2);
    $('#man_of_the_match').val(data.man_of_the_match).trigger('change');
    $('#status').val(data.status);
    $('#hasilPertandingan').modal('toggle')
}


// Click Ubah
const Voted = (id) => {
    $.LoadingOverlay("show");
    $.ajax({
        method: 'post',
        url: '<?= base_url() ?>pertandingan/jadwal/getDetailMotm',
        data: {
            id: id
        }
    }).done((data) => {
        if (data) {
            $("#Listvoting").modal('toggle');
            // render body
            const table_body = $("#tbl_vote_body");
            table_body.html('');
            const element_table = $('#tbl_vote');
            $(element_table).dataTable().fnDestroy();
            let table_body_html = '';
            let number = 1;
            data.forEach(e => {
                table_body_html += `
                <tr>
                    <td>${number++}</td>
                    <td>${e.nama}</td>
                    <td>${e.vote}</td>
                </tr>
                `;
            });
            table_body.html(table_body_html);
            renderTable(element_table);
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

function renderTable(element_table) {
    const tableUser = $(element_table).DataTable({
        columnDefs: [{
            orderable: false,
            targets: [0]
        }],
        order: [
            [2, 'desc']
        ]
    });
    tableUser.on('draw.dt', function () {
        var PageInfo = $(element_table).DataTable().page.info();
        tableUser.column(0, {
            page: 'current'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });
}