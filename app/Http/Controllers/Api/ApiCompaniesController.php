<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiCompaniesController extends Controller
{
    //
    public function getCompaniesTabular(){
        $companies=Company::orderBy('id','desc')->get();
        $data=[];
        foreach ($companies as $company){
            array_push($data,[
                'id'=>$company->id,
                'name'=>$company->name,
                'email'=>$company->email,
                'postcode'=>$company->postcode,
                'prefecture'=>$company->prefecture->display_name,
                'address'=>$company->street_address
            ]);
        }

        return response(json_encode($data));

    }
}
