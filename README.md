<h1-Package Easytrip</h1-

## Install
- Add this to your composer.json file:
   
        "repositories": [{
            "type": "composer"
            "url": "https://repo.geekhives.com",         
        }],
    
        "require": {
            "geekhives/geekhives/package-qc-lgu": "^1.0",
        }
    
- Run Composer Install

- Publish Config Files `php artisan vendor:publish ->tag=package-qc-lgu`

- Done!

## Sample Usage
<h4> Default .env </h4>

    PACKAGE_QC_LGU_APP_ID=3371ac4e9cae9c0766cb5661d0132a3e.unifysyscontrol.com
    PACKAGE_QC_LGU_APP_SECRET=538cf04072e9d62ca3460083f81ef4190993309fdb7583573ef16ecad1068354
    PACKAGE_QC_LGU_CALL_BACK_URL=https://2e5027dfdfea.ngrok.io/api/token/callback
    PACKAGE_QC_LGU_ACCESS_TOKEN=4e44e41648cbf215aa9d55a1f00b667453fe8c69e65a21eaf0a15a0b318f8d31

<h4>Get Call Back Url:</h4>    

    $client = new \Geekhives\Qclgu\Services\Clients\GetCallBackUrl;
    $response = $client->post();

- Success
    {
        "message": "Successfully added."
    }

- Error
    - \Geekhives\Qclgu\Services\Clients\Exceptions\GetCallBackUrlException()
    - message format : "[$errorCode] $errorMessage"

<h4>Create Token:</h4>

    $client = new \Geekhives\Qclgu\Services\Clients\CreateToken;
    $response = $client->post();

- Error
    - \Geekhives\Qclgu\Services\Clients\Exceptions\CreateTokenException()
    - message format : "[$errorCode] $errorMessage"

- Error List
    - [B1] Error during request for token: All parameters are required.
    - [B2] Error during request for token: Invalid call_back_url.
    - [B3] Error during request for token: There is an existing active token for your app_id.
    - [B4] Error during request for token: Generate token is not successful.
    - [B5] Error during request for token: Your app_id, app_secret and call_back_url does not
 
<h4>Inquire:</h4>

    $accessToken = '974d7bd7731899dacccf567748fadfd6cfee9d74401dd95ed3ceffcd8957cc21';
    $client = new \Geekhives\Qclgu\Services\Clients\Inquire();
    $referenceNo = "A0-09CB8-00001";
    $response = $client->post($request->reference_no);

- Success
    {
        "reference_number": "A0-09CB8-00001",
        "status_code": "A0",
        "status_message": "Ongoing",
        "amount_to_pay": "3469.1"
    }

- Error

    - \Geekhives\Qclgu\Services\Clients\Exceptions\InquireException()
    - message format : "[$errorCode] $errorMessage"

    
- Error List
    - [C1] Error during inquiry: Invalid Reference No length.
    - [C2] Error during inquiry: Invalid 1st characters should be on ALPHABET FORMAT (A-Z).
    - [C3] Error during inquiry: 3rd and 9th character must be dash(-).
    - [C4] Error during inquiry: Invalid characters should be on ALPHA NUMERIC FORMAT (A-Z and 0-9).
    - [C5] Error during inquiry: Your reference number does not exists.
    - [C6] Error during inquiry: Expired access_token.
    - [C7] Error during inquiry: Invalid access_token.

<h4>Post:</h4>
        
    $accessToken = '974d7bd7731899dacccf567748fadfd6cfee9d74401dd95ed3ceffcd8957cc21';
    $client = new \Geekhives\Qclgu\Services\Clients\Post($accessToken);
    $referenceNo = "A0-09CB8-00001";
    $amountPaid = 3489.1;
    $transactionDate = '2020-03-25';
    $response = $client->post($referenceNo, amountPaid, transactionDate);

- Success
    {
        "reference_number": "A0-09CB8-00001",
        "status_code": "D0",
        "status_message": "Payment: Successful."
    }

- Error

    - \Geekhives\Qclgu\Services\Clients\Exceptions\PostException()
    - message format : "[$errorCode] $errorMessage"

    
- Error List
    - [D1] Error during payment: All parameters are required.
    - [D2] Error during payment: Invalid amount. 0 and negative values are not allowed.
    - [D3] Error during payment: Invalid date format. Date must be on [yyyy-mm-dd] format.
    - [D4] Error during payment: Invalid date.
    - [D5] Error during payment: Your Reference No. are already exists.
    - [D6] Error during payment: Your payment is not successful.
    - [D7] Error during payment: Your reference no. does not exists.
    - [D8] Error during payment: Expired access_token.
    - [D9] Error during payment: Invalid access_token.
