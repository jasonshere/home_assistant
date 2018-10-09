<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Weather Station</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="https://d3q5poti6uedt7.cloudfront.net/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://d3q5poti6uedt7.cloudfront.net/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="https://d3q5poti6uedt7.cloudfront.net/vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="https://d3q5poti6uedt7.cloudfront.net/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="https://d3q5poti6uedt7.cloudfront.net/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="#">
          <h3 style="color: #24d5e0; line-height: 63px">Weather Station</h3>
        </a>
        
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
          
          <li class="nav-item active">
            <a href="/pressure" class="nav-link">
              <i class="mdi mdi-elevation-rise"></i>Pressure Reports</a>
          </li>

           <li class="nav-item active">
            <a href="/humidity" class="nav-link">
              <i class="mdi mdi-elevation-rise"></i>Humidity Reports</a>
          </li>

           <li class="nav-item active">
            <a href="/temperature" class="nav-link">
              <i class="mdi mdi-elevation-rise"></i>Temperature Reports</a>
          </li>
         
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown d-none d-xl-inline-block">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <span class="profile-text">Hello, {{ Auth::user()->name }} !</span>
              <img class="img-xs rounded-circle" src="https://d3q5poti6uedt7.cloudfront.net/images/faces/face1.jpg" alt="Profile image">
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" style="padding-top: 20px" aria-labelledby="UserDropdown">
              <a class="dropdown-item" href="{{ route('logout') }}">
                Sign Out
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <div class="nav-link">
              <div class="user-wrapper">
                <div class="profile-image">
                  <img src="https://d3q5poti6uedt7.cloudfront.net/images/faces/face1.jpg" alt="profile image">
                </div>
                <div class="text-wrapper">
                  <p class="profile-name">{{ Auth::user()->name }}</p>
                  <div>
                    <small class="designation text-muted">Manager</small>
                    <span class="status-indicator online"></span>
                  </div>
                </div>
              </div>
              
            </div>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="/pressure">
              <i class="menu-icon mdi mdi-chart-line"></i>
              <span class="menu-title">Pressure Reports</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/humidity">
              <i class="menu-icon mdi mdi-chart-line"></i>
              <span class="menu-title">Humidity Reports</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/temperature">
              <i class="menu-icon mdi mdi-chart-line"></i>
              <span class="menu-title">Temperature Reports</span>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          
        @yield('content')
          
        </div>
        <!-- content-wrapper ends -->
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="https://d3q5poti6uedt7.cloudfront.net/vendors/js/vendor.bundle.base.js"></script>
  <script src="https://d3q5poti6uedt7.cloudfront.net/vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="https://d3q5poti6uedt7.cloudfront.net/js/off-canvas.js"></script>
  <script src="https://d3q5poti6uedt7.cloudfront.net/js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="https://d3q5poti6uedt7.cloudfront.net/js/dashboard.js"></script>
  <!-- End custom js for this page-->
  @stack('scripts')
</body>

</html>