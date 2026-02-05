@php
    use App\Modules\ECOMMERCE\Managements\Orders\Database\Models\Order;
@endphp
<!-- Left Menu Start -->
<div style="padding: 10px;">
    <input type="text" id="menuSearch" placeholder="Search menu..."
        style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
</div>

<ul class="metismenu list-unstyled" id="side-menu">
    {{-- Dashboard --}}
    {{-- Dashboard --}}
    <li>
        <a href="{{ route('admin.dashboard') }}" data-active-paths="{{ route('admin.dashboard') }}">
            <i class="feather-shopping-cart"></i>
            <span>Dashboard</span>
        </a>
    </li>



    <li>
        <a href="{{ route('CreateNewOrder') }}" data-active-paths="{{ route('CreateNewOrder') }}">
            <i class="feather-credit-card"></i>
            <span> POS</span>
        </a>
    </li>
    {{-- Start MLM Module --}}
    {{-- Start MLM Module --}}

    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">MLM Modules</li>


    <li>
        <a href="{{ route('mlm.dashboard') }}" data-active-paths="{{ route('mlm.dashboard') }}">
            <i class="feather-home"></i> <span>MLM Dashboard</span></a>
    </li>
    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-percent"></i>
            <span>Commissions</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('mlm.commissions.settings') }}"
                    data-active-paths="{{ route('mlm.commissions.settings') }}">Commission Settings</a>
            </li>
            <li>
                <a href="{{ route('mlm.commissions.record') }}"
                    data-active-paths="{{ route('mlm.commissions.record') }}">Commission Records</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-activity"></i>
            <span>Referrals</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('mlm.referral.lists') }}" data-active-paths="{{ route('mlm.referral.lists') }}">
                    Referral Lists
                </a>
            </li>
            {{-- <li>
                <a href="{{ route('mlm.referral.tree') }}" data-active-paths="{{ route('mlm.referral.tree') }}">
                    Referral Tree
                </a>
            </li> --}}
            <li>
                <a href="{{ route('mlm.referral.activity.log') }}"
                    data-active-paths="{{ route('mlm.referral.activity.log') }}">
                    Referral Activity Log
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-credit-card"></i>
            <span>Wallet</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('mlm.wallet.transaction') }}"
                    data-active-paths="{{ route('mlm.wallet.transaction') }}">Wallet Transactions</a>
            </li>
            <li>
                <a href="{{ route('mlm.user.wallet.balance') }}"
                    data-active-paths="{{ route('mlm.user.wallet.balance') }}">User Wallet Balances</a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-arrow-down-circle"></i>
            <span>Withdrawals</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('mlm.user.withdraw.request') }}"
                    data-active-paths="{{ route('mlm.user.withdraw.request') }}">Withdrawal Requests</a>
            </li>
            <li>
                <a href="{{ route('mlm.withdraw.history') }}"
                    data-active-paths="{{ route('mlm.withdraw.history') }}">Withdrawal History</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="{{ route('mlm.top.earners') }}" data-active-paths="{{ route('mlm.top.earners') }}">
            <i class="feather-star"></i> <span>Top Earners</span></a>
    </li>

    {{-- <li>
        <a  onclick="return false;" class="has-arrow">
            <i class="feather-bar-chart-2"></i> <span>MLM Reports</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">

            <li>
                <a href="{{ route('mlm.reports.referral') }}"
                    data-active-paths="{{ route('mlm.reports.referral') }}">Referral Report</a>
            </li>
            <li>
                <a href="{{ route('mlm.reports.commission') }}"
                    data-active-paths="{{ route('mlm.reports.commission') }}">Commission Report</a>
            </li>
            <li>
                <a href="{{ route('mlm.reports.user_performance') }}"
                    data-active-paths="{{ route('mlm.reports.user_performance') }}">User Performance</a>
            </li>
            <li>
                <a href="{{ route('mlm.reports.top_earners') }}"
                    data-active-paths="{{ route('mlm.reports.top_earners') }}">Top Earners</a>
            </li>
            <li>
                <a href="{{ route('mlm.reports.withdrawal') }}"
                    data-active-paths="{{ route('mlm.reports.withdrawal') }}">Withdrawal Report</a>
            </li>
            <li>
                <a href="{{ route('mlm.reports.activity_log') }}"
                    data-active-paths="{{ route('mlm.reports.activity_log') }}">Activity Log</a>
            </li>
            <li>
                <a href="{{ route('mlm.reports.wallet_summary') }}"
                    data-active-paths="{{ route('mlm.reports.wallet_summary') }}">Wallet Summary</a>
            </li>
        </ul>
    </li> --}}
    <li>
        <a href="{{ route('mlm.passive.income') }}" data-active-paths="{{ route('mlm.passive.income') }}">
            <i class="feather-dollar-sign"></i> <span>Passive Income</span>
        </a>
    </li>
    {{-- End MLM Module --}}
    {{-- End MLM Module --}}

    {{-- Start E-commerce Module --}}
    {{-- Start E-commerce Module --}}

    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">E-commerce Modules</li>
    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-settings"></i>
            <span>Config</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">

            <li>
                <a href="{{ route('ConfigSetup') }}" data-active-paths="{{ route('ConfigSetup') }}">Setup
                    Your
                    Config</a>
            </li>

            {{-- tech industry --}}
            {{-- @if (DB::table('config_setups')->where('code', 'storage')->first())
            <li><a href="{{ route('ViewAllStorages') }}">Storage</a></li>
            @endif
            @if (DB::table('config_setups')->where('code', 'sim')->first())
            <li><a href="{{ route('ViewAllSims') }}">SIM Type</a></li>
            @endif
            @if (DB::table('config_setups')->where('code', 'device_condition')->first())
            <li><a href="{{ route('ViewAllDeviceConditions') }}">Device Condition</a></li>
            @endif --}}

            {{-- <li>
                <a  onclick="return false;" class="has-arrow"><i class="fas fa-sms"></i><span>SMS Service</span></a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('ViewSmsTemplates') }}">SMS Templates</a></li>
                    <li><a href="{{ route('SendSmsPage') }}">Send SMS</a></li>
                    <li><a href="{{ route('ViewSmsHistory') }}">SMS History</a></li>
                </ul>
            </li> --}}

            <li>
                <a href="{{ route('ViewEmailCredentials') }}" data-active-paths="{{ route('ViewEmailCredentials') }}">
                    Email Configure (SMTP)
                </a>
            </li>
            {{-- <li><a href="{{ url('/admin/view/email/templates') }}">Email Templates</a></li> --}}
            {{-- <li><a href="{{ route('SetupSmsGateways') }}">SMS Gateway</a></li> --}}
            <li><a href="{{ route('ViewPaymentGateways') }}" data-active-paths="{{ route('ViewPaymentGateways') }}">
                    Payment Gateway
                </a>
            </li>
            <li>
                <a href="{{ route('ViewAllDeliveryCharges') }}"
                    data-active-paths="{{ route('ViewAllDeliveryCharges') }}">

                    <span>Delivery Charges</span>
                </a>
            </li>
            <li>
                <a href="{{ route('ViewUpazilaThana') }}" data-active-paths="{{ route('ViewUpazilaThana') }}">

                    <span>Upazila & Thana</span>
                </a>
            </li>

        </ul>
    </li>
    <li>
        <a href="javascript:void(0);" class="has-arrow"><i class="feather-box"></i><span>Product
                Management</span></a>
        <ul class="sub-menu" aria-expanded="false">

            {{-- Section: Products (Category/Subcategory/Child) --}}
            <li>
                <a href="javascript:void(0);" class="has-arrow">Product Categories</a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{ route('ViewAllCategory') }}"
                            data-active-paths="{{ route('ViewAllCategory') }},{{ route('AddNewCategory') }},{{ url('/admin/edit/category/*') }},{{ route('RearrangeCategory') }}">
                            <i class="feather-sliders"></i>
                            <span>Category</span>
                            <span style="color:lightgreen"
                                title="Total Categories">({{ DB::table('categories')->count() }})</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ViewAllSubcategory') }}"
                            data-active-paths="{{ route('ViewAllSubcategory') }},{{ route('AddNewSubcategory') }},{{ url('/admin/edit/subcategory/*') }},{{ route('RearrangeSubcategory') }}">
                            <i class="feather-command"></i>
                            <span>Subcategory</span>
                            <span style="color:lightgreen"
                                title="Total Subcategories">({{ DB::table('subcategories')->count() }})</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ViewAllChildcategory') }}"
                            data-active-paths="{{ route('ViewAllChildcategory') }},{{ route('AddNewChildcategory') }},{{ url('/admin/edit/childcategory/*') }}">
                            <i class="feather-git-pull-request"></i>
                            <span>Child Category</span>
                            <span style="color:lightgreen"
                                title="Total Child Categories">({{ DB::table('child_categories')->count() }})</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Section: Attributes --}}
            <li>
                <a href="javascript:void(0);" class="has-arrow">Product Attributes</a>
                <ul class="sub-menu" aria-expanded="false">
                    {{-- Fashion Industry / Sizes --}}
                    @if (DB::table('config_setups')->where('code', 'product_size')->first())
                        <li>
                            <a href="{{ route('ViewAllSizes') }}"
                                data-active-paths="{{ route('ViewAllSizes') }},{{ route('RearrangeSize') }}">Product
                                Sizes</a>
                        </li>
                    @endif

                    {{-- Common Attributes --}}
                    @if (DB::table('config_setups')->where('code', 'color')->first())
                        <li>
                            <a href="{{ route('ViewAllColors') }}"
                                data-active-paths="{{ route('ViewAllColors') }}">Product Colors</a>
                        </li>
                    @endif

                    @if (DB::table('config_setups')->where('code', 'measurement_unit')->first())
                        <li>
                            <a href="{{ route('ViewAllUnits') }}"
                                data-active-paths="{{ route('ViewAllUnits') }}">Measurement Units</a>
                        </li>
                    @endif

                    <li>
                        <a href="{{ route('ViewAllBrands') }}"
                            data-active-paths="{{ route('ViewAllBrands') }},{{ route('AddNewBrand') }},{{ route('RearrangeBrands') }},{{ url('edit/brand/*') }}">Product
                            Brands</a>
                    </li>
                    <li>
                        <a href="{{ route('ViewAllModels') }}"
                            data-active-paths="{{ route('ViewAllModels') }}, {{ url('add/new/model') }},{{ url('edit/model/*') }}">Models
                            of Brand</a>
                    </li>
                    <li>
                        <a href="{{ route('ViewAllFlags') }}"
                            data-active-paths="{{ route('ViewAllFlags') }}">Product Flags</a>
                    </li>
                </ul>
            </li>

            {{-- Section: Manage Products (listing, reviews, Q/A) --}}
            <li>
                <a href="javascript:void(0);" class="has-arrow">Manage Products</a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{ route('ViewAllProducts') }}"
                            data-active-paths="{{ route('ViewAllProducts') }},{{ route('AddNewProduct') }},{{ url('/admin/edit/product/*') }}">
                            View All Products
                            <span style="color:lightgreen"
                                title="Total Products">({{ DB::table('products')->where('is_package', false)->count() }})</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ViewAllProductReviews') }}"
                            data-active-paths="{{ route('ViewAllProductReviews') }}">Products's Review
                            <span style="color:goldenrod" title="Indicate Pending Review">(@php echo DB::table('product_reviews')->where('status', 0)->count(); @endphp)</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ViewAllQuestionAnswer') }}"
                            data-active-paths="{{ route('ViewAllQuestionAnswer') }}">Product Ques/Ans
                            <span style="color:goldenrod"
                                title="Indicate Unanswered Questions">(@php
                                    echo DB::table('product_question_answers')
                                        ->whereNull('answer')
                                        ->orWhere('answer', '=', '')
                                        ->count();
                                @endphp)</span>
                        </a>
                    </li>

                    <!-- <li>
                        <a href="{{ route('PackageProducts.Index') }}"
                            data-active-paths="{{ route('PackageProducts.Index') }}, {{ route('PackageProducts.Create') }}, {{ url('/admin/package-products/*/edit') }}, {{ url('/admin/package-products/*/manage-items') }}">
                            <i class="feather-package"></i> Package Products
                            <span style="color:lightgreen" title="Total Package Products">
                                ({{ DB::table('products')->where('is_package', true)->count() }})
                            </span>
                        </a>
                    </li> -->
                </ul>
            </li>

        </ul>
    </li>



    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-shopping-cart"></i>
            <span>Order Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            @php
                // Optimize: Calculate all order counts in one efficient query
                $orderCounts = DB::table('orders')
                    ->selectRaw(
                        '
                        COUNT(*) as total,
                        SUM(CASE WHEN deleted_at IS NULL THEN 1 ELSE 0 END) as active,
                        SUM(CASE WHEN order_status = ? AND deleted_at IS NULL THEN 1 ELSE 0 END) as pending,
                        SUM(CASE WHEN order_status = ? AND deleted_at IS NULL THEN 1 ELSE 0 END) as approved,
                        SUM(CASE WHEN order_status = ? AND deleted_at IS NULL THEN 1 ELSE 0 END) as dispatch,
                        SUM(CASE WHEN order_status = ? AND deleted_at IS NULL THEN 1 ELSE 0 END) as intransit,
                        SUM(CASE WHEN order_status = ? AND deleted_at IS NULL THEN 1 ELSE 0 END) as cancelled,
                        SUM(CASE WHEN order_status = ? AND deleted_at IS NULL THEN 1 ELSE 0 END) as delivered,
                        SUM(CASE WHEN order_status = ? AND deleted_at IS NULL THEN 1 ELSE 0 END) as return_orders,
                        SUM(CASE WHEN deleted_at IS NOT NULL THEN 1 ELSE 0 END) as trashed
                    ',
                        [
                            Order::STATUS_PENDING,
                            Order::STATUS_APPROVED,
                            Order::STATUS_DISPATCH,
                            Order::STATUS_INTRANSIT,
                            Order::STATUS_CANCELLED,
                            Order::STATUS_DELIVERED,
                            Order::STATUS_RETURN,
                        ],
                    )
                    ->first();
            @endphp
            <li>
                <a style="color: white !important;" href="{{ route('ViewAllOrders') }}"
                    data-active-paths="{{ route('ViewAllOrders') }}, {{ url('create/new/order') }},{{ url('order/details/*') }}">
                    All Orders ({{ $orderCounts->active }})
                </a>
            </li>
            <li>
                <a style="color: rgb(126, 125, 125) !important;" href="{{ route('ViewPendingOrders') }}"
                    data-active-paths="{{ route('ViewPendingOrders') }}, {{ url('order/edit/*') }}">
                    Pending Orders ({{ $orderCounts->pending }})
                </a>
            </li>
            <li>
                <a class="text-primary" href="{{ route('ViewApprovedOrders') }}"
                    data-active-paths="{{ route('ViewApprovedOrders') }}">
                    Approved Orders ({{ $orderCounts->approved }})
                </a>
            </li>
            <li>
                <a style="color: wheat !important;" href="{{ route('ViewDispatchOrders') }}"
                    data-active-paths="{{ route('ViewDispatchOrders') }}">
                    Dispatch Orders ({{ $orderCounts->dispatch }})
                </a>
            </li>
            <li>
                <a style="color: violet !important;" href="{{ route('ViewIntransitOrders') }}"
                    data-active-paths="{{ route('ViewIntransitOrders') }}">
                    Intransit Orders ({{ $orderCounts->intransit }})
                </a>
            </li>
            <li>
                <a class="text-warning" href="{{ route('ViewCancelledOrders') }}"
                    data-active-paths="{{ route('ViewCancelledOrders') }}">
                    Cancelled Orders ({{ $orderCounts->cancelled }})
                </a>
            </li>
            <li>
                <a style="color: #0c0 !important;" href="{{ route('ViewDeliveredOrders') }}"
                    data-active-paths="{{ route('ViewDeliveredOrders') }}">
                    Delivered Orders ({{ $orderCounts->delivered }})
                </a>
            </li>
            <li>
                <a style="color: tomato !important;" href="{{ route('ViewReturnOrders') }}"
                    data-active-paths="{{ route('ViewReturnOrders') }}">
                    Return Orders ({{ $orderCounts->return_orders }})
                </a>
            </li>
            <li>
                <a style="color: red !important;" href="{{ route('ViewAllTrashedOrders') }}"
                    data-active-paths="{{ route('ViewAllTrashedOrders') }}">
                    Trashed Orders ({{ $orderCounts->trashed }})
                </a>
            </li>
            <li>
                <a class="text-info" href="{{ route('ViewOrderLogs') }}"
                    data-active-paths="{{ route('ViewOrderLogs') }}">
                    Order Logs
                </a>
            </li>
        </ul>
    </li>
    {{-- <li>
        <a  onclick="return false;" class="has-arrow"><i class="feather-box"></i><span>Old Purchase
                Product</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ route('AddNewPurchaseProductQuotation') }}">Add Quotation</a></li>
            <li>
                <a href="{{ route('ViewAllPurchaseProductQuotation') }}">
                    All Quotations
                    <span style="color:lightgreen" title="Total Product Quotations">
                        ({{DB::table('product_purchase_quotations')->count()}})
                    </span>
                </a>
            </li>
            <li><a href="{{ route('AddNewPurchaseProductOrder') }}">Add Order</a></li>
            <li>
                <a href="{{ route('ViewAllPurchaseProductOrder') }}">
                    All Orders
                    <span style="color:lightgreen" title="Total Product Orders">
                        ({{DB::table('product_purchase_orders')->count()}})
                    </span>
                </a>
            </li>
        </ul>
    </li> --}}

    <li>
        <a href="{{ route('ViewAllInvoices') }}" data-active-paths="{{ route('ViewAllInvoices') }}">
            <i class="feather-file-text"></i>
            <span>Pos Invoices</span>
            <span style="color:lightgreen" title="Total Invoices">
                (@php
                    echo \Illuminate\Support\Facades\Schema::hasColumn('orders', 'order_from')
                        ? DB::table('orders')->where('order_from', 3)->where('invoice_generated', 1)->count()
                        : 0;
                @endphp)
            </span>
        </a>

    </li>
    <li>
        <a href="{{ route('ViewAllPromoCodes') }}"
            data-active-paths="{{ route('ViewAllPromoCodes') }},{{ route('AddPromoCode') }},{{ url('/admin/edit/promo/code/*') }}">
            <i class="feather-gift"></i>
            <span>Promo Codes</span>
            <span style="color:lightgreen" title="Total Products">
                ({{ DB::table('promo_codes')->count() }})
            </span>
        </a>
    </li>

    {{-- <li><a href="{{ route('FileManager') }}"><i class="fas fa-folder-open"></i><span>File Manager</span></a></li>
    --}}

    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-bell"></i>
            <span>Push Notification</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('SendNotificationPage') }}"
                    data-active-paths="{{ route('SendNotificationPage') }}">
                    Send Notification
                </a>
            </li>
            <li>
                <a href="{{ route('ViewAllPushNotifications') }}"
                    data-active-paths="{{ route('ViewAllPushNotifications') }}">
                    Prevoious Notifications
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="{{ route('CustomersWishlist') }}" data-active-paths="{{ route('CustomersWishlist') }}">
            <i class="feather-heart"></i>
            <span>Customer's Wishlist</span>
        </a>
    </li>


    <li><a href="{{ route('ViewPaymentHistory') }}" data-active-paths="{{ route('ViewPaymentHistory') }}">
            <i class="feather-dollar-sign"></i>
            <span>Payment History</span>
        </a>
    </li>

    <li>
        <a href="javascript:void(0);" class="has-arrow"><i class="feather-printer"></i><span>Generate
                Report</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('SalesReport') }}" data-active-paths="{{ route('SalesReport') }}">Sales
                    Report</a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-users"></i>
            <span>User Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('ViewAllSystemUsers') }}"
                    data-active-paths="{{ route('ViewAllSystemUsers') }}, {{ url('add/new/system/user') }}, {{ url('edit/system/user/*') }}">
                    <i class="fas fa-user-shield"></i>
                    <span>System Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('ViewAllUserRoles') }}"
                    data-active-paths="{{ route('ViewAllUserRoles') }}, {{ url('/admin/new/user/role') }}, {{ url('/admin/edit/user/role/*') }}">
                    <i class="feather-user-plus"></i>
                    <span>User Roles</span>
                </a>
            </li>
            <li>
                <a href="{{ route('ViewUserRolePermission') }}"
                    data-active-paths="{{ route('ViewUserRolePermission') }}, {{ url('/admin/assign/role/permission/*') }}">
                    <i class="mdi mdi-security"></i>
                    <span>Assign Role Permission</span>
                </a>
            </li>
            <li>
                <a href="{{ route('ViewAllPermissionRoutes') }}"
                    data-active-paths="{{ route('ViewAllPermissionRoutes') }}">
                    <i class="feather-git-merge"></i>
                    <span>Permission Routes</span>
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-settings"></i>
            <span>Website Config</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('GeneralInfo') }}" data-active-paths="{{ route('GeneralInfo') }}">
                    <i class="feather-grid"></i>
                    <span>General Info</span>
                </a>
            </li>
            <li>
                <a href="{{ route('WebsiteThemePage') }}" data-active-paths="{{ route('WebsiteThemePage') }}">
                    <i class="mdi mdi-format-color-fill" style="font-size: 18px"></i>
                    <span>Website Theme Color</span>
                </a>
            </li>
            <li>
                <a href="{{ route('SocialMediaPage') }}" data-active-paths="{{ route('SocialMediaPage') }}">
                    <i class="mdi mdi-link-variant" style="font-size: 17px"></i>
                    <span>Social Media Links</span>
                </a>
            </li>
            <li>
                <a href="{{ route('SeoHomePage') }}" data-active-paths="{{ route('SeoHomePage') }}">
                    <i class="dripicons-search"></i>
                    <span>Home Page SEO</span>
                </a>
            </li>
            <li>
                <a href="{{ route('CustomCssJs') }}" data-active-paths="{{ route('CustomCssJs') }}">
                    <i class="feather-code"></i>
                    <span>Custom CSS & JS</span>
                </a>
            </li>
            <li>
                <a href="{{ route('SocialChatScriptPage') }}"
                    data-active-paths="{{ route('SocialChatScriptPage') }}">
                    <i class="mdi mdi-code-brackets"></i>
                    <span>Social & Chat Scripts</span>
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-file-text"></i>
            <span>Content Management</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <i class="feather-image"></i>
                    <span>Sliders & Banners</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{ route('ViewAllSliders') }}"
                            data-active-paths="{{ route('ViewAllSliders') }}, {{ route('AddNewSlider') }}, {{ url('/admin/edit/slider/*') }}, {{ route('RearrangeSlider') }}">
                            View All Sliders
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ViewAllBanners') }}"
                            data-active-paths="{{ route('ViewAllBanners') }}, {{ route('AddNewBanner') }}, {{ url('/admin/edit/banner/*') }}, {{ route('RearrangeBanners') }}">
                            View All Banners
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ViewPromotionalBanner') }}"
                            data-active-paths="{{ route('ViewPromotionalBanner') }}">
                            Promotional Banner
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ViewAllSideBanner') }}"
                            data-active-paths="{{ route('ViewAllSideBanner') }}, {{ route('AddNewSideBanner') }}, {{ url('edit/side-banner/*') }}">
                            Side Banner
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('ViewTestimonials') }}"
                    data-active-paths="{{ route('ViewTestimonials') }}, {{ route('AddTestimonial') }}, {{ url('/admin/edit/testimonial/*') }}">
                    <i class="feather-message-square"></i>
                    <span>Testimonials</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <i class="feather-file-text"></i>
                    <span>Manage Blogs</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{ route('BlogCategories') }}"
                            data-active-paths="{{ route('BlogCategories') }}, {{ route('RearrangeBlogCategory') }}">
                            Blog Categories
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('AddNewBlog') }}" data-active-paths="{{ route('AddNewBlog') }}">
                            Write a Blog
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ViewAllBlogs') }}"
                            data-active-paths="{{ route('ViewAllBlogs') }}, {{ url('/admin/edit/blog/*') }}">
                            View All Blogs
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:void(0);" class="has-arrow">
                    <i class="feather-alert-triangle"></i>
                    <span>Manage Pages</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <a href="{{ route('ViewTermsAndCondition') }}"
                            data-active-paths="{{ route('ViewTermsAndCondition') }}">
                            <i class="feather-file-text"></i>
                            <span>Terms & Condition</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ViewPrivacyPolicy') }}"
                            data-active-paths="{{ route('ViewPrivacyPolicy') }}">
                            <i class="feather-shield"></i>
                            <span>Privacy Policy</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ViewShippingPolicy') }}"
                            data-active-paths="{{ route('ViewShippingPolicy') }}">
                            <i class="feather-truck"></i>
                            <span>Shipping Policy</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ViewReturnPolicy') }}"
                            data-active-paths="{{ route('ViewReturnPolicy') }}">
                            <i class="feather-rotate-ccw"></i>
                            <span>Return Policy</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('AboutUsPage') }}" data-active-paths="{{ route('AboutUsPage') }}">
                            <i class="feather-globe"></i>
                            <span>About Us</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ViewAllFaqs') }}"
                            data-active-paths="{{ route('ViewAllFaqs') }}, {{ route('AddNewFaq') }}, {{ url('/admin/edit/faq/*') }}">
                            <i class="far fa-question-circle"></i>
                            <span>FAQ's</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ViewCustomPages') }}"
                            data-active-paths="{{ route('ViewCustomPages') }}, {{ route('CreateNewPage') }}, {{ url('edit/custom/page/*') }}">
                            <i class="feather-file-plus"></i>
                            <span>Custom Pages</span>
                            <span style="color:lightgreen" title="Total Custom Pages">
                                ({{ DB::table('custom_pages')->count() }})
                            </span>
                        </a>
                    </li>
                </ul>
            </li>



            <li>
                <a href="{{ route('ViewAllOutlet') }}"
                    data-active-paths="{{ route('ViewAllOutlet') }}, {{ route('AddNewOutlet') }}, {{ url('/admin/edit/outlet/*') }}">
                    <i class="feather-box"></i>
                    <span>View All Outlets</span>
                    <span style="color:lightgreen" title="Total Outlets">
                        ({{ DB::table('outlets')->count() }})
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('ViewAllVideoGallery') }}"
                    data-active-paths="{{ route('ViewAllVideoGallery') }}, {{ route('AddNewVideoGallery') }}, {{ url('/admin/edit/video-gallery/*') }}">
                    <i class="feather-box"></i>
                    <span>View All Videos</span>
                    <span style="color:lightgreen" title="Total Videos">
                        ({{ DB::table('video_galleries')->count() }})
                    </span>
                </a>
            </li>

        </ul>
    </li>
    {{-- End E-commerce Module --}}
    {{-- End E-commerce Module --}}


    {{-- Start Inventory Module --}}
    {{-- Start Inventory Module --}}

    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">Inventory Modules</li>
    <li>
        <a href="{{ route('inventory.home') }}" data-active-paths="{{ route('inventory.home') }}">
            <i class="feather-box"></i>
            <span> Inventory Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllProductWarehouse') }}"
            data-active-paths="{{ route('ViewAllProductWarehouse') }}, {{ route('AddNewProductWarehouse') }}, {{ url('/admin/edit/product-warehouse/*') }}">
            <i class="feather-box"></i>
            <span>Product Warehouse</span>
            <span style="color:lightgreen" title="Total Product Warehouses">
                ({{ DB::table('product_warehouses')->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllProductWarehouseRoom') }}"
            data-active-paths="{{ route('ViewAllProductWarehouseRoom') }}, {{ route('AddNewProductWarehouseRoom') }}, {{ url('/admin/edit/product-warehouse-room/*') }}">
            <i class="feather-box"></i>Warehouse Room
            <span style="color:lightgreen" title="Total Product Warehouse Rooms">
                ({{ DB::table('product_warehouse_rooms')->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllProductWarehouseRoomCartoon') }}"
            data-active-paths="{{ route('ViewAllProductWarehouseRoomCartoon') }}, {{ route('AddNewProductWarehouseRoomCartoon') }}, {{ url('/admin/edit/product-warehouse-room-cartoon/*') }}">
            <i class="feather-box"></i> Room Cartoon
            <span style="color:lightgreen" title="Total Product Warehouse Room cartoons">
                ({{ DB::table('product_warehouse_room_cartoons')->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllSupplierSource') }}"
            data-active-paths="{{ route('ViewAllSupplierSource') }}, {{ route('AddNewSupplierSource') }}, {{ url('/admin/edit/supplier-source/*') }}">
            <i class="feather-box"></i> Supplier Src Type
            <span style="color:lightgreen" title="Total CS Types">
                ({{ DB::table('supplier_source_types')->count() }})
            </span>
        </a>
    </li>

    <li>
        <a href="{{ route('ViewAllProductSupplier') }}"
            data-active-paths="{{ route('ViewAllProductSupplier') }}, {{ route('AddNewProductSupplier') }}, {{ url('/admin/edit/product-supplier/*') }}">
            <i class="feather-box"></i> Product Suppliers
            <span style="color:lightgreen" title="Total Product Suppliers">
                ({{ DB::table('product_suppliers')->count() }})
            </span>
        </a>
    </li>


    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-box"></i>
            <span>Product Purchase</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('ViewAllPurchaseProductCharge') }}"
                    data-active-paths="{{ route('ViewAllPurchaseProductCharge') }}, {{ route('AddNewPurchaseProductCharge') }}, {{ url('/admin/edit/purchase-product/charge/*') }}">
                    Other Charge Types
                </a>
            </li>
            <li>
                <a href="{{ route('ViewAllPurchaseProductQuotation') }}"
                    data-active-paths="{{ route('ViewAllPurchaseProductQuotation') }}, {{ route('AddNewPurchaseProductQuotation') }}, {{ url('/admin/edit/purchase-product/quotation/*') }}, {{ url('edit/purchase-product/sales/quotation/*') }}">
                    View All Quotations
                    <span style="color:lightgreen" title="Total Product Purchase Quotations">
                        ({{ DB::table('product_purchase_quotations')->count() }})
                    </span>
                </a>
            </li>
            {{-- <a  onclick="return false;" class="has-arrow"><i class="feather-box"></i><span>Order</span></a> --}}

            <li>
                <a href="{{ route('ViewAllPurchaseProductOrder') }}"
                    data-active-paths="{{ route('ViewAllPurchaseProductOrder') }}, {{ route('AddNewPurchaseProductOrder') }}, {{ url('/admin/edit/purchase-product/order/*') }}, {{ url('edit/purchase-product/sales/order/*') }}">
                    View All Orders
                    <span style="color:lightgreen" title="Total Product Purchase Orders">
                        ({{ DB::table('product_purchase_orders')->count() }})
                    </span>
                </a>
            </li>

        </ul>
    </li>

    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-printer"></i>
            <span>Generate Report</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('generateProductPurchaseReport') }}"
                    data-active-paths="{{ route('generateProductPurchaseReport') }}">
                    Product Purchase Report
                </a>
            </li>
        </ul>
    </li>
    {{-- End Inventory Module --}}
    {{-- End Inventory Module --}}


    {{-- Start Accounts Module --}}
    {{-- Start Accounts Module --}}

    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">Accounts Modules</li>
    <li>
        <a href="{{ route('accounts.home') }}" data-active-paths="{{ route('accounts.home') }}">
            <i class="feather-dollar-sign"></i>
            <span> Accounts Dashboard</span>
        </a>
    </li>
    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-layers"></i><span>Chart of Accounts</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('account-types.index') }}"
                    data-active-paths="{{ route('account-types.index') }}">
                    <i class="feather-list"></i>
                    <span>Account Types</span>
                </a>
            </li>
            <li>
                <a href="{{ route('group.index') }}" data-active-paths="{{ route('group.index') }}">
                    <i class="feather-folder"></i>
                    <span>Group Name</span>
                </a>
            </li>
            <li>
                <a href="{{ route('subsidiary-ledger.index') }}"
                    data-active-paths="{{ route('subsidiary-ledger.index') }}">
                    <i class="feather-layers"></i>
                    <span>Subsidiary Ledger</span>
                </a>
            </li>
            <li>
                <a href="{{ route('chart-of-accounts.index') }}"
                    data-active-paths="{{ route('chart-of-accounts.index') }}">
                    <i class="fas fa-sitemap"></i>
                    <span>Chart of Accounts</span>
                </a>
            </li>
            <li>
                <a href="{{ route('accounts-configuration.index') }}"
                    data-active-paths="{{ route('accounts-configuration.index') }}">
                    <i class="fas fa-cogs"></i>
                    <span>Accounts Configuration</span>
                </a>
            </li>
        </ul>
    </li>



    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-file-text"></i><span>Voucher Entry</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('voucher.payment') }}" data-active-paths="{{ route('voucher.payment') }}">
                    <i class="feather-credit-card"></i>
                    <span>Payment Voucher</span>
                </a>
            </li>
            <li>
                <a href="{{ route('voucher.receive') }}" data-active-paths="{{ route('voucher.receive') }}">
                    <i class="feather-download"></i>
                    <span>Receive Voucher</span>
                </a>
            </li>
            <li>
                <a href="{{ route('voucher.journal') }}" data-active-paths="{{ route('voucher.journal') }}">
                    <i class="feather-book"></i>
                    <span>Journal Voucher</span>
                </a>
            </li>
            <li>
                <a href="{{ route('contra-voucher.index') }}"
                    data-active-paths="{{ route('contra-voucher.index') }}, {{ route('contra-voucher.create') }}, {{ route('contra-voucher.edit', '*') }}, {{ route('contra-voucher.show', '*') }}, {{ route('contra-voucher.print', '*') }}">
                    <i class="feather-refresh-ccw"></i>
                    <span>Contra Voucher</span>
                </a>
            </li>
        </ul>
    </li>

    <!-- Route::get('/journal-report', [JournalVoucherController::class, 'journalReport'])->name('reports.journal-report');
        Route::get('/lager-report', [PaymentVoucherController::class, 'lagerReport'])->name('reports.lager-report');
        Route::get('/balance-sheet-report', [ReceiveVoucherController::class, 'balanceSheetReport'])->name('reports.balance-sheet-report');
        Route::get('/income-statement-report', [ContraVoucherController::class, 'incomeStatementReport'])->name('reports.income-statement-report'); -->
    <li>
        <a href="javascript:void(0);" class="has-arrow"><i class="feather-settings"></i><span>Reports</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('reports.journal-report') }}"
                    data-active-paths="{{ route('reports.journal-report') }}">
                    <i class="feather-book"></i>
                    <span>Journal</span>
                </a>
            </li>
            <li>
                <a href="{{ route('reports.lager-report') }}"
                    data-active-paths="{{ route('reports.lager-report') }}">
                    <i class="feather-credit-card"></i>
                    <span>Lager</span></a>
            </li>
            <li>
                <a href="{{ route('reports.balance-sheet-report') }}"
                    data-active-paths="{{ route('reports.balance-sheet-report') }}">
                    <i class="feather-layers"></i>
                    <span>Balance Sheet</span>
                </a>
            </li>
            <li>
                <a href="{{ route('reports.income-statement-report') }}"
                    data-active-paths="{{ route('reports.income-statement-report') }}">
                    <i class="feather-trending-up"></i>
                    <span>Income Statement</span>
                </a>
            </li>
            <!-- <li>
                <a href="{{ route('reports.journal-report') }}" data-active-paths="{{ route('reports.journal-report') }}">
                    <i class="feather-trending-up"></i>
                    <span>Journal Voucher Report</span>
                </a>
            </li> -->
        </ul>
    </li>



    {{-- <li>
        <a href="{{ route('ViewAllPaymentType') }}"
            data-active-paths="{{ route('ViewAllPaymentType') }}, {{ route('AddNewPaymentType') }}, {{ url('/admin/edit/payment-type/*') }}">
            <i class="feather-box"></i> Payment Types
            <span style="color:lightgreen" title="Total CS Types">
                ({{ DB::table('db_paymenttypes')->count() }})
            </span>
        </a>
    </li>
    <li>

        <a href="{{ route('ViewAllExpenseCategory') }}"
            data-active-paths="{{ route('ViewAllExpenseCategory') }}, {{ route('AddNewExpenseCategory') }}, {{ url('/admin/edit/expense-category/*') }}">
            <i class="feather-box"></i> Expense Categories
            <span style="color:lightgreen" title="Total Categories">
                ({{ DB::table('db_expense_categories')->count() }})
            </span>
        </a>

    </li>
    <li>
        <a href="{{ route('ViewAllAcAccount') }}"
            data-active-paths="{{ route('ViewAllAcAccount') }}, {{ route('AddNewAcAccount') }}, {{ url('/admin/edit/ac-account/*') }}">
            <i class="feather-box"></i> All Accounts
            <span style="color:lightgreen" title="Total Accounts">
                ({{ DB::table('ac_accounts')->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllExpense') }}"
            data-active-paths="{{ route('ViewAllExpense') }}, {{ route('AddNewExpense') }}, {{ url('/admin/edit/expense/*') }}">
            <i class="feather-box"></i> All Expenses
            <span style="color:lightgreen" title="Total Expenses">
                ({{ DB::table('db_expenses')->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllDeposit') }}"
            data-active-paths="{{ route('ViewAllDeposit') }}, {{ route('AddNewDeposit') }}, {{ url('/admin/edit/deposit/*') }}">
            <i class="feather-box"></i> All Deposits
            <span style="color:lightgreen" title="Total Deposits">
                ({{ DB::table('ac_transactions')->count() }})
            </span>
        </a>
    </li> --}}


    <!-- <li>
        <a  onclick="return false;" class="has-arrow"><i class="feather-settings"></i><span>Reports</span></a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('journal.index') }}" data-active-paths="{{ route('journal.index') }}">
                    <i class="feather-box"></i>
                    <span>Journal</span>
                </a>
            </li>
            <li>
                <a href="{{ route('ledger.index') }}" data-active-paths="{{ route('ledger.index') }}">
                    <i class="feather-box"></i>
                    <span>Ledger</span></a>
            </li>
            <li>
                <a href="{{ route('ledger.balance_sheet') }}"
                    data-active-paths="{{ route('ledger.balance_sheet') }}">
                    <i class="feather-box"></i>
                    <span>Balance Sheet</span>
                </a>
            </li>
            <li>
                <a href="{{ route('ledger.income_statement') }}"
                    data-active-paths="{{ route('ledger.income_statement') }}">
                    <i class="feather-box"></i>
                    <span>Income Statement</span>
                </a>
            </li>
            <li>
                <a href="{{ route('voucher.journal.report') }}" data-active-paths="{{ route('voucher.journal.report') }}">
                    <i class="feather-bar-chart-2"></i>
                    <span>Journal Voucher Report</span>
                </a>
            </li>
        </ul>
    </li> -->
    {{-- End Accounts Module --}}
    {{-- End Accounts Module --}}

    {{-- Start Crm Module --}}
    {{-- Start Crm Module --}}

    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">CRM Modules</li>
    <li>
        <a href="{{ route('crm.home') }}" data-active-paths="{{ route('crm.home') }}">
            <i class="feather-user-check"></i>
            <span> CRM-Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllCustomerSource') }}"
            data-active-paths="{{ route('ViewAllCustomerSource') }}, {{ route('AddNewCustomerSource') }}, {{ url('/admin/edit/customer-source/*') }}">
            <i class="feather-box"></i> Customer Src Type
            <span style="color:lightgreen" title="Total CS Types">
                ({{ DB::table('customer_source_types')->count() }})
            </span>
        </a>
    </li>
    <li>

        <a href="{{ route('ViewAllCustomerCategory') }}"
            data-active-paths="{{ route('ViewAllCustomerCategory') }}, {{ route('AddNewCustomerCategory') }}, {{ url('/admin/edit/customer-category/*') }}">
            <i class="feather-box"></i> Customer Category
            <span style="color:lightgreen" title="Total Categories">
                ({{ DB::table('customer_categories')->count() }})
            </span>
        </a>

    </li>
    <li>
        <a href="{{ route('ViewAllCustomer') }}"
            data-active-paths="{{ route('ViewAllCustomer') }}, {{ route('AddNewCustomers') }}, {{ url('/admin/edit/customers/*') }}">
            <i class="feather-box"></i> Customers
            <span style="color:lightgreen" title="Total Customers">
                ({{ DB::table('customers')->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllCustomerEcommerce') }}"
            data-active-paths="{{ route('ViewAllCustomerEcommerce') }}, {{ route('AddNewCustomerEcommerce') }}, {{ url('/admin/edit/customer-ecommerce/*') }}">
            <i class="feather-box"></i> E-Customer
            <span style="color:lightgreen" title="Total Contact Histories">
                ({{ DB::table('users')->where('user_type', 3)->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllCustomerContactHistories') }}"
            data-active-paths="{{ route('ViewAllCustomerContactHistories') }}, {{ route('AddNewCustomerContactHistories') }}, {{ url('/admin/edit/customer-contact-history/*') }}">
            <i class="feather-box"></i> Contacts History
            <span style="color:lightgreen" title="Total Contact Histories">
                ({{ DB::table('customer_contact_histories')->count() }})
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllCustomerNextContactDate') }}"
            data-active-paths="{{ route('ViewAllCustomerNextContactDate') }}, {{ route('AddNewCustomerNextContactDate') }}, {{ url('/admin/edit/customer-next-contact-date/*') }}">
            <i class="feather-box"></i> Next Date Contacts
            <span style="color:lightgreen" title="Total Contact Histories">
                ({{ DB::table('customer_next_contact_dates')->count() }})
            </span>
        </a>
    </li>

    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="fas fa-headset"></i>
            <span>Support Ticket</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a style="color: skyblue !important;" href="{{ route('PendingSupportTickets') }}"
                    data-active-paths="{{ route('PendingSupportTickets') }}, {{ url('view/support/messages/*') }}">
                    Pending Supports
                    (@php
                        echo DB::table('support_tickets')->where('status', 0)->orWhere('status', 1)->count();
                    @endphp)
                </a>
            </li>
            <li>
                <a style="color: #0c0 !important;" href="{{ route('SolvedSupportTickets') }}"
                    data-active-paths="{{ route('SolvedSupportTickets') }},{{ url('view/support/messages/*') }}">
                    Solved Supports
                    (@php
                        echo DB::table('support_tickets')->where('status', 2)->count();
                    @endphp)
                </a>
            </li>
            <li>
                <a style="color: goldenrod !important;" href="{{ route('OnHoldSupportTickets') }}"
                    data-active-paths="{{ route('OnHoldSupportTickets') }},{{ url('view/support/messages/*') }}">
                    On Hold Supports
                    (@php
                        echo DB::table('support_tickets')->where('status', 4)->count();
                    @endphp)
                </a>
            </li>
            <li>
                <a style="color: red !important;" href="{{ route('RejectedSupportTickets') }}"
                    data-active-paths="{{ route('RejectedSupportTickets') }},{{ url('view/support/messages/*') }}">
                    Rejected Supports
                    (@php
                        echo DB::table('support_tickets')->where('status', 3)->count();
                    @endphp)
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="{{ route('ViewAllContactRequests') }}" data-active-paths="{{ route('ViewAllContactRequests') }}">
            <i class="feather-phone-forwarded"></i>
            <span>Contact Request</span>
        </a>
    </li>
    <li>
        <a href="{{ route('ViewAllSubscribedUsers') }}" data-active-paths="{{ route('ViewAllSubscribedUsers') }}">
            <i class="feather-user-check"></i>
            <span>Subscribed Users</span>
        </a>
    </li>
    {{-- End Crm Modules --}}
    {{-- End Crm Modules --}}








    {{-- Start Download & Backup Module --}}

    <li class="menu-title" style="color: khaki; text-shadow: 1px 1px 2px black;">Download & Backup</li>

    <li>
        <a href="{{ route('DownloadDBBackup') }}" data-active-paths="{{ route('DownloadDBBackup') }}"
            onclick="return confirm('Are you sure you want to download the database backup?');">
            <i class="feather-database"></i>
            Database Backup
        </a>
    </li>
    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-image"></i>
            <span>Images Backup</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('DownloadAllImagesBackup') }}"
                    data-active-paths="{{ route('DownloadAllImagesBackup') }}"
                    onclick="return confirm('Are you sure you want to download all images backup? This may take some time.');">
                    All Images Backup
                </a>
            </li>
            <li>
                <a href="{{ route('DownloadProductFilesBackup') }}"
                    data-active-paths="{{ route('DownloadProductFilesBackup') }}"
                    onclick="return confirm('Are you sure you want to download the product images backup?');">
                    Product Images
                </a>
            </li>
            <li>
                <a href="{{ route('DownloadUserFilesBackup') }}"
                    data-active-paths="{{ route('DownloadUserFilesBackup') }}"
                    onclick="return confirm('Are you sure you want to download the user images backup?');">
                    User Images
                </a>
            </li>
            <li>
                <a href="{{ route('DownloadBannerFilesBackup') }}"
                    data-active-paths="{{ route('DownloadBannerFilesBackup') }}"
                    onclick="return confirm('Are you sure you want to download the banner images backup?');">
                    Banner Images
                </a>
            </li>
            <li>
                <a href="{{ route('DownloadCategoryFilesBackup') }}"
                    data-active-paths="{{ route('DownloadCategoryFilesBackup') }}"
                    onclick="return confirm('Are you sure you want to download the category icon backup?');">
                    Category Icons
                </a>
            </li>
            <li>
                <a href="{{ route('DownloadSubcategoryFilesBackup') }}"
                    onclick="return confirm('Are you sure you want to download the subcategory backup?');">
                    Subcategory Images
                </a>
            </li>
            <li>
                <a href="{{ route('DownloadFlagFilesBackup') }}"
                    data-active-paths="{{ route('DownloadFlagFilesBackup') }}"
                    onclick="return confirm('Are you sure you want to download the flag icon backup?');">
                    Flag Icons
                </a>
            </li>
            <li>
                <a href="{{ route('DownloadTicketFilesBackup') }}"
                    data-active-paths="{{ route('DownloadTicketFilesBackup') }}"
                    onclick="return confirm('Are you sure you want to download the ticket files backup?');">
                    Ticket Files
                </a>
            </li>
            <li>
                <a href="{{ route('DownloadBlogFilesBackup') }}"
                    data-active-paths="{{ route('DownloadBlogFilesBackup') }}"
                    onclick="return confirm('Are you sure you want to download the blog files backup?');">
                    Blog Images
                </a>
            </li>
            <li>
                <a href="{{ route('DownloadOtherFilesBackup') }}"
                    data-active-paths="{{ route('DownloadOtherFilesBackup') }}"
                    onclick="return confirm('Are you sure you want to download the other images backup?');">
                    Other Images
                </a>
            </li>
        </ul>
    </li>



    <li>
        <a href="javascript:void(0);" class="has-arrow">
            <i class="feather-box"></i>
            <span>Demo Products</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('GenerateDemoProducts') }}"
                    data-active-paths="{{ route('GenerateDemoProducts') }}">
                    Generate Products
                </a>
            </li>
            <li>
                <a href="{{ route('RemoveDemoProductsPage') }}"
                    data-active-paths="{{ route('RemoveDemoProductsPage') }}">
                    Remove Products
                </a>
            </li>
        </ul>
    </li>
    <li><a href="{{ route('ClearCache') }}"><i class="feather-rotate-cw"></i><span>Clear Cache</span></a></li>
    <li>
        <a href="{{ route('admin.logout') }}"
            onclick="event.preventDefault(); if (confirm('Are you sure you want to logout?')) { document.getElementById('logout-form').submit(); }">
            <i class="feather-log-out"></i><span>Logout</span>
        </a>
    </li>
</ul>

<script>
    document.getElementById('menuSearch').addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        const menuItems = document.querySelectorAll('#side-menu > li');
        const sideMenu = document.getElementById('side-menu');
        const sectionsWithVisibleItems = new Set();

        menuItems.forEach(item => {
            const mainLink = item.querySelector('a');
            const submenu = item.querySelector('.sub-menu');
            const mainText = mainLink?.innerText.toLowerCase() || '';
            const mainMatch = mainText.includes(query);
            let subMatch = false;

            if (submenu) {
                const subItems = submenu.querySelectorAll('li');
                subItems.forEach(subItem => {
                    const subText = subItem.innerText.toLowerCase();
                    const match = subText.includes(query);
                    subItem.style.display = match || mainMatch ? '' : 'none';
                    if (match) subMatch = true;
                });

                if (mainMatch || subMatch) {
                    item.style.display = '';
                    submenu.style.display = '';
                    item.classList.add('mm-active');
                    submenu.classList.add('mm-show');
                    sectionsWithVisibleItems.add(getMenuSection(item));
                } else {
                    item.style.display = 'none';
                    submenu.style.display = 'none';
                    item.classList.remove('mm-active');
                    submenu.classList.remove('mm-show');
                }
            } else {
                const match = mainText.includes(query);
                item.style.display = match ? '' : 'none';
                if (match) sectionsWithVisibleItems.add(getMenuSection(item));
            }
        });

        // Show/hide .menu-title and <hr> based on visible section items
        const children = Array.from(sideMenu.children);
        for (let i = 0; i < children.length; i++) {
            const node = children[i];

            // Handle <hr>
            if (node.tagName === 'HR') {
                const nextTitle = getNextMenuTitle(children, i);
                const showHr = nextTitle && sectionsWithVisibleItems.has(nextTitle.textContent.trim());
                node.style.display = showHr ? '' : 'none';
            }

            // Handle .menu-title
            if (node.classList?.contains('menu-title')) {
                const sectionText = node.textContent.trim();
                node.style.display = sectionsWithVisibleItems.has(sectionText) ? '' : 'none';
            }
        }
    });

    function getMenuSection(item) {
        let prev = item.previousElementSibling;
        while (prev) {
            if (prev.classList?.contains('menu-title')) {
                return prev.textContent.trim();
            }
            prev = prev.previousElementSibling;
        }
        return '';
    }

    function getNextMenuTitle(children, index) {
        for (let j = index + 1; j < children.length; j++) {
            const next = children[j];
            if (next.classList?.contains('menu-title')) {
                return next;
            }
            if (next.tagName === 'LI') {
                const section = getMenuSection(next);
                if (section) return children.find(el => el.classList?.contains('menu-title') && el.textContent
                    .trim() === section);
            }
        }
        return null;
    }

    // Smart Sidebar Auto-Scroll (No Interference with MetisMenu)
    (function() {
        'use strict';

        let hasScrolledOnce = false;

        // Scroll to active child menu item only on initial page load
        function scrollToActiveMenuItem() {
            if (hasScrolledOnce) return; // Only scroll once per page load

            const sidebarContainer = document.querySelector('.left-side-menu') ||
                document.querySelector('.sidebar') ||
                document.querySelector('.simplebar-content-wrapper') ||
                document.querySelector('#side-menu')?.parentElement;

            if (!sidebarContainer) return;

            // Find active child menu items (not parent dropdowns)
            const activeChildItems = document.querySelectorAll('#side-menu .sub-menu li > a');
            let activeItem = null;

            // Look for active child in submenu first
            for (let item of activeChildItems) {
                const href = item.getAttribute('href');
                const isActive = item.closest('li')?.classList.contains('mm-active') ||
                    item.classList.contains('active') ||
                    href === window.location.pathname ||
                    (href && window.location.pathname.includes(href));

                if (isActive && href && href !== '#' && !href.includes('javascript:')) {
                    activeItem = item;
                    break;
                }
            }

            // Fallback to top-level active items (but not parent dropdowns)
            if (!activeItem) {
                const topLevelItems = document.querySelectorAll('#side-menu > li > a:not(.has-arrow)');
                for (let item of topLevelItems) {
                    const href = item.getAttribute('href');
                    const isActive = item.closest('li')?.classList.contains('mm-active') ||
                        item.classList.contains('active') ||
                        href === window.location.pathname;

                    if (isActive && href && href !== '#' && !href.includes('javascript:')) {
                        activeItem = item;
                        break;
                    }
                }
            }

            if (!activeItem) return;

            // Wait for MetisMenu to complete initialization
            setTimeout(function() {
                const containerRect = sidebarContainer.getBoundingClientRect();
                const itemRect = activeItem.getBoundingClientRect();

                // Only scroll if item is outside visible area
                const isAboveView = itemRect.top < containerRect.top + 50;
                const isBelowView = itemRect.bottom > containerRect.bottom - 50;

                if (isAboveView || isBelowView) {
                    const itemOffsetTop = activeItem.offsetTop;
                    const containerHeight = sidebarContainer.clientHeight;
                    const itemHeight = activeItem.offsetHeight;
                    const scrollPosition = itemOffsetTop - (containerHeight / 2) + (itemHeight / 2);

                    sidebarContainer.scrollTo({
                        top: Math.max(0, scrollPosition),
                        behavior: 'smooth'
                    });

                    hasScrolledOnce = true;
                }
            }, 400); // Increased delay for MetisMenu animation
        }

        // Prevent scrolling when clicking parent menu items
        function preventParentMenuScroll() {
            const parentMenuLinks = document.querySelectorAll(
                'a.has-arrow, a[href="javascript:void(0);"], a[href="#"]');
            parentMenuLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    // Prevent default anchor behavior that causes scrolling
                    if (link.getAttribute('href') === '#' ||
                        link.getAttribute('href') === 'javascript:void(0);' ||
                        link.classList.contains('has-arrow')) {
                        e.preventDefault();
                    }
                });
            });
        }

        // Initialize only once on DOM ready

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                scrollToActiveMenuItem();
                preventParentMenuScroll();
            });
        } else {
            scrollToActiveMenuItem();
            preventParentMenuScroll();
        }
    })();
