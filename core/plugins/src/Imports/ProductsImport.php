<?php

namespace AngelBooks\Plugins\Imports;

use App\User;
use App\Group;
use App\Product;
use App\Pcategory;
use App\ProductImage;
use Maatwebsite\Excel\Row;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $product = Product::firstOrCreate([
            'sku'   => $row['sku'],
            'status'    => 1,
        ]);

        //flush storage
        $this->flushStorage($product);

        $product->title     = $row['name'];
        $product->slug              = trim(Str::slug($row['name']));
        $product->language_id       = trim(169);
        $product->stock             = trim($row['stock']);
        // $product->category_id       = trim($parent_category->id);
        // $product->sub_category_id   = $sub_category ? trim($sub_category->id) : NULL;
        // $product->sub_child_category_id     = $sub_child_category ? trim($sub_child_category->id) : NULL;
        $product->tags              = trim($row['tags']);
        $product->feature_image     = trim(explode(',', $row['images'])[0]);
        $product->pending_images_download   = trim(trim($row['images']));
        $product->summary           = trim(e($row['short_description']));
        $product->description       = trim(e($row['description']));
        $product->current_price     = trim(trim(preg_replace("/[^\d\.]/", "", $row['regular_price'])) != "" ? preg_replace("/[^\d\.]/", "", $row['regular_price']) : '0.00');
        $product->is_feature        = trim($row['is_featured']);
        $product->status            = trim(1);
        $product->rating            = trim('0.00');
        $product->type              = trim('physical');
        $product->save();

        $this->setChildSubCategory($product, $row);
        $this->setProductAttributes($product, $row);


    }

    public function setCategory(Product $product, Array $row)
    {
        $category   = Pcategory::firstOrCreate([
            'name' => trim($row['categories']) == '' ? 'Default Category' : $row['categories'],
        ]);
        $product->category_id   = $category->id;
        $category->name         = trim($row['categories']);
        $category->slug         = Str::slug( trim( $row['categories']) );
        $category->language_id  = 169;
        $category->status       = 1;
        $category->is_feature   = NULL;
        $category->is_child     = 0;
        $category->show_in_menu = 1;
        $category->menu_level   = 1;
        $category->parent_menu_id   = NULL;
        $category->save();
        $product->save();

        return $category;
    }

    public function setSubCategory(Product $product, Array $row)
    {
        $category   = Pcategory::firstOrCreate([
            'name' => trim($row['child_categories']) == '' ? 'Default Category' : $row['child_categories'],
        ]);
        $product->sub_category_id   = $category->id;
        $category->name             = trim($row['child_categories']);
        $category->slug             = Str::slug( trim( $row['child_categories']) );
        $category->language_id      = 169;
        $category->status           = 1;
        $category->is_feature       = NULL;
        $category->is_child         = 1;
        $category->show_in_menu     = 1;
        $category->menu_level       = 2;
        $category->parent_menu_id   = $this->setCategory($product, $row)->id;
        $category->save();
        $product->save();

        return $category;
    }

    public function setChildSubCategory(Product $product, Array $row)
    {

        if(!isset($row['sub_child_categories'])) $row['sub_child_categories'] = 'Default Category';

        $category   = Pcategory::firstOrCreate([
            'name' => trim($row['sub_child_categories']) == '' ? 'Default Category' : $row['sub_child_categories'],
        ]);
        $product->sub_child_category_id = $category->id;
        $category->name             = trim($row['sub_child_categories']);
        $category->slug             = Str::slug( trim( $row['sub_child_categories']) );
        $category->language_id      = 169;
        $category->status           = 1;
        $category->is_feature       = NULL;
        $category->is_child         = 1;
        $category->show_in_menu     = 1;
        $category->menu_level       = 3;
        $category->parent_menu_id   = $this->setSubCategory($product, $row)->id;
        $category->save();
        $product->save();

        return $category;
    }

    public function flushStorage(Product $product)
    {
        if ($product->feature_image)
        {
            Storage::disk('baze')->delete($product->feature_image);
        }
        foreach (ProductImage::query()->where('product_id', $product->id)->get() as $slider)
        {
            Storage::disk('baze')->delete("front/img/product/featured/$slider");
            $slider->delete();
        }
        foreach ($product->product_images as $imp)
        {
            $imp->delete();
        }
    }

    public function setProductAttributes(Product $product, Array $row)
    {
        $attributes = [];

        if ( isset( $row[ 'attribute_1_name' ] ) ) {
            $attributes[] = [
                'name' => $row[ 'attribute_1_name' ],
                'value' => $row[ 'attribute_1_values'],
                'visible' => $row[ 'attribute_1_visible' ],
                'global' => $row[ 'attribute_1_global' ]
            ];
        }
        if ( isset( $row[ 'attribute_2_name' ] ) ) {
            $attributes[] = [
                'name' => $row[ 'attribute_2_name' ],
                'value' => $row[ 'attribute_2_values'],
                'visible' => $row[ 'attribute_2_visible' ],
                'global' => $row[ 'attribute_2_global' ]
            ];
        }
        if ( isset( $row[ 'attribute_3_name' ] ) ) {
            $attributes[] = [
                'name' => $row[ 'attribute_3_name' ],
                'value' => $row[ 'attribute_3_values'],
                'visible' => $row[ 'attribute_3_visible' ],
                'global' => $row[ 'attribute_3_global' ]
            ];
        }
        if ( isset( $row[ 'attribute_4_name' ] ) ) {
            $attributes[] = [
                'name' => $row[ 'attribute_4_name' ],
                'value' => $row[ 'attribute_4_values'],
                'visible' => $row[ 'attribute_4_visible' ],
                'global' => $row[ 'attribute_4_global' ]
            ];
        }
        if ( isset( $row[ 'attribute_5_name' ] ) ) {
            $attributes[] = [
                'name' => $row[ 'attribute_5_name' ],
                'value' => $row[ 'attribute_5_values'],
                'visible' => $row[ 'attribute_5_visible' ],
                'global' => $row[ 'attribute_5_global' ]
            ];
        }
        if ( isset( $row[ 'attribute_6_name' ] ) ) {
            $attributes[] = [
                'name' => $row[ 'attribute_6_name' ],
                'value' => $row[ 'attribute_6_values'],
                'visible' => $row[ 'attribute_6_visible' ],
                'global' => $row[ 'attribute_6_global' ]
            ];
        }
        if ( isset( $row[ 'attribute_7_name' ] ) ) {
            $attributes[] = [
                'name' => $row[ 'attribute_7_name' ],
                'value' => $row[ 'attribute_7_values'],
                'visible' => $row[ 'attribute_7_visible' ],
                'global' => $row[ 'attribute_7_global' ]
            ];
        }
        if ( isset( $row[ 'attribute_8_name' ] ) ) {
            $attributes[] = [
                'name' => $row[ 'attribute_8_name' ],
                'value' => $row[ 'attribute_8_values'],
                'visible' => $row[ 'attribute_8_visible' ],
                'global' => $row[ 'attribute_8_global' ]
            ];
        }
        if ( isset( $row[ 'attribute_9_name' ] ) ) {
            $attributes[] = [
                'name' => $row[ 'attribute_9_name' ],
                'value' => $row[ 'attribute_9_values'],
                'visible' => $row[ 'attribute_9_visible' ],
                'global' => $row[ 'attribute_9_global' ]
            ];
        }
        if ( isset( $row[ 'attribute_10_name' ] ) ) {
            $attributes[] = [
                'name' => $row[ 'attribute_10_name' ],
                'value' => $row[ 'attribute_10_values'],
                'visible' => $row[ 'attribute_10_visible' ],
                'global' => $row[ 'attribute_10_global' ]
            ];
        }
        if ( isset( $row[ 'attribute_11_name' ] ) ) {
            $attributes[] = [
                'name' => $row[ 'attribute_11_name' ],
                'value' => $row[ 'attribute_11_values'],
                'visible' => $row[ 'attribute_11_visible' ],
                'global' => $row[ 'attribute_11_global' ]
            ];
        }
        if ( isset( $row[ 'attribute_12_name' ] ) ) {
            $attributes[] = [
                'name' => $row[ 'attribute_12_name' ],
                'value' => $row[ 'attribute_12_values'],
                'visible' => $row[ 'attribute_12_visible' ],
                'global' => $row[ 'attribute_12_global' ]
            ];
        }
        if ( isset( $row[ 'attribute_13_name' ] ) ) {
            $attributes[] = [
                'name' => $row[ 'attribute_13_name' ],
                'value' => $row[ 'attribute_13_values'],
                'visible' => $row[ 'attribute_13_visible' ],
                'global' => $row[ 'attribute_13_global' ]
            ];
        }
        $product->attributes = json_encode( $attributes );

        $options = [
            'weight' => $row['weight_kg'],
            'length' => $row['length_cm'],
            'width' => $row['width_cm'],
            'height' => $row['height_cm']
        ];

        $product->options = json_encode( $options );

        $product->save();
    }
}
