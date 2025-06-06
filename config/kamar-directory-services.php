<?php

return [

    'username' =>  env('KAMAR_DS_USERNAME'),
    'password' => env('KAMAR_DS_PASSWORD'),
    'encryptionKey' => env('KAMAR_ENCRYPTION_KEY', 'My Kamar directory service encryption key, if applicable'),
    'encryptionAlgorithm' => env('KAMAR_ENCRYPTION_ALGORITHM', 'aes-128-ecb'),

    'storageDisk' => env('KAMAR_DS_STORAGE_DISK', 'local'),
    'storageFolder' => env('KAMAR_DS_STORAGE_FOLDER', 'data'),

    'format' => env('KAMAR_DS_FORMAT'),

    'serviceName' => 'Kamar Directory Service',
    'serviceVersion' => "1.0.1",
    'countryDataStored' => 'New Zealand',

    'authSuffix' => env('KAMAR_DS_AUTH_SUFFIX'),

    'infoUrl' => 'https://www.myschool.co.nz/more-info',
    'privacyStatement' => 'Change this to a valid privacy statement | All your data belongs to us and will be kept in a top secret vault.',

    'options' => [

        "ics" => false,

        "students" => [
            "details" => true,
            "passwords" => true,
            "photos" => false,
            "groups" => false,
            "awards" => false,
            "timetables" => true,
            "attendance" => true,
            "assessments" => true,
            "pastoral" => true,
            "learningsupport" => false,
            "fields" => [
                "required" =>  "uniqueid;firstname;lastname;username;password",
                "optional" => "schoolindex;nsn;yearlevel;leavingdate;tutor;house;ethnicityL1;ethnicityL2;ethnicity,gender"
            ]
        ],

        "staff" => [
            "details" => true,
            "passwords" => false,
            "photos" => false,
            "timetables" => true,
            "fields" => [
                "required" =>  "uniqueid;firstname;lastname;username",
                "optional" => "schoolindex;title;classification;tutor;leavingdate"
            ]
        ],

        "common" => [
            "subjects" => false,
            "notices" => false,
            "calendar" => false,
            "bookings" => false
        ]
    ],

    'vivi' => [
        'apiKey' => env('VIVI_API_KEY'),
        'emergencyTypeId' => env('VIVI_EMERGENCY_TYPE_ID'),
    ]
];
