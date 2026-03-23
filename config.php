<?php

return [
    'baseUrl' => '',
    'production' => false,
    'siteName' => 'gTLD.fyi',
    'siteDescription' => 'Help applications fix their broken email validation.',

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
