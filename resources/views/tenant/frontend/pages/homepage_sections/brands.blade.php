<!-- Start Featured Brands Section -->
<style>
    .featured-brands-section {
        padding: 60px 0;
        background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
    }

    .featured-brands-title {
        font-size: 36px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 48px;
        position: relative;
        display: inline-block;
        padding-bottom: 16px;
        margin-top: 10px;
    }

    .featured-brands-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #e91e63 0%, #d81b60 100%);
        border-radius: 2px;
    }

    .brands-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 24px;
        padding: 0;
        margin: 0;
    }

    .brand-card {
        background: white;
        border-radius: 16px;
        padding: 32px 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 16px;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.04);
        min-height: 200px;
        position: relative;
        overflow: hidden;
    }

    .brand-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #e91e63 0%, #d81b60 100%);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .brand-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(233, 30, 99, 0.15);
        border-color: rgba(233, 30, 99, 0.2);
    }

    .brand-card:hover::before {
        transform: scaleX(1);
    }

    .brand-image-wrapper {
        width: 100%;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px;
        position: relative;
    }

    .brand-image {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
        transition: all 0.3s ease;
        filter: grayscale(0%);
    }

    .brand-card:hover .brand-image {
        transform: scale(1.08);
        filter: grayscale(0%) brightness(1.05);
    }

    .brand-name {
        font-size: 15px;
        font-weight: 600;
        color: #2d3748;
        text-align: center;
        margin: 0;
        line-height: 1.4;
        word-wrap: break-word;
        overflow-wrap: break-word;
        transition: color 0.3s ease;
        width: 100%;
    }

    .brand-card:hover .brand-name {
        color: #e91e63;
    }

    @media (max-width: 1200px) {
        .brands-grid {
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 20px;
        }
    }

    @media (max-width: 768px) {
        .featured-brands-section {
            padding: 40px 0;
        }

        .featured-brands-title {
            font-size: 28px;
            margin-bottom: 32px;
        }

        .brands-grid {
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 16px;
        }

        .brand-card {
            padding: 24px 16px;
            min-height: 160px;
        }

        .brand-image-wrapper {
            height: 90px;
        }

        .brand-name {
            font-size: 14px;
        }
    }

    @media (max-width: 480px) {
        .brands-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<section class="featured-brands-section">
    <div class="container-fluid ">
        <div class="text-center">
            <h2 class="featured-brands-title">{{ __('home.featured_brands') }}</h2>
        </div>
        <div class="brands-grid mb-5">
            @foreach ($featuredBrands as $brands)
                @php
                    $brandImage = !empty($brands->logo)
                        ? env('ADMIN_URL') . '/' . $brands->logo
                        : 'https://ui-avatars.com/api/?name=' .
                            urlencode($brands->name) .
                            '&size=200&background=e91e63&color=ffffff&font-size=0.4&bold=true';
                @endphp
                <a href="{{ url('shop') }}?brand={{ $brands->id }}" class="brand-card">
                    <div class="brand-image-wrapper">
                        <img src="{{ $brandImage }}" alt="{{ $brands->name }}" class="brand-image"
                            onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($brands->name) }}&size=200&background=e91e63&color=ffffff&font-size=0.4&bold=true';" />
                    </div>
                    <p class="brand-name">{{ $brands->name }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
<!-- End Featured Brands Section -->
