<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-danger elevation-4">
<!-- Brand Logo -->
<a href="{{route("admin.dashboard")}}" class="brand-link text-center">
  <img src="{{asset('images/logo-mini.PNG')}}" class="brand-image center-block" 
       style="opacity: .8;float: none;max-height: 31px;">
  
</a>

<!-- Sidebar -->
<div class="sidebar" style="padding-left: 0px;padding-right: 0px; ">
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel pt-3 pb-3 mb-3 d-flex" style="background-color: #e4e4e4;
border-bottom: 1px solid #ccc;
border-top: 1px solid #ccc;">
    <div class="image">
      <img src="{{asset('images/user.png')}}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
      {!!Auth::user()->first_name . ' ' . Auth::user()->last_name!!}
    </div>
  </div>

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      @include('layouts.menu')      
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>