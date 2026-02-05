<?php

namespace App\Http\Controllers\Tenant\Frontend;

use App\Http\Controllers\Controller;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Example Tenant Frontend Controller demonstrating SEO usage
 * 
 * This controller shows how to use the SeoService to set SEO metadata
 * for different pages in your multi-tenant application.
 */
class ExampleSeoController extends Controller
{
    /**
     * Constructor - inject SeoService
     * 
     * @param SeoService $seo
     */
    public function __construct(protected SeoService $seo) {}

    /**
     * Example 1: Basic SEO setup for homepage
     * 
     * @return \Illuminate\View\View
     */
    public function homepage()
    {
        // Set basic SEO metadata
        $this->seo
            ->setTitle('Welcome to Our Store')
            ->setDescription('Discover amazing products at great prices. Shop electronics, fashion, home goods and more with fast shipping.')
            ->setKeywords(['ecommerce', 'online shopping', 'electronics', 'fashion']);

        // Fetch data for the page
        $featuredProducts = DB::table('products')
            ->where('status', 1)
            ->where('featured', 1)
            ->limit(8)
            ->get();

        return view('tenant.frontend.pages.index', compact('featuredProducts'));
    }

    /**
     * Example 2: SEO for product detail page with dynamic content
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function productDetail($id)
    {
        $product = DB::table('products')->where('id', $id)->first();

        if (!$product) {
            abort(404);
        }

        // Set SEO with product-specific data
        $this->seo
            ->setTitle($product->name . ' - Buy Online', false) // Don't append site name automatically
            ->setDescription(strip_tags($product->description), 160)
            ->setKeywords(explode(',', $product->keywords ?? ''))
            ->setCanonical(url()->current());

        // Set Open Graph tags for social sharing
        $productImage = $product->thumbnail
            ? ( $product->thumbnail)
            : null;

        $this->seo->setOpenGraph(
            title: $product->name,
            description: strip_tags($product->description),
            image: $productImage,
            url: url()->current(),
            type: 'product'
        );

        // Set Twitter Card
        $this->seo->setTwitterCard(
            title: $product->name,
            description: strip_tags($product->description),
            image: $productImage
        );

        // Add structured data for product
        $this->seo->addMeta('product:price:amount', $product->price);
        $this->seo->addMeta('product:price:currency', 'USD');

        return view('tenant.frontend.pages.product_details.details', compact('product'));
    }

    /**
     * Example 3: SEO for category/listing page
     * 
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function categoryProducts($slug)
    {
        $category = DB::table('categories')->where('slug', $slug)->first();

        if (!$category) {
            abort(404);
        }

        $products = DB::table('products')
            ->where('category_id', $category->id)
            ->where('status', 1)
            ->paginate(20);

        // Set SEO for category page
        $this->seo
            ->setTitle($category->name . ' Products')
            ->setDescription("Browse our collection of {$category->name} products. Find the best deals and latest items.")
            ->setKeywords([$category->name, 'products', 'shop', 'buy online']);

        return view('tenant.frontend.pages.shop.category', compact('category', 'products'));
    }

    /**
     * Example 4: SEO for blog post with auto-generation
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function blogPost($id)
    {
        $post = DB::table('blogs')->where('id', $id)->first();

        if (!$post) {
            abort(404);
        }

        // Auto-generate SEO tags from content
        $this->seo->autoGenerateFromContent($post->content, $post->title);

        // Manually set additional tags
        $this->seo
            ->setOgType('article')
            ->setAuthor($post->author_name ?? 'Admin')
            ->addMeta('article:published_time', $post->created_at)
            ->addMeta('article:modified_time', $post->updated_at);

        // Set blog post image for social sharing
        if ($post->featured_image) {
            $this->seo->setOgImage( $post->featured_image);
        }

        return view('tenant.frontend.pages.blog_details', compact('post'));
    }

    /**
     * Example 5: SEO for search results page
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        $results = DB::table('products')
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->where('status', 1)
            ->paginate(20);

        // Set SEO for search results
        $this->seo
            ->setTitle("Search Results for: {$query}")
            ->setDescription("Find products matching '{$query}'. Browse {$results->total()} results.")
            ->setRobots('noindex,follow') // Don't index search result pages
            ->setCanonical(url()->current());

        return view('tenant.frontend.pages.search_results', compact('results', 'query'));
    }

    /**
     * Example 6: SEO for static content page
     * 
     * @return \Illuminate\View\View
     */
    public function aboutUs()
    {
        // Simple static page SEO
        $this->seo
            ->setTitle('About Us - Our Story')
            ->setDescription('Learn about our company mission, values, and the team behind our success.')
            ->setKeywords(['about us', 'company', 'mission', 'team']);

        return view('tenant.frontend.pages.about');
    }

    /**
     * Example 7: Using SeoService without constructor injection
     * (useful in route closures or middleware)
     * 
     * @return \Illuminate\View\View
     */
    public function contactUs()
    {
        // Get SEO service from container
        $seo = app(SeoService::class);

        $seo->setTitle('Contact Us - Get in Touch')
            ->setDescription('Have questions? Contact our customer support team. We\'re here to help!')
            ->setKeywords(['contact', 'support', 'customer service']);

        return view('tenant.frontend.pages.contact');
    }

    /**
     * Example 8: SEO debugging - view all SEO data as JSON
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function seoDebug()
    {
        // Set some test data
        $this->seo
            ->setTitle('Debug Page')
            ->setDescription('This is a debug page to test SEO metadata')
            ->setKeywords(['debug', 'test', 'seo']);

        // Return all SEO data as JSON for debugging
        return response()->json($this->seo->toArray());
    }

    /**
     * Example 9: SEO for package/deal page
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function packageDetail($id)
    {
        $package = DB::table('packages')->where('id', $id)->first();

        if (!$package) {
            abort(404);
        }

        // Set comprehensive SEO for package
        $this->seo
            ->setTitle($package->name . ' - Special Deal')
            ->setDescription(strip_tags($package->description))
            ->setKeywords(['package deal', 'discount', 'bundle', $package->name]);

        // Set social media tags
        if ($package->image) {
            $packageImage =  $package->image;

            $this->seo
                ->setOgImage($packageImage)
                ->setTwitterCard(
                    title: $package->name,
                    description: strip_tags($package->description),
                    image: $packageImage
                );
        }

        return view('tenant.frontend.pages.package_details.details', compact('package'));
    }
}
