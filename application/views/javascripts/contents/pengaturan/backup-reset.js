let tabel = '';

const Reset = (tbl) => {
    tabel = tbl;
    $("#LabelCheck").text(`Reset ${tabel}`)
    $("#ContentCheck").text(`Apakah anda yakin akan me-reset data ${tabel}?`)
    $('#ModalCheck').modal('toggle')
}

$(function () {
    $('#OkCheck').click(() => {
        $.LoadingOverlay("show");
        $.ajax({
            method: 'post',
            url: `<?= base_url() ?>pengaturan/backupReset/reset${tabel}`,
            data: null
        }).done((data) => {
            Toast.fire({
                icon: 'success',
                title: 'Data berhasil direset'
            })
        }).fail(($xhr) => {
            Toast.fire({
                icon: 'error',
                title: 'Data gagal direset'
            })
        }).always(() => {
            $('#ModalCheck').modal('toggle')
            $.LoadingOverlay("hide");
        })
    })
})
