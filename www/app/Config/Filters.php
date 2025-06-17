<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Shield\Filters\SessionAuth;
use CodeIgniter\Shield\Filters\GroupFilter;
use CodeIgniter\Shield\Filters\PermissionFilter;


class Filters extends BaseConfig
{
    public array $aliases = [
        'csrf'     => CSRF::class,
        'toolbar'  => DebugToolbar::class,
        'session'  => SessionAuth::class,
        'group'    => GroupFilter::class,
        'permission' => PermissionFilter::class,
    ];

    public array $globals = [
        'before' => [
        ],
        'after'  => [
            'toolbar',
        ],
    ];

    public array $methods = [];

    public array $filters = [
        'session' => [
            'before' => [
                'admin/*',   // Protege todas as rotas que começam com /admin/
                'dashboard', // Protege a rota do dashboard
            ],
        ],
    ];
}