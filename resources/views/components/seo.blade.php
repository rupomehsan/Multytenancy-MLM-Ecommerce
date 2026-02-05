{{--
    SEO Component - Renders all SEO meta tags automatically
    
    Usage in layout:
    <x-seo />
    
    The component automatically pulls SEO data from the SeoService instance
    which is injected into all views via SeoComposer
--}}

@php
    // Get SEO service instance from view composer
    $seo = $seo ?? app(\App\Services\SeoService::class);
@endphp

<!-- Primary Meta Tags -->
<title>{{ $seo->getTitle() }}</title>
@if ($seo->getDescription())
    <meta name="title" content="{{ $seo->getTitle() }}" />
    <meta name="description" content="{{ $seo->getDescription() }}" />
@endif

@if ($seo->getKeywords())
    <meta name="keywords" content="{{ $seo->getKeywords() }}" />
@endif

@if ($seo->getAuthor())
    <meta name="author" content="{{ $seo->getAuthor() }}" />
@endif

<meta name="robots" content="{{ $seo->getRobots() }}" />

<!-- Canonical URL -->
<link rel="canonical" href="{{ $seo->getCanonical() }}" />

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $seo->getOgType() }}" />
<meta property="og:url" content="{{ $seo->getOgUrl() }}" />
<meta property="og:title" content="{{ $seo->getOgTitle() }}" />
@if ($seo->getOgDescription())
    <meta property="og:description" content="{{ $seo->getOgDescription() }}" />
@endif
@if ($seo->getOgImage())
    <meta property="og:image" content="{{ $seo->getOgImage() }}" />
@endif
<meta property="og:site_name" content="{{ $seo->getSiteName() }}" />

<!-- Twitter Card -->
<meta name="twitter:card" content="{{ $seo->getTwitterCard() }}" />
<meta name="twitter:url" content="{{ $seo->getOgUrl() }}" />
<meta name="twitter:title" content="{{ $seo->getTwitterTitle() }}" />
@if ($seo->getTwitterDescription())
    <meta name="twitter:description" content="{{ $seo->getTwitterDescription() }}" />
@endif
@if ($seo->getTwitterImage())
    <meta name="twitter:image" content="{{ $seo->getTwitterImage() }}" />
@endif

<!-- Additional Meta Tags -->
@foreach ($seo->getAdditionalMeta() as $name => $content)
    <meta name="{{ $name }}" content="{{ $content }}" />
@endforeach

<!-- Favicon (from generalInfo) -->
@php
    $generalInfo = view()->shared('generalInfo');
@endphp
@if ($generalInfo && $generalInfo->fav_icon)
    <link rel="icon" href="{{ $generalInfo->fav_icon }}" type="image/x-icon" />
@endif
