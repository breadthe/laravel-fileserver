<?php

return [
    'temporary_file_upload' => [
        'rules' => 'file|max:204800', // 200MB max
        'max_upload_time' => 5, // Max duration (in minutes) before an upload gets invalidated.
    ],
];

