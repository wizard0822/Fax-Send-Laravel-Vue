<?php

namespace App\Admin\Controllers;

use App\Fax;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Customer;

class FaxAdminController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Faxes')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Faxes')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Fax);

        $grid->id('Id');
        $grid->customer('Customer')->display(function($customer) {
            return "<span class='label label-success'>{$customer['first_name']} {$customer['last_name']}</span>";
        });
        $grid->government('Government')->display(function($government) {
            return "<span class='label label-warning'>{$government['name']}</span>";
        });
        $grid->letter_received('Letter received');
        $grid->applied_for('Applied for');
        $grid->gen_faxcode('Gen faxcode');
        $grid->status('State')->display(function($State) {
            if($State=="success"){
                return "<span class='label label-success'>{$State}</span>";
            }
            else{
                return "<span class='label label-warning'>{$State}</span>";
            }
        });
        $grid->gen_pdf('Gen pdf');
        $grid->date('Date');
        $grid->created_at('Created at');

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
        $show = new Show(Fax::findOrFail($id));

        $show->id('Id');
        $show->date('Date');
        $show->letter_received('Letter received');
        $show->applied_for('Applied for');
        $show->customer('customer information', function ($customer) {

            $customer->setResource('admin/customer');
            $customer->first_name();
            $customer->last_name();
        });
        $show->government('Government information', function ($government) {

            $government->setResource('admin/government');
            $government->name();
            $government->department();
        });

        $show->gen_faxcode('Gen faxcode');
        $show->gen_pdf('Gen pdf')->file();
        $show->trans('Report')->file();
        $show->new_trans('New Report')->file();
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Fax);

        $form->text('date', 'Date');
        $form->text('letter_received', 'Letter received');
        $form->text('applied_for', 'Applied for');
        $form->number('government_id', 'Government id');
        $form->number('customer_id', 'Customer id');
        $form->text('gen_faxcode', 'Gen faxcode');
        $form->text('gen_pdf', 'Gen pdf');

        return $form;
    }
}
