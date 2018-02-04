<?php

return [
    'is' => 'Category',
    'map' => [
        'Olustur' => 'Create',
        'Guncelle' => 'Update'
    ],
    'use' => [
        'user' => 'Kullanici'
    ],
    'filter' => [
        'Auth/User' =>  ['Update']
    ]
];