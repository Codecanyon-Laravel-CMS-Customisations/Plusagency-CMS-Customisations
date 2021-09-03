<?php

namespace App\Models\Unscoped;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'language_id',
        'stock',
        'sku',
        'category_id',
        'tags',
        'feature_image',
        'show_in_page_builder',
        'pending_images_download',
        'summary',
        'description',
        'current_price',
        'previous_price',
        'rating',
        'status',
        'meta_keywords',
        'meta_description',
        'type',
        'download_link',
        'download_file',
        'attributes',
        'options',
        'sub_categories',
        'is_variation',
        'sub_category_id',
        'sub_child_category_id'
    ];

    public function getTitleAttribute($title)
    {
        return trim(nl2br(html_entity_decode($title, ENT_QUOTES)));
    }
    public function getSummaryAttribute($summary)
    {
        return trim(nl2br(html_entity_decode($summary, ENT_QUOTES)));
    }
    public function getDescriptionAttribute($description)
    {
        return trim(nl2br(html_entity_decode($description, ENT_QUOTES)));
    }

    protected static function boot()
    {
        parent::boot();

        /*static::addGlobalScope('variation', function (Builder $builder) {
            $builder->where('is_variation', 0);
        });*/
    }

    /*public function scopeFilterPcategory($query, $productId)
    {
        return $query->select('products.*')
            ->join('units', 'units.id', '=', 'tenant.unit_id')
            ->join('blocks', 'blocks.id', '=', 'units.block_id')
            ->join('pcategories', 'pcategories.id', '=', 'products.category_id')
            ->where('products.id', $productId);
    }*/

    public function category() {
        return $this->hasOne('App\Pcategory','id','category_id')->withoutGlobalScope('App\MenuScope');
    }

    public function sub_category() {
        //return $this->hasOne('App\ChidCategory','id','sub_category_id');
        return $this->hasOne('App\Pcategory','id','sub_category_id');
    }

    public function child_category() {
        return $this->sub_category()->where('is_child', '1');
    }

    public function product_images() {
        return $this->hasMany('App\ProductImage');
    }

    public function language() {
        return $this->belongsTo('App\Language');
    }
}