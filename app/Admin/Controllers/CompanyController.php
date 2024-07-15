<?php

namespace App\Admin\Controllers;

use App\Models\Company;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;

class CompanyController extends AdminController
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
        $grid->quickSearch('name','email');
        $grid->column('id', __('Id'))->hide();
        $grid->column('created_at', __('Created'))
        ->display(function ($created_at){
            return date('Y-m-d',strtotime($created_at));
        });
       // $grid->column('updated_at', __('Updated at'));
        $grid->column('owner_id', __('Owner'))->display(function($owner_id){
            $user = User::find($owner_id);
            if($user == null ){
                return ("Not found");
            }
            return $user->name;
             
            
        })->sortable();
        $grid->column('name', __('Company Name'));
        $grid->column('email', __('Email'));
        $grid->column('logo', __('Logo'))->hide();
        $grid->column('website', __('Website'))->hide();
        $grid->column('about', __('About'))->hide();
        $grid->column('status', __('Status'))->display(function($status){
            return $status == 'active' ? 'Active' : 'Inactive';
        })->sortable();
        $grid->column('license_expiry', __('License expiry'))
        ->display(function ($license_expire){
            return date('Y-m-d',strtotime($license_expire));
        })->sortable();
        $grid->column('phone_number1', __('Phone number1'))->hide();
        $grid->column('phone_number2', __('Phone number2'))->hide();
        $grid->column('PoBox', __('PoBox'))->hide();
        $grid->column('color', __('Color'))->hide();
        $grid->column('slogan', __('Slogan'))->hide();
        $grid->column('twitter', __('Twitter'))->hide();
        $grid->column('facebook', __('Facebook'))->hide();

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

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        
        // $comp = Company::find(1);
        // $comp->name = $comp->name. '-'.rand(1,100);
        // $comp->save();
        // die("done");


        $admin_role_users = DB::table('admin_role_users')->where(['role_id'=> 2])->get();

        $company_admins = [];

        foreach($admin_role_users as $key => $value ){
            $user = User::find($value->user_id);
            if($user == null){
                continue;
            }
            $company_admins[$user->id] = $user->name;
        }

        
        $form = new Form(new Company());

        $form->select('owner_id', __('Company Owner'))
        ->options($company_admins)
        ->rules('required');
        $form->text('name', __('Company Name'));
        $form->email('email', __('Email'));
        $form->image('logo', __('Logo'));
        $form->url('website', __('Website'));
        $form->textarea('about', __('About Company'));
        $form->text('status', __('Status'));
        $form->date('license_expiry', __('License expiry'))->default(date('Y-m-d'));
        $form->text('phone_number1', __('Phone number1'));
        $form->text('phone_number2', __('Phone number2'));
        $form->text('PoBox', __('PoBox'));
        $form->color('color', __('Color'));
        $form->text('slogan', __('Slogan'));
        $form->url('twitter', __('Twitter'));
        $form->url('facebook', __('Facebook'));

        return $form;
    }
}
