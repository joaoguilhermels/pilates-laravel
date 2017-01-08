@extends('layouts.admin.admin')

@section('content')
{{-- <div class="container"> --}}
    
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="clients">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Clients</span>
                <span class="info-box-number">{{ $clients }}</span>
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
          </a>
        </div><!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="professionals">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Professionals</span>
                <span class="info-box-number">{{ $professionals }}</span>
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
          </a>
        </div><!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">This Month</span>
              <span class="info-box-number">{{ $month }}</span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div><!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">This Year</span>
              <span class="info-box-number">{{ $year }}</span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div><!-- /.col -->
    </div>
    
{{-- </div> --}}
@endsection
