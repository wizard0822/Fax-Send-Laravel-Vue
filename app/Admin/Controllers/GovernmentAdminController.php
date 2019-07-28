<?php

namespace App\Admin\Controllers;

use App\Government;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class GovernmentAdminController extends Controller
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
        $grid = new Grid(new Government);

        $grid->id('Id');
        $grid->name('Name');
        $grid->department('Department');
        $grid->email('Email');
        $grid->fax('Fax');
        $grid->address('Address');
        $grid->postal('Postal');
        $grid->city('City');
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
        $show = new Show(Government::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->department('Department');
        $show->email('Email');
        $show->fax('Fax');
        $show->address('Address');
        $show->postal('Postal');
        $show->city('City');
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
        $form = new Form(new Government);

        $form->text('name', 'Name');
        $form->text('department', 'Department');
        $form->email('email', 'Email');
        $form->text('fax', 'Fax');
        $form->text('address', 'Address');
        $form->text('postal', 'Postal');
        $form->text('city', 'City');

        return $form;
    }
}
