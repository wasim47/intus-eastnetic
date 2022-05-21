<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Config\GoogleApi;
use App\Services\UrlService;


class UrlController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    private $urlService;
	

    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }



    public function index()
    {
        try {
			$getAllUrls = $this->urlService->index();		 ////////////////////// Get all data from index method in URL service	
			return $this->successResponse($getAllUrls, 'Created Successfully', Response::HTTP_CREATED);
		} 
		catch (\Exception $exception) {			
			return redirect()->back()->with('message','Something wrong! Please try again');
		}
    }

   
    public function store(Request $request)
    {		
		try {
			$validator = Validator::make($request->all(), [
				  'inputUrl' => 'required|unique:urls|max:255',
			  ]);
	
			  if ($validator->fails()) {
				return response()->json('URL Already Exist');
			  }			  
			  
            $data = $request->all();
            $result = $this->urlService->create($data);
			if ($result['status'] == true) {
            	return $this->successResponse($result['data'], $result['message'], Response::HTTP_CREATED);
			}
			else{
				return $this->errorRessponse($result['message'], '', Response::HTTP_CREATED);
			}
			
        } catch (\Exception $exception) {
            return redirect()->back()->with('message','Something wrong! Please try again');
        }
    }

    public function getHashUrl($hashkey)
    {		
		
		 try {
			$result = $this->urlService->getHashUrl($hashkey);		 //////////////////////Gel Hash URL data from getHashUrl method in URL service	
			//dd($result);
			if ($result['status'] == true) {
            	return redirect($result['data']);
			}
			else{
				return $this->errorRessponse($result['message'], '', Response::HTTP_CREATED);
			}
		} 
		catch (\Exception $exception) {		
			return redirect()->back()->with('message','Something wrong! Please try again');
		}

    }	
}
