<?php
define('ACCESS_TOKEN_SOCIAL', 'accessTokenSocial');

return [
    //phân quyền người dùng
    'role' => [
        'admin' => 'admin',
        'lecture' => 'lecture',
        'company' => 'company',
        'student' => 'student',
        'social' => 'social'
    ],

    //login social
    'provider' => [
        'facebook' => 'facebook',
    ],

    'groupID' => '756558567743997',
];
