<?php

namespace App\Modules\ECOMMERCE\Managements\WebsiteConfigurations\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralInfo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * Explicitly list all fields that controllers may mass-assign so
     * `updateOrCreate` / `fill` calls succeed and data persists.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'logo',
        'logo_dark',
        'fav_icon',
        'tab_title',
        'company_name',
        'short_description',
        'contact',
        'email',
        'address',
        'google_map_link',
        'play_store_link',
        'app_store_link',
        'footer_copyright_text',
        'payment_banner',

        'primary_color',
        'secondary_color',
        'tertiary_color',
        'title_color',
        'paragraph_color',
        'border_color',

        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'youtube',
        'messenger',
        'whatsapp',
        'telegram',
        'tiktok',
        'pinterest',
        'viber',

        'meta_title',
        'meta_keywords',
        'meta_description',
        'meta_og_title',
        'meta_og_description',
        'meta_og_image',

        'custom_css',
        'header_script',
        'footer_script',

        'google_analytic_status',
        'google_analytic_tracking_id',
        'google_tag_manager_status',
        'google_tag_manager_id',

        'fb_pixel_status',
        'fb_pixel_app_id',
        'fb_page_id',
        'messenger_chat_status',
        'tawk_chat_status',
        'tawk_chat_link',
        'crisp_chat_status',
        'crisp_website_id',

        'guest_checkout',

        'created_at',
        'updated_at'
    ];
}
