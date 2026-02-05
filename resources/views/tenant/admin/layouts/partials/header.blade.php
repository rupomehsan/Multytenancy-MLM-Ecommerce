  <header id="page-topbar">
      <div class="navbar-header">
          <div class="dropdown  ml-2" style="display:flex;gap:8px;align-items:center;">
              <!-- Sidebar Toggle Button -->
              <button type="button" class="btn text-white rounded d-flex align-items-center justify-content-center"
                  id="sidebar-toggle-btn"
                  style="width:42px; height:36px; padding:6px; background: linear-gradient(to right, #17263ADE, #2c3e50f5, #17263A);"
                  title="Toggle Sidebar" aria-label="Toggle Sidebar">
                  <i class="fas fa-bars" aria-hidden="true" style="font-size:16px;"></i>
              </button>

              <!-- Icon-only Guest Checkout: checkbox is visually hidden but operable via label -->
              <label class="btn text-white rounded  mb-0 d-flex align-items-center justify-content-center"
                  style="cursor:pointer; width:42px; height:36px; padding:6px; background: linear-gradient(to right, #17263ADE, #2c3e50f5, #17263A);"
                  title="{{ isset($generalInfo) && isset($generalInfo->guest_checkout) && $generalInfo->guest_checkout == 1 ? 'Guest Checkout: ON' : 'Guest Checkout: OFF' }}"
                  aria-label="{{ isset($generalInfo) && isset($generalInfo->guest_checkout) && $generalInfo->guest_checkout == 1 ? 'Guest Checkout: ON' : 'Guest Checkout: OFF' }}">
                  <input type="checkbox" id="guest_checkout" onchange="guestCheckout()"
                      @if (isset($generalInfo) && isset($generalInfo->guest_checkout) && $generalInfo->guest_checkout == 1) checked @endif
                      style="position:absolute;opacity:0;width:0;height:0;margin:0;padding:0;">
                  @if (isset($generalInfo) && isset($generalInfo->guest_checkout) && $generalInfo->guest_checkout == 1)
                      <i class="fas fa-user-check" aria-hidden="true" style="font-size:16px;color:#b7f5b0;"></i>
                  @else
                      <i class="fas fa-user-slash" aria-hidden="true" style="font-size:16px;color:#f5b0b0;"></i>
                  @endif
              </label>

              <!-- Icon-only Visit Website button -->
              <a href="/" target="_blank"
                  class="btn text-white rounded d-flex align-items-center justify-content-center"
                  style="width:42px; height:36px; padding:6px; background: linear-gradient(to right, #17263ADE, #2c3e50f5, #17263A);"
                  title="Visit Website" aria-label="Visit Website">
                  <i class="fas fa-globe" aria-hidden="true" style="font-size:16px;"></i>
              </a>
          </div>
          {{-- <div class="d-flex align-items-center">
              <button type="button" class="btn btn-sm mr-2 d-lg-none header-item" id="vertical-menu-btn">
                  <i class="fa fa-fw fa-bars"></i>
              </button>

              <div class="header-breadcumb">
                  <h6 class="header-pretitle d-none d-md-block">Pages <i class="dripicons-arrow-thin-right"></i>
                      @yield('page_title')</h6>
                  <h2 class="header-title">@yield('page_heading')</h2>
              </div>
          </div> --}}
          <div class="d-flex align-items-center">

              {{-- <div class="dropdown d-inline-block ml-2">
                            <button type="button" class="btn header-item noti-icon"
                                id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="mdi mdi-bell-outline"></i>
                                <span class="badge badge-danger badge-pill">6</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                                aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0"> Notifications </h6>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 230px;">
                                    <a href="" class="text-reset">
                                        <div class="media py-2 px-3">
                                            <img src="{{url('assets')}}/images/users/avatar-2.jpg"
                                                class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="media-body">
                                                <h6 class="mt-0 mb-1">Samuel Coverdale</h6>
                                                <p class="font-size-12 mb-1">You have new follower on Instagram</p>
                                                <p class="font-size-12 mb-0 text-muted"><i
                                                        class="mdi mdi-clock-outline"></i> 2 min ago</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="" class="text-reset">
                                        <div class="media py-2 px-3">
                                            <div class="avatar-xs mr-3">
                                                <span class="avatar-title bg-success rounded-circle">
                                                    <i class="mdi mdi-cloud-download-outline"></i>
                                                </span>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="mt-0 mb-1">Download Available !</h6>
                                                <p class="font-size-12 mb-1">Latest version of admin is now available.
                                                    Please download here.</p>
                                                <p class="font-size-12 mb-0 text-muted"><i
                                                        class="mdi mdi-clock-outline"></i> 4 hours ago</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div> --}}




              <div class="dropdown d-inline-block ml-2">
                  <button type="button" class="btn header-item" id="page-header-user-dropdown" data-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                      <img class="rounded-circle header-profile-user"
                          src="{{ url('tenant/admin/assets') }}/images/users/avatar-1.jpg" alt="Header Avatar">
                      <span class="d-none d-sm-inline-block ml-1">@auth {{ Auth::user()->name }}
                          @endauth
                      </span>
                      <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                      {{-- <a class="dropdown-item d-flex align-items-center justify-content-between"
                                    href="javascript:void(0)">
                                    Profile
                                </a> --}}
                      <a class="dropdown-item d-flex align-items-center justify-content-between"
                          href="{{ route('changePasswordPage') }}">
                          <span class="d-none d-sm-inline-block"><i class="fas fa-key"></i> Change
                              Password</span>
                      </a>
                      <a href="{{ route('admin.logout') }}"
                          class="dropdown-item d-flex align-items-center justify-content-between logout"
                          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                          <span class="d-none d-sm-inline-block"><i class="fas fa-sign-out-alt"></i>
                              Logout</span>
                      </a>

                      <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                  </div>
              </div>

          </div>
          <script>
              document.addEventListener('DOMContentLoaded', function() {
                  const gc = document.getElementById('guest_checkout');
                  if (!gc) return;
                  const label = gc.closest('label');
                  const icon = label ? label.querySelector('i') : null;

                  function updateIcon(checked) {
                      if (!icon || !label) return;
                      if (checked) {
                          icon.classList.remove('fa-user-slash');
                          icon.classList.add('fa-user-check');
                          icon.style.color = '#b7f5b0';
                          label.setAttribute('title', 'Guest Checkout: ON');
                          label.setAttribute('aria-label', 'Guest Checkout: ON');
                      } else {
                          icon.classList.remove('fa-user-check');
                          icon.classList.add('fa-user-slash');
                          icon.style.color = '#f5b0b0';
                          label.setAttribute('title', 'Guest Checkout: OFF');
                          label.setAttribute('aria-label', 'Guest Checkout: OFF');
                      }
                  }

                  // initialize
                  updateIcon(gc.checked);

                  // reflect UI immediately when checkbox is toggled
                  gc.addEventListener('change', function() {
                      updateIcon(this.checked);
                  });
              });

              // Sidebar toggle functionality
              document.addEventListener('DOMContentLoaded', function() {
                  const toggleBtn = document.getElementById('sidebar-toggle-btn');
                  const layoutWrapper = document.getElementById('layout-wrapper');

                  // Check if sidebar state is saved in localStorage
                  const isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

                  // Apply saved state on page load
                  if (isSidebarCollapsed && layoutWrapper) {
                      layoutWrapper.classList.add('sidebar-collapsed');
                  }

                  // Toggle sidebar when button is clicked
                  if (toggleBtn) {
                      toggleBtn.addEventListener('click', function() {
                          if (layoutWrapper) {
                              layoutWrapper.classList.toggle('sidebar-collapsed');
                              // Save state to localStorage
                              const isCollapsed = layoutWrapper.classList.contains('sidebar-collapsed');
                              localStorage.setItem('sidebarCollapsed', isCollapsed);
                          }
                      });
                  }
              });
          </script>
      </div>
  </header>
