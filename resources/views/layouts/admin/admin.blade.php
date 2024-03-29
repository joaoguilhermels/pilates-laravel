<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AdminLTE 2 | Starter</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- Ionicons -->
  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"> --}}
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css") }}">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/dist/css/skins/skin-blue.min.css") }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->


  <!-- Fonts -->
  <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
  <!-- link href="//fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css' -->

  <!-- Styles -->
  <!--link href="/css/app.css" rel="stylesheet"-->
  <link href="/css/all.css" rel="stylesheet">
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  @yield('css')

  <!-- Scripts -->
  <script defer>
      window.Laravel = <?php echo json_encode([
          'csrfToken' => csrf_token(),
      ]); ?>
  </script>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div id="app" class="wrapper">

  <!-- Header -->
  @include('layouts/admin/header')

  <!-- Sidebar -->
  @include('layouts/admin/sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    {{-- <section class="content-header">
      <h1>
        {{ $page_title or "Page Title" }}
        <small>{{ $page_description or null }}</small>
        @if(isset($button_link))
          <a href="{{ $button_link }}" class="btn btn-success"><i class="fa fa-plus"></i> {{ $button_text or "..." }}</a>
        @endif
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section> --}}

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->
      @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Footer -->
  @include('layouts/admin/footer')

  <!-- Control Sidebar -->
  @include('layouts/admin/control-sidebar')
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<!-- <script src="plugins/jQuery/jquery-2.2.3.min.js"></script> -->
<!-- Bootstrap 3.3.6 -->
<!-- <script src="bootstrap/js/bootstrap.min.js"></script> -->

  <script src="{{ mix('js/app.js') }}"></script>
  {{-- <script src="/js/app.js"></script> --}}
  @yield('script_footer')

  <!-- AdminLTE App -->
  <script src="{{ asset("/bower_components/AdminLTE/dist/js/app.min.js") }}"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>