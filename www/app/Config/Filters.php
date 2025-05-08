<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
    public array $aliases = [
        'csrf'     => \CodeIgniter\Filters\CSRF::class,
        'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
        'session'  => \App\Filters\SessionFilter::class,
    ];

    public array $globals = [
        'before' => [],
        'after'  => ['toolbar'],
    ];

    public array $methods = [];

    public array $filters = [];
}