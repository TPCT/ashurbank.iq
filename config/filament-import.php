<?php

return [
    'accepted_mimes' => [
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/csv',
        'text/plain',
        'csv',
        'txt',
    ],
    'temporary_files' => [
        'disk' => 'local',
        'directory' => 'public/filament-import',
    ],
];
