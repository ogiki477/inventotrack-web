<?php

namespace App\Http\Controllers;

use App\Models\Utils;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
   public function register(Request $request){

    //when creating 
    //user information
    //need comapany information 

    /* 
    
id	
username	
password	
name	
avatar	
remember_token	
created_at	
updated_at	
company_id	
first_name	
last_name	
phone_number 1	
phone_number 2	
address	
sex	
dob	
status	
email
    
    */

    Utils::error([], 'Something went wrong');
       
   }
}
