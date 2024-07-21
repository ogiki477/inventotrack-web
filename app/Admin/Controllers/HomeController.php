<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\StockRecord;
use App\Models\User;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        $u = Admin::user();
        $company = Company::find($u->company_id);
        return $content 
            ->title($company->name." -- Dashboard")
            ->description('Hello  '. $u->name)
        
            ->row(function (Row $row) {

                $row->column(3, function (Column $column) {
                    
                    $count = User::where('company_id', Admin::user()->company_id)->count();

                    $box = new Box('Employees', '<h4 style="text-align:right; margin: 0; font-size: 40px; font-weight: 800">'.$count.'</h4>');
                    //$box->collapsable();
                    //$box->removable();
                    $box->style('success');
                    $box->solid();
                    $column->append($box);

                    

                    

                });


                $row->column(3, function (Column $column) {
                    $total_sales = StockRecord::where('company_id', Admin::user()->company_id)->sum('total_sales');
                    $u = Admin::user();
                    $company = Company::find($u->company_id);
                    $box = new Box("Today's Sales", '<h4 style="text-align:right; margin: 0; font-size: 40px; font-weight: 800">'
                    .$company->currency." ".number_format($total_sales).'</h4>');
                    //$box->collapsable();
                    //$box->removable();
                    $box->style('success');
                    $box->solid();
                    $column->append($box);
                });


              

                $row->column(3, function (Column $column) {
                    $total_sales = StockRecord::where('company_id', Admin::user()->company_id)->sum('total_sales');
                    $total_sales = $total_sales * 7;
                    $u = Admin::user();
                    $company = Company::find($u->company_id);
                    $box = new Box("This Week's Sales", '<h4 style="text-align:right; margin: 0; font-size: 40px; font-weight: 800">'
                    .$company->currency." ".number_format($total_sales).'</h4>');
                    //$box->collapsable();
                    //$box->removable();
                    $box->style('success');
                    $box->solid();
                    $column->append($box);
                });

                $row->column(3, function (Column $column) {
                    $total_sales = StockRecord::where('company_id', Admin::user()->company_id)->sum('total_sales');
                    $total_sales = $total_sales * 30;
                    $u = Admin::user();
                    $company = Company::find($u->company_id);
                    $box = new Box("This Month's Sales", '<h4 style="text-align:right; margin: 0; font-size: 40px; font-weight: 800">'
                    .$company->currency." ".number_format($total_sales).'</h4>');
                    //$box->collapsable();
                    //$box->removable();
                    $box->style('success');
                    $box->solid();
                    $column->append($box);
                });

                //In-stock 
                $row->column(3, function (Column $column) {
                    $total_stock = StockRecord::where('company_id', Admin::user()->company_id)->sum('quantity');
                    $u = Admin::user();
                    $company = Company::find($u->company_id);
                    $box = new Box("In-stock", '<h4 style="text-align:right; margin: 0; font-size: 40px; font-weight: 800">'
                    ."Items ".number_format($total_stock).'</h4>');
                    //$box->collapsable();
                    //$box->removable();
                    $box->style('success');
                    $box->solid();
                    $column->append($box);
                });


                

            });
    }
}
