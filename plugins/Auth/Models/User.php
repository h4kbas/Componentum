<?php
return 
[
    'email' => [
        'unique' => true,
        'required' => true,
        'type' => 'Text',
        'title' => '@user/email'
    ],
    'username' => [
        'unique' => true,
        'required' => true,
        'type' => 'Text',
        'title' => '@user/username'
    ],
    'password' => [
        'required' => true,
        'type' => 'Password',
        'title' => '@user/password'
    ],
    'name' => [
        'required' => true,
        'type' => 'Text',
        'title' => '@user/name'
    ],
    'surname' => [
        'required' => true,
        'type' => 'Text',
        'title' => '@user/surname'
    ]
];