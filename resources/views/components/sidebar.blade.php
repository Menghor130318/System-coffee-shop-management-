<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('home') }}">Coffee Shop Cambodia</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('home') }}">CS</a>
        </div>
        <ul class="sidebar-menu">

            <li class="menu-header">Menu</li>
            
            {{-- កែប្រែលក្ខខណ្ឌត្រង់នេះ ដើម្បីការពារការខុសឈ្មោះ Role Admin --}}
            @if(auth()->check() && (str_contains(strtolower(auth()->user()->role?->name ?? ''), 'admin') || auth()->user()->role_id == 1))
                <li class="{{ Request::is('admin*') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-tachometer-alt"></i><span>Admin Dashboard</span></a>
                </li>

                <li class="nav-item dropdown {{ Request::is('user*', 'customer*', 'employee*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i><span>User Management</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ Request::is('user*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('user.index') }}">Users</a>
                        </li>
                        <li class="{{ Request::is('customer*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('customer.index') }}">Customers</a>
                        </li>
                        <li class="{{ Request::is('employee*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('employee.index') }}">Employees</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ Request::is('category*') ? 'active' : '' }}">
                    <a href="{{ route('category.index') }}" class="nav-link"><i class="fas fa-box"></i><span>Categories</span></a>
                </li>
                <li class="{{ Request::is('product*') ? 'active' : '' }}">
                    <a href="{{ route('product.index') }}" class="nav-link"><i class="fas fa-shopping-cart"></i><span>Products</span></a>
                </li>
                <li class="{{ Request::is('discount*') ? 'active' : '' }}">
                    <a href="{{ route('discount.index') }}" class="nav-link"><i class="fas fa-tags"></i><span>Discount</span></a>
                </li>
                <li class="{{ Request::is('order*') ? 'active' : '' }}">
                    <a href="{{ route('order.index') }}" class="nav-link"><i class="fas fa-list-alt"></i><span>Orders</span></a>
                </li>

                <li class="nav-item dropdown {{ Request::is('inventory*', 'supplier*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Warehouse</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ Request::is('inventory*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('inventory.index') }}">Inventory</a>
                        </li>
                        <li class="{{ Request::is('supplier*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('supplier.index') }}">Supplier</a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </aside>
</div>