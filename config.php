<?php

use Illuminate\Support\Str;

return [
    'baseUrl' => '',
    'production' => false,
    'siteName' => 'gTLD.fyi',
    'siteDescription' => 'Beautiful docs powered by Jigsaw',

    // Algolia DocSearch credentials
    'docsearchApiKey' => env('DOCSEARCH_KEY'),
    'docsearchIndexName' => env('DOCSEARCH_INDEX'),

    // navigation menu
    'navigation' => require_once('navigation.php'),

    // helpers
    'isActive' => function ($page, $path) {
        return Str::endsWith(trimPath($page->getPath()), trimPath($path));
    },
    'isActiveParent' => function ($page, $menuItem) {
        if (is_object($menuItem) && $menuItem->children) {
            return $menuItem->children->contains(function ($child) use ($page) {
                return trimPath($page->getPath()) == trimPath($child);
            });
        }
    },
    'url' => function ($page, $path) {
        return Str::startsWith($path, 'http') ? $path : '/' . trimPath($path);
    },
    'collections' => [
        'gtlds' => [
            'extends' => '_layouts.gtld',
            'path' => 'tld/{name}',
            'sort' => 'name',
            'items' => function($config) {
                return collect(explode("\n", file_get_contents(__DIR__ . '/gtlds.txt')))
                    ->reject(fn(string $gtld) => empty($gtld))
                    ->reject(fn(string $gtld) => str_starts_with($gtld, '#'))
                    ->reject(fn(string $gtld) => str_starts_with($gtld, 'XN--'))
                    ->reject(fn(string $gtld) => in_array($gtld, ['COM', 'NET', 'ORG', 'EDU', 'GOV', 'MIL']))
                    ->map(function($gtld) {
                        return [
                            'name' => $gtld,
                            'iana_db_url' => "https://www.iana.org/domains/root/db/" . strtolower($gtld) . ".html",
                            'github_edit_url' => "https://github.com/returnearly/gtld.fyi/blob/master/source/_layouts/gtld.blade.php",
                        ];
                    });
            }
        ],
    ],
];
