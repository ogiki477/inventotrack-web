<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EmployeesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Employees';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('username', __('Username'));
        $grid->column('password', __('Password'));
        $grid->column('name', __('Name'));
        $grid->column('avatar', __('Avatar'));
        $grid->column('remember_token', __('Remember token'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('company_id', __('Company id'));
        $grid->column('first_name', __('First name'));
        $grid->column('last_name', __('Last name'));
        $grid->column('phone_number 1', __('Phone number 1'));
        $grid->column('phone_number 2', __('Phone number 2'));
        $grid->column('address', __('Address'));
        $grid->column('sex', __('Sex'));
        $grid->column('dob', __('Dob'));
        $grid->column('status', __('Status'));

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('username', __('Username'));
        $show->field('password', __('Password'));
        $show->field('name', __('Name'));
        $show->field('avatar', __('Avatar'));
        $show->field('remember_token', __('Remember token'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('company_id', __('Company id'));
        $show->field('first_name', __('First name'));
        $show->field('last_name', __('Last name'));
        $show->field('phone_number 1', __('Phone number 1'));
        $show->field('phone_number 2', __('Phone number 2'));
        $show->field('address', __('Address'));
        $show->field('sex', __('Sex'));
        $show->field('dob', __('Dob'));
        $show->field('status', __('Status'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $u = Admin::user();
        $form->hidden('company_id', __('Company id'))->default($u->company_id);
        
        $form->divider('Person Information');

        $form->text('first_name', __('First name'))->rules('required');

        $form->text('last_name', __('Last name'))->rules('required');
 
        $form->radio('sex', __('Gender'))
        ->options([
            'Male' => 'Male',
            'Female'=> 'Female',
            'Other'=> 'Other',
        ]);
        
        $form->text('address', __('Address'));
        $form->text('phone_number 1', __('Phone number 1'))->rules('required');

        $form->text('phone_number 2', __('Phone number 2'));
        
        $form->date('dob', __('Date Of Birth'));

        $form->divider('Account Information');
      
        $form->image('avatar', __('Avatar'));

        
        
       
       
       
        

        $form->text('email', __('Username'));
       // $form->password('password', __('Password'));

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