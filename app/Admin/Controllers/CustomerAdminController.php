<?php

namespace App\Admin\Controllers;

use App\Customer;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CustomerAdminController extends Controller
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
            ->header('Index')
            ->description('description')
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
            ->header('Detail')
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
        $grid = new Grid(new Customer);

        $grid->id('Id');
        $grid->first_name('First name');
        $grid->last_name('Last name');
        $grid->postal('Postal');
        $grid->home_num('Home num');
        $grid->phone('Phone');
        $grid->email('Email');
        $grid->bank_account('Bank account');
        $grid->address('Address');
        $grid->city('City');
        $grid->gender('Gender');
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
        $show = new Show(Customer::findOrFail($id));

        $show->id('Id');
        $show->first_name('First name');
        $show->last_name('Last name');
        $show->postal('Postal');
        $show->home_num('Home num');
        $show->phone('Phone');
        $show->email('Email');
        $show->bank_account('Bank account');
        $show->address('Address');
        $show->city('City');
        $show->gender('Gender');
        $show->notes('Notes');
        $show->sign('Sign')->image();
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
        $form = new Form(new Customer);

        $form->text('first_name', 'First name');
        $form->text('last_name', 'Last name');
        $form->text('postal', 'Postal');
        $form->number('home_num', 'Home num');
        $form->number('phone', 'Phone');
        $form->email('email', 'Email');
        $form->text('bank_account', 'Bank account');
        $form->text('address', 'Address');
        $form->text('city', 'City');
        $form->text('gender', 'Gender');
        $form->text('notes', 'Notes');
        $form->text('sign', 'Sign');

        return $form;
    }
}
