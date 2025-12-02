# Laravel SEO System - Complete Guide

## 📋 Overview

A production-ready, tenant-aware SEO management system for Laravel applications. This system provides comprehensive SEO metadata management with support for Open Graph, Twitter Cards, and Schema.org structured data.

## ✨ Features

- **Fluent API** - Chain methods for easy SEO configuration
- **Multi-tenant Support** - Automatic tenant-specific defaults from `general_infos` table
- **Social Media Ready** - Full Open Graph and Twitter Card support
- **Auto-generation** - Automatically generate meta tags from content
- **Blade Components** - Simple `<x-seo />` component for layouts
- **SEO Best Practices** - Follows Google's SEO guidelines
- **Flexible Configuration** - Per-page customization with global defaults

## 🚀 Installation & Setup

### 1. Files Created

```
app/
├── Services/
│   └── SeoService.php                    # Core SEO service
├── Http/
│   ├── View/
│   │   └── Composers/
│   │       └── SeoComposer.php           # View composer for injection
│   └── Controllers/
│       └── Tenant/Frontend/
│           └── ExampleSeoController.php   # Example usage

resources/views/
└── components/
    └── seo.blade.php                      # Blade component
```

### 2. Service Provider Configuration

The `AppServiceProvider` has been updated to:

- Register `SeoService` as a singleton
- Inject `SeoService` into all views via `SeoComposer`
- Share `generalInfo` globally for tenant defaults

### 3. Layout Integration

The tenant frontend layout (`resources/views/tenant/frontend/layouts/app.blade.php`) now includes:

```blade
<head>
    <!-- SEO Meta Tags Component (auto-injected from SeoService) -->
    <x-seo />

    @stack('site-seo')
    <!-- Other head content -->
</head>
```

## 📖 Usage Examples

### Basic Usage in Controller

```php
namespace App\Http\Controllers\Tenant\Frontend;

use App\Services\SeoService;

class HomeController extends Controller
{
    public function __construct(protected SeoService $seo)
    {
    }

    public function index()
    {
        // Set SEO metadata
        $this->seo
            ->setTitle('Welcome to Our Store')
            ->setDescription('Shop the best products at amazing prices')
            ->setKeywords(['shop', 'ecommerce', 'products']);

        return view('tenant.frontend.pages.index');
    }
}
```

### Product Detail Page

```php
public function show($id)
{
    $product = Product::findOrFail($id);

    // Set comprehensive SEO
    $this->seo
        ->setTitle($product->name)
        ->setDescription($product->short_description, 160)
        ->setKeywords(explode(',', $product->keywords))
        ->setCanonical(url()->current());

    // Set social media tags
    $this->seo->setOpenGraph(
        title: $product->name,
        description: $product->short_description,
        image: $product->featured_image_url,
        type: 'product'
    );

    // Twitter Card
    $this->seo->setTwitterCard(
        title: $product->name,
        description: $product->short_description,
        image: $product->featured_image_url
    );

    return view('tenant.frontend.pages.product', compact('product'));
}
```

### Blog Post with Auto-generation

```php
public function showPost($slug)
{
    $post = BlogPost::where('slug', $slug)->firstOrFail();

    // Auto-generate SEO from content
    $this->seo->autoGenerateFromContent($post->content, $post->title);

    // Customize specific fields
    $this->seo
        ->setOgType('article')
        ->setAuthor($post->author->name)
        ->setOgImage($post->featured_image_url)
        ->addMeta('article:published_time', $post->published_at->toIso8601String());

    return view('tenant.frontend.pages.blog-post', compact('post'));
}
```

### Category/Listing Page

```php
public function category($slug)
{
    $category = Category::where('slug', $slug)->firstOrFail();
    $products = $category->products()->paginate(20);

    $this->seo
        ->setTitle($category->name . ' Products')
        ->setDescription("Browse {$products->total()} {$category->name} products")
        ->setKeywords([$category->name, 'shop', 'buy']);

    return view('tenant.frontend.pages.category', compact('category', 'products'));
}
```

### Search Results (No-index)

```php
public function search(Request $request)
{
    $query = $request->input('q');
    $results = Product::search($query)->paginate(20);

    $this->seo
        ->setTitle("Search: {$query}")
        ->setDescription("Found {$results->total()} results for '{$query}'")
        ->setRobots('noindex,follow'); // Don't index search pages

    return view('tenant.frontend.pages.search', compact('results', 'query'));
}
```

