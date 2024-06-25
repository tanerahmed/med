




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
  <meta name="author" content="NobleUI">
  <meta name="keywords"
    content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

  <title>Admin Panel - HTML Bootstrap 5 Admin Dashboard Template</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->

  <!-- core:css !!!!!!!!!!!!!!!! asset -- MEAN Public/Assets folder !!!!!!!!!!!!!!!!!!!!!!!!!! -->
  <link rel="stylesheet" href="{{ asset('../assets/vendors/core/core.css') }}">
  <!-- endinject -->

  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{asset('../assets/vendors/flatpickr/flatpickr.min.css') }}">
  <!-- End plugin css for this page -->

  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('../assets/fonts/feather-font/css/iconfont.css') }}">
  <link rel="stylesheet" href="{{asset('../assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
  <!-- endinject -->

  <!-- Layout styles -->
  <link rel="stylesheet" href="{{asset('../assets/css/demo1/style.css') }}">
  <!-- End layout styles -->

  <link rel="shortcut icon" href="{{asset('../assets/images/favicon.png') }} " />

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
  {{-- jQuery --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>


  <style>
    #toast-container > .toast {
        font-size: 25px; /* Променете размера на текста */
        width: 700px; /* Променете ширината на съобщението */
    }
    #toast-container > .toast-success {
        background-color: #28a745;
        color: white;
    }
    #toast-container > .toast-error {
        background-color: #dc3545;
        color: white;
    }
    #toast-container > .toast-warning {
        background-color: #ffc107;
        color: black;
    }
    #toast-container > .toast-info {
        background-color: #17a2b8;
        color: white;
    }
</style>

</head>

<body>
  <div class="main-wrapper">

    <!-- partial:partials/_sidebar.html -->
    @include('layouts.admin_sidebar')
    <!-- partial -->

    <div class="page-wrapper">

      <!-- partial:partials/_navbar.html -->
      @include('layouts.admin_header')
      <!-- partial -->

      @yield('admin')

      <!-- partial:partials/_footer.html -->
      @include('layouts.admin_footer')
      <!-- partial -->

    </div>
  </div>

  <!-- core:js -->
  <script src="{{ asset('../assets/vendors/core/core.js') }}"></script>
  <!-- endinject -->

  <!-- Plugin js for this page -->
  <script src="{{ asset('../assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('../assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
  <!-- End plugin js for this page -->

  <!-- inject:js -->
  <script src="{{ asset('../assets/vendors/feather-icons/feather.min.js') }}"></script>
  <script src="{{ asset('../assets/js/template.js') }}"></script>
  <!-- endinject -->

  <!-- https://www.facebook.com/http.huy -->
  <script src="{{ asset('../assets/js/dashboard-dark.js') }}"></script>
  <!-- https://www.facebook.com/taner.ahmed -->

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script src="{{ asset('../assets/js/article_form_validation.js') }}"></script>
  <script src="{{ asset('../assets/js/dynamicFields.js') }}"></script>
  <script src="{{ asset('../assets/js/dynamicAddAuthors.js') }}"></script>
  

  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  

<script>
 @if(Session::has('message'))
 var type = "{{ Session::get('alert-type','info') }}"
 switch(type){
    case 'info':
    toastr.info(" {{ Session::get('message') }} ");
    break;

    case 'success':
    toastr.success(" {{ Session::get('message') }} ");
    break;

    case 'warning':
    toastr.warning(" {{ Session::get('message') }} ");
    break;

    case 'error':
    toastr.error(" {{ Session::get('message') }} ");
    break; 
 }
 @endif 

  // Вашият jQuery код
  $(document).ready(function() {
    // Инициализация на DataTables
    $('.table').DataTable();
  });
</script>

</body>

</html>
