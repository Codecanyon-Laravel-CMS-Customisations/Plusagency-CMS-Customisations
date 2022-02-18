<?php

namespace App\Models\Unscoped;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

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
        'offline',
        'options',
        'sub_categories',
        'is_variation',
        'sub_category_id',
        'sub_child_category_id',
        'current_price_international'
    ];

    protected $casts    = [
        'digital'       => 'boolean',
        'offline'       => 'boolean',
    ];

    public function getPriceAttribute()
    {
        if(ship_to_india())
        {
            return $this->current_price;
        }
        return !empty($this->current_price_international) ? $this->current_price_international : $this->current_price;
    }

    public function getCurrencyAttribute()
    {
        if(ship_to_india())
        {
            return "INR";
        }
        return !empty($this->current_price_international) ? "USD" : "INR";
    }

    public function getSymbolAttribute()
    {
        if(ship_to_india())
        {
            return "₹";
        }
        return !empty($this->current_price_international) ? "$" : "₹";
    }

    public function getInCountryAttribute()
    {
        if(product_in_location($this->id))
        {
            return true;
        }
        return false;
    }

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

    public function getFeatureImageAttribute($feature_image)
    {
        if(trim($feature_image) == '') return trim(asset("assets/front/img/product/edition_placeholder.png"));
        if(Str::endsWith($feature_image, 'featured')) return trim(asset("assets/front/img/product/edition_placeholder.png"));
        if(Str::endsWith($feature_image, 'featured/')) return trim(asset("assets/front/img/product/edition_placeholder.png"));
        if(Str::startsWith($feature_image, 'http')) return trim($feature_image);

        //make link http
        return asset("assets/front/img/product/featured/$feature_image");
    }

    protected static function boot()
    {
        parent::boot();

//        static::addGlobalScope('variation', function (Builder $builder) {
//            $builder->where('is_variation', 0);
//        });
    }

//    public function scopeFilterPcategory($query, $productId)
//    {
//        return $query->select('products.*')
//            ->join('units', 'units.id', '=', 'tenant.unit_id')
//            ->join('blocks', 'blocks.id', '=', 'units.block_id')
//            ->join('pcategories', 'pcategories.id', '=', 'products.category_id')
//            ->where('products.id', $productId);
//    }

    public function category()
    {
        return $this->hasOne('App\Pcategory', 'id', 'category_id')->withoutGlobalScope('App\MenuScope');
    }

    public function sub_category()
    {
        //return $this->hasOne('App\ChidCategory','id','sub_category_id');
        return $this->hasOne('App\Pcategory', 'id', 'sub_category_id');
    }

    public function child_category()
    {
        return $this->sub_category()->where('is_child', '1');
    }

    public function product_images()
    {
        return $this->hasMany('App\ProductImage');
    }

    public function language()
    {
        return $this->belongsTo('App\Language');
    }
}
