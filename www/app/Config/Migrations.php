<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Migrations extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Enable/Disable Migrations
     * --------------------------------------------------------------------------
     *
     * Migrations are enabled by default.
     *
     * You should enable migrations whenever you intend to do a schema migration
     * and disable it back when you're done.
     */
    public bool $enabled = true;
    public string $group = 'default';


    /**
     * --------------------------------------------------------------------------
     * Migrations Table
     * --------------------------------------------------------------------------
     *
     * This is the name of the table that will store the current migrations state.
     * When migrations runs it will store in a database table which migration
     * files have already been run.
     */
    public string $table = 'migrations';

    /**
     * --------------------------------------------------------------------------
     * Timestamp Format
     * --------------------------------------------------------------------------
     *
     * This is the format that will be used when creating new migrations
     * using the CLI command:
     *   > php spark make:migration
     *
     * NOTE: if you set an unsupported format, migration runner will not find
     *       your migration files.
     *
     * Supported formats:
     * - YmdHis_
     * - Y-m-d-His_
     * - Y_m_d_His_
     */
    public string $timestampFormat = 'Y-m-d-His_';

    /**
     * --------------------------------------------------------------------------
     * Migration Paths
     * --------------------------------------------------------------------------
     *
     * Array of paths to look for migrations.
     * You can add multiple paths if needed.
     */
    public array $paths = [];

    public array $groups = [
        'default' => [
            APPPATH . 'Database/Migrations',
            ROOTPATH . 'vendor/codeigniter4/settings/src/Database/Migrations',
            ROOTPATH . 'vendor/codeigniter4/shield/src/Database/Migrations',
        ],
    ];
}
