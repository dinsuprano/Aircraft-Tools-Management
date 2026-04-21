<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Aircraft Tools Management') }}</title>
  <link rel="icon" href="{{ asset('dist/img/AdminLTELogo.png') }}" type="image/ico">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  @yield('styles')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #dfe4ea;">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link nav-link">Logout</button>
            </form>
        </li>
    </ul>
  </nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #1f2d3d;">
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Tools Management</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/admin.png') }}" class="rounded" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ route('profile.edit') }}" class="d-block">{{ Auth::user()->name ?? 'Guest' }}</a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
              <i class="nav-icon fab fa-dashcube"></i>
              <p>Dashboard</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{ route('employees.index') }}" class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
            <i class="nav-icon fa fa-users"></i>
              <p>Employee Profile</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('tools.index') }}" class="nav-link {{ request()->routeIs('tools.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-laptop"></i>
              <p>Tool Inventory</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{ route('borrows.index') }}" class="nav-link {{ request()->routeIs('borrows.*') ? 'active' : '' }}">
            <i class="nav-icon fa fa-qrcode"></i>
              <p>Check In / Check Out</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('maintenance.index') }}" class="nav-link {{ request()->routeIs('maintenance.*') ? 'active' : '' }}">
            <i class="nav-icon fa fa-wrench"></i>
              <p>Tools Maintenance</p>
            </a>
          </li>

        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    @yield('content')
  </div>

  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">Aircraft Tools Management</div>
    <strong>Copyright &copy; {{ date('Y') }} <a href="#">Nurudddin Naim</a>.</strong> All rights reserved.
  </footer>
</div>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
@yield('scripts')
</body>
</html>
