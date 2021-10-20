$("#team").select2();
$("#posisi").select2();
$(function () {
    function dynamic() {
        const table_html = $('#dt_basic');
        table_html.dataTable().fnDestroy()
        table_html.DataTable({
            "ajax": {
                "url": "<?= base_url()?>member/dataMember/ajax_data/",
                "data": null,
                "type": 'POST'
            },
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "columns": [
                { "data": "username" },
                { "data": "email" },
                { "data": "no_whatsapp" },
                {
                    "data": "photo", render(data, type, full, meta) {
                        return `<button
                    class="btn btn-success btn-sm btn-photo"
                    data-toggle="modal"
                    data-data="${data}"
                    data-target="#photo"
                    onclick="view_photo(this)"
                    id="btn-photo"><i class="fas fa-search"></i></button>`
                    }, className: "nowrap"
                },
                { "data": "status_str" },
                {
                    "data": "updated_at", render(data, type, full, meta) {
                        return data == null || data == '' ? full.created_at : full.updated_at;

                    }, className: "nowrap"
                }
            ],
        });
    }
    dynamic();

})

const view_photo = (datas) => {
    $("#img-view").attr('src', `<?= base_url() ?>/files/member/${datas.dataset.data}`)
}
