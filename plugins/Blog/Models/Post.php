<?php

use Just\Util\Random;
return 
[
    'title' => [
        'required' => true,
        'type' => 'Text',
        'title' => '@post/title'
    ],
    'text' => [
        'required' => true,
        'type' => 'Textarea',
        'title' => '@post/text'
    ],
    'category_id' => [
        'required' => true,
        'type' => 'Select',
        'relation' => [
            'table' => 'category',
            'key'   => 'id'
        ],
        'resolve' => [
            'display' => 'title',
            'return' => 'id'
        ],
        'title' => '@post/category_id'
    ],
    'user_id' => [
        'protected' => true,
        'default' => ''
    ],
    'published' => [
        'type' => 'Checkbox',
        'title' => '@post/published'
    ],
    'image' => [
        'type' => 'File',
        'title' => '@post/image',
        'upload' => [
            'dir' => ROOT.'/public/images',
            'file_new_name_body' => Random::string(6),
            'allowed' => ['image/*'],
            //'forbidden' => ['image/jpeg']
        ]
    ]
];