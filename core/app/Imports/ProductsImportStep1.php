<?php

namespace App\Imports;

use App\Product;
use App\Pcategory;
use App\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductsImportStep1 implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, ShouldQueue
{
    public function chunkSize(): int
    {
        return 1000;
    }
    public function batchSize(): int
    {
        return 1000;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ( ! Product::where( 'slug', Str::slug( $row['name'] ) )->first() )
        {
            //product category
            $counter                = 0;
            $categories             = explode('>', $row['categories']);
            foreach ($categories as $key => $value)
            {
                $counter           += 1;
                if ( ! Pcategory::where( 'name', trim( $value ) )->first() )
                {
                    if ( $counter == 1 )
                    {
                        $category           = Pcategory::create([
                            'name'          => trim( $value ),
                            'slug'          => Str::slug( trim( $value ) ),
                            'language_id'   => 169,
                            'status'        => 1,
                            'is_feature'    => NULL,
                            'is_child'      => 0,
                            'show_in_menu'  => 0,
                            'menu_level'    => intval($counter),
                            'parent_menu_id'=> NULL,
                        ]);
                    }
                    if ( $counter == 2 )
                    {
                        $parent             = Pcategory::where( 'name', trim( $categories[$counter-1] ) )->first();
                        $category           = Pcategory::create([
                            'name'          => trim( $value ),
                            'slug'          => Str::slug( trim( $value ) ),
                            'language_id'   => 169,
                            'status'        => 1,
                            'is_feature'    => NULL,
                            'is_child'      => 1,
                            'show_in_menu'  => 0,
                            'menu_level'    => intval($counter),
                            'parent_menu_id'=> $parent ? $parent->id : NULL,
                        ]);
                    }
                    elseif ( $counter == 3 )
                    {
                        $parent             = Pcategory::where( 'name', trim( $categories[$counter-1] ) )->first();
                        $category           = Pcategory::create([
                            'name'          => trim( $value ),
                            'slug'          => Str::slug( trim( $value ) ),
                            'language_id'   => 169,
                            'status'        => 1,
                            'is_feature'    => NULL,
                            'is_child'      => 1,
                            'show_in_menu'  => 0,
                            'menu_level'    => intval($counter),
                            'parent_menu_id'=> $parent ? $parent->id : NULL,
                        ]);
                    }
                }
            }
            $category = Pcategory::where( 'name', trim( $categories[count($categories)-1] ) )->first();


            return new Product([
                'title'             => $row['name'],
                'slug'              => Str::slug($row['name']),
                'language_id'       => 169,
                'stock'             => 100,
                'sku'               => $row['sku'],
                'category_id'       => $category->id,
                'sub_category_id'   => NULL,
                'sub_categories'    => NULL,
                'tags'              => $row['tags'],
                'feature_image'     => explode(',', $row['images'])[0],
                'summary'           => e($row['short_description']),
                'description'       => e($row['description']),
                'current_price'     => preg_match("/[\d]{1,}/", $row['regular_price']) ? number_format((int)$row['regular_price'], 2) : '0.00',
                'is_feature'        => $row['is_featured'],
                'status'            => 1,
                'rating'            => '0.00',
                'type'              => 'physical'
            ]);
        }
        else
        {
            //
        }

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
