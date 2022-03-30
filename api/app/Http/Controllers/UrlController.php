<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Url;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Config\GoogleApi;


class UrlController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public $curl;

    public function __construct(GoogleApi $curl)
    {
        $this->curl = $curl;
    }

    public function index()
    {
        $shortLinks = Url::latest()->get();
        return $this->successResponse($shortLinks, 'Created Successfully', Response::HTTP_CREATED);
        //return csrf_token();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			  'url_userdefine' => 'required|unique:urls|max:255',
		  ]);

		  if ($validator->fails()) {
			return response()->json('URL Already Exist');
		  }

        $url_shortcode = $this->codeGeneration();
        $url_baseurl = url('');

        $dataMerchant = Url::create([
                'url_userdefine' => $request->url_userdefine,
				'url_shortcode' => $url_shortcode,
                'url_baseurl' => $url_baseurl
            ]);

        $response = $this->curl->send();
		return $this->successResponse($dataMerchant, 'Created Successfully', Response::HTTP_CREATED);
    }

    public function shortenLink($code)
    {
        $find = Url::where('url_shortcode', $code)->first();
        if($find!=""){
            return redirect($find->url_userdefine);
        }
        else{
            return abort(404);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



	public function codeGeneration()
    {
		$token = $this->getToken(6);
        $codes = $token . substr(strftime("%M", time()),2);
		return $codes;
    }

	private function getToken($length){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";

       // mt_srand($seed);      // Call once. Good since $application_id is unique.
	   mt_srand(time());

        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[mt_rand(0,strlen($codeAlphabet)-1)];
        }
        return $token;
    }
}
