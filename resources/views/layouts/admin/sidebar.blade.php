<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    {{-- <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset("/bower_components/AdminLte/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name }}</p>
        <!-- Status -->
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div> --}}

    <!-- search form (Optional) -->
    {{-- <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form> --}}
    <!-- /.search form -->

    <!-- Sidebar Menu -->
    {{-- <ul class="sidebar-menu">
      <li class="header">HEADER</li>
      <!-- Optionally, you can add icons to the links -->
      <li class="active"><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li>
      <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
      <li class="treeview">
        <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="#">Link in level 2</a></li>
          <li><a href="#">Link in level 2</a></li>
        </ul>
      </li>
    </ul> --}}

    <ul class="sidebar-menu">
      <li class="header">MENU</li>
      @if (Auth::check())
      <li class="{{ (request()->is('clients/*')) ? 'active' : '' }}"><a href="{{ url('/clients') }}"><i class="fa fa-users"></i>{{ trans('menu.clients') }}</a></li>
      <li class="{{ (request()->is('calendar')) ? 'active' : '' }}"><a href="{{ url('/calendar/group') }}" data-turbolinks="false"><i class="fa fa-calendar"></i>{{ trans('menu.calendar') }}</a></li>
      <li class="dropdown {{-- active(['classes', 'classes/*', 'rooms', 'rooms/*', 'professionals', 'professionals/*', 'not:professionals/payments', 'not:professionals/payments/*', 'plans', 'plans/*']) --}}">
        <a href="#"><i class="fa fa-plus"></i> <span>CADASTROS</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        {{-- <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cadastros <span class="caret"></span></a> --}}
        <ul class="treeview-menu">
          <li class="{{-- active(['classes', 'classes/*']) --}}"><i class="fa fa-link"></i><a href="{{ url('/classes') }}">{{ trans('menu.classes') }}</a></li>
          <li class="{{-- active(['rooms', 'rooms/*']) --}}"><i class="fa fa-link"></i><a href="{{ url('/rooms') }}">{{ trans('menu.rooms') }}</a></li>
          <li class="{{-- active(['professionals', 'professionals/*']) --}}"><i class="fa fa-link"></i><a href="{{ url('/professionals') }}">{{ trans('menu.professionals') }}</a></li>
          <li class="{{-- active(['plans', 'plans/*']) --}}"><i class="fa fa-link"></i><a href="{{ url('/plans') }}">{{ trans('menu.plans') }}</a></li>
          <!--li class="{{-- active('schedules') --}} hidden-sm"><a href="{{ url('/schedules') }}">{{ trans('menu.schedules') }}</a></li-->
        </ul>
      </li>
      <li class="dropdown {{-- active(['bank-accounts', 'payment-methods', 'professionals/payments', 'professionals/payments/*']) --}}">
        {{-- <i class="fa fa-link"></i><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('menu.financials') }} <span class="caret"></span></a> --}}
        <a href="#"><i class="fa fa-usd"></i> <span>FINANÇAS</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{-- active(['professionals/payments', 'professionals/payments/*']) --}}"><a href="{{ url('/professionals/payments') }}">{{ trans('menu.pro_payments') }}</a></li>
          <li class="{{-- active('bank-accounts') }}"><a href="{{ url('/bank-accounts') --}}">{{ trans('menu.bank_accounts') }}</a></li>
          <li class="{{-- active('payment-methods') }}"><a href="{{ url('/payment-methods') --}}">{{ trans('menu.payment_methods') }}</a></li>
        </ul>
      </li>
      <li class="dropdown {{-- active(['reports/cash-journal']) ---}}">
        <a href="#"><i class="fa fa-line-chart"></i> <span>RELATÓRIOS</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        {{-- <i class="fa fa-link"></i><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('menu.reports') }} <span class="caret"></span></a> --}}
        <ul class="treeview-menu">
          <li class="{{-- active('reports/cash-journal') --}}"><a href="{{ url('/reports/cash-journal') }}">{{ trans('menu.cash_journal') }}</a></li>
        </ul>
      </li>
      @endif
    </ul>

    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>