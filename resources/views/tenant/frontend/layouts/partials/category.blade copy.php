@php
    $categories = DB::table('categories')->where('show_on_navbar', 1)->get();
@endphp

<!-- Modern Professional Navigation CSS -->
<style>
    /* Modern Header Navigation Styles */
    .modern-nav {
        background: linear-gradient(135deg, #1b1c1d 0%, #020202 100%);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 1;
        display: none;
        /* Hide on mobile by default */
    }

    /* Show only on large devices */
    @media (min-width: 992px) {
        .modern-nav {
            display: block;
        }
    }

    .modern-nav__container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .modern-nav__menu {
        display: flex;
        align-items: center;
        justify-content: center;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 5px;
    }

    .modern-nav__item {
        position: relative;
    }

    .modern-nav__link {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 18px 20px;
        color: #ffffff;
        font-size: 15px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        border-radius: 8px;
        position: relative;
    }

    .modern-nav__link:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        transform: translateY(-2px);
    }

    .modern-nav__link--active {
        background: rgba(255, 255, 255, 0.2);
        font-weight: 600;
    }

    .modern-nav__icon {
        width: 14px;
        height: 14px;
        transition: transform 0.3s ease;
    }

    .modern-nav__item:hover .modern-nav__icon {
        transform: rotate(180deg);
    }

    /* Modern Dropdown Menu */
    .modern-nav__dropdown {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 280px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        padding: 12px 0;
        margin-top: 0px;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        z-index: 1000;
    }

    .modern-nav__item:hover>.modern-nav__dropdown {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .modern-nav__dropdown-item {
        position: relative;
    }

    .modern-nav__dropdown-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 24px;
        color: #2d3748;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .modern-nav__dropdown-link:hover {
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        color: #667eea;
        padding-left: 32px;
    }

    /* Child Dropdown (Second Level) */
    .modern-nav__child-dropdown {
        display: none;
        position: absolute;
        top: 0;
        left: 100%;
        min-width: 250px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        padding: 12px 0;
        margin-left: 0px;
        opacity: 0;
        transform: translateX(-10px);
        transition: all 0.3s ease;
    }

    .modern-nav__dropdown-item:hover>.modern-nav__child-dropdown {
        display: block;
        opacity: 1;
        transform: translateX(0);
    }

    .modern-nav__child-link {
        display: block;
        padding: 10px 24px;
        color: #4a5568;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .modern-nav__child-link:hover {
        background: rgba(102, 126, 234, 0.08);
        color: #667eea;
        padding-left: 32px;
    }

    /* Mobile Menu Toggle */
    .modern-nav__mobile-toggle {
        display: none;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        padding: 12px 16px;
        border-radius: 8px;
        color: #ffffff;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .modern-nav__mobile-toggle:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 991px) {
        .modern-nav__mobile-toggle {
            display: block;
        }

        .modern-nav__menu {
            display: none;
            flex-direction: column;
            align-items: stretch;
            background: #ffffff;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 0 0 12px 12px;
            padding: 12px;
            gap: 4px;
        }

        .modern-nav__menu.active {
            display: flex;
        }

        .modern-nav__link {
            color: #2d3748;
            justify-content: space-between;
        }

        .modern-nav__link:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .modern-nav__dropdown {
            position: static;
            box-shadow: none;
            background: #f7fafc;
            border-radius: 8px;
            margin: 4px 0;
            padding: 8px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .modern-nav__item.mobile-open>.modern-nav__dropdown {
            display: block;
            opacity: 1;
            transform: translateY(0);
            max-height: 500px;
        }

        .modern-nav__child-dropdown {
            position: static;
            margin: 4px 0 4px 16px;
            box-shadow: none;
            background: #edf2f7;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .modern-nav__dropdown-item.mobile-open>.modern-nav__child-dropdown {
            display: block;
            opacity: 1;
            transform: translateX(0);
            max-height: 400px;
        }
    }
</style>

<!-- Modern Professional Navigation -->
<nav class="modern-nav">
    <div class="modern-nav__container">
        <button class="modern-nav__mobile-toggle" id="modernNavToggle">
            <i class="bi bi-list"></i> Menu
        </button>

        <ul class="modern-nav__menu" id="modernNavMenu">
            @foreach ($categories as $category)
                @php
                    $subcategories = DB::table('subcategories')->where('category_id', $category->id)->get();
                @endphp

                <li class="modern-nav__item">
                    <a class="modern-nav__link @if (str_contains(Request::fullUrl(), '=' . $category->slug)) modern-nav__link--active @endif"
                        href="{{ url('shop') }}?category={{ $category->slug }}">
                        {{ $category->name }}

                        @if (count($subcategories) > 0)
                            <svg class="modern-nav__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z" />
                            </svg>
                        @endif
                    </a>

                    @if (count($subcategories) > 0)
                        <ul class="modern-nav__dropdown">
                            @foreach ($subcategories as $subcategory)
                                @php
                                    $childcategories = DB::table('child_categories')
                                        ->where('subcategory_id', $subcategory->id)
                                        ->get();
                                @endphp

                                <li class="modern-nav__dropdown-item">
                                    <a href="{{ url('shop') }}?category={{ $category->slug }}&subcategory_id={{ $subcategory->id }}"
                                        class="modern-nav__dropdown-link">
                                        {{ $subcategory->name }}

                                        @if (count($childcategories) > 0)
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z" />
                                            </svg>
                                        @endif
                                    </a>

                                    @if (count($childcategories) > 0)
                                        <ul class="modern-nav__child-dropdown">
                                            @foreach ($childcategories as $childcategory)
                                                <li>
                                                    <a href="{{ url('shop') }}?category={{ $category->slug }}&subcategory_id={{ $subcategory->id }}&childcategory_id={{ $childcategory->id }}"
                                                        class="modern-nav__child-link">
                                                        {{ $childcategory->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</nav>

<!-- Modern Navigation JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('modernNavToggle');
        const menu = document.getElementById('modernNavMenu');
        const navItems = document.querySelectorAll('.modern-nav__item');

        // Mobile menu toggle
        if (toggle && menu) {
            toggle.addEventListener('click', function() {
                menu.classList.toggle('active');
                this.innerHTML = menu.classList.contains('active') ?
                    '<i class="bi bi-x"></i> Close' :
                    '<i class="bi bi-list"></i> Menu';
            });
        }

        // Mobile accordion functionality
        if (window.innerWidth <= 991) {
            navItems.forEach(item => {
                const link = item.querySelector('.modern-nav__link');
                const dropdown = item.querySelector('.modern-nav__dropdown');

                if (link && dropdown) {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        item.classList.toggle('mobile-open');
                    });

                    // Handle child dropdowns
                    const dropdownItems = dropdown.querySelectorAll('.modern-nav__dropdown-item');
                    dropdownItems.forEach(dropdownItem => {
                        const dropdownLink = dropdownItem.querySelector(
                            '.modern-nav__dropdown-link');
                        const childDropdown = dropdownItem.querySelector(
                            '.modern-nav__child-dropdown');

                        if (dropdownLink && childDropdown) {
                            dropdownLink.addEventListener('click', function(e) {
                                e.preventDefault();
                                dropdownItem.classList.toggle('mobile-open');
                            });
                        }
                    });
                }
            });
        }
    });
</script>
