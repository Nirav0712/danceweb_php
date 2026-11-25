<?php

namespace App\Services;

use App\Core\Database;

class ContentService
{
    public static function getHeaderMenu(): array
    {
        return CacheService::remember('content_header_menu', 3600, function () {
            try {
                $items = Database::fetchAll(
                    "SELECT * FROM menu_items WHERE position = 'HEADER' AND is_active = 1 ORDER BY sort_order ASC"
                );

                // Build parent-child tree
                $tree = [];
                $lookup = [];
                foreach ($items as $item) {
                    $item['children'] = [];
                    $lookup[$item['id']] = $item;
                }

                foreach ($lookup as $id => &$item) {
                    if ($item['parent_id'] && isset($lookup[$item['parent_id']])) {
                        $lookup[$item['parent_id']]['children'][] = &$item;
                    } else {
                        $tree[] = &$item;
                    }
                }

                if (!empty($tree)) {
                    return $tree;
                }
            } catch (\Throwable $e) {}

            // Fallback default menu items
            return [
                ['title' => 'Home', 'url' => '/', 'children' => []],
                ['title' => 'About', 'url' => '/about', 'children' => []],
                [
                    'title' => 'Journey',
                    'url' => '#',
                    'children' => [
                        ['title' => 'National Journey', 'url' => '/journey/national'],
                        ['title' => 'International Journey', 'url' => '/journey/international'],
                    ],
                ],
                ['title' => 'Awards', 'url' => '/awards', 'children' => []],
                ['title' => 'Gallery', 'url' => '/gallery', 'children' => []],
                ['title' => 'Dance Stories', 'url' => '/blogs', 'children' => []],
                [
                    'title' => 'News',
                    'url' => '#',
                    'children' => [
                        ['title' => 'National News', 'url' => '/news/national'],
                        ['title' => 'International News', 'url' => '/news/international'],
                    ],
                ],
                ['title' => 'Contact', 'url' => '/contact', 'children' => []],
            ];
        });
    }

    public static function getFooterMenu(): array
    {
        return CacheService::remember('content_footer_menu', 3600, function () {
            try {
                $items = Database::fetchAll(
                    "SELECT * FROM menu_items WHERE position = 'FOOTER' AND is_active = 1 ORDER BY sort_order ASC"
                );
                if (!empty($items)) return $items;
            } catch (\Throwable $e) {}

            return [
                ['title' => 'Home', 'url' => '/'],
                ['title' => 'About Us', 'url' => '/about'],
                ['title' => 'National Journey', 'url' => '/journey/national'],
                ['title' => 'International Journey', 'url' => '/journey/international'],
                ['title' => 'Awards & Records', 'url' => '/awards'],
                ['title' => 'Photo Gallery', 'url' => '/gallery'],
                ['title' => 'Dance Stories', 'url' => '/blogs'],
                ['title' => 'Contact Us', 'url' => '/contact'],
            ];
        });
    }

    public static function getSettings(): array
    {
        return CacheService::remember('content_settings', 3600, function () {
            try {
                $rows = Database::fetchAll("SELECT setting_key, setting_value FROM website_settings");
                $settings = [];
                foreach ($rows as $r) {
                    $settings[$r['setting_key']] = $r['setting_value'];
                }
                if (!empty($settings)) {
                    // Aliases for template convenience and backwards compatibility
                    if (!isset($settings['phone_primary']) && isset($settings['primary_phone'])) {
                        $settings['phone_primary'] = $settings['primary_phone'];
                    }
                    if (!isset($settings['phone_secondary']) && isset($settings['secondary_phone'])) {
                        $settings['phone_secondary'] = $settings['secondary_phone'];
                    }
                    if (!isset($settings['email']) && isset($settings['official_email'])) {
                        $settings['email'] = $settings['official_email'];
                    }
                    return $settings;
                }
            } catch (\Throwable $e) {}

            return [
                'phone_primary' => '+91 91738 78750',
                'phone_secondary' => '+91 72280 53232',
                'email' => 'dynamicechildrenacademy@gmail.com',
                'address_nikol' => 'VAIKUNTH COMPLEX, NR RASPAN ARCADE, NIKOL.',
                'director_name' => 'Shri Tirthraj Trivedi',
                'instagram_url' => 'https://www.instagram.com/dynamice_children_academy/',
                'youtube_url' => 'https://www.youtube.com',
                'founding_year' => '1998',
            ];
        });
    }

    public static function getBranches(): array
    {
        return CacheService::remember('content_branches', 3600, function () {
            try {
                $branches = Database::fetchAll("SELECT * FROM branches ORDER BY sort_order ASC");
                if (!empty($branches)) return $branches;
            } catch (\Throwable $e) {}

            return [
                [
                    'branch_name' => 'Nikol Branch',
                    'address_line1' => 'VAIKUNTH COMPLEX, NR RASPAN ARCADE, NIKOL.',
                    'city' => 'Ahmedabad',
                    'state' => 'Gujarat',
                    'phone_primary' => '+91 91738 78750',
                    'timing_info' => 'Mon - Sat: 9:00 AM - 8:00 PM',
                ],
                [
                    'branch_name' => 'Bapunagar Branch',
                    'address_line1' => '204, CENTRE POINT, INDIA COLONY ROAD, BAPUNAGAR.',
                    'city' => 'Ahmedabad',
                    'state' => 'Gujarat',
                    'phone_primary' => '+91 72280 53232',
                    'timing_info' => 'Mon - Sat: 9:00 AM - 8:00 PM',
                ]
            ];
        });
    }
}
