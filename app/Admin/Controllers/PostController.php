<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Post;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PostController extends AdminController
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
        $grid = new Grid(new Post());
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->like('title', __('Başlık'));
            $filter->equal('category_id', __('Kategori'))->select(
                Category::all()->pluck('title', 'id')
            );
            $filter->equal('status', __('Durum'))->select(
                [
                    1 => 'Aktif',
                    0 => 'Pasif',
                ]
            );
        });

        $grid->column('id', __('Id'));
        $grid->column('image', __('Resim'))->image(
            null,
            50,
            50
        );
        $grid->column('title', __('Başlık'));
        $grid->column('category_id', __('Kategori'))
            ->display(function ($category_id) {
                return Category::find($category_id)->title;
            });
        $grid->column('status', __('Durum'))->switch(
            [
                'on' => ['value' => 1, 'text' => 'Aktif'],
                'off' => ['value' => 0, 'text' => 'Pasif'],
            ]
        );
        $grid->column('created_at', __('Eklenme Tarihi'))->display(
            function ($created_at) {
                return date('d.m.Y H:i:s', strtotime($created_at));
            }
        );

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
        $show = new Show(Post::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Başlık'));
        $show->field('description', __('Description'));
        $show->field('image', __('Image'));
        $show->field('category_id', __('Category id'));
        $show->field('status', __('Status'));
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
        $form = new Form(new Post());
        $form->setTitle(' ');
        $form->disableCreatingCheck();
        $form->disableEditingCheck();
        $form->disableViewCheck();
        $form->text('title', __('Başlık'));
        $form->summernote('description', __('İçerik'));
        $form->image('image', __('Resim'))
            ->uniqueName();
        $form->select('category_id', __('Kategori'))
            ->options(Category::all()->pluck('title', 'id'));
        $form->switch('status', __('Durum'))
            ->default(1);

        return $form;
    }
}
