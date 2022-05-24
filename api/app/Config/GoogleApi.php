<?php
namespace App\Config;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;


class GoogleApi
{
    public function send($url)
    {
        $baseurl = "https://safebrowsing.googleapis.com/v4/threatMatches:find?key=AIzaSyD1LcS1OdLLSEZJmBL5kQGxexR6BaqfPOE";
        $data = '{
                    "client": {
                        "clientId":      "eastnetic",
                        "clientVersion": "1.0"
                    },
                    "threatInfo": {
                        "threatTypes":      ["MALWARE", "SOCIAL_ENGINEERING"],
                        "platformTypes":    ["ANY_PLATFORM"],
                        "threatEntryTypes": ["URL"],
                        "threatEntries": [
                            {"url": "'.$url.'"},
                        ]
                    }
                }';

        $headers = array(
            "Content-Type: application/json",
            'Content-Length: '.strlen($data)
        );

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL, $baseurl);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_ENCODING, '');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

		$response = curl_exec ($ch);
        $err = curl_error($ch);
        curl_close ($ch);
        return json_decode($response);

    }
}
