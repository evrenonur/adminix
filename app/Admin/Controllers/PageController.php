<?php

namespace App\Admin\Controllers;

use App\Models\Page;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = ' ';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Page());
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->like('title', __('Başlık'));
        });

        $grid->column('id', __('#'));
        $grid->column('image', __('Resim'))->image(
            null,
            50,
            50
        );
        $grid->column('title', __('Başlık'));
        $grid->column('created_at', __('Oluşturulma Tarihi'))
            ->display(function ($created_at) {
                return date('d.m.Y H:i:s', strtotime($created_at));
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
        $show = new Show(Page::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('description', __('Description'));
        $show->field('image', __('Image'));
        $show->field('slug', __('Slug'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Page());
        $form->setTitle(' ');
        $form->disableCreatingCheck();
        $form->disableEditingCheck();
        $form->disableViewCheck();

        $form->text('title', __('Başlık'))
            ->rules('required|min:3|max:255',[
                'required' => 'Bu alan zorunludur.',
                'min' => 'Bu alan en az 3 karakterden oluşmalıdır.',
                'max' => 'Bu alan en fazla 255 karakterden oluşmalıdır.'
            ]);

        $form->summernote('description', __('Açıklama'))
            ->rules('required',[
                'required' => 'Bu alan zorunludur.'
            ]);

        $form->image('image', __('Resim'))
            ->rules('required',[
                'required' => 'Bu alan zorunludur.'
            ]);

        return $form;
    }
}
