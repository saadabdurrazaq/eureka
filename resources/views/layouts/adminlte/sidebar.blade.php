<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ URL::to('public/bower_components/admin-lte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar Left -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (\Auth::user())
                    @if (Auth::user()->avatar != null)
                        <img src="{{ URL::to('storage/app/public') . '/' . Auth::user()->avatar }}"
                            class="img-circle elevation-2" alt="User Image">
                    @endif
                    @if (Auth::user()->avatar == null)
                        @if (Auth::user()->gender == 'Male')
                            <img src="{{ URL::asset('public/bower_components/admin-lte/dist/img/fb-male.jpg') }}"
                                class="img-circle elevation-2" alt="User Image">
                        @else
                            <img src="{{ URL::asset('public/bower_components/admin-lte/dist/img/female-fb.jpg') }}"
                                class="img-circle elevation-2" alt="User Image">
                        @endif
                    @endif
                @else
                    <img src="{{ URL::asset('public/bower_components/admin-lte/dist/img/avatar5.png') }}"
                        class="img-circle elevation-2" alt="User Image">
                @endif
            </div>
            <div class="info">
                @if (\Auth::user())
                    <a href="{{ route('profile.show', ['username' => Auth::user()->username]) }}"
                        class="d-block">{{ Auth::user()->name }}</a>
                @endif
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <!-- Authentication Links -->
                @can('View Roles')
                    <li class="nav-item">
                        <a href="{{ route('roles.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-lock"></i>
                            <p>Manage Roles</p>
                        </a>
                    </li>
                @endcan
                @can('View Users')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Manage Users</p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Products & Categories</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
