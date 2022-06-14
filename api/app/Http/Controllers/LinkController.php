<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\LinkService;
use Illuminate\Support\Facades\Validator;

class LinkController extends BaseController
{
    private $linkService;

    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    public function index(): JsonResponse
    {
        try {
            /////////////// Get all data from index method in URL service//////////
			$getAllUrls = $this->linkService->index();

            if($getAllUrls['status']){
                return $this->successResponse($getAllUrls['data'], $getAllUrls['message'], Response::HTTP_CREATED);
            }
            else{
                return $this->errorRessponse($getAllUrls['message'], '', Response::HTTP_CREATED);
            }
		}
		catch (\Exception $exception) {
            return $this->errorRessponse('Something wrong! Please try again', '', Response::HTTP_CREATED);
		}
    }


    public function store(Request $request): JsonResponse
    {
		try {
            /////////////// Unique URL Validation /////////////
			$validator = Validator::make($request->all(), [
				  'inputUrl' => 'required|unique:links|max:255',
			  ]);

			  if ($validator->fails()) {
				return response()->json('URL already exist, Please try another one');
			  }

           /////////////// Send Request data to Link Service /////////////
            $data = $request->all();
            $result = $this->linkService->create($data);

			if ($result['status'] == true) {
            	return $this->successResponse($result['data'], $result['message'], Response::HTTP_CREATED);
			}
			else{
				return $this->errorRessponse($result['message'], '', Response::HTTP_CREATED);
			}

        } catch (\Exception $exception) {
            return $this->errorRessponse('Something wrong! Please try again', '', Response::HTTP_CREATED);
        }
    }

    public function getHashUrl($hashkey)
    {
		 try {
             ///////////////Gel Hash URL data from getHashUrl method in URL service/////////////
			$result = $this->linkService->getHashUrl($hashkey);

			if ($result['status'] == true) {
                 /////////////// Redirect actual url to short url/////////////
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
