<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = ' ';
    protected $description = [
        'index'  => 'Kategori Listesi',
        'show'   => 'Show',
        'edit'   => 'Edit',
        'create' => 'Kategori Ekle',
    ];


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category());
        $grid->disableExport();
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        $grid->setTitle('Kategori Listesi');
        $grid->column('id', __('#'));
        $grid->column('image', __('Resim'))->image(
            '',
            100,
            100
        );
        $grid->column('title', __('Başlık'));
        $grid->column('created_at', __('Eklenme Tarihi'))->display(
            function ($date) {
                return date('d.m.Y', strtotime($date));
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
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Başlık'));
        $show->field('description', __('Açıklama'));
        $show->image('image', __('Resim'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category());
        $form->setTitle('Kategori Ekle');

        $form->text('title', __('Başlık'))
            ->rules('required|min:3|max:255',[
                'required' => 'Bu alan zorunludur.',
                'min' => 'En az 3 karakter girmelisiniz.',
                'max' => 'En fazla 255 karakter girebilirsiniz.'
            ]);

        $form->text('description', __('Açıklama'))
            ->rules('required|min:3|max:255',[
                'required' => 'Bu alan zorunludur.',
                'min' => 'En az 3 karakter girmelisiniz.',
                'max' => 'En fazla 255 karakter girebilirsiniz.'
            ]);
        $form->image('image', __('Resim'))
            ->rules('required|min:3|max:255',[
                'required' => 'Bu alan zorunludur.',
                'min' => 'En az 3 karakter girmelisiniz.',
                'max' => 'En fazla 255 karakter girebilirsiniz.'
            ])->uniqueName();

        $form->disableCreatingCheck();
        $form->disableEditingCheck();
        $form->disableViewCheck();

        return $form;
    }
}
