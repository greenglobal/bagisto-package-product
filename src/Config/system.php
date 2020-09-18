<?php
    return [
        [
            'key'    => 'catalog.products.general',
            'name'   => 'gg-php::app.admin.system.general',
            'sort'   => 1,
            'fields' => [
                [
                    'name'    => 'show-parent-product-only',
                    'title'   => 'gg-php::app.admin.system.show-parent-product-only',
                    'type'    => 'boolean',
                ],
                [
                    'name'    => 'list-product-type',
                    'title'   => 'gg-php::app.admin.system.product-type',
                    'type'    => 'multiselect',
                    'options' => [
                        [
                            'title' => 'gg-php::app.admin.system.booking.title',
                            'value' => 'booking'
                        ],
                        [
                            'title' => 'gg-php::app.admin.system.simple.title',
                            'value' => 'simple'
                        ],
                        [
                            'title' => 'gg-php::app.admin.system.configurable.title',
                            'value' => 'configurable'
                        ],
                        [
                            'title' => 'gg-php::app.admin.system.downloadable.title',
                            'value' => 'downloadable'
                        ],
                        [
                            'title' => 'gg-php::app.admin.system.bundle.title',
                            'value' => 'bundle'
                        ],
                        [
                            'title' => 'gg-php::app.admin.system.virtual.title',
                            'value' => 'virtual',
                        ],
                        [
                            'title' => 'gg-php::app.admin.system.grouped.title',
                            'value' => 'grouped'
                        ]
                    ]
                ]
            ],
        ]
    ];
