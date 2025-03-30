<?php

return [
    'service_account' => [
        'file_path' => storage_path('storage/app/firebase/firebase-service-account.json'),
        'project_id' => env('FIREBASE_PROJECT_ID'),
    ],
];