@php
    $categories = DB::table('categories')->where('show_on_navbar', 1)->get();
@endphp

<!-- Main Content Container -->
<div class="container-fluid mb-3">
    <div class="row g-4">
        <div class="col-lg-3">
            <!-- Unified Sidebar for All Devices -->
            <div class="sidebar" id="mainSidebar">

                <!-- Menu Content -->
                <div class="sidebar-content" id="sidebarContent" style="display: none;">
                    @foreach ($categories as $category)
                        @if ($category->show_on_navbar == 1)
                            @php
                                $subcategories = DB::table('subcategories')
                                    ->where('category_id', $category->id)
                                    ->get();
                            @endphp
                            <div class="menu-item">
                                <div class="menu-button" data-toggle="submenu-{{ $category->id }}">
                                    <span class="menu-icon">
                                        @if ($category->name == 'Fruits & Vegetables')
                                            <i class="bi bi-apple"></i>
                                        @elseif ($category->name == 'Meats & Seafood')
                                            <i class="bi bi-fish"></i>
                                        @elseif ($category->name == 'Breakfast & Dairy')
                                            <i class="bi bi-egg"></i>
                                        @elseif ($category->name == 'Beverages')
                                            <i class="bi bi-cup"></i>
                                        @elseif ($category->name == 'Breads & Bakery')
                                            <i class="bi bi-cake"></i>
                                        @elseif ($category->name == 'Frozen Foods')
                                            <i class="bi bi-snow"></i>
                                        @elseif ($category->name == 'Biscuits & Snacks')
                                            <i class="bi bi-cookie"></i>
                                        @elseif ($category->name == 'Grocery & Staples')
                                            <i class="bi bi-basket"></i>
                                        @else
                                            <i class="bi bi-box"></i>
                                        @endif
                                    </span>
                                    {{ $category->name }}
                                </div>
                                @if (count($subcategories) > 0)
                                    <div class="submenu" id="submenu-{{ $category->id }}">
                                        @foreach ($subcategories as $subcategory)
                                            @php
                                                $childcategories = DB::table('child_categories')
                                                    ->where('subcategory_id', $subcategory->id)
                                                    ->get();
                                            @endphp
                                            <div class="submenu-item">
                                                @if (count($childcategories) > 0)
                                                    <div class="submenu-button" data-toggle="childmenu-{{ $subcategory->id }}">
                                                        <a href="{{ url('shop') }}?category={{ $category->slug }}&subcategory_id={{ $subcategory->id }}"
                                                            class="submenu-link">{{ $subcategory->name }}</a>
                                                    </div>
                                                    <div class="child-submenu" id="childmenu-{{ $subcategory->id }}">
                                                        @foreach ($childcategories as $childcategory)
                                                            <div class="child-submenu-item">
                                                                <a href="{{ url('shop') }}?category={{ $category->slug }}&subcategory_id={{ $subcategory->id }}&childcategory_id={{ $childcategory->id }}"
                                                                    class="child-submenu-link">{{ $childcategory->name }}</a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <a href="{{ url('shop') }}?category={{ $category->slug }}&subcategory_id={{ $subcategory->id }}"
                                                        class="submenu-link">{{ $subcategory->name }}</a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Only keep sidebar toggle for mobile
    document.addEventListener("DOMContentLoaded", function () {
        const sidebarContent = document.getElementById("sidebarContent");
        const sidebarToggle = document.getElementById("sidebarToggle");
        if (sidebarContent && sidebarToggle) {
            sidebarContent.style.display = "none";
            sidebarToggle.addEventListener("click", function () {
                if (sidebarContent.style.display === "none") {
                    sidebarContent.style.display = "block";
                    sidebarToggle.classList.add("active");
                } else {
                    sidebarContent.style.display = "none";
                    sidebarToggle.classList.remove("active");
                }
            });
        }
    });
</script>
