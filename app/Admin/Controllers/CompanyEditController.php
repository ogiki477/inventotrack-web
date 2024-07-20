<?php

namespace App\Admin\Controllers;

use App\Models\Company;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CompanyEditController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Company';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Company());

        $grid->disableBatchActions();
        $grid->quickSearch('name')->placeholder('Search by name');

        $grid->disableCreateButton();

        $u = Admin::user();
        $grid->model()->where('id',$u->company_id);

       
        $grid->column('logo', __('Logo'))->image('',70,70);
        
        $grid->column('name', __('Name'))->sortable();
        $grid->column('email', __('Email'));
        
        $grid->column('website', __('Website'));
        $grid->column('about', __('About'))->hide();
        
        $grid->column('license_expiry', __('License expiry'));
        $grid->column('phone_number1', __('Phone number1'));

        $grid->actions(function ($actions) {
           
           // $actions->disableEdit();
            $actions->disableView();
            $actions->disableDelete();
        });
       
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
        $show = new Show(Company::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('owner_id', __('Owner id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('logo', __('Logo'));
        $show->field('website', __('Website'));
        $show->field('about', __('About'));
        $show->field('status', __('Status'));
        $show->field('license_expiry', __('License expiry'));
        $show->field('phone_number1', __('Phone number1'));
        $show->field('phone_number2', __('Phone number2'));
        $show->field('PoBox', __('PoBox'));
        $show->field('color', __('Color'));
        $show->field('slogan', __('Slogan'));
        $show->field('twitter', __('Twitter'));
        $show->field('facebook', __('Facebook'));
        $show->field('currency', __('Currency'));
        $show->field('settings_worker_can_create_stock_item', __('Settings worker can create stock item'));
        $show->field('settings_worker_can_create_stock_record', __('Settings worker can create stock record'));
        $show->field('settings_worker_can_create_stock_category', __('Settings worker can create stock category'));
        $show->field('settings_worker_can_view_balance', __('Settings worker can view balance'));
        $show->field('settings_worker_can_view_statistics', __('Settings worker can view statistics'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Company());

       
        $form->text('name', __('Name'))->rules('required');
        $form->text('email', __('Email'));
        $form->image('logo', __('Logo'));
        $form->text('website', __('Website'));
        $form->text('about', __('About'));
        

        $form->textarea('phone_number1', __('Phone number1'));
        $form->textarea('phone_number2', __('Phone number2'));
        $form->textarea('PoBox', __('PoBox'));
        $form->textarea('color', __('Color'));
        $form->textarea('slogan', __('Slogan'));
        $form->textarea('twitter', __('Twitter'));
        $form->textarea('facebook', __('Facebook'));

        $form->divider('Settings');
        $form->text('currency', __('Currency'))->default('USD')->rules('required');
        $form->radio('settings_worker_can_create_stock_item', __('Can worker create stock item'))
        ->options(['Yes' => 'Yes', 'No' => 'No'])
        ->default('Yes');
        $form->radio('settings_worker_can_create_stock_record', __('Can worker create stock record'))
        ->options(['Yes' => 'Yes', 'No' => 'No'])
        ->default('Yes');
        $form->radio('settings_worker_can_create_stock_category', __('Can worker create stock category'))
        ->options(['Yes' => 'Yes', 'No' => 'No'])
        ->default('Yes');
        $form->radio('settings_worker_can_view_balance', __('Can worker view balances'))
        ->options(['Yes' => 'Yes', 'No' => 'No'])
        ->default('Yes');
        $form->radio('settings_worker_can_view_statistics', __('Can worker view statistics'))
        ->options(['Yes' => 'Yes', 'No' => 'No'])
        ->default('Yes');

        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });

        $form->disableCreatingCheck();
        $form->disableEditingCheck();
        $form->disableViewCheck();


       

        return $form;
    }
}
