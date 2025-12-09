<div class="getcom-user-sidebar">
    <div class="user-sidebar-head">
        <div class="user-sidebar-profile">
            @if(Auth::user()->image)
                <img alt="" src="{{env('ADMIN_URL')."/".Auth::user()->image}}" />
            @endif
        </div>
        <div class="user-sidebar-profile-info">
            <h5>{{Auth::user()->name}}</h5>
            <p>{{Auth::user()->email}}</p>
            <p>{{Auth::user()->phone}}</p>
            <div class="user-sidebar-profile-btn">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fi-rr-sign-out-alt"></i>Logout</a>
            </div>
        </div>
    </div>
    <div class="user-sidebar-menus">
        <ul class="user-sidebar-menu-list">
            <li>
                <a class="{{ (Request::path() == 'home') ? 'active' : ''}}" href="{{url('/home')}}"><i class="fi-ss-apps"></i>Dashboard</a>
            </li>
            <li>
                <a class="{{ (Request::path() == 'my/delivery/orders') || (str_contains(Request::path(), 'order/details')) || (str_contains(Request::path(), 'track/my/order')) ? 'active' : ''}}" href="{{url('/my/delivery/orders')}}"><i class="fi-ss-shopping-cart"></i>My orders</a>
            </li>

        </ul>
    </div>
</div>
