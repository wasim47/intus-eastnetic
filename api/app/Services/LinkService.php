<?php
namespace App\Services;

use App\Models\Url;
use App\Config\GoogleApi;
use App\Interfaces\LinkRepositoryInterface;


class LinkService
{

	public $curl;

    private LinkRepositoryInterface $linkRepository;


    public function __construct(LinkRepositoryInterface $linkRepository, GoogleApi $curl)
    {
        $this->linkRepository = $linkRepository;

        $this->curl = $curl;
    }

	 public function index()
     {
        try {
             ///////////// Gel all URL list from Link Table Using Repository //////////
            $getAllUrls = $this->linkRepository->getAllLinks();
            return ['status' => true, 'message' => 'Fetched Successfully', 'data' =>$getAllUrls];
        }
		catch (\Exception $exception) {
            return ['status' => false, 'message' => 'Something went wrong'];
        }
    }


    public function create($inputs)
    {
        try {
            $shortHashUrl = $this->generateShortUrl();
			$baseUrl = url('');

            $insertedData = array(
				'inputUrl' => $inputs['inputUrl'],
				'hashKey' => $shortHashUrl,
				'baseUrl' => $baseUrl
			);

            $checkInsertedData = $this->linkRepository->createLinks($insertedData);

			if($checkInsertedData){
				$response = $this->curl->send($inputs['inputUrl']);
				$insertedData['safeBrowsingApi'] = $response;
				$data = array('status' => true, 'message' => 'Successfully Added', 'data' => $insertedData);
				return $data;
			}
			else{
				$data = array('status' => false, 'message' => 'Insert failed');
				return $data;
			}

        } catch (\Exception $exception) {
            return ['status' => false, 'message' => 'Something went wrong'];
        }
    }


	 public function getHashUrl($hashkey)
     {
        try {
			////////////// Gel Hash URL from Link Table using repository////////
			$checkUrlExist = $this->linkRepository->getLinkByHashKey($hashkey);
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
            return ['status' => false, 'message' => 'Something went wrong'];
        }
    }


	//////////////// 6 digit Hash Url Making /////////////////////
	private function generateShortUrl(){
        $hashKey = "";
        $alphabetNumeric = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	   mt_srand(time());

        for($i=0;$i<6;$i++){
            $hashKey .= $alphabetNumeric[mt_rand(0,strlen($alphabetNumeric)-1)];
        }
		$shortUrl = $hashKey . substr(strftime("%M", time()),2);
        return $shortUrl;
    }

}
