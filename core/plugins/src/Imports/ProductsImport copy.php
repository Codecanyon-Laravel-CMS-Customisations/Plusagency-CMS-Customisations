<?php

namespace AngelBooks\Plugins\Imports;

use App\Product;
use App\Pcategory;
use App\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class ProductsImport implements OnEachRow, WithHeadingRow//ToModel, WithHeadingRow, WithUpserts
{
    // public function chunkSize(): int
    // {
    //     return 10;
    // }

    /**
     * @return string
     */
    public function uniqueBy()
    {
        return 'sku';
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    public function onRow(Row $row)
    {
        ini_set('memory_limit','1024M');
        set_time_limit(0);
        // $is_an_update   = false;


        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        //dd($row);

        if(!isset($row['sub_child_categories'])) $row['sub_child_categories'] = 'Default Category';//dd($row);


        $sliders        = [];
        $featured_image = uniqid() .'.'.'png';
        $image_links    = explode(',', $row['images'] );

        //product category
        $category_col           = trim($row['categories']);
        $child_category_col     = trim(explode('>', $row['child_categories'])[0]);
        $sub_child_category_col = trim(explode('>', $row['sub_child_categories'])[0]);

        if (strlen(trim($category_col)) < 3)            $category_col           = "Default Category";
        if (strlen(trim($child_category_col)) < 3)      $child_category_col     = "Default Category";
        if (strlen(trim($sub_child_category_col)) < 3)  $sub_child_category_col = "Default Category";

        $parent_category        = Pcategory::where( 'name', $category_col )->first();
        if (!$parent_category)
        {
            $parent_category    = Pcategory::create([
                'name'          => trim( $category_col),
                'slug'          => Str::slug( trim( $category_col) ),
                'language_id'   => 169,
                'status'        => 1,
                'is_feature'    => NULL,
                'is_child'      => 0,
                'show_in_menu'  => 1,
                'menu_level'    => 1,
                'parent_menu_id'=> NULL,
            ]);
        }

        $sub_category           = Pcategory::where( 'name', $child_category_col )
            ->where( 'parent_menu_id', $parent_category->id)
            ->first();
        if (!$sub_category)
        {
            $sub_category       = Pcategory::create([
                'name'          => trim( $child_category_col),
                'slug'          => Str::slug( trim( $child_category_col) ),
                'language_id'   => 169,
                'status'        => 1,
                'is_feature'    => NULL,
                'is_child'      => 1,
                'show_in_menu'  => 1,
                'menu_level'    => 2,
                'parent_menu_id'=> $parent_category->id,
            ]);
        }

        $sub_child_category     = Pcategory::where( 'name', $sub_child_category_col )
            ->where( 'parent_menu_id', $sub_category->id)
            ->first();
        if (!$sub_child_category)
        {
            $sub_child_category = Pcategory::create([
                'name'          => trim( $sub_child_category_col),
                'slug'          => Str::slug( trim( $sub_child_category_col) ),
                'language_id'   => 169,
                'status'        => 1,
                'is_feature'    => NULL,
                'is_child'      => 1,
                'show_in_menu'  => 1,
                'menu_level'    => 3,
                'parent_menu_id'=> $sub_category->id,
            ]);
        }


        //delete old images
        if ( $product = Product::where( 'sku', trim($row['sku']) )->first() )
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





        $properties = [
            'title'             => trim($row['name']),
            'slug'              => trim(Str::slug($row['name'])),
            'language_id'       => trim(169),
            'stock'             => trim($row['stock']),
            'sku'               => trim($row['sku']),
            'category_id'       => trim($parent_category->id),
            'sub_category_id'   => $sub_category ? trim($sub_category->id) : NULL,
            'sub_child_category_id'     => $sub_child_category ? trim($sub_child_category->id) : NULL,
            'tags'              => trim($row['tags']),
            'feature_image'     => trim(explode(',', $row['images'])[0]),
            'pending_images_download'   => trim(trim($row['images'])),
            'summary'           => trim(e($row['short_description'])),
            'description'       => trim(e($row['description'])),
            'current_price'     => trim(trim(preg_replace("/[^\d\.]/", "", $row['regular_price'])) != "" ? preg_replace("/[^\d\.]/", "", $row['regular_price']) : '0.00'),
            'is_feature'        => trim($row['is_featured']),
            'status'            => trim(1),
            'rating'            => trim('0.00'),
            'type'              => trim('physical')
        ];

//        if ( ! Product::where( 'slug', Str::slug( $row['name'] ) )->first() )
        // if ( ! Product::where( 'sku', '=', trim($row['sku']) )->first() )
        // {
        //     $product = Product::make( $properties );
        //     $product->save();
        // }
        // else
        // {
        //     // $properties['title']             = trim($row['name'].'-updated');
        //     Product::where( 'sku', '=', trim($row['sku']) )->update($properties);
        //     $product                            = Product::query()->where( 'sku', '=', trim($row['sku']) )->first();
        //     $is_an_update   = true;
        // }

        $product = Product::updateOrCreate(
            ['sku' => $row['sku'] ],
            $row
        );


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

        // foreach ($product->product_images as $imp) {
        //     $imp->delete();
        // }

        // foreach ($sliders as $slider) {
        //     $pi = new ProductImage;
        //     $pi->product_id = $product->id;
        //     $pi->image = trim($slider);
        //     $pi->save();
        // }

        // dd($product->product_images);
        //return $product;
    }

    public function parse_google_drive($link)
    {
        //parse Url
        $url    = parse_url($link);

        if($url['host'] == "drive.google.com")
        {
            //process google link
            $url_array  = explode("/", $url['path']);
            $file_id    = trim($url_array[3]);

            return "https://drive.google.com/uc?id=$file_id&export=download";
        }
        return $link;
    }
}
