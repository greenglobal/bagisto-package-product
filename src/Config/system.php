<?php
    return [
        [
            'key'    => 'catalog.products.general',
            'name'   => 'ggphp::product.admin.system.general',
            'sort'   => 1,
            'fields' => [
                [
                    'name'    => 'show-parent-product-only',
                    'title'   => 'ggphp::product.admin.system.show-parent-product-only',
                    'type'    => 'boolean',
                ],
                [
                    'name'    => 'list-product-type',
                    'title'   => 'ggphp::product.admin.system.product-type',
                    'type'    => 'multiselect',
                    'options' => [
                        [
                            'title' => 'ggphp::product.admin.system.booking.title',
                            'value' => 'booking'
                        ],
                        [
                            'title' => 'ggphp::product.admin.system.simple.title',
                            'value' => 'simple'
                        ],
                        [
                            'title' => 'ggphp::product.admin.system.configurable.title',
                            'value' => 'configurable'
                        ],
                        [
                            'title' => 'ggphp::product.admin.system.downloadable.title',
                            'value' => 'downloadable'
                        ],
                        [
                            'title' => 'ggphp::product.admin.system.bundle.title',
                            'value' => 'bundle'
                        ],
                        [
                            'title' => 'ggphp::product.admin.system.virtual.title',
                            'value' => 'virtual',
                        ],
                        [
                            'title' => 'ggphp::product.admin.system.grouped.title',
                            'value' => 'grouped'
                        ]
                    ]
                ]
            ],
        ]
    ];
