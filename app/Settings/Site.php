<?php

namespace App\Settings;

use App\Helpers\TranslatableSettings;
use Spatie\LaravelSettings\Settings;

class Site extends Settings
{
    private array $translatable = [
        'fav_icon', 'logo', 'mobile_logo', 'footer_logo', 'address',
    ];

    private array $uploads = [
        'fav_icon', 'logo', 'mobile_logo', 'footer_logo'
    ];

    public function translatable()
    {
        return $this->translatable;
    }

    public function uploads(){
        return $this->uploads;
    }

    use TranslatableSettings;

    public ?string $fav_icon;

    public ?array $logo;
    public ?array $mobile_logo;
    public ?array $footer_logo;
    public ?array $address;
//    public ?array $p_o_box;


    public ?string $email;
    public ?string $phone;
    public ?string $fax;

    public ?string $facebook_link;
    public ?string $instagram_link;
    public ?string $twitter_link;
    public ?string $youtube_link;
    public ?string $linkedin_link;
    public ?string $whatsapp_link;
    public ?string $app_store_link;
    public ?string $play_store_link;
    public ?string $app_gallery_link;

    public ?float $headquarter_longitude;
    public ?float $headquarter_latitude;


    public ?string $google_tag_code;
    public ?string $google_analytics_code;
    public ?string $meta_pixel_code;


    public ?int $default_page_size;
    public ?int $news_page_size;
    public ?int $photo_gallery_page_size;
    public ?int $video_gallery_page_size;
    public ?int $branches_page_size;
    public ?int $faqs_page_size;
    public ?int $search_page_size;
    public ?int $downloadable_files_page_size;
    public ?int $our_team_page_size;

    public ?int $careers_page_size;

    public ?int $financial_statements_page_size;
    public ?int $annual_general_page_size;
    public ?int $shareholders_page_size;


    public ?string $contact_us_mailing_list;
    public ?string $careers_mailing_list;
    public ?string $account_appliers_mailing_list;
    public ?string $card_appliers_mailing_list;
    public ?string $finance_appliers_mailing_list;

    public ?string $captcha_secret_key;
    public ?string $captcha_site_key;
    public bool $enable_captcha;

    public float $deposits_interest_rate;

//    public ?array $title;
//    public ?array $description;
//    public ?string $admin_email;

    public ?string $chat_key;

    public static function group(): string
    {
        return 'site';
    }
}
