<?php

namespace App\Models\Unscoped;

use App\MenuScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Pcategory extends Model
{
    protected $fillable = [
        'name',
        'language_id',
        'status','slug',
        'is_child',
        'menu_level',
        'sort_order',
        'show_in_menu',
        'parent_menu_id'
    ];

    protected $table    = 'pcategories';



    public static function boot()
    {
        parent::boot();
        static::addGlobalScope('sort_order', function (Builder $builder) {
            $builder->orderBy('sort_order', 'ASC');
        });
    }

    public function getTitleAttribute() {
        return $this->name ;
    }
    public function getTotalChildCatsAttribute() {
        return $this->child_cats()->count() ;
    }

    public function parent_category() {
        return $this->hasOne('App\Pcategory','id','parent_menu_id') ;
    }
    public function childs() {
        return $this->hasMany('App\Pcategory','parent_menu_id','id') ;
    }
    public function child_cats() {
        return $this->childs()/*->where('parent_menu_id', '!=', '')*/->where('menu_level','2') ;
    }
    public function child_sub_cats() {
        return $this->childs()/*->where('parent_menu_id', '!=', '')*/->where('menu_level','3') ;
    }

    public function products_all() {
        return $this->hasMany('App\Product','category_id','id');
    }
    public function products() {

        return $this->products_all()->orWhere('category_id', $this->id)->orWhere('sub_category_id', $this->id);
    }
    public function products_sub_0() {

        return $this->products_all()->where('category_id', $this->id);
    }
    public function products_sub_1() {

        return $this->products_all()->where('sub_category_id', $this->id);
    }
    public function products_sub_2() {

        return $this->products_all()->where('sub_child_category_id', $this->id);
    }

    public function language() {
        return $this->belongsTo('App\Language');
    }
}