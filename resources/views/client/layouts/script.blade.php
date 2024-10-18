 <!--Plugins-->
 <script src="{{ asset('client/js/jquery.js') }}"></script>
 <script src="{{ asset('client/js/plugins.js') }}"></script>
 <!--Template functions-->
 <script src="{{ asset('client/js/functions.js') }}"></script>
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
 <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
 
 <script>
    const toastify = (message, type) => {
        let background = "#28a745";

        if (type == 'error') {
            background = "#dc3545";
        } else if (type == 'warning') {
            background = "#ffc107";
        }

        Toastify({
            text: message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
                background: background,
            },
        }).showToast();
    }
 </script>

 @stack('script')