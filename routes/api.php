<?php

use App\Models\StockItem;
use App\Models\StockSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//route api for stock-items
Route::get('/stock-items',function(Request $request){
    $q = $request->get('q');
    
    $company_id = $request->get('company_id');
    if($company_id==null){
        return response()->json(
            [
                'data'=>[],
            ], 400);
    }

    $sub_categories = StockItem::where('company_id', $company_id)
    ->where('name','like',"%$q%")
    ->orderBy('name','asc')
    ->limit(20)
    ->get();

    $data = []; 

    foreach($sub_categories as $sub_category){
        
        $data[] = [
            'id' => $sub_category->id,
            'text'=>$sub_category->sku." ".$sub_category->name_text,
        ];
    }
   

    return response()->json([
        'data'=> $data,
    ]);
});


// route api for stock-categories

Route::get('/stock-sub-categories',function(Request $request){
    $q = $request->get('q');
    
    $company_id = $request->get('company_id');
    if($company_id==null){
        return response()->json(
            [
                'data'=>[],
            ], 400);
    }

    $sub_categories = StockSubCategory::where('company_id', $company_id)
    ->where('name','like',"%$q%")
    ->orderBy('name','asc')
    ->limit(20)
    ->get();

    $data = []; 

    foreach($sub_categories as $sub_category){
        
        $data[] = [
            'id' => $sub_category->id,
            'text'=>$sub_category->name_text . "(".$sub_category->measurement_unit .")",
        ];
    }
   

    return response()->json([
        'data'=> $data,
    ]);
});