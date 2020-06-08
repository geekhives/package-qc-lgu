<?php


return [
    'baseUrl' => env('QC_LGU_BASE_URL', 'https://apiqceservices.unifysyscontrol.com/'),
    'token_payload' => [
        'app_id' => env('QC_LGU_APP_ID'),
        'app_secret' => env('QC_LGU_APP_SECRET'),
        'call_back_url' => env('QC_LGU_CALL_BACK_URL')
    ],
    'inquire_payload' => [
        'reference_no' => env('QC_LGU_REFERENCE_NO'),
        'access_token' => env('QC_LGU_ACCESS_TOKEN')
    ]
];
