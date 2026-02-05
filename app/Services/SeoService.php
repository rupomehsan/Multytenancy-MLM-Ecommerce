<?php

namespace App\Services;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

/**
 * SEO Service - Centralized service for managing SEO metadata across the application
 * 
 * This service provides a fluent interface for setting SEO tags including:
 * - Meta title, description, keywords
 * - Open Graph tags (Facebook, LinkedIn)
 * - Twitter Card tags
 * - Canonical URLs
 * - Schema.org structured data
 * 
 * Usage in Controller:
 * app(SeoService::class)->setTitle('Page Title')->setDescription('Page description');
 * 
 * Or inject via constructor:
 * public function __construct(protected SeoService $seo) {}
 */
class SeoService
{
    protected ?string $title = null;
    protected ?string $description = null;
    protected ?string $keywords = null;
    protected ?string $canonical = null;
    protected ?string $ogTitle = null;
    protected ?string $ogDescription = null;
    protected ?string $ogImage = null;
    protected ?string $ogUrl = null;
    protected ?string $ogType = 'website';
    protected ?string $twitterCard = 'summary_large_image';
    protected ?string $twitterTitle = null;
    protected ?string $twitterDescription = null;
    protected ?string $twitterImage = null;
    protected ?string $robots = 'index,follow';
    protected ?string $author = null;
    protected array $additionalMeta = [];

    // Configuration defaults (pulled from tenant settings or config)
    protected ?string $siteName = null;
    protected ?string $defaultTitle = null;
    protected ?string $defaultDescription = null;
    protected ?string $defaultKeywords = null;
    protected ?string $defaultImage = null;
    protected string $titleSeparator = ' | ';

    /**
     * Initialize SEO service with tenant-specific defaults
     */
    public function __construct()
    {
        $this->loadDefaults();
    }

    /**
     * Load default SEO values from general_infos (shared via AppServiceProvider)
     */
    protected function loadDefaults(): void
    {
        // Access the globally shared $generalInfo from AppServiceProvider
        $generalInfo = view()->shared('generalInfo');

        if ($generalInfo) {
            $this->siteName = $generalInfo->company_name ?? config('app.name');
            $this->defaultTitle = $generalInfo->meta_title ?? $generalInfo->company_name ?? config('app.name');
            $this->defaultDescription = $generalInfo->meta_description ?? '';
            $this->defaultKeywords = $generalInfo->meta_keywords ?? '';
            $this->defaultImage = $generalInfo->meta_og_image
                ? ( $generalInfo->meta_og_image)
                : null;
        } else {
            // Fallback if generalInfo is not available
            $this->siteName = config('app.name');
            $this->defaultTitle = config('app.name');
        }

        // Set canonical to current URL by default
        $this->canonical = URL::current();
    }

    /**
     * Set the page title
     * 
     * @param string $title Page title (will be appended with site name)
     * @param bool $appendSiteName Whether to append site name
     * @return $this
     */
    public function setTitle(string $title, bool $appendSiteName = true): self
    {
        $this->title = $appendSiteName
            ? ($title . $this->titleSeparator . $this->siteName)
            : $title;

        return $this;
    }

    /**
     * Set meta description (recommended max 160 characters)
     * 
     * @param string $description Page description
     * @param int $maxLength Maximum length (default 160 chars for SEO best practice)
     * @return $this
     */
    public function setDescription(string $description, int $maxLength = 160): self
    {
        $this->description = Str::limit($description, $maxLength, '...');
        return $this;
    }

    /**
     * Set meta keywords (comma-separated)
     * 
     * @param string|array $keywords Keywords as string or array
     * @return $this
     */
    public function setKeywords($keywords): self
    {
        $this->keywords = is_array($keywords) ? implode(', ', $keywords) : $keywords;
        return $this;
    }

