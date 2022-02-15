<?php

use Illuminate\Support\Facades\Route;

Route::group( [ 'prefix' => 'admin/plugins', 'middleware' => ['web', 'auth:admin'] ], function() {
    Route::get( 'import', 'AngelBooks\Plugins\Controllers\ImportController@show' )->name('plugins.importer.show');
    Route::get('child-categories/{id}/edit', 'AngelBooks\Plugins\Controllers\ChildCategoriesController@edit')->name('plugins.category.edit');
    Route::get('child-categories', 'AngelBooks\Plugins\Controllers\ChildCategoriesController@index')->name('plugins.category.index');
    Route::post('child-categories', 'AngelBooks\Plugins\Controllers\ChildCategoriesController@store')->name('plugins.category.store');
    Route::post('child-categories/update', 'AngelBooks\Plugins\Controllers\ChildCategoriesController@update')->name('plugins.category.update');
    Route::post('child-categories/destroy', 'AngelBooks\Plugins\Controllers\ChildCategoriesController@destroy')->name('plugins.category.destroy');

    Route::group([
        'prefix'    => 'sub-child-categories',
        'as'        => 'plugins.child-category.',
        'namespace' => 'AngelBooks\Plugins\Controllers\\'
    ], function(){
        // Route::resource('', 'ChildSubCategoriesController');
        Route::get('/{id}/edit', 'ChildSubCategoriesController@edit')->name('edit');
        Route::get('', 'ChildSubCategoriesController@index')->name('index');
        Route::post('', 'ChildSubCategoriesController@store')->name('store');
        Route::post('/update', 'ChildSubCategoriesController@update')->name('update');
        Route::post('/destroy', 'ChildSubCategoriesController@destroy')->name('destroy');
        Route::post('toggle-show-in-menu/{id}', 'ChildSubCategoriesController@toggle_show_in_menu')->name('toggle_show_in_menu');
    });

    Route::get( 'export', 'AngelBooks\Plugins\Controllers\ImportController@export' )->name('plugins.importer.export');
    Route::post( 'import', 'AngelBooks\Plugins\Controllers\ImportController@store' )->name('plugins.importer.store');
    Route::get( 'tabs', 'AngelBooks\Plugins\Controllers\TabsController@show' )->name('plugins.tabs.show');
    Route::get( 'tabs/edit', 'AngelBooks\Plugins\Controllers\TabsController@edit' )->name('plugins.tabs.edit');
    Route::get( 'tabs/delete', 'AngelBooks\Plugins\Controllers\TabsController@destroy' )->name('plugins.tabs.destroy');
    Route::post( 'tabs/update', 'AngelBooks\Plugins\Controllers\TabsController@update' )->name('plugins.tabs.update');
    Route::post( 'tabs', 'AngelBooks\Plugins\Controllers\TabsController@store' )->name('plugins.tabs.store');
    Route::get( 'attributes', 'AngelBooks\Plugins\Controllers\AttributesController@show' )->name('plugins.attributes.show');
    Route::get( 'attributes/edit', 'AngelBooks\Plugins\Controllers\AttributesController@edit' )->name('plugins.attributes.edit');
    Route::get( 'attributes/delete', 'AngelBooks\Plugins\Controllers\AttributesController@destroy' )->name('plugins.attributes.destroy');
    Route::post( 'attributes/update', 'AngelBooks\Plugins\Controllers\AttributesController@update' )->name('plugins.attributes.update');
    Route::post( 'attributes', 'AngelBooks\Plugins\Controllers\AttributesController@store' )->name('plugins.attributes.store');
    Route::get( 'fields', 'AngelBooks\Plugins\Controllers\FieldsController@show' )->name('plugins.fields.show');
    Route::post( 'fields', 'AngelBooks\Plugins\Controllers\FieldsController@store' )->name('plugins.fields.store');
    Route::get( 'fields/edit', 'AngelBooks\Plugins\Controllers\FieldsController@edit' )->name('plugins.fields.edit');
    Route::get( 'fields/delete', 'AngelBooks\Plugins\Controllers\FieldsController@destroy' )->name('plugins.fields.destroy');
    Route::post( 'fields/update', 'AngelBooks\Plugins\Controllers\FieldsController@update' )->name('plugins.fields.update');
    Route::get( 'variations', 'AngelBooks\Plugins\Controllers\VariationsController@show' )->name('plugins.variations.show');
    Route::get( 'variations/edit', 'AngelBooks\Plugins\Controllers\VariationsController@edit' )->name('plugins.variations.edit');
    Route::get( 'variations/delete', 'AngelBooks\Plugins\Controllers\VariationsController@destroy' )->name('plugins.variations.destroy');
} );

Route::get( 'attributes/create', 'AngelBooks\Plugins\Controllers\AttributesController@create' )->name('plugins.attributes.create');
Route::get( 'attributes/diff', 'AngelBooks\Plugins\Controllers\AttributesController@diff' )->name('plugins.attributes.diff');
Route::get( 'attributes/max', 'AngelBooks\Plugins\Controllers\AttributesController@max' )->name('plugins.attributes.max');
Route::get( 'attributes/cache', 'AngelBooks\Plugins\Controllers\AttributesController@cache' )->name('plugins.attributes.cache');
Route::get( 'attributes/create', 'AngelBooks\Plugins\Controllers\AttributesController@create' )->name('plugins.attributes.create');
