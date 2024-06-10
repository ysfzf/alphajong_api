<?php

namespace App\Admin\Controllers;

use App\Models\ClientModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ClientController extends AdminController
{
    protected $title='AI客户端';
    protected function grid()
    {
        return Grid::make(new ClientModel(), function (Grid $grid) {
            $grid->model()->orderBy('id','desc');
            $grid->column('name');
            $grid->column('status')->switch();
            $grid->column('last_time');
            $grid->column('last_ip');
            $grid->column('created_at');
            $grid->disableCreateButton();
            $grid->disableEditButton();
            $grid->disableViewButton();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->expand()->panel();
                $filter->like('name')->width(4);

            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new ClientModel(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('status');
            $show->field('last_time');
            $show->field('last_ip');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new ClientModel(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('status');
            $form->text('last_time');
            $form->text('last_ip');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
