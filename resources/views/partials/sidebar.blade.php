<ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <!-- Divider -->

    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active mt-5">
        <a class="nav-link" href="{{route('dashboard')}}">
            <span>الرئيسية</span>
            <i class="fas fa-fw fa-tachometer-alt"></i>
        </a>
    </li>

    <!-- Divider -->

    @role('Super Admin')
        <hr class="sidebar-divider">
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="true" aria-controls="collapseTwo">
            <span>إدارة المطاعم</span>
            <i class="fas fa-fw fa-cog"></i>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded text-right">
                <a class="collapse-item" href="{{route('restaurant.create')}}">إضافة</a>
                <a class="collapse-item" href="{{route('restaurant.index')}}">عرض الكل</a>
            </div>
        </div>
    </li>
    @endrole

@if(!auth()->user()->hasRole('Super Admin'))
   @hasanyrole('Admin|Data Entry')
    @if(auth()->user()->restaurant)
        <hr class="sidebar-divider">
        <li class="nav-item">
        <a class="nav-link" href="{{route('categories.index')}}">
            <span>إدارة الأقسام</span>
            <i class="fas fa-fw fa-list"></i>
        </a>
        </li>
        @endif
    @endrole
@endif
    @if(!auth()->user()->hasRole('Super Admin'))
    @hasanyrole('Admin|Data Entry')
        <hr class="sidebar-divider">
        <li class="nav-item">
        <a class="nav-link" href="{{route('items.index')}}">
            <span>إدارة العناصر</span>
            <i class="fas fa-fw fa-blog"></i>
        </a>
        </li>
    @endrole
@endif

 @if(!auth()->user()->hasRole('Super Admin'))
    @role('Admin')
        <hr class="sidebar-divider">
        <li class="nav-item">
        <a class="nav-link" href="{{route('orders.index')}}">
            <span>الطلبات</span>
            <i class="fas fa-fw fa-blog"></i>
        </a>
        </li>
    @endrole
@endif
@role('Admin')
    @if(auth()->user()->restaurant)
    <hr class="sidebar-divider">

    <li class="nav-item">

            <a class="nav-link" href="{{route('restaurant.show',auth()->user()->restaurant->id)}}">
            <span>إدارة بيانات المطعم</span>
            <i class="fas fa-fw fa-table"></i>
        </a>
        @endif
    </li>
    @endrole

    @hasanyrole('Admin|Super Admin')
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
           aria-expanded="true" aria-controls="collapseUsers">
            <span>ادارة المستخدمين</span>
            <i class="fas fa-fw fa-folder"></i>
        </a>
        <div id="collapseUsers" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded text-right">
                <a class="collapse-item" href="{{route('users.index')}}">المستخدمين</a>
                @endrole
                @role('Super Admin')
                <a class="collapse-item" href="{{route('roles.index')}}">الأدوار الصلاحيات</a>
                @endrole
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
