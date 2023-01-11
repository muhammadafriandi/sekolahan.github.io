//  Swall Alert 2
const swal = $('.swal').data('swal');
if (swal) {
    Swal.fire({
        title : 'Data Berahasil',
        text : swal,
        icon : 'success'
    })
}

$(document).on('click', '.btn-hapus',function (e) {
    //hentikan asksi default
    e.preventDefault();
    const href = $(this).attr('href');

    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Data Yang Di Hapus Tidak Bisa Dikembalikan !!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Hapus'
      }).then((result) => {
        if (result.value) {
          document.location.href = href;
        }
      })
})

// dropify (image-preview)
$(document).ready(function() {
$('.dropify').dropify();
})