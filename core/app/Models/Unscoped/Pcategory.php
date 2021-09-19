<?php

namespace App\Models\Unscoped;

use App\MenuScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Pcategory extends Model
{
    protected $fillable = [
        'name',
        'language_id',
        'status', 'slug',
        'is_child',
        'menu_level',
        'show_in_menu',
        'parent_menu_id'
    ];

    protected $table = 'pcategories';


    public static function boot()
    {
        parent::boot();

        //static::addGlobalScope(new MenuScope);
        static::addGlobalScope('sort_order', function (Builder $builder) {
            $builder->orderBy('sort_order', 'ASC');
        });
    }

    public function parent_category()
    {
        return $this->hasOne('App\Pcategory', 'id', 'parent_menu_id');
    }

    public function childs()
    {
        return $this->hasMany('App\Pcategory', 'parent_menu_id', 'id');
    }

    public function child_cats()
    {
        return $this->childs()/*->where('parent_menu_id', '!=', '')*/ ->where('menu_level', '2');
    }

    public function child_sub_cats()
    {
        return $this->childs()/*->where('parent_menu_id', '!=', '')*/ ->where('menu_level', '3');
    }

    public function products_all()
    {
        return $this->hasMany('App\Product', 'category_id', 'id');
    }

    public function products()
    {

        return $this->products_all()->orWhere('category_id', $this->id)->orWhere('sub_category_id', $this->id);
    }

    public function products_sub_0()
    {
        return $this->hasMany('App\Product', 'category_id', 'id');
    }

    public function products_sub_1()
    {
        return $this->hasMany('App\Product', 'sub_category_id', 'id');
    }

    public function products_sub_2()
    {
        return $this->hasMany('App\Product', 'sub_child_category_id', 'id');
    }

    public function language()
    {
        return $this->belongsTo('App\Language');
    }
}

