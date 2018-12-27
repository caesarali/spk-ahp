<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="api-base-url" content="{{ url('/api') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - {{ config('app.fullname', '') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/manifest.json">

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
    <div id="app" class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-dark bg-info app-shadow">
            {{-- Left Menu --}}
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <router-link :to="{ name: 'home' }" class="nav-link">HOME</router-link>
                </li>
                <li class="nav-item dropdown d-none d-sm-inline-block">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        ANALISIS
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <router-link :to="{ name: 'analysis.criteria' }" class="dropdown-item">
                            Analisis Kriteria
                        </router-link>
                        <router-link :to="{ name: 'analysis.alternative' }" class="dropdown-item">
                            Analisis Alternatif
                        </router-link>
                        <div class="dropdown-divider"></div>
                        <router-link :to="{ name: 'analysis.result' }" class="dropdown-item">
                            Hasil Analisis
                        </router-link>
                    </div>
                </li>
            </ul>

            <a href="{{ url('/') }}" class="brand-link bg-info mx-auto py-0 d-inline-block d-sm-none">
                <img src="{{ asset('images/home.png') }}" alt="APP Logo" class="brand-image p-1 mt-0 ml-0 bg-white img-circle" style="opacity: .8">
                <span class="brand-text font-weight-bold h3">{{ config('app.name', 'Laravel') }}</span>
            </a>

            {{-- Right Menu --}}
            <ul class="navbar-nav ml-sm-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-light-info elevation-4" style="overflow-x: hidden;">
            <a href="{{ url('/') }}" class="brand-link bg-info">
                <img src="{{ asset('images/home.png') }}" alt="APP Logo" class="brand-image p-1 bg-white img-circle" style="opacity: .8">
                <span class="brand-text font-weight-bold">{{ config('app.name', 'Laravel') }}</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('images/user.png') }}" class="img-circle" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-header">DATA MASTER</li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'admin.criterias' }" class="nav-link">
                                <i class="fas fa-database nav-icon"></i>
                                <p>Data Kriteria</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'admin.alternatives' }" class="nav-link">
                                <i class="fas fa-database nav-icon"></i>
                                <p>Data Alternatif</p>
                            </router-link>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper pb-5">
            @yield('content')
        </div>

        <nav class="navbar fixed-bottom footbar bg-white p-0 d-flex d-sm-none" style="border-top: 1px solid #dee2e6">
            <div class="col text-center">
                <router-link :to="{ name: 'home' }" class="navbar-brand text-secondary">
                    <i class="fas fa-home"></i>
                    <small class="d-block">Home</small>
                </router-link>
            </div>
            <div class="col text-center">
                <router-link :to="{ name: 'analysis.criteria' }" class="navbar-brand text-secondary">
                    <i class="fas fa-table"></i>
                    <small class="d-block">Kriteria</small>
                </router-link>
            </div>
            <div class="col text-center">
                <router-link :to="{ name: 'analysis.alternative' }" class="navbar-brand text-secondary">
                    <i class="fas fa-table"></i>
                    <small class="d-block">Alternatif</small>
                </router-link>
            </div>
            <div class="col text-center">
                <router-link :to="{ name: 'analysis.result' }" class="navbar-brand text-secondary">
                    <i class="fas fa-poll"></i>
                    <small class="d-block">Hasil</small>
                </router-link>
            </div>
        </nav>

        <aside class="control-sidebar control-sidebar-light">
            <div class="p-3">
                <img src="{{ asset('images/user.png') }}" class="img-fluid mx-auto d-block rounded-circle" style="width: 75px">
                <div class="pt-2 text-center">
                    <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                    <p>{{ Auth::user()->roles[0]->display_name }}</p>
                </div>
                <hr class="mt-0">
                <button class="btn btn-outline-info btn-block" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>
        {{-- @include('layouts.footer') --}}
    </div>
</body>
</html>