    /**
     * Set canonical URL (prevents duplicate content issues)
     * 
     * @param string|null $url Canonical URL (defaults to current URL)
     * @return $this
     */
    public function setCanonical(?string $url = null): self
    {
        $this->canonical = $url ?? URL::current();
        return $this;
    }

    /**
     * Set all Open Graph tags at once
     * 
     * @param string $title OG title
     * @param string $description OG description
     * @param string|null $image OG image URL (absolute URL)
     * @param string|null $url OG URL
     * @param string $type OG type (default: website)
     * @return $this
     */
    public function setOpenGraph(
        string $title,
        string $description,
        ?string $image = null,
        ?string $url = null,
        string $type = 'website'
    ): self {
        $this->ogTitle = $title;
        $this->ogDescription = Str::limit($description, 160, '...');
        $this->ogImage = $image;
        $this->ogUrl = $url ?? URL::current();
        $this->ogType = $type;

        return $this;
    }

    /**
     * Set Open Graph title
     * 
     * @param string $title OG title
     * @return $this
     */
    public function setOgTitle(string $title): self
    {
        $this->ogTitle = $title;
        return $this;
    }

    /**
     * Set Open Graph description
     * 
     * @param string $description OG description
     * @return $this
     */
    public function setOgDescription(string $description): self
    {
        $this->ogDescription = Str::limit($description, 160, '...');
        return $this;
    }

    /**
     * Set Open Graph image (for social media sharing)
     * 
     * @param string $imageUrl Absolute URL to image
     * @return $this
     */
    public function setOgImage(string $imageUrl): self
    {
        $this->ogImage = $imageUrl;
        return $this;
    }

    /**
     * Set Open Graph URL
     * 
     * @param string $url OG URL
     * @return $this
     */
    public function setOgUrl(string $url): self
    {
        $this->ogUrl = $url;
        return $this;
    }

    /**
     * Set Open Graph type (website, article, product, etc.)
     * 
     * @param string $type OG type
     * @return $this
     */
    public function setOgType(string $type): self
    {
        $this->ogType = $type;
        return $this;
    }

    /**
     * Set all Twitter Card tags at once
     * 
     * @param string $title Twitter card title
     * @param string $description Twitter card description
     * @param string|null $image Twitter card image URL (absolute URL)
     * @param string $cardType Twitter card type (default: summary_large_image)
     * @return $this
     */
    public function setTwitterCard(
        string $title,
        string $description,
        ?string $image = null,
        string $cardType = 'summary_large_image'
    ): self {
        $this->twitterCard = $cardType;
        $this->twitterTitle = $title;
        $this->twitterDescription = Str::limit($description, 160, '...');
        $this->twitterImage = $image;

        return $this;
    }

    /**
     * Set robots meta tag (controls search engine crawling)
     * 
     * @param string $robots Robots directive (e.g., 'index,follow', 'noindex,nofollow')
     * @return $this
     */
    public function setRobots(string $robots): self
    {
        $this->robots = $robots;
        return $this;
    }

    /**
     * Set author meta tag
     * 
     * @param string $author Author name
     * @return $this
     */
    public function setAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Add custom meta tag
     * 
     * @param string $name Meta tag name
     * @param string $content Meta tag content
     * @return $this
     */
    public function addMeta(string $name, string $content): self
    {
        $this->additionalMeta[$name] = $content;
        return $this;
    }

    /**
     * Auto-generate missing SEO tags from provided content
     * Useful when you have page content but want to auto-populate meta tags
     * 
     * @param string $content HTML or text content
     * @param string|null $title Optional title
     * @return $this
     */
    public function autoGenerateFromContent(string $content, ?string $title = null): self
    {
        // Strip HTML tags
        $plainText = strip_tags($content);

        // Generate description if not set
        if (!$this->description) {
            $this->setDescription($plainText, 160);
        }

        // Generate title if provided and not set
        if ($title && !$this->title) {
            $this->setTitle($title);
        }

        // Generate keywords from content (extract most common words)
        if (!$this->keywords) {
            $words = str_word_count(strtolower($plainText), 1);
            $words = array_filter($words, fn($word) => strlen($word) > 4); // Filter short words
            $commonWords = array_count_values($words);
            arsort($commonWords);
            $topWords = array_slice(array_keys($commonWords), 0, 10);
            $this->setKeywords(implode(', ', $topWords));
        }

        return $this;
    }

