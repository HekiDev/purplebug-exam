<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <style>
        body {
        min-height: 100vh;
        min-height: -webkit-fill-available;
        background-color: #EEEEEE;
        }

        html {
        height: -webkit-fill-available;
        }

        main {
        display: flex;
        flex-wrap: nowrap;
        height: 100vh;
        height: -webkit-fill-available;
        max-height: 100vh;
        overflow-x: auto;
        overflow-y: hidden;
        }

        .b-example-divider {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .bi {
        vertical-align: -.125em;
        pointer-events: none;
        fill: currentColor;
        }

        .dropdown-toggle { outline: 0; }

        .nav-flush .nav-link {
        border-radius: 0;
        }

        .btn-toggle {
        display: inline-flex;
        align-items: center;
        padding: .25rem .5rem;
        font-weight: 600;
        color: rgba(0, 0, 0, .65);
        background-color: transparent;
        border: 0;
        }
        .btn-toggle:hover,
        .btn-toggle:focus {
        color: rgba(0, 0, 0, .85);
        background-color: #d2f4ea;
        }

        .btn-toggle::before {
        width: 1.25em;
        line-height: 0;
        content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%280,0,0,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
        transition: transform .35s ease;
        transform-origin: .5em 50%;
        }

        .btn-toggle[aria-expanded="true"] {
        color: rgba(0, 0, 0, .85);
        }
        .btn-toggle[aria-expanded="true"]::before {
        transform: rotate(90deg);
        }

        .btn-toggle-nav a {
        display: inline-flex;
        padding: .1875rem .5rem;
        margin-top: .125rem;
        margin-left: 1.25rem;
        text-decoration: none;
        }
        .btn-toggle-nav a:hover,
        .btn-toggle-nav a:focus {
        background-color: #d2f4ea;
        }

        .scrollarea {
        overflow-y: auto;
        }

        .fw-semibold { font-weight: 600; }
        .lh-tight { line-height: 1.25; }
        .table-row{
            cursor: pointer;
        }
    </style>
  </head>
  <body>
    @if(session()->has('id'))
    <div class = "d-flex">
        <div class="flex-shrink-0 p-3 bg-white" style="width: 280px; height: 100vh;">
            <a href="/dashboard" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
            <svg class="bi me-2" width="30" height="24"><use xlink:href="#bootstrap"/></svg>
            <span class="fs-5 fw-semibold">{{ucfirst(session()->get('name'))}}</span>
            </a>
            <ul class="list-unstyled ps-0">
            <li class="mb-1">
                <a href="{{url('dashboard')}}" class="btn align-items-center rounded" aria-expanded="true">
                Dashboard
                </a>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="true">
                User Management
                </button>
                <div class="collapse show" id="dashboard-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    @if(session()->get('role') == 1)
                        <li><a href="{{url('roles')}}" class="link-dark rounded">Roles</a></li>
                        <li><a href="{{url('users')}}" class="link-dark rounded">Users</a></li>
                    @endif
                </ul>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="true">
                Expense Management
                </button>
                <div class="collapse show" id="orders-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    @if(session()->get('role') == 1)
                        <li><a href="{{url('categories')}}" class="link-dark rounded">Expense Categories</a></li>
                    @endif
                    <li><a href="{{url('expenses')}}" class="link-dark rounded">Expenses</a></li>
                </ul>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#account" aria-expanded="true">
                Account
                </button>
                <div class="collapse show" id="account">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="{{url('account')}}" class="link-dark rounded">Change Password</a></li>
                </ul>
                </div>
            </li>
            </ul>
        </div>
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                        <form class="d-flex" style= "margin-left: auto;">
                            <a class="navbar-brand" href="#">Welcome to Expense Manager</a>
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{url('logout')}}">Logout</a>
                            </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </nav>
            @yield('content')
        </div>
    </div>
    @else
    @yield('login')
    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>