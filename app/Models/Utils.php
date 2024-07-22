<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Utils 
{
    public static function file_upload($file){
        
        if($file==null){
            return "";
        }
        
        //get file extension
        $file_extension = $file->getClientOriginalExtension();
        $file_name = time()."_".rand(1000,10000).".".$file_extension;
        $file->move(public_path('uploads/images'),$file_name);
        $url = 'images/'.$file_name;
        return $url;
        

    }


    public static function get_user(Request $r){
        $logged_in_user_id = $r->header('logged_in_user_id');
        $u = User::find($logged_in_user_id);
        return $u;
    }


    public static function success($data, $message){
       
       header('Content-Type: application/json');
       http_response_code(200);
       echo json_encode([
           'status' => 'success',
           'message' => $message,
           'data' => $data,
       ]);
       die();
    } 


    public static function error($message){
       
       header('Content-Type: application/json');
       http_response_code(400);
       echo json_encode([
           'status' => 'error',
           'message' => $message,
           
       ]);
       die();
    }




    
    






    static function getActiveFinancialPeriod($company_id){

        return FinancialPeriod::where('company_id',$company_id)
               ->where('status','Active')->first();

}

     static public function generateSKU($sub_category_id){
        //year-subcategory-id-serial
        $year = date('Y');
        $sub_category = StockSubCategory::find($sub_category_id);
        $serial = StockItem::where('stock_sub_category_id',$sub_category_id)->count() + 1;
        $sku = $year . "-" . $sub_category_id . "-" . $serial;
        return $sku;

     }


}