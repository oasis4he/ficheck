<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FiCheck</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body id="app-layout" class="page-{{\Request::route()->getName()}}">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                    @if(Request::route('user_id'))
                        <a class="navbar-brand" href="{{ url('/admin') }}">
                            {{App\User::find(Request::route('user_id'))->email}}
                        </a>
                    @else
                        <a class="navbar-brand" href="{{ url('/') }}">
                            FiCheck
                        </a>
                    @endif
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                @if (!Auth::guest())
                  <ul class="nav navbar-nav">
                      <li><a href="{{ route('financial-goals', ['user_id'=>Request::route('user_id')]) }}">Financial Goals</a></li>
                      <li><a href="{{ route('monthly-budget', ['user_id'=>Request::route('user_id')]) }}">Monthly Budget</a></li>
                      <li><a href="{{ route('revolving-savings', ['user_id'=>Request::route('user_id')]) }}">Revolving Savings</a></li>
                      <li><a href="{{ route('net-worth-statement', ['user_id'=>Request::route('user_id')]) }}">Net Worth Statement</a></li>
                      <li><a href="{{ route('income-and-expense-statement', ['user_id'=>Request::route('user_id')]) }}">Income and Expense Statement</a></li>
                      <li><a href="{{ route('financial-ratios', ['user_id'=>Request::route('user_id')]) }}">Financial Ratios</a></li>
                      <li><a href="{{ route('retirement-needs', ['user_id'=>Request::route('user_id')]) }}">Retirement Needs</a></li>
                      <li><a href="{{ route('life-insurance', ['user_id'=>Request::route('user_id')]) }}">Life Insurance</a></li>
                      <li><a href="{{ route('monthly-tracking', ['user_id'=>Request::route('user_id')]) }}">Monthly Tracking</a></li>
                  </ul>
                @endif

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>


                            <ul class="dropdown-menu" role="menu">
                                @if(Auth::user()->hasRole(['grader', 'administrator']))
                                <li><a href="{{ url('/admin') }}">Admin</a></li>
                                @endif

                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
      @yield('content')
    </div>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>
