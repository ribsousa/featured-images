<?php namespace Ribsousa\Featuredimages;

use System\Classes\PluginBase;
use RainLab\Blog\Controllers\Categories as CategoriesController;
use RainLab\Blog\Models\Category as CategoryModel;

class Plugin extends PluginBase
{
    public $require = ['RainLab.Blog'];

    public function pluginDetails()
    {
        return [
            'name'        => 'ribsousa.featuredimages::lang.plugin.name',
            'description' => 'ribsousa.featuredimages::lang.plugin.description',
            'author'      => 'Ronaldo Ribeiro',
            'icon'        => 'icon-file'
        ];
    }

    public function boot()
    {
        CategoryModel::extend(function ($model) {
            $model->attachMany['featured_images'] = [
                'System\Models\File', 'order' => 'sort_order', 'delete' => true
            ];
        });
        CategoriesController::extendFormFields(function ($form, $model) {
            if (!$model instanceof CategoryModel) return;
            $form->addFields([
                'featured_images' => [
                    'label'     => 'ribsousa.featuredimages::lang.plugin.name',
                    'type'      => 'fileupload',
                    'mode'      => 'image',
                ]
            ]);
        });
    }
}