</script>

<style>
    /* Modern Sidebar Design - Creative UI */

    /* Custom Scrollbar */
    #side-menu::-webkit-scrollbar {
        width: 6px;
    }

    #side-menu::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
    }

    #side-menu::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }

    #side-menu::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #764ba2 0%, #667eea 100%);
    }

    /* Enhanced Search Container with Glassmorphism */
    .menu-search-container,
    div[style*="padding: 10px"] {
        padding: 16px !important;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
        margin-bottom: 8px;
    }

    #menuSearch {
        width: 100%;
        /* keep left padding for text, right padding to make room for icon */
        padding: 12px 45px 12px 16px;
        border: 2px solid rgba(102, 126, 234, 0.2);
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.95);
        color: #2d3748;
        font-size: 14px;
        font-weight: 500;
        box-sizing: border-box;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%23667eea' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'%3E%3C/circle%3E%3Cpath d='m21 21-4.35-4.35'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        /* place icon on the right side */
        background-position: calc(100% - 16px) center;
        background-size: 18px;
    }

    #menuSearch::placeholder {
        color: #a0aec0;
        font-weight: 400;
    }

    #menuSearch:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), 0 4px 16px rgba(102, 126, 234, 0.2);
        transform: translateY(-1px);
    }

    /* Menu List Container */
    #side-menu {
        padding: 8px 12px;
    }

    /* Parent Menu Items - Modern Card Style */
    #side-menu>li {
        margin-bottom: 4px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    #side-menu>li>a {
        padding: 8px 16px !important;
        border-radius: 10px;
        font-weight: 500;
        font-size: 14px;
        color: #4a5568;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        border: 1px solid rgb(50 59 81 / 12%);
        background-clip: padding-box;
        box-shadow: inset 0 -1px 0 rgba(255, 255, 255, 0.02);
    }

    /* Animated gradient background on hover */
    #side-menu>li>a::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
        transition: left 0.5s ease;
    }

    #side-menu>li>a:hover::before {
        left: 100%;
    }

    #side-menu>li>a:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
        color: #667eea;
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    }

    /* Active menu item */
    #side-menu>li.mm-active>a,
    #side-menu>li>a.active {
        background: linear-gradient(90deg, rgba(126, 144, 223, 0.527), rgba(118, 75, 162, 0.02));
        color: white !important;
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        transform: translateX(4px);
    }

    /* Icons styling with gradient */
    #side-menu>li>a>i {
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }


    #side-menu>li>a:hover>i {
        transform: scale(1.15) rotate(5deg);
    }

    #side-menu>li.mm-active>a>i,
    #side-menu>li>a.active>i {
        -webkit-text-fill-color: white;
        transform: scale(1.1);
    }

    /* Menu Title - Modern Section Headers */
    .menu-title {
        /* Professional, highlightable section header */
        font-weight: 700 !important;
        font-size: 12px !important;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        padding: 14px 14px !important;
        position: relative;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 12px;
        margin-bottom: 12px;
        text-align: left;
        border-radius: 8px;
        background: linear-gradient(135deg, #394683b2 0%, #764ba275 100%);
        border: 1px solid rgba(15, 23, 42, 0.04);
        box-shadow: 0 1px 2px rgba(16, 24, 40, 0.03) inset;
        transition: background 200ms ease, transform 160ms ease, box-shadow 200ms ease;
        cursor: default;
    }

    .menu-title:hover {
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.08), rgba(118, 75, 162, 0.04));
        transform: translateX(3px);
        box-shadow: 0 6px 18px rgba(99, 102, 241, 0.06);
    }

    /* Left accent bar for quick visual section identification */
    .menu-title::before {
        content: '';
        width: 6px;
        height: 22px;
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        border-radius: 3px;
        margin-right: 10px;
        box-shadow: 0 2px 6px rgba(102, 126, 234, 0.12);
        flex-shrink: 0;
    }

    /* When the section is visible/active (JS may toggle a class), give stronger highlight */
    .menu-title.is-visible,
    .menu-title.visible {
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.10), rgba(118, 75, 162, 0.05));
        border-color: rgba(102, 126, 234, 0.18);
        transform: translateX(3px);
        box-shadow: 0 8px 26px rgba(102, 126, 234, 0.08);
    }

    /* Horizontal Rule - Gradient Divider */
    hr {
        border: none !important;
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, rgba(102, 126, 234, 0.3) 50%, transparent 100%) !important;
        margin: 16px 12px !important;
    }

    /* Tree Structure for Submenus - Enhanced */
    .sub-menu {
        position: relative;
        margin-left: 20px !important;
        padding-left: 24px !important;
        border-left: 2px solid rgba(102, 126, 234, 0.2) !important;
        background: linear-gradient(to right, rgba(102, 126, 234, 0.02) 0%, transparent 100%);
        border-radius: 0 8px 8px 0;
        margin-top: 4px !important;
        margin-bottom: 4px !important;
    }

    /* Glowing effect on active submenu */
    li.mm-active>.sub-menu {
        border-left-color: #667eea !important;
        background: linear-gradient(to right, rgba(102, 126, 234, 0.05) 0%, transparent 100%);
        box-shadow: -2px 0 8px rgba(102, 126, 234, 0.1);
    }

    /* Submenu items */
    .sub-menu>li {
        position: relative;
        padding-left: 0px !important;
        margin: 2px 0;
    }

    /* Animated horizontal connector line */
    .sub-menu>li::before {
        content: '';
        position: absolute;
        left: -24px;
        top: 50%;
        width: 20px;
        height: 2px;
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.3), rgba(102, 126, 234, 0.6));
        z-index: 1;
        transition: all 0.3s ease;
    }

    .sub-menu>li:hover::before {
        width: 24px;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }

    /* Enhanced dot connector with pulse effect */
    .sub-menu>li::after {
        content: '';
        position: absolute;
        left: -4px;
        top: 50%;
        transform: translateY(-50%);
        width: 8px;
        height: 8px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        z-index: 2;
        transition: all 0.3s ease;
        box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.4);
    }

    .sub-menu>li:hover::after {
        width: 10px;
        height: 10px;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.4);
        }

        70% {
            box-shadow: 0 0 0 8px rgba(102, 126, 234, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
        }
    }

    /* Submenu links - Modern style */
    .sub-menu>li>a {
        padding: 10px 14px !important;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        color: #64748b;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: block;
        position: relative;
        border: 1px solid rgba(15, 23, 42, 0.04);
        background-clip: padding-box;
    }

    .sub-menu>li>a:hover {
        padding-left: 18px !important;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
        color: #667eea;
        transform: translateX(2px);
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
    }

    /* Active submenu item */
    .sub-menu>li.mm-active>a,
    .sub-menu>li>a.active,
    .sub-menu>li>a[aria-expanded="true"] {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
        color: #667eea !important;
        font-weight: 600;
        border-left: 3px solid #667eea;
        border: 1px solid rgba(102, 126, 234, 0.18);
        padding-left: 18px !important;
        box-shadow: 0 2px 12px rgba(102, 126, 234, 0.2);
    }

    /* Nested submenus */
    .sub-menu .sub-menu {
        margin-left: 24px !important;
        border-left-color: rgba(102, 126, 234, 0.15) !important;
    }

    /* Has-arrow indicator - Right-pointing triangle with smooth rotation */
    .has-arrow {
        position: relative;
        padding-right: 32px !important;
        color: #94a3b8;
        /* arrow color is controlled via currentColor */
    }

    .has-arrow::after {
        content: '' !important;
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%) rotate(0deg);
        transform-origin: center;
        width: 0;
        height: 0;
        border-top: 6px solid transparent;
        border-bottom: 6px solid transparent;
        border-left: 8px solid currentColor;
        transition: transform 0.18s ease, border-left-color 0.18s ease;
    }

    /* Rotate arrow down when submenu is expanded (by class or aria attribute) */
    li.mm-active>a.has-arrow::after,
    a.has-arrow[aria-expanded="true"]::after {
        transform: translateY(-50%) rotate(90deg) !important;
    }

    /* Hover changes arrow color only; when parent is active, keep arrow white */
    a.has-arrow:hover {
        color: #667eea !important;
    }

    a.has-arrow:hover::after {
        border-left-color: currentColor;
    }

    li.mm-active>a.has-arrow {
        color: white !important;
    }

    /* Badge/Counter styling */
    #side-menu span[style*="color:lightgreen"],
    #side-menu span[style*="color:goldenrod"],
    #side-menu span[style*="color:tomato"] {
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        margin-left: auto;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Smooth entrance animation for menu items */
    #side-menu>li {
        animation: slideInLeft 0.4s ease-out backwards;
    }

    #side-menu>li:nth-child(1) {
        animation-delay: 0.05s;
    }

    #side-menu>li:nth-child(2) {
        animation-delay: 0.1s;
    }

    #side-menu>li:nth-child(3) {
        animation-delay: 0.15s;
    }

    #side-menu>li:nth-child(4) {
        animation-delay: 0.2s;
    }

    #side-menu>li:nth-child(5) {
        animation-delay: 0.25s;
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Collapsible transition enhancement */
    .sub-menu {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    /* Tooltip effect for collapsed items (optional enhancement) */
    #side-menu>li>a[title]:hover::after {
        content: attr(title);
        position: absolute;
        left: 100%;
        margin-left: 10px;
        padding: 6px 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 6px;
        font-size: 12px;
        white-space: nowrap;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        #side-menu>li>a {
            padding: 10px 12px !important;
        }

        .sub-menu {
            margin-left: 24px !important;
            padding-left: 16px !important;
        }
    }
</style>
