<?php
define('ACCESS_TOKEN_SOCIAL', 'accessTokenSocial');
define('DATA_PRINT', 'dataPrint');

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

    'email' => '@student.hust.edu.vn',
    'count_student_default' => 10,

    'status_assign' => [
        'init' => 0,
        'start' => 1,
        'assign' => 2,
        'finish' => 3
    ],
];
