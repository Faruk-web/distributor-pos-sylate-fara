
        <script src="{{asset('backend/assets/js/oneui.core.min.js') }}"></script>

        <script src="{{asset('backend/assets/js/oneui.app.min.js') }}"></script>

        <script src="{{asset('backend/assets/js/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
   

        <script src="{{asset('backend/assets/js/pages/be_pages_dashboard.min.js') }}"></script>
        <script src="{{ asset('js/toastify-js.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/sweetalert.min.js') }}"></script>

        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var route = "{{ route('supplier.supplier.search') }}";
            $('#supplier_search').typeahead({
                source: function (query, process) {
                    return $.get(route, {
                        query: query
                    }, function (data) {
                        return process(data);
                    });
                }
            });
        </script> -->


        
        <script>
            jQuery(function () {
                One.helpers(['sparkline']);
            });

            
            function balance_statement() {
                $.ajax({
                    type: 'get',
                    url: '/admin/report/header-balance-statements',
                    beforeSend: function() {
                        $('#balance_output_show_div').html('<div class="text-center col-md-12"><div class="spinner-border text-dark mb-5" role="status"><span class="sr-only">Loading...</span></div></div>');
                    },
                    success: function (data) {
                        $('#balance_output_show_div').html(data);
                    }
                });
            }

        </script>

        @if(session('success'))
        <script>
            // swal({
            //     title: "Success",
            //     text: "{{ session('success') }}",
            //     icon: "success",
            //     button: "Ok",
            // });
            Toastify({
                text: "{{ session('success') }}",
                backgroundColor: "linear-gradient(to right, #269E70, #00BFA6)",
                className: "success",
            }).showToast();
            var play = document.getElementById('success').play();
        </script>
        @endif

        @if(session('error'))
        <script>
            // swal({
            //     title: "Error",
            //     text: "{{ session('error') }}",
            //     icon: "error",
            //     button: "Ok",
            // });
            Toastify({
                text: "{{ session('error') }}",
                backgroundColor: "linear-gradient(to right, #6E32CF, #FFA300)",
                className: "error",
            }).showToast();
            var play = document.getElementById('error').play();
        </script>
        @endif
        
        <script>
            function form_submit(number) {
                if (document.getElementById("form_"+number).checkValidity()) { 
                    $('#submit_button_'+number).hide();
                    $('#processing_button_'+number).show();
                }
                else {
                    Toastify({
                        text: "Something is missing!",
                        backgroundColor: "linear-gradient(to right, #6E32CF, #FFA300)",
                        className: "error",
                    }).showToast();
                    var play = document.getElementById('error').play(); 
                }
            }
        </script>
        
        
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>


<script>
    
$(document).ready(function() {
    $('.select1').selectpicker();
    $('.select2').selectpicker();
    $('.select3').selectpicker();
    $('.select4').selectpicker();
});

function error(info) {
    Toastify({
        text: info,
        backgroundColor: "linear-gradient(to right, #6E32CF, #FFA300)",
        className: "error",
    }).showToast();
    var play = document.getElementById('error').play(); 
}

function success(info) {
    Toastify({
        text: info,
        backgroundColor: "linear-gradient(to right, #269E70, #00BFA6)",
        className: "success",
    }).showToast();
    var play = document.getElementById('success').play();
}


</script>
        

    </body>
</html>
