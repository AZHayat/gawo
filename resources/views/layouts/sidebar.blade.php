<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Buat WO -->
                <li class="nav-item">
                    <a href="{{ route('workorder.create') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Buat WO</p>
                    </a>
                </li>

                <!-- Update WO -->
                <li class="nav-item">
                    <a href="{{ route('workorder.update') }}" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>Update WO</p>
                    </a>
                </li>

                <!-- Status WO -->
                <li class="nav-item">
                    <a href="{{ route('workorder.status') }}" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Status WO</p>
                    </a>
                </li>
                
            </ul>
        </nav>
    </div>
</aside>
