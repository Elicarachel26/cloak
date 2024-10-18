<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>

<!-- password-addon init -->
<script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>

<!-- Sweet Alerts js -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    const hapus = (item, name, url, csrf) => {
        swal.fire({
            title: 'Are you sure to delete ' + item + ' ' + name + 
            '?',
            text: "Deleted data can't be restored!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    data: {
                        '_method': 'DELETE'
                    },
                    success: function(response) {
                        if (response.success) {
                            swal.fire({
                                title: 'Success',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            })
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal.fire({
                                title: 'Error',
                                text: response.message,
                                icon: 'error',
                            })
                        }
                    },
                    error: function() {
                        swal.fire({
                            title: 'Error',
                            text: 'Something went wrong',
                            icon: 'error',
                        })
                    }
                })
            }
        })
    }
</script>

@stack('script')