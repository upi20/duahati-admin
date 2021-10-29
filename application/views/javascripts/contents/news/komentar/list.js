let gb_id = '', gb_aksi = '', gb_st = '', gb_ps = ''
$(function () {
    $('#filter-news').select2();
    ajax_select(false, '#filter-news', '<?= base_url(); ?>news/master/getList', null, false, 'Pilih News');
    $('#filter-member').select2();
    ajax_select(false, '#filter-member', '<?= base_url(); ?>news/komentar/getListMember', null, false, 'Pilih Member');
    function dynamic(datas = {
        news: null,
        member: null,
    }) {
        let filter = null;
        if (datas.news != null && datas.member != null) {
            filter = {
                news: datas.news,
                member: datas.member,
            }
        }
        const table_html = $('#dt_basic');
        table_html.dataTable().fnDestroy()
        const new_table = table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>news/komentar/ajax_data/",
                "data": datas,
                "type": 'POST'
            },
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "columns": [
                { "data": null },
                { "data": "news" },
                { "data": "member" },
                { "data": "komentar" },
                { "data": "status_str" },
                {
                    "data": "id", render(data, type, full, meta) {
                        return `<div class="pull-right">`+
                                    (full.status != 1 ?
									(`<button class="btn btn-primary btn-xs mr-1" onclick="Set(${data}, 'aktifkan', 'setStatus', '1')">
										<i class="fa fa-edit"></i> Aktifkan
									</button>`) :
									(`<button class="btn btn-warning btn-xs mr-1" onclick="Set(${data}, 'non-Aktifkan', 'setStatus', '2')">
										<i class="fa fa-edit"></i> Non-Aktifkan
									</button>`))+
									`<button class="btn btn-danger btn-xs" onclick="Set(${data}, 'hapus', 'delete')">
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

    $("#btn-filter").click(() => {
        $('#stfilter').val(1);
        const news = $('#filter-news').val();
        const member = $('#filter-member').val();
        dynamic({
            news: news,
            member: member,
        });
    });

    // hapus
    $('#OkCheck').click(() => {
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: '<?= base_url() ?>news/komentar/' + gb_aksi,
            data: {
                id: gb_id,
                aksi: gb_aksi,
                st: gb_st,
            }
        }).done((data) => {
            Toast.fire({
                icon: 'success',
                title: 'Data berhasil di'+gb_ps
            })
            dynamic();
        }).fail(($xhr) => {
            Toast.fire({
                icon: 'error',
                title: 'Data gagal di'+gb_ps
            })
        }).always(() => {
            $('#ModalCheck').modal('toggle')
            $.LoadingOverlay("hide");
        })
    })
})

// Click Set
const Set = (id = null, ps = '', aksi = null, st = null) => {
    gb_id = id
    gb_ps = ps
    gb_aksi = aksi
    gb_st = st
    // $("#idCheck").val(id)
    $("#LabelCheck").text('Form Konfirmasi')
    $("#ContentCheck").text('Apakah anda yakin akan meng'+gb_ps+' data ini?')
    $('#ModalCheck').modal('toggle')
}
