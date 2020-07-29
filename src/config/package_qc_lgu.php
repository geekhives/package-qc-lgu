<?php


return [
    'base_url' => env('PACKAGE_QC_LGU_BASE_URL', 'https://apiqceservices.unifysyscontrol.com/'),
    'token_payload' => [
        'app_id' => env('PACKAGE_QC_LGU_APP_ID'),
        'app_secret' => env('PACKAGE_QC_LGU_APP_SECRET'),
        'call_back_url' => env('PACKAGE_QC_LGU_CALL_BACK_URL')
    ]
];
