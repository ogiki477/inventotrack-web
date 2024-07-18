<?php

namespace App\Admin\Controllers;

use App\Models\StockCategory;
use App\Models\StockSubCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class StockSubCategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Stock Sub Categories';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new StockSubCategory());
        $grid->disableBatchActions();
        $grid->quickSearch('name');
         
        $u = Admin::user();
        $grid->model()
        ->where('company_id',$u->company_id)
        ->orderBy('name','asc');

        $grid->column('id', __('Id'))->sortable();
        
        $grid->column('image', __('Image'))->image('',70,70);
        
        $grid->column('name', __('SubCategory Name'))->sortable();
        $grid->column('stock_category_id', __('Category Name'))
             ->display(function($stock_category_id){
                $category = StockCategory::find($stock_category_id);
                if($category==null){
                    return "";
                }
                return $category->name;
             })->sortable();
        $grid->column('description', __('Description'))->hide();
      

        $grid->column('buying_price', __('Investment'))->sortable();
        $grid->column('selling_price', __('Expected Sales'))->sortable();
        $grid->column('expected_profit', __('Expected profit'))->sortable();
        $grid->column('earned_profit', __('Earned profit'))->sortable();
       
        $grid->column('current_quantity', __('Current quantity'))
        ->display(function($current_quantity){
            return number_format($current_quantity).' '.$this->measurement_unit;
        })->sortable();
        $grid->column('reorder_level', __('Reorder level'))
        ->display(function($reorder_level){
            return number_format($reorder_level).' '.$this->measurement_unit;
        })->sortable()
        ->editable();
        
        $grid->column('status', __('Status'))
        ->label([
            'Active'=> 'success',
            'Inactive'=> 'danger'
        ])
        ->sortable();
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
        $show = new Show(StockSubCategory::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('company_id', __('Company id'));
        $show->field('stock_category_id', __('Stock category id'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('status', __('Status'));
        $show->field('image', __('Image'));
        $show->field('buying_price', __('Buying price'));
        $show->field('selling_price', __('Selling price'));
        $show->field('expected_profit', __('Expected profit'));
        $show->field('earned_profit', __('Earned profit'));
        $show->field('measurement_unit', __('Measurement unit'));
        $show->field('current_quantity', __('Current quantity'));
        $show->field('reorder_level', __('Reorder level'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        
        $form = new Form(new StockSubCategory());
        $u = Admin::user();
        $form->hidden('company_id', __('Company id'))
        ->default($u->company_id);

        $categories = StockCategory::where([
            'company_id'=> $u->company_id,
            'status'=> 'active'
        ])->get()->pluck('name','id');

       
        
        
        $form->select('stock_category_id', __('Stock category'))
            ->options($categories)
            ->rules('required');
        $form->text('name', __('SubCategory Name'))
            ->rules('required');
        $form->textarea('description', __('Description'));

        
        $form->image('image', __('Image'))
        ->uniqueName();
        
        
        $form->text('measurement_unit', __('Measurement unit'))
            ->rules('required');
       
        $form->decimal('reorder_level', __('Reorder level'))
            ->rules('required');

        $form->radio('status', __('Status'))
        ->options([
            'Active' => 'Active',
            'Inactive'=> 'Inactive'
        ])
        ->default('Active')
        ->rules('required');

        return $form;
    }
}
