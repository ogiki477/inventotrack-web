<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockCategory extends Model
{
    use HasFactory;
    public function update_self()
    {   
        $active__financial_period = Utils::getActiveFinancialPeriod($this->company_id);
        if($active__financial_period==null){
            return;
        }
        $total_buying_price = 0;
        $total_selling_price = 0;

        $stock_items = StockItem::where('stock_category_id',$this->id)
        ->where('financial_period_id',$active__financial_period->id)
        ->get();
        foreach($stock_items as $key => $value){
            $total_buying_price += ($value->buying_price * $value->original_quantity);
            $total_selling_price += ($value->selling_price * $value->original_quantity);
        }
        
        $total_expected_profit = $total_selling_price - $total_buying_price;


        //


        $this->earned_profit = StockRecord::where('stock_sub_category_id',$this->id)
        ->where('financial_period_id',$active__financial_period->id)
        ->sum('profit');


        $this->buying_price = $total_buying_price;
        $this->selling_price = $total_selling_price;
        $this->expected_profit = $total_expected_profit;
        $this->save();
        
     
    }

    /*  
    
    
   
    
    "earned_profit" => 0
    
    */
}