### Using Without Constructor Injection

```php
Route::get('/example', function () {
    $seo = app(SeoService::class);

    $seo->setTitle('Example Page')
        ->setDescription('This is an example');

    return view('example');
});
```

## 🎯 SeoService API Reference

### Title Methods

```php
// Set title (appends site name by default)
$seo->setTitle('Page Title');

// Set title without appending site name
$seo->setTitle('Complete Title', appendSiteName: false);

// Get final title
$seo->getTitle();
```

### Description & Keywords

```php
// Set description (auto-truncates to 160 chars)
$seo->setDescription('Your page description');

// Custom max length
$seo->setDescription('Your description', maxLength: 200);

// Set keywords (string or array)
$seo->setKeywords(['keyword1', 'keyword2']);
$seo->setKeywords('keyword1, keyword2, keyword3');
```

### Canonical URL

```php
// Set canonical (defaults to current URL)
$seo->setCanonical('https://example.com/page');

// Use current URL
$seo->setCanonical();
```

### Open Graph Tags

```php
// Set all OG tags at once
$seo->setOpenGraph(
    title: 'OG Title',
    description: 'OG Description',
    image: 'https://example.com/image.jpg',
    url: 'https://example.com/page',
    type: 'article'
);

// Or set individually
$seo->setOgTitle('Title');
$seo->setOgDescription('Description');
$seo->setOgImage('https://example.com/image.jpg');
$seo->setOgUrl('https://example.com/page');
$seo->setOgType('product');
```

### Twitter Card

```php
// Set Twitter Card
$seo->setTwitterCard(
    title: 'Twitter Title',
    description: 'Twitter Description',
    image: 'https://example.com/image.jpg',
    cardType: 'summary_large_image'
);

// Card types: summary, summary_large_image, app, player
```

### Additional Tags

```php
// Set robots directive
$seo->setRobots('index,follow');
$seo->setRobots('noindex,nofollow');

// Set author
$seo->setAuthor('John Doe');

// Add custom meta tag
$seo->addMeta('property-name', 'content');
$seo->addMeta('article:published_time', '2024-01-01');
```

### Auto-generation

```php
// Auto-generate missing tags from content
$seo->autoGenerateFromContent($htmlContent, $title);

// This will:
// - Generate description from content (if not set)
// - Extract keywords from content (if not set)
// - Use provided title (if not set)
```

### Debugging

```php
// Get all SEO data as array
$seoData = $seo->toArray();

// Returns:
[
    'title' => '...',
    'description' => '...',
    'keywords' => '...',
    'canonical' => '...',
    'robots' => '...',
    'og' => [...],
    'twitter' => [...],
    'additional_meta' => [...]
]
```

## 🎨 Blade Component

The `<x-seo />` component automatically renders all meta tags:

```blade
<head>
    <x-seo />
</head>
```

Outputs:

```html
<title>Page Title | Site Name</title>
<meta name="description" content="..." />
<meta name="keywords" content="..." />
<meta name="robots" content="index,follow" />
<link rel="canonical" href="..." />

<!-- Open Graph -->
<meta property="og:type" content="website" />
<meta property="og:url" content="..." />
<meta property="og:title" content="..." />
<meta property="og:description" content="..." />
<meta property="og:image" content="..." />
<meta property="og:site_name" content="..." />

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="..." />
<meta name="twitter:title" content="..." />
<meta name="twitter:description" content="..." />
<meta name="twitter:image" content="..." />

<!-- Favicon -->
<link rel="icon" href="..." type="image/x-icon" />
```

## ⚙️ Configuration

### Tenant-Specific Defaults

SEO defaults are pulled from the `general_infos` table (shared globally by `AppServiceProvider`):

- `company_name` → Site Name
- `meta_title` → Default Title
- `meta_description` → Default Description
- `meta_keywords` → Default Keywords
- `meta_og_image` → Default OG Image

### Fallback Chain

If page-level SEO is not set, the service uses this fallback order:

1. **Page-specific** (set via `setTitle()`, etc.)
2. **Tenant defaults** (from `general_infos`)
3. **Application defaults** (from `config/app.php`)

## 🎯 SEO Best Practices

### Title Tags

- ✅ Keep titles under 60 characters
- ✅ Include primary keyword
- ✅ Use unique titles per page
- ✅ Format: "Primary Keyword | Brand Name"

