import swal from 'sweetalert2';
window.swal = swal;

export default class Confirm {
    delete() {
        return swal({
            title: 'Hapus data?',
            text: "Data yang telah dihapus tidak dapat dikembalikan!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus data!',
            cancelButtonText: 'Batalkan',
        })
    }
}