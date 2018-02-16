<?php

return [
    'is' => 'Admin',

    'use' => [
        'homepage' => 'Home'
    ],
    'filter' => [
        'Admin/Admin' =>  [ ['except' => ['Login'] ],
            [
                'fallback' => '/Admin/Login'
            ]
        ]
    ]
];