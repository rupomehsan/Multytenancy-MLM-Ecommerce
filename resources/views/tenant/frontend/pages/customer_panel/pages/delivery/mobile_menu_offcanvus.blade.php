<!-- Mobile Menu Button Trigger -->
<button type="button" class="mobile-menu-sidebar-icon btn btn-primary" data-bs-toggle="offcanvas"
data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
<i class="fi fi-rr-user"></i>
</button>

<!-- Mobile Menu Offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasWithBothOptions"
aria-labelledby="offcanvasWithBothOptionsLabel" data-bs-scroll="false" style="z-index: 9999999 !important;">
<div class="modal-dialog offcanvas-dialog">
    <div class="modal-content">
        <div class="getcom-user-sidebar user-mobile-menu-sidebar">
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
                <!-- Offcanvas Close Button -->
                <button type="button" class="mobile-menu-sidebar-close" data-bs-dismiss="offcanvas"
                    aria-label="Close">
                    <i class="fi fi-rr-cross-small"></i>
                </button>
            </div>
            <div class="user-sidebar-menus">
                <ul class="user-sidebar-menu-list">
                    <li>
                        <a class="{{ (Request::path() == 'home') ? 'active' : ''}}" href="{{url('/home')}}"><i class="fi-ss-apps"></i>Dashboard</a>
                    </li>
                    <li>
                        <a class="{{ (Request::path() == 'my/delivery/orders') ? 'active' : ''}}" href="{{url('/my/delivery/orders')}}"><i class="fi-ss-shopping-cart"></i>My orders</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
<!-- End Mobile Menu Offcanvas -->
