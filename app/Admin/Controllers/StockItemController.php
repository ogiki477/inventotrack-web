<?php

namespace App\Admin\Controllers;

use App\Models\StockItem;
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
    protected $title = 'StockItem';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new StockItem());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('company_id', __('Company id'));
        $grid->column('created_by_id', __('Created by id'));
        $grid->column('stock_category_id', __('Stock category id'));
        $grid->column('stock_sub_category_id', __('Stock sub category id'));
        $grid->column('financial_period_id', __('Financial period id'));
        $grid->column('name', __('Name'));
        $grid->column('description', __('Description'));
        $grid->column('image', __('Image'));
        $grid->column('barcode', __('Barcode'));
        $grid->column('sku', __('Sku'));
        $grid->column('generate_sku', __('Generate sku'));
        $grid->column('update_sku', __('Update sku'));
        $grid->column('gallery', __('Gallery'));
        $grid->column('buying_price', __('Buying price'));
        $grid->column('selling_price', __('Selling price'));
        $grid->column('original_quantity', __('Original quantity'));
        $grid->column('current_quantity', __('Current quantity'));

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
        $form = new Form(new StockItem());
        $u = Admin::user();

        $form->hidden('company_id', __('Company id'))->default($u->company_id);
        $form->number('created_by_id', __('Created by id'));
        $form->number('stock_category_id', __('Stock category id'));
        $form->number('stock_sub_category_id', __('Stock sub category id'));
        $form->number('financial_period_id', __('Financial period id'));
        $form->textarea('name', __('Name'));
        $form->text('description', __('Description'));
        $form->textarea('image', __('Image'));
        $form->textarea('barcode', __('Barcode'));
        $form->textarea('sku', __('Sku'));
        $form->textarea('generate_sku', __('Generate sku'));
        $form->textarea('update_sku', __('Update sku'));
        $form->textarea('gallery', __('Gallery'));
        $form->number('buying_price', __('Buying price'));
        $form->number('selling_price', __('Selling price'));
        $form->number('original_quantity', __('Original quantity'));
        $form->number('current_quantity', __('Current quantity'));

        return $form;
    }
}
