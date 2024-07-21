<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utils 
{


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


    public static function error($data, $message){
       
       header('Content-Type: application/json');
       http_response_code(400);
       echo json_encode([
           'status' => 'error',
           'message' => $message,
           'data' => $data,
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