<?php
namespace App\Services;

use App\Models\Url;
use App\Config\GoogleApi;


class UrlService
{
    /**
     * @param $inputs
     * @return mixed
     */
	 
	 public $curl;
	
	  
	public function __construct(GoogleApi $curl)
    {
        $this->curl = $curl;
    }
	 
	 
	 public function index()
     {		
        try {
			$getAllUrls = Url::latest()->get();  ////////////////////// Gel all URL list from URL Table
			return $getAllUrls;
        } 
		catch (\Exception $exception) {
            \Helper::handleException($exception);
            return ['status' => false, 'message' => 'Something went wrong'];
        }
    }
	
	
    public function create($inputs)
    {
        try {
			$response = $this->curl->send('POST','banner/store', '', $inputs,'insert');
            $shortHashUrl = $this->generateShortUrl();
			$baseUrl = url('');
	
			$dataMerchant = Url::create([
				'inputUrl' => $request->inputUrl,
				'hashKey' => $shortHashUrl,
				'baseUrl' => $baseUrl
			]);
			
			if($dataMerchant){
				$response = $this->curl->send($request->inputUrl);
				$dataMerchant['safeBrowsingApi'] = $response;
				$data = array('status' => true, 'message' => 'Successfully Added', 'data' => $dataMerchant);
				return $data;
			}
			else{			
				$data = array('status' => false, 'message' => 'Insert failed');
				return $data;
			}
			
		
        } catch (\Exception $exception) {
            \Helper::handleException($exception);
            return ['status' => false, 'message' => 'Something went wrong'];
        }
    }
	
	
	 public function getHashUrl($hashkey)
     {		
        try {
			$checkUrlExist = Url::where('hashKey', $hashkey)->first();  ////////////////////// Gel Hash URL from URL Table
			if($checkUrlExist!=""){				
				$data = array('status' => true, 'message' => 'Valid URL', 'data' => $checkUrlExist->inputUrl);
				return $data;
			}
			else{			
				$data = array('status' => false, 'message' => 'Wrong URL');
				return $data;
			}
        } 
		catch (\Exception $exception) {
            \Helper::handleException($exception);
            return ['status' => false, 'message' => 'Something went wrong'];
        }
    }
	
	
	//////////////// Hash Url Making /////////////////////
	private function generateShortUrl($length){
        $hashKey = "";
        $alphabetNumeric = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        //$codeAlphabet.= "0123456789";
	   mt_srand(time());

        for($i=0;$i<6;$i++){
            $hashKey .= $alphabetNumeric[mt_rand(0,strlen($alphabetNumeric)-1)];
        }
		
		$shortUrl = $hashKey . substr(strftime("%M", time()),2);
        return $shortUrl;
    }

}
