<?php

return [
    /*
    |--------------------------------------------------------------------------
    | My File Module Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration options for the My File module.
    |
    */

    // Maximum file size in MB (default: 10MB)
    'max_file_size' => 10,

    // Allowed file types
    'allowed_extensions' => [
        'images' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'],
        'documents' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt'],
        'videos' => ['mp4', 'mov', 'avi', 'wmv', 'flv'],
        'audio' => ['mp3', 'wav', 'ogg', 'aac'],
        'archives' => ['zip', 'rar', '7z', 'tar', 'gz'],
    ],

    // Media conversions settings
    'conversions' => [
        'thumb' => [
            'width' => 150,
            'height' => 150,
            'quality' => 90,
        ],
    ],
];