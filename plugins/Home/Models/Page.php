<?php
return 
[
    'title' => [
        'required' => true,
        'type' => 'Text',
        'title' => '@page/title'
    ],
    'slug' => [
        'required' => true,
        'type' => 'Text',
        'title' => '@page/slug'
    ],
    'content' => [
        'required' => true,
        'type' => 'Textarea',
        'title' => '@page/content'
    ],

];