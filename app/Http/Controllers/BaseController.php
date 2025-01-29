<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;

class BaseController extends Controller
{
    use AuthorizesRequests;
    public function handelResponse($response,$successRoute,$failureRoute =null,$successMessage=null,$failureMessage=null): RedirectResponse
    {
        $response = $response->getData();
        if($response->status){
            return to_route($successRoute)->with('success',$successMessage ?: $response->message);
        }
        return to_route($failureRoute ?: back())->withErrors($failureMessage ?: $response->message);
    }
}
