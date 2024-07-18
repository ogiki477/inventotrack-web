<?php

namespace App\Admin\Controllers;

use App\Models\FinancialPeriod;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FinancialPeriodController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Financial  Periods';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FinancialPeriod());
        $u = Admin::user();
        $grid->model()
            ->where('company_id',$u->company_id)
            ->orderBy('status','asc');

            $grid->disableBatchActions();
            $grid->quickSearch('name');

        $grid->column('id', __('Id'));
       
        $grid->column('company_id', __('Company id'));
        $grid->column('name', __('Name'));
        $grid->column('start-date', __('Start date'))
        ->display(function($start_date){
            return date('D-m-y', strtotime($start_date));
        })
        ->sortable();
        $grid->column('end-date', __('End date')) 
        ->display(function($end_date){
            return date('D-m-y', strtotime($end_date));
        })
        ->sortable();
        $grid->column('status', __('Status'))
        ->label([
            'Active'=> 'success',
            'Inactive' => 'danger',
        ])->sortable();
        $grid->column('descriptive', __('Descriptive'))->hide();
        $grid->column('total_investment', __('Total investment'))
        ->display(function($total_inv){
            return number_format($total_inv);
        });
        $grid->column('total_sales', __('Total sales'))
        ->display(function($total_sales){
            return number_format($total_sales);
        });
        $grid->column('total_profit', __('Total profit'))
        ->display(function($total_prof){
            return number_format($total_prof);
        });
        $grid->column('total_expenses', __('Total expenses'))
        ->display(function($total_exp){
            return number_format($total_exp);
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
        $show = new Show(FinancialPeriod::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('company_id', __('Company id'));
        $show->field('name', __('Name'));
        $show->field('start-date', __('Start date'));
        $show->field('status', __('Status'));
        $show->field('descriptive', __('Descriptive'));
        $show->field('total_investment', __('Total investment'));
        $show->field('total_sales', __('Total sales'));
        $show->field('total_profit', __('Total profit'));
        $show->field('total_expenses', __('Total expenses'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new FinancialPeriod());

        $u = Admin::user();

        $form->hidden('company_id', __('Company id'))->default($u->company_id); 
        $form->text('name', __('Name'))->rules('required');
        $form->date('start-date', __('Start date'))->default(date('Y-m-d'));
        $form->date('end-date', __('End date'))->default(date('Y-m-d'));
        $form->textarea('descriptive', __('Descriptive'));
        
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
