<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    public array $aliases = [
    'csrf'          => \CodeIgniter\Filters\CSRF::class,
    'toolbar'       => \CodeIgniter\Filters\DebugToolbar::class,
    'honeypot'      => \CodeIgniter\Filters\Honeypot::class,
    'invalidchars'  => \CodeIgniter\Filters\InvalidChars::class,
    'secureheaders' => \CodeIgniter\Filters\SecureHeaders::class,
    'cors'          => \CodeIgniter\Filters\Cors::class,
    'forcehttps'    => \CodeIgniter\Filters\ForceHTTPS::class,
    'pagecache'     => \CodeIgniter\Filters\PageCache::class,
    'performance'   => \CodeIgniter\Filters\PerformanceMetrics::class,
    'auth'          => \App\Filters\Auth::class,
    'apiauth'       => \App\Filters\ApiAuthFilter::class, // ✅ tambahkan ini
    ];

    public array $required = [
        'before' => [
            // 'forcehttps',
            'pagecache',
        ],
        'after' => [
            'pagecache',
            'performance',
            'toolbar',
        ],
    ];

    // ✅ KOSONGKAN globals — jangan taruh cors di sini
    public array $globals = [
        'before' => [],
        'after'  => [],
    ];

    public array $methods = [];

    // ✅ Pasang cors hanya untuk route post/*
    public array $filters = [
    'auth' => ['before' => ['admin', 'admin/*']],
    'cors' => [
        'before' => ['post', 'post/*', 'api/*'],
        'after'  => ['post', 'post/*', 'api/*'],
    ],
    ];
}