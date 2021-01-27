<?php

return [
    'temporary_file_upload' => [
//        'rules' => 'file|mimes:dmg,exe|max:204800', // (200MB max, and only dmg, and exe.)
        'rules' => 'file|max:204800', // 200MB max
        'max_upload_time' => 5, // Max duration (in minutes) before an upload gets invalidated.
    ],
];

