<div class="vertical-menu">

    <div data-simplebar class="h-100">
        <!-- User details -->
        <div class="user-profile text-center mt-3">
            {{-- <div class="">
                <img src="assets/images/users/avatar-1.jpg" alt="" class="avatar-md rounded-circle">
            </div> --}}
            <div class="mt-3">
                <h4 class="font-size-16 mb-1">Hello {{ ucfirst(request()->user()->name) }}</h4>
                <span class="text-muted"><i class="ri-record-circle-line align-middle font-size-14 text-success"></i>
                    {{ ucfirst(request()->user()->role) }}</span>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        {{-- <i class="ri-dashboard-line"></i> --}}
                        <i class="ri-vip-crown-2-line"></i>
                        {{-- <span class="badge rounded-pill bg-success float-end">3</span> --}}
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title">Student</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>Students</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('students')}}">View All</a></li>
                        <li><a href="{{route('student.add')}}">Add New</a></li>
                        <li><a href="{{route('plans')}}">Asign Plan</a></li>
                    </ul>
                </li>

                @role('admin')
                <li class="menu-title">Manager</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>Manager</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('users.index') }}">View All</a></li>
                        <li><a href="{{ route('users.create') }}">Add New</a></li>
                    </ul>
                </li>

                @endrole

                @role('admin')
                <li class="menu-title">Settings</li>
                <li class="{{ request()->is('users/*') || request()->is('roles/*') ? 'active' : '' }}">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="{{ request()->is('roles/*') ? 'active' : '' }}">
                            <a href="{{ route('roles.index') }}">Role</a>
                        </li>
                    </ul>
                </li>

                @endrole

                {{-- <li>
                    <a href="{{route('terms')}}" class="waves-effect">
                        <i class="ri-pencil-ruler-2-line"></i>
                        <span>Terms</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('privacy')}}" class="waves-effect">
                        <i class="ri-bar-chart-line"></i>
                        <span>Privacy</span>
                    </a>
                </li> --}}


            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