### Meta Descriptions

- ✅ Keep between 150-160 characters
- ✅ Include call-to-action
- ✅ Unique per page
- ✅ Include target keywords naturally

### Keywords

- ✅ 5-10 relevant keywords
- ✅ Focus on long-tail keywords
- ✅ Match user search intent

### Open Graph

- ✅ Always set OG image (1200x630px recommended)
- ✅ Use descriptive titles
- ✅ Set correct `og:type` (website, article, product)

### Twitter Cards

- ✅ Use `summary_large_image` for most content
- ✅ Ensure images are high quality
- ✅ Keep titles under 70 characters

### Canonical URLs

- ✅ Always set canonical to prevent duplicate content
- ✅ Use absolute URLs
- ✅ Point to the preferred version of the page

### Robots

- ✅ Use `index,follow` for main content
- ✅ Use `noindex,follow` for search results, filters
- ✅ Use `noindex,nofollow` for admin pages

## 🧪 Testing SEO

### Manual Testing

```php
// Debug SEO data in browser
Route::get('/seo-debug', function () {
    $seo = app(SeoService::class);
    $seo->setTitle('Test')->setDescription('Test desc');

    return response()->json($seo->toArray());
});
```

### Preview Tools

- **Google**: [Rich Results Test](https://search.google.com/test/rich-results)
- **Facebook**: [Sharing Debugger](https://developers.facebook.com/tools/debug/)
- **Twitter**: [Card Validator](https://cards-dev.twitter.com/validator)
- **LinkedIn**: [Post Inspector](https://www.linkedin.com/post-inspector/)

### Browser Extensions

- **Meta SEO Inspector** (Chrome/Firefox)
- **SEOquake**
- **MozBar**

## 📊 Advanced Usage

### Dynamic Schema.org Markup

```php
// Add structured data for products
$seo->addMeta('product:price:amount', $product->price);
$seo->addMeta('product:price:currency', 'USD');
$seo->addMeta('product:availability', $product->in_stock ? 'in stock' : 'out of stock');
```

### Multiple Images for OG

```php
// Primary image
$seo->setOgImage($product->main_image);

// Additional images
foreach ($product->gallery as $image) {
    $seo->addMeta('og:image', $image->url);
}
```

### Article-specific Metadata

```php
$seo->setOgType('article')
    ->addMeta('article:published_time', $post->published_at->toIso8601String())
    ->addMeta('article:modified_time', $post->updated_at->toIso8601String())
    ->addMeta('article:author', $post->author->profile_url)
    ->addMeta('article:section', $post->category->name);
```

## 🔧 Troubleshooting

### SEO Not Appearing

1. Clear view cache: `php artisan view:clear`
2. Check `AppServiceProvider` registration
3. Verify `<x-seo />` is in layout `<head>`

### Defaults Not Loading

1. Ensure `general_infos` table has data
2. Check `View::share('generalInfo', ...)` in `AppServiceProvider`
3. Verify database connection

### Images Not Showing on Social Media

1. Use absolute URLs for images
2. Images must be publicly accessible
3. Recommended size: 1200x630px
4. Use `.jpg` or `.png` format
5. Clear cache on social platform debuggers

## 📝 Migration from Old System

If you have existing SEO code in views:

### Before:

```blade
@push('site-seo')
    @php
        $generalInfo = DB::table('general_infos')->first();
    @endphp
    <title>{{ $generalInfo->meta_title }}</title>
    <meta name="description" content="{{ $generalInfo->meta_description }}" />
@endpush
```

### After:

```php
// In Controller
$this->seo->setTitle('Page Title')->setDescription('Description');
```

```blade
<!-- In Layout (already added) -->
<x-seo />
```

## 🚀 Next Steps

1. **Update existing controllers** to use `SeoService`
2. **Remove old `@push('site-seo')` blocks** from individual pages
3. **Test with social media debuggers**
4. **Monitor Google Search Console** for SEO improvements
5. **Add structured data** for rich snippets

## 📚 Additional Resources

- [Google SEO Starter Guide](https://developers.google.com/search/docs/beginner/seo-starter-guide)
- [Open Graph Protocol](https://ogp.me/)
- [Twitter Cards Documentation](https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/abouts-cards)
- [Schema.org](https://schema.org/)

---

**Questions or Issues?** Check the example controller for comprehensive usage patterns.
