<?php

namespace App\Admin\Controllers;

use App\Models\FinancialPeriod;
use App\Models\StockCategory;
use App\Models\StockItem;
use App\Models\StockSubCategory;
use App\Models\User;
use App\Models\Utils;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class StockItemController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Stock Items';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        
        // $item = StockItem::find(3);
        // $stock_sub_category = StockSubCategory::find($item->stock_sub_category_id);
        // $stock_sub_category->update_self();

        // die('done');


        $grid = new Grid(new StockItem());


        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('name','Name');

            $u = Admin::user();
            $filter->equal('stock_sub_category_id','Stock Sub Category')
            ->select(StockSubCategory::where([
                'company_id'=> $u->company_id

            ])->pluck('name','id'));

            $filter->equal('financial_period_id','Financial Period')
            ->select(FinancialPeriod::where([
                'company_id'=> $u->company_id

            ])->pluck('name','id'));


            $filter->like('sku','SKU');

        });




        $grid->disableBatchActions();
        $grid->quickSearch('name')->placeholder("Search by name..");
        $u = Admin::user();

        $grid->model()->where('company_id',$u->company_id);

        $grid->column('id', __('Id'))->sortable();
       
        
        
        $grid->column('image', __('Image'))->image('',70,70);


        $grid->column('name', __('Item Name'))->sortable();
        

        $grid->column('stock_category_id', __('Stock category'))
        ->display(function ($stock_category_id){
            $stock_category = StockCategory::find($stock_category_id);
            if($stock_category) {
                return $stock_category->name; 
            } else{
                return 'N/A'; 
            }
        })
        ->hide() 
        ->sortable();


        $grid->column('stock_sub_category_id', __('Stock Subcategory'))
        ->display(function ($stock_sub_category_id){
          $stock_sub_category = StockSubCategory::find($stock_sub_category_id);
          if($stock_sub_category){
            return $stock_sub_category->name_text;

          }else{
            return 'N/A';
          }
        })->sortable();
        



        $grid->column('financial_period_id', __('Financial Period'))
        ->display(function($financial_period_id){
            $financial_period = FinancialPeriod::find($financial_period_id);
            if($financial_period){
                return $financial_period->name;

            }else{
                return "N/A";
            }
        })->hide();
       
        $grid->column('description', __('Description'))->hide();
       
        $grid->column('barcode', __('Barcode'))->sortable();
        $grid->column('sku', __('Sku'))->sortable();
        
        $grid->column('buying_price', __('Buying price'))->sortable();
        $grid->column('selling_price', __('Selling price'))->sortable();
        $grid->column('original_quantity', __('Original quantity'))->sortable() ;
        $grid->column('current_quantity', __('Current quantity'))->sortable();


        $grid->column('created_by_id', __('Created by id'))
        ->display(function ($created_by_id){
            $user = User::find($created_by_id);
            if($user){
                return $user->name;
            } else{
                return 'N/A'; 
            }
            
        })->sortable();



        $grid->column('created_at', __('Registered'))
       
        ->display(function ($created_at){
            return date('Y-m-d',strtotime($created_at));
        })->sortable();
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(StockItem::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('company_id', __('Company id'));
        $show->field('created_by_id', __('Created by id'));
        $show->field('stock_category_id', __('Stock category id'));
        $show->field('stock_sub_category_id', __('Stock sub category id'));
        $show->field('financial_period_id', __('Financial period id'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('image', __('Image'));
        $show->field('barcode', __('Barcode'));
        $show->field('sku', __('Sku'));
        $show->field('generate_sku', __('Generate sku'));
        $show->field('update_sku', __('Update sku'));
        $show->field('gallery', __('Gallery'));
        $show->field('buying_price', __('Buying price'));
        $show->field('selling_price', __('Selling price'));
        $show->field('original_quantity', __('Original quantity'));
        $show->field('current_quantity', __('Current quantity'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {   
        $u = Admin::user();
        $financial_period = Utils::getActiveFinancialPeriod($u->company_id);
        
        if($financial_period==null){
            return admin_error('Please Enter a finacial Period');
        }


        $form = new Form(new StockItem());
       


        $form->hidden('company_id', __('Company id'))->default($u->company_id);

        if($form->isCreating()){
            $form->hidden('created_by_id', __('Created by id'))->default($u->id);
        }
        
        //ajax
        $sub_cat_ajax_url = url('api/stock-sub-categories');
        $sub_cat_ajax_url = $sub_cat_ajax_url . '?company_id='. $u->company_id;
        $form->select('stock_sub_category_id', __('Stock Category'))
        ->ajax($sub_cat_ajax_url)
        ->options(function($id){
            $sub_cat = StockSubCategory::find($id);
            if($sub_cat){
                return [
                    $sub_cat->id => $sub_cat->name_text . "(" . $sub_cat->measurement_unit  . ")"];
                
            }else{
                return [];
            }
        })->rules('required');
        

        
        $form->text('name', __('Name'))->rules('required');
        $form->image('image', __('Image'))
        ->uniqueName();

     


      
        
       
        
        
        if($form->isEditing()){

        $form->radio('update_sku', __('Update sku'))
        ->options(
            [
                'Yes'=>'Yes',
                'No'=>'No',
            ]
        )->when('Yes',function(Form $form){
            $form->text('sku',_('ENTER SKU (Batch Number)'))->rules('required');
        })->rules('required');

        }else{
            $form->radio('generate_sku', __('Generate SKU (Batch Number)'))
            ->options(
                [
                    'Manual' => 'Manual',
                    'Auto' => 'Auto',
    
                ]
            )->when('Manual',function(Form $form){
                $form->text('sku',_('ENTER SKU (Batch Number)'))->rules('required');
            })->rules('required');
        }

        




        $form->multipleImage('gallery', __('Gallery'))
        ->removable()
        ->downloadable()
        ->sortable()
        ->uniqueName();
        $form->decimal('buying_price', __('Buying price'))
        ->default(0.00)
        ->rules('required');
        $form->decimal('selling_price', __('Selling price'))
        ->default(0.00)
        ->rules('required');
        $form->decimal('original_quantity', __('Original quantity (in units)'))
        ->default(0.00)
        ->rules('required');

        $form->text('description', __('Description'));
        //$form->textarea('barcode', __('Barcode'));
        return $form;
    }
}
