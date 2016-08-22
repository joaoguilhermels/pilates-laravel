<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

        <!-- Styles -->
        <!--link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"-->
        <link href="https://bootswatch.com/cerulean/bootstrap.min.css" rel="stylesheet">
        {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
        @yield('css')

        <style>
            body {
                font-family: 'Lato';
            }

            .fa-btn {
                margin-right: 6px;
            }
        </style>
    </head>
    <body id="app-layout">
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        Pilates
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if (Auth::check())
                        <li class="{{ active('dashboard') }}"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        <li class="{{ active('clients') }}"><a href="{{ url('/clients') }}">{{ trans('menu.clients') }}</a></li>
                        <li class="{{ active('professionals') }}"><a href="{{ url('/professionals') }}">{{ trans('menu.professionals') }}</a></li>
                        <li class="{{ active('rooms') }}"><a href="{{ url('/rooms') }}">{{ trans('menu.rooms') }}</a></li>
                        <li class="{{ active('classes') }}"><a href="{{ url('/classes') }}">{{ trans('menu.classes') }}</a></li>
                        <li class="{{ active('plans') }}"><a href="{{ url('/plans') }}">{{ trans('menu.plans') }}</a></li>
                        <li class="{{ active('schedules') }} hidden-sm"><a href="{{ url('/schedules') }}">{{ trans('menu.schedules') }}</a></li>
                        <li class="{{ active('calendar') }}"><a href="{{ url('/calendar/group') }}" data-turbolinks="false">{{ trans('menu.calendar') }}</a></li>
                        <li class="dropdown {{ active(['bank-accounts', 'payment-methods']) }}">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('menu.financials') }} <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li class="{{ active('expenses') }}"><a href="{{ url('/expenses') }}">{{ trans('menu.expenses') }}</a></li>
                            <li class="{{ active('professionals/payments') }}"><a href="{{ url('/professionals/payments') }}">{{ trans('menu.pro_payments') }}</a></li>
                            <li class="{{ active('bank-accounts') }}"><a href="{{ url('/bank-accounts') }}">{{ trans('menu.bank_accounts') }}</a></li>
                            <li class="{{ active('payment-methods') }}"><a href="{{ url('/payment-methods') }}">{{ trans('menu.payment_methods') }}</a></li>
                          </ul>
                        </li>
                        <li class="dropdown {{ active(['reports/cash-journal']) }}">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('menu.reports') }} <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li class="{{ active('reports/cash-journal') }}"><a href="{{ url('/reports/cash-journal') }}">{{ trans('menu.cash_journal') }}</a></li>
                          </ul>
                        </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">{{ trans('menu.register') }}</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>{{ trans('menu.logout') }}</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
          <!-- will be used to show any messages -->
          @if (Session::has('message'))
              <div class="alert alert-info fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ Session::get('message') }}
              </div>
          @endif
        </div>

        @yield('content')

        <!-- JavaScripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.21/vue.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.0/vue-resource.js"></script>

        {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
        <script src="/js/app.js"></script>
        @yield('script_footer')
    </body>
</html>
