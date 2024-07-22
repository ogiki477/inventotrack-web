<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Utils;
use Dflydev\DotAccessData\Util;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ApiController extends BaseController
{

    public function file_uploading(Request $r){
     $path = Utils::file_upload($r->file('photo'));
     if($path==""){
          Utils::error('File not uploaded');
      }
      Utils::success($path, 'File uploaded successfully');
      
    }




    public function manifest(Request $r){
        $u = Utils::get_user($r);
        if($u==null){
            Utils::error('Unauthenticated');
        }
        $roles = DB::table('admin_role_users')->where('user_id',$u->id)->get();
        $data = [
            'user'=>$u,
            'roles'=>$roles,
            'company'=>$u->company,
            'description'=>'Inventory Management System',
            'version'=>'1.0.0',
            'author'=>'Ogiki Moses Odera',
            'email'=>'omo88moses@gmail.com',
        ];
        Utils::success($data, 'Manifest fetched successfully');



      
}





    public function my_list(Request $r,$model){

        $u = Utils::get_user($r);
        if($u==null){
            Utils::error('Unauthenticated');
        }
       
        $model = "App\Models\\".$model;
        $data = $model::where('company_id',$u->company_id)->limit(10000)->get();
        Utils::success($data, 'Data fetched successfully');

      
}



    public function my_update(Request $r,$model){

        $u = Utils::get_user($r);
        if($u==null){
            Utils::error('Unauthenticated');
        }
       
        $model = "App\Models\\".$model;

        $object = $model::find($r->id);
        $isEdit = true;
        if($object==null){
            $object = new $model();
            $isEdit = false;
        }

       

        $table_name = $object->getTable();
        $columns = Schema::getColumnListing($table_name);
        $except = ['id','created_at','updated_at'];
        $data = $r->all();

        foreach($data as $key=>$value){
            if(!in_array($key,$columns)){
                continue;
            }
            if(in_array($key,$except)){
                continue;
            }
            $object->$key = $value; 
        }

        $object->company_id = $u->company_id;

        //temp_file_field
        if($r->temp_file_field!=null){
            if(strlen($r->temp_file_field)>1){
                $file = $r->file('photo');
                if($file != null){
                    $path = "";
                    try{
                        $path = Utils::file_upload($r->file('photo'));
                    }catch(\Exception $e){
                        $path = "";
                       
                    }
                    if(strlen($path)>3){
                        $field_name = $r->temp_file_field;
                        $object->$field_name = $path;
                    }
                    
                }
                
            }
        }
 
        try{
            $object->save();
        }catch(\Exception $e){
            Utils::error($e->getMessage());
        }

        $new_object = $model::find($object->id);
        if($isEdit){
            Utils::success($new_object, 'Updated successfully');
        }else{  

        Utils::success($new_object, 'Created successfully');
    }
}


    //register function

   public function register(Request $r){

    if($r->first_name==null){
        Utils::error('First name is required');
    }

    if($r->last_name==null){
        Utils::error('Last name is required');
    }

    if($r->email==null){
        Utils::error('Email is required');
    }

    //if email is valid
    if(!filter_var($r->email, FILTER_VALIDATE_EMAIL)){
        Utils::error('Email is invalid');
    }

    
    //if email is already registered 
    $u = User::where('email',$r->email)->first();
    if($u!=null){
        Utils::error('Email is already registered');
    }

    //if password is provided
    if($r->password==null){
        Utils::error('Password is required');
    }

    //check if comapny name is provided
    if($r->company_name==null){
        Utils::error('Company name is required');
    }

    //check if company currency is provided
    if($r->company_currency==null){
        Utils::error('Company currency is required');
    }

    $new_user = new User();
    $new_user->first_name = $r->first_name;
    $new_user->last_name = $r->last_name;
    $new_user->username = $r->email;
    $new_user->email = $r->email;
    $new_user->password = password_hash($r->password,PASSWORD_DEFAULT);
    $new_user->name = $r->first_name . " " . $r->last_name;
    //phone number
    $new_user->phone_number1 = $r->phone_number1;
    //status 
    $new_user->status = 'Active';

     try{
        $new_user->save();

    }catch(\Exception $e){
        Utils::error($e->getMessage());
    }

    $registered_user= User::find($new_user->id);
    if($registered_user==null){
        Utils::error('Failed to register user');
    }

    //Utils::success($registered_user, 'User registered successfully');

    

    //creating a company 

    $new_company = new Company();
    $new_company->owner_id = $registered_user->id;
    $new_company->name = $r->company_name;
    $new_company->email = $r->email;
    $new_company->currency = $r->company_currency;
    $new_company->status = 'Active';
    $new_company->license_expiry = date('Y-m-d', strtotime('+1 year'));
    $new_company->phone_number1 = $r->phone_number1;

    try{
        $new_company->save();
    }catch(\Exception $e){
        Utils::error($e->getMessage());
    }

    $registered_company = Company::find($new_company->id);
    if($registered_company==null){
        Utils::error('Failed to register company');
    }

    //insert into admin_users
    DB::table('admin_role_users')->insert([
        'user_id'=>$registered_user->id,
        'role_id'=> 2,
        
    ]);

    Utils::success([
        'user'=>$registered_user,
        'company'=>$registered_company,
    ], 'User and company registered successfully'); 


    die('success'); 
    
    /*
    user information
    


dob	
status	
email
    
    */


    //company information

    /*
    


 */

    Utils::error([], 'Something went wrong');
       
   }

    //login function

    public function login(Request $r){
     if($r->email==null){
          Utils::error('Email is required');
     }

     if(!filter_var($r->email, FILTER_VALIDATE_EMAIL)){
        Utils::error('Email is invalid');
    }

    
     if($r->password==null){
          Utils::error('Password is required');
     }
    
     $u = User::where('email',$r->email)->first();
     if($u==null){
          Utils::error('Account not found');
     }
    
     if(!password_verify($r->password, $u->password)){
          Utils::error('Invalid password');
     }

     $company = Company::find($u->company_id);
        if($company==null){
            Utils::error('Company not found');
        }
    
     Utils::success(['user'=>$u,'company'=>$company], 'Login successful');
    }
}
