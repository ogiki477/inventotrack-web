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

        $grid->disableCreateButton();

        $u = Admin::user();
        $grid->model()->where('id',$u->company_id);

       
        
        
        $grid->column('name', __('Name'))->sortable();
        $grid->column('email', __('Email'));
        $grid->column('logo', __('Logo'))->image('',70,70);
        $grid->column('website', __('Website'));
        $grid->column('about', __('About'))->hide();
        
        $grid->column('license_expiry', __('License expiry'));
        $grid->column('phone_number1', __('Phone number1'));
        $grid->column('phone_number2', __('Phone number2'));
        $grid->column('PoBox', __('PoBox'));
        $grid->column('color', __('Color'));
        $grid->column('slogan', __('Slogan'));
        $grid->column('twitter', __('Twitter'));
        $grid->column('facebook', __('Facebook'));
        $grid->column('currency', __('Currency'));
        $grid->column('settings_worker_can_create_stock_item', __('Settings worker can create stock item'));
        $grid->column('settings_worker_can_create_stock_record', __('Settings worker can create stock record'));
        $grid->column('settings_worker_can_create_stock_category', __('Settings worker can create stock category'));
        $grid->column('settings_worker_can_view_balance', __('Settings worker can view balance'));
        $grid->column('settings_worker_can_view_statistics', __('Settings worker can view statistics'));

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

        $form->textarea('owner_id', __('Owner id'));
        $form->textarea('name', __('Name'));
        $form->textarea('email', __('Email'));
        $form->textarea('logo', __('Logo'));
        $form->textarea('website', __('Website'));
        $form->text('about', __('About'));
        $form->textarea('status', __('Status'));
        $form->date('license_expiry', __('License expiry'))->default(date('Y-m-d'));
        $form->textarea('phone_number1', __('Phone number1'));
        $form->textarea('phone_number2', __('Phone number2'));
        $form->textarea('PoBox', __('PoBox'));
        $form->textarea('color', __('Color'));
        $form->textarea('slogan', __('Slogan'));
        $form->textarea('twitter', __('Twitter'));
        $form->textarea('facebook', __('Facebook'));
        $form->text('currency', __('Currency'))->default('USD');
        $form->text('settings_worker_can_create_stock_item', __('Settings worker can create stock item'))->default('Yes');
        $form->text('settings_worker_can_create_stock_record', __('Settings worker can create stock record'))->default('Yes');
        $form->text('settings_worker_can_create_stock_category', __('Settings worker can create stock category'))->default('Yes');
        $form->text('settings_worker_can_view_balance', __('Settings worker can view balance'))->default('Yes');
        $form->text('settings_worker_can_view_statistics', __('Settings worker can view statistics'))->default('Yes');

        return $form;
    }
}
