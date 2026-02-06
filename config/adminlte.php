<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default page title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/8.-Configuration-and-customization
    |
    */

    'title' => 'CBT v3',
    'title_prefix' => '',
    'title_postfix' => ' | CBT v3',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon option for the admin panel.
    | See config/adminlte.php for detailed instructions.
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts in your admin
    | panel. If set to true, fonts will be loaded from googleapis.com
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/8.-Configuration-and-customization
    |
    */

    'logo' => '<b>CBT</b>v3',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'CBT v3',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel User Image
    |--------------------------------------------------------------------------
    |
    | Here you can change the user image of your admin panel.
    |
    | For detailed instructions you can look the user image section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/8.-Configuration-and-customization
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/8.-Configuration-and-customization
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/8.-Configuration-and-customization
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin LTE Skins
    |--------------------------------------------------------------------------
    |
    | Here you can change the skin of the AdminLTE admin panel.
    |
    | For detailed instructions you can look the skins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/8.-Configuration-and-customization
    |
    */

    'skin' => 'blue',
    'dark_mode' => null,
    'dark_mode_icon' => 'fas fa-moon',
    'light_mode_icon' => 'fas fa-sun',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here you can change the sidebar/top navigation menu items by adding or
    | removing menu item objects.
    |
    | For detailed instructions you can look the menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/8.-Configuration-and-customization
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type' => 'navbar-search',
            'text' => 'search',
            'topnav_right' => true,
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        [
            'text' => 'Dasbor',
            'url' => '/admin',
            'icon' => 'fas fa-fw fa-home',
            'active' => ['admin'],
        ],
        [
            'text' => 'Manajemen',
            'icon' => 'fas fa-fw fa-folder',
            'submenu' => [
                [
                    'text' => 'Ujian',
                    'icon' => 'fas fa-fw fa-file',
                    'submenu' => [
                        [
                            'text' => 'Semua Ujian',
                            'url' => '/admin/exams',
                            'icon' => 'fas fa-fw fa-list',
                        ],
                        [
                            'text' => 'Buat Ujian',
                            'url' => '/admin/exams/create',
                            'icon' => 'fas fa-fw fa-plus',
                        ],
                    ],
                ],
                [
                    'text' => 'Pertanyaan',
                    'icon' => 'fas fa-fw fa-question',
                    'submenu' => [
                        [
                            'text' => 'Grup Pertanyaan',
                            'url' => '#',
                            'icon' => 'fas fa-fw fa-folder',
                        ],
                        [
                            'text' => 'Semua Pertanyaan',
                            'url' => '#',
                            'icon' => 'fas fa-fw fa-list',
                        ],
                    ],
                ],
            ],
        ],
        [
            'text' => 'Pengaturan',
            'icon' => 'fas fa-fw fa-cog',
            'submenu' => [
                [
                    'text' => 'Mobile Settings',
                    'url' => '#',
                    'icon' => 'fas fa-fw fa-mobile',
                ],
                [
                    'text' => 'Pengguna',
                    'url' => '#',
                    'icon' => 'fas fa-fw fa-users',
                ],
            ],
        ],
        [
            'text' => 'Laporan',
            'icon' => 'fas fa-fw fa-chart-bar',
            'submenu' => [
                [
                    'text' => 'Analitik',
                    'url' => '#',
                    'icon' => 'fas fa-fw fa-chart-line',
                ],
                [
                    'text' => 'Log Aktivitas',
                    'url' => '#',
                    'icon' => 'fas fa-fw fa-book',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/8.-Configuration-and-customization
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminlte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminlte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminlte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminlte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can change the status of the `adminlte` package plugins initialization
    | option. If set to true, the adminlte dependencies will be automatically
    | included. If set to false, the dependencies must be included manually.
    |
    */

    'plugins_init' => true,

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the status of the `adminlte` package iframe integration
    | option. If set to true, the iframe will be automatically integrated into
    | the master template. If set to false, set it to null.
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'new_tab' => true,
            'close_tab' => true,
            'close_all_tabs' => true,
            'close_all_other_tabs' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'auto_show_first_created_tab' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    */

    'livewire' => false,
];
