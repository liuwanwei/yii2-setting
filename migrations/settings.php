<?php

return [
    // 全局配置
    'setting' => [
        // 配置每个界面的参数
        'views' => [
            'index' => [
                'title' => '参数配置',
                'showTitle' => false,
                'showCreateButton' => true,
            ]
        ],
    ],

    [
        'name' => '演示 in validator',
        'key' => 'grade_sz_share_limit',
        'value' => '3',
        'weight' => '0',
        'description' => '配置项的值必须从现有值选择',
        'options' => [
            'validator' => 'in',
            'params' => [
                'range' => ['1', '2', '3']
            ]
        ],
    ],
    [
        'name' => '演示 integer validator',
        'key' => 'kclass_zy_earning',
        'value' => '20',
        'weight' => '5',
        'description' => '配置项的值必须是整数',
        'options' => [
            'validator' => 'integer',
        ],
    ],
    [
        'name' => '演示 re validator',
        'key' => 'charge_rate',
        'value' => '0.03',
        'weight' => '70',
        'description' => '配置项必须符合 0.03 这样的格式',
        'options' => [
            'validator' => 'match',
            'params' => [
                'pattern' => '/^0\.[0-9]{2}$/'
            ],
        ]
    ],
    [
        'name' => '演示 string vaidator',
        'key' => 'safty_code',
        'value' => '1801379',
        'weight' => '200',
        'description' => '配置项最短长度为 1',
        'options' => [
            'validator' => 'string',
            'params' => [
                'min' => 1,
            ]
        ]
    ],
    
];

?>