    /**
     * Get the final title (falls back to default if not set)
     * 
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title ?? $this->defaultTitle ?? $this->siteName ?? config('app.name');
    }

    /**
     * Get the final description (falls back to default if not set)
     * 
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description ?? $this->defaultDescription ?? '';
    }

    /**
     * Get keywords
     * 
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->keywords ?? $this->defaultKeywords ?? '';
    }

    /**
     * Get canonical URL
     * 
     * @return string
     */
    public function getCanonical(): string
    {
        return $this->canonical ?? URL::current();
    }

    /**
     * Get Open Graph title (falls back to page title)
     * 
     * @return string
     */
    public function getOgTitle(): string
    {
        return $this->ogTitle ?? $this->getTitle();
    }

    /**
     * Get Open Graph description (falls back to meta description)
     * 
     * @return string
     */
    public function getOgDescription(): string
    {
        return $this->ogDescription ?? $this->getDescription();
    }

    /**
     * Get Open Graph image
     * 
     * @return string|null
     */
    public function getOgImage(): ?string
    {
        return $this->ogImage ?? $this->defaultImage;
    }

    /**
     * Get Open Graph URL (falls back to canonical)
     * 
     * @return string
     */
    public function getOgUrl(): string
    {
        return $this->ogUrl ?? $this->getCanonical();
    }

    /**
     * Get Open Graph type
     * 
     * @return string
     */
    public function getOgType(): string
    {
        return $this->ogType;
    }

    /**
     * Get Twitter card type
     * 
     * @return string
     */
    public function getTwitterCard(): string
    {
        return $this->twitterCard;
    }

    /**
     * Get Twitter title (falls back to OG title)
     * 
     * @return string
     */
    public function getTwitterTitle(): string
    {
        return $this->twitterTitle ?? $this->getOgTitle();
    }

    /**
     * Get Twitter description (falls back to OG description)
     * 
     * @return string
     */
    public function getTwitterDescription(): string
    {
        return $this->twitterDescription ?? $this->getOgDescription();
    }

    /**
     * Get Twitter image (falls back to OG image)
     * 
     * @return string|null
     */
    public function getTwitterImage(): ?string
    {
        return $this->twitterImage ?? $this->getOgImage();
    }

    /**
     * Get robots directive
     * 
     * @return string
     */
    public function getRobots(): string
    {
        return $this->robots;
    }

    /**
     * Get author
     * 
     * @return string|null
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * Get site name
     * 
     * @return string
     */
    public function getSiteName(): string
    {
        return $this->siteName ?? config('app.name');
    }

    /**
     * Get all additional meta tags
     * 
     * @return array
     */
    public function getAdditionalMeta(): array
    {
        return $this->additionalMeta;
    }

    /**
     * Export all SEO data as array (useful for testing or debugging)
     * 
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'keywords' => $this->getKeywords(),
            'canonical' => $this->getCanonical(),
            'robots' => $this->getRobots(),
            'author' => $this->getAuthor(),
            'og' => [
                'title' => $this->getOgTitle(),
                'description' => $this->getOgDescription(),
                'image' => $this->getOgImage(),
                'url' => $this->getOgUrl(),
                'type' => $this->getOgType(),
                'site_name' => $this->getSiteName(),
            ],
            'twitter' => [
                'card' => $this->getTwitterCard(),
                'title' => $this->getTwitterTitle(),
                'description' => $this->getTwitterDescription(),
                'image' => $this->getTwitterImage(),
            ],
            'additional_meta' => $this->getAdditionalMeta(),
        ];
    }
}
