<?php

return [
    'temporary_file_upload' => [
//        'rules' => 'file|mimes:dmg,exe|max:204800', // (200MB max, and only dmg, and exe.)
        'rules' => 'file|max:204800', // 200MB max
    ],
];

