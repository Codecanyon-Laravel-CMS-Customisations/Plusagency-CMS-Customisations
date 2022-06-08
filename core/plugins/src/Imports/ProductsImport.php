<?php

namespace AngelBooks\Plugins\Imports;

use App\BasicExtended;
use App\Language;
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
use Symfony\Component\DomCrawler\Crawler;

class ProductsImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {

        $rowIndex = $row->getIndex();
        $row      = $row->toArray();
        
        if (strlen(trim(convertUtf8($row['name']))) > 1)
        {
            $product                        = Product::firstOrCreate([
                'sku'                       => trim(convertUtf8($row['sku'])),
                // 'status'    => 1,
            ]);
            if (!isset($row['images']))  $row['images']  = "";
            if (!isset($row['offline'])) $row['offline'] = 0;
            if (!isset($row['digital'])) $row['digital'] = 0;
            if (!isset($row['meta_wcj_price_by_country_regular_price_local_1'])) $row['meta_wcj_price_by_country_regular_price_local_1'] = null;

            $product_categories             = $this->setProductCategories($row);

            $parent_category                = $product_categories['parent_category'];
            $sub_category                   = $product_categories['sub_category'];
            $sub_child_category             = $product_categories['sub_child_category'];


            $product->title                 = convertUtf8($row['name']);
            $product->slug                  = trim(Str::slug(convertUtf8($row['name'])));
            $product->language_id           = trim(169);
            $product->offline               = intval($row['offline']);
            $product->digital               = intval($row['digital']);
            $product->show_inquiry_form     = intval(isset($row['show_inquiry_form']) ? $row['show_inquiry_form'] : 0);
            $product->stock                 = trim($row['stock']);
            $product->category_id           = trim($parent_category->id);
            $product->sub_category_id       = $sub_category ? trim($sub_category->id) : NULL;
            $product->sub_child_category_id = $sub_child_category ? trim($sub_child_category->id) : NULL;
            $product->tags                  = trim($row['tags']);
            // $product->feature_image         = trim(explode(',', $row['images'])[0]);
            // $product->pending_images_download   = trim(trim($row['images']));
            $product->summary               = trim(e($this->parse_digital_links($product, (string)$row['short_description'])));
            $product->description           = trim(e($this->parse_digital_links($product, (string)$row['description'])));
            $product->current_price         = trim(trim(preg_replace("/[^\d\.]/", "", $row['regular_price'])) != "" ? preg_replace("/[^\d\.]/", "", $row['regular_price']) : '0.00');
            $product->current_price_international   = trim(trim(preg_replace("/[^\d\.]/", "", $row['meta_wcj_price_by_country_regular_price_local_1'])) != "" ? preg_replace("/[^\d\.]/", "", $row['meta_wcj_price_by_country_regular_price_local_1']) : '0.00');
            $product->is_feature                    = trim($row['is_featured']);
            $product->status                        = trim(1);
            $product->rating                        = trim('0.00');
            $product->type                          = trim('physical');
            $product->save();

             $this->setProductImages($product, $row);
            // $this->setChildSubCategory($product, $row);
             $this->setProductAttributes($product, $row);
             $this->setProductTabs($product, $row);

             
             // start: import variations data
             if ( isset($row['type']) && $row['type'] == "variation" ) {
                $this->setProductVariations($product, $row);
             }
             // end: import variations data 

             if(isset($row['add_to_menu'])) $product->show_in_page_builder  = intval($row['add_to_menu']);$product->save();
        }

    }

    public function setCategory(Product $product, Array $row)
    {
        //product category
        if (!isset($row['categories']))   $row['categories'] = "Default Category";
        $category_col           = trim($row['categories']);
        if (strlen(trim($category_col)) < 3)            $category_col           = "Default Category";

        $category   = Pcategory::firstOrCreate(['name' => $category_col]);

        $product->category_id   = $category->id;
        $category->name         = trim($category_col);
        $category->slug         = Str::slug( trim($category_col) );
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


    public function setProductCategories(Array $row)
    {
        //product category
        if (!isset($row['child_categories']))       $row['child_categories']     = "Default Category";
        if (!isset($row['sub_child_categories']))   $row['sub_child_categories'] = "Default Category";
        $category_col           = isset($row['categories']) ? trim($row['categories']) : "Default Category";
        $child_category_col     = Str::contains($row['child_categories'], '>') ?     trim(explode('>', $row['child_categories'])[0])     : trim($row['child_categories']);
        $sub_child_category_col = Str::contains($row['sub_child_categories'], '>') ? trim(explode('>', $row['sub_child_categories'])[0]) : trim($row['sub_child_categories']);

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

        return [
            "parent_category"   => $parent_category,
            "sub_category"      => $sub_category,
            "sub_child_category"=> $sub_child_category,
        ];


    }

    public function setSubCategory(Pcategory $parent_category, Product $product, Array $row)
    {
        if (!isset($row['child_categories']))   $row['child_categories'] = "Default Category";
        $child_category_col         = trim(explode('>', $row['child_categories'])[0]);
        if (strlen(trim($child_category_col)) < 3)      $child_category_col     = "Default Category";

        $category   = Pcategory::firstOrCreate(['name' => $child_category_col]);

        $product->sub_category_id   = $category->id;
        $category->name             = trim($child_category_col);
        $category->slug             = Str::slug( trim($child_category_col) );
        $category->language_id      = 169;
        $category->status           = 1;
        $category->is_feature       = NULL;
        $category->is_child         = 1;
        $category->show_in_menu     = 1;
        $category->menu_level       = 2;
        $category->parent_menu_id   = $parent_category->id;
        $category->save();
        $product->save();

        return $category;
    }

    public function setChildSubCategory(Pcategory $sub_category, Product $product, Array $row)
    {
        if (!isset($row['sub_child_categories']))   $row['sub_child_categories'] = "Default Category";
        $sub_child_category_col = trim(explode('>', $row['sub_child_categories'])[0]);
        if (strlen(trim($sub_child_category_col)) < 3)  $sub_child_category_col = "Default Category";

        $category   = Pcategory::firstOrCreate(['name' => $sub_child_category_col]);

        $product->sub_child_category_id = $category->id;
        $category->name             = trim($sub_child_category_col);
        $category->slug             = Str::slug( trim($sub_child_category_col) );
        $category->language_id      = 169;
        $category->status           = 1;
        $category->is_feature       = NULL;
        $category->is_child         = 1;
        $category->show_in_menu     = 1;
        $category->menu_level       = 3;
        $category->parent_menu_id   = $sub_category->id;
        $category->save();
        $product->save();

        return $category;
    }

    public function setProductAttributes(Product $product, Array $row)
    {
        $attributes = [];

        if ( isset( $row[ 'attribute_1_name' ] ) ) {
            $attributes[] = [
                'name'      => $row[ 'attribute_1_name' ],
                'value'     => $row[ 'attribute_1_values'],
                'visible'   => $row[ 'attribute_1_visible' ],
                'global'    => $row[ 'attribute_1_global' ]
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
                'name'    => $row[ 'attribute_4_name' ],
                'value'   => isset($row[ 'attribute_4_values']) ? $row[ 'attribute_4_values'] : '',
                'visible' => $row[ 'attribute_4_visible' ],
                'global'  => $row[ 'attribute_4_global' ]
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

    public function setProductVariations(Product $product, Array $row)
    {

        $product_id = $product->id;
        // dd($row[ 'variation_1_title' ]);

        $in = $row;

        $in['language_id']  = 169;
        $in['is_variation'] = 1;

        $importer           = new ProductsImport();
        

        if (isset($row['summary'])) unset($row['summary']);
        if (isset($row['description'])) unset($row['description']);

        /* start: storing variation 1 details */

        if ( isset( $row['variation_1_title'] ) ) {

            // modal init for variation check
                $productModel = Product::withoutGlobalScope('variation');
            // end modal init for variation check

            // first check if variation already exists then update previous else add new
            $variationDetails = $productModel->where('title', '=', $row['variation_1_title'])->first();
            $productVariation = $variationDetails?$product->whereRaw("FIND_IN_SET($variationDetails->id, variations) > 0")->first():null;

            if ($productVariation) {
                $product = $variationDetails;
            } else {
                $product = Product::create($in);
            }
            

            // $in['summary']      = trim(e($importer->parse_digital_links($product, $importer->parse_tabs($row['short_description']))));
            // $in['description']  = trim(e($importer->parse_digital_links($product, $importer->parse_tabs($row['description']))));
            

            
            $product->title = $row['variation_1_title'];
            $product->sku = null;
            // $product->slug = make_slug($row['variation_1_title']);
            $product->current_price = $row['variation_1_regular_price'];
            $product->current_price_international = $row['variation_1_foreign_price'];
            $product->type = 'physical';

            $variation_1 = $product;

            // start: adding variation attributes
                $attributes = [];

                if ( isset( $row[ 'variation_1_attribute_1_name' ] ) ) {
                    $attributes[] = [
                        'name'      => $row[ 'variation_1_attribute_1_name' ],
                        'value'     => $row[ 'variation_1_attribute_1_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_1_attribute_2_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_1_attribute_2_name' ],
                        'value' => $row[ 'variation_1_attribute_2_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_1_attribute_3_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_1_attribute_3_name' ],
                        'value' => $row[ 'variation_1_attribute_3_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_1_attribute_4_name' ] ) ) {
                    $attributes[] = [
                        'name'    => $row[ 'variation_1_attribute_4_name' ],
                        'value'   => $row[ 'variation_1_attribute_4_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_1_attribute_5_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_1_attribute_5_name' ],
                        'value' => $row[ 'variation_1_attribute_5_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_1_attribute_6_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_1_attribute_6_name' ],
                        'value' => $row[ 'variation_1_attribute_6_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
            // end: adding variation attributes
            
            $product->attributes = json_encode( $attributes );
            $product->variation_data = json_encode( [
                'title' => $row['variation_1_title'],
                'value' => null,
                'type' => 'physical',
                'thumbnail' => $row['variation_1_thumbnail'],
            ] );

            if ($productVariation) {
                $product->update();
            } else {
                $product->save();
            }
            // $product->save();

            if (!$productVariation) {
                $parent = Product::find($product_id);

                if (is_null($parent->variations)) {
                    $parent->variations = $product->id;
                } else {
                    $parent->variations = $parent->variations . ',' . $product->id;
                }

                $parent->save();

                $lang = Language::where('code', 'en')->first();

                $abx = $lang->basic_extended;

                if ( is_null($abx->product_variations ) ) {
                    $global_variations = [];
                } else {
                    $global_variations = (array) json_decode( $abx->product_variations );
                }

                $global_variations[] = [
                    'product_id' => $parent->id,
                    'variation_id' => $product->id
                ];

                $abx->product_variations = json_encode( $global_variations );

                $abx->save();
            } 
            
        }
        /* end: storing variation 1 details */


        /* start: storing variation 2 details */
        if ( isset( $row['variation_2_title'] ) ) {
            // modal init for variation check
                $productModel = Product::withoutGlobalScope('variation');
            // end modal init for variation check

            // first check if variation already exists then update previous else add new
            $variationDetails = $productModel->where('title', '=', $row['variation_2_title'])->first();
            $productVariation = $variationDetails?$product->whereRaw("FIND_IN_SET($variationDetails->id, variations) > 0")->first():null;

            if ($productVariation) {
                $product = $variationDetails;
            } else {
                $product = Product::create($in);
            }


            // $in['summary']      = trim(e($importer->parse_digital_links($product, $importer->parse_tabs($row['short_description']))));
            // $in['description']  = trim(e($importer->parse_digital_links($product, $importer->parse_tabs($row['description']))));
            

            
            $product->title = $row['variation_2_title'];
            $product->sku = null;
            $product->tags = null;
            // $product->slug = make_slug($row['variation_1_title']);
            $product->current_price = $row['variation_2_regular_price'];
            $product->current_price_international = $row['variation_2_foreign_price'];
            $product->type = 'physical';


            // start: adding variation attributes
                $attributes = [];

                if ( isset( $row[ 'variation_2_attribute_1_name' ] ) ) {
                    $attributes[] = [
                        'name'      => $row[ 'variation_2_attribute_1_name' ],
                        'value'     => $row[ 'variation_2_attribute_1_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_2_attribute_2_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_2_attribute_2_name' ],
                        'value' => $row[ 'variation_2_attribute_2_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_2_attribute_3_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_2_attribute_3_name' ],
                        'value' => $row[ 'variation_2_attribute_3_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_2_attribute_4_name' ] ) ) {
                    $attributes[] = [
                        'name'    => $row[ 'variation_2_attribute_4_name' ],
                        'value'   => $row[ 'variation_2_attribute_4_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_2_attribute_5_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_2_attribute_5_name' ],
                        'value' => $row[ 'variation_2_attribute_5_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_2_attribute_6_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_2_attribute_6_name' ],
                        'value' => $row[ 'variation_2_attribute_6_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
            // end: adding variation attributes
            
            $product->attributes = json_encode( $attributes );
            $product->variation_data = json_encode( [
                'title' => $row['variation_2_title'],
                'value' => null,
                'type' => 'physical',
                'thumbnail' => $row['variation_2_thumbnail'],
            ] );


            if ($productVariation) {
                $product->update();
            } else {
                $product->save();
            }

            if (!$productVariation) {

                $parent = Product::find($product_id);

                if (is_null($parent->variations)) {
                    $parent->variations = $product->id;
                } else {
                    $parent->variations = $parent->variations . ',' . $product->id;
                }

                $parent->save();

                $lang = Language::where('code', 'en')->first();

                $abx = $lang->basic_extended;

                if ( is_null($abx->product_variations ) ) {
                    $global_variations = [];
                } else {
                    $global_variations = (array) json_decode( $abx->product_variations );
                }

                $global_variations[] = [
                    'product_id' => $parent->id,
                    'variation_id' => $product->id
                ];

                $abx->product_variations = json_encode( $global_variations );

                $abx->save();
            }
        }
        /* end: storing variation 2 details */


        /* start: storing variation 3 details */
        if ( isset( $row['variation_3_title'] ) ) {

            // modal init for variation check
                $productModel = Product::withoutGlobalScope('variation');
            // end modal init for variation check

            // first check if variation already exists then update previous else add new
            $variationDetails = $productModel->where('title', '=', $row['variation_3_title'])->first();
            $productVariation = $variationDetails?$product->whereRaw("FIND_IN_SET($variationDetails->id, variations) > 0")->first():null;

            if ($productVariation) {
                $product = $variationDetails;
            } else {
                $product = Product::create($in);
            }


            // $in['summary']      = trim(e($importer->parse_digital_links($product, $importer->parse_tabs($row['short_description']))));
            // $in['description']  = trim(e($importer->parse_digital_links($product, $importer->parse_tabs($row['description']))));
            

            
            $product->title = $row['variation_3_title'];
            $product->sku = null;
            $product->tags = null;
            // $product->slug = make_slug($row['variation_3_title']);
            $product->current_price = $row['variation_3_regular_price'];
            $product->current_price_international = $row['variation_3_foreign_price'];
            $product->type = 'physical';


            // start: adding variation attributes
                $attributes = [];

                if ( isset( $row[ 'variation_3_attribute_1_name' ] ) ) {
                    $attributes[] = [
                        'name'      => $row[ 'variation_3_attribute_1_name' ],
                        'value'     => $row[ 'variation_3_attribute_1_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_3_attribute_2_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_3_attribute_2_name' ],
                        'value' => $row[ 'variation_3_attribute_2_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_3_attribute_3_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_3_attribute_3_name' ],
                        'value' => $row[ 'variation_3_attribute_3_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_3_attribute_4_name' ] ) ) {
                    $attributes[] = [
                        'name'    => $row[ 'variation_3_attribute_4_name' ],
                        'value'   => $row[ 'variation_3_attribute_4_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_3_attribute_5_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_3_attribute_5_name' ],
                        'value' => $row[ 'variation_3_attribute_5_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_3_attribute_6_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_3_attribute_6_name' ],
                        'value' => $row[ 'variation_3_attribute_6_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
            // end: adding variation attributes
            
            $product->attributes = json_encode( $attributes );
            $product->variation_data = json_encode( [
                'title' => $row['variation_3_title'],
                'value' => null,
                'type' => 'physical',
                'thumbnail' => $row['variation_3_thumbnail'],
            ] );


            if ($productVariation) {
                $product->update();
            } else {
                $product->save();
            }

            if (!$productVariation) {

                $parent = Product::find($product_id);

                if (is_null($parent->variations)) {
                    $parent->variations = $product->id;
                } else {
                    $parent->variations = $parent->variations . ',' . $product->id;
                }

                $parent->save();

                $lang = Language::where('code', 'en')->first();

                $abx = $lang->basic_extended;

                if ( is_null($abx->product_variations ) ) {
                    $global_variations = [];
                } else {
                    $global_variations = (array) json_decode( $abx->product_variations );
                }

                $global_variations[] = [
                    'product_id' => $parent->id,
                    'variation_id' => $product->id
                ];

                $abx->product_variations = json_encode( $global_variations );

                $abx->save();
            }
        }
        /* end: storing variation 3 details */


        /* start: storing variation 4 details */
        if ( isset( $row['variation_4_title'] ) ) {

            // modal init for variation check
                $productModel = Product::withoutGlobalScope('variation');
            // end modal init for variation check

            // first check if variation already exists then update previous else add new
            $variationDetails = $productModel->where('title', '=', $row['variation_4_title'])->first();
            $productVariation = $variationDetails?$product->whereRaw("FIND_IN_SET($variationDetails->id, variations) > 0")->first():null;

            if ($productVariation) {
                $product = $variationDetails;
            } else {
                $product = Product::create($in);
            }

            // $product = Product::create($in);


            // $in['summary']      = trim(e($importer->parse_digital_links($product, $importer->parse_tabs($row['short_description']))));
            // $in['description']  = trim(e($importer->parse_digital_links($product, $importer->parse_tabs($row['description']))));
            

            
            $product->title = $row['variation_4_title'];
            $product->sku = null;
            $product->tags = null;
            // $product->slug = make_slug($row['variation_4_title']);
            $product->current_price = $row['variation_4_regular_price'];
            $product->current_price_international = $row['variation_4_foreign_price'];
            $product->type = 'physical';


            // start: adding variation attributes
                $attributes = [];

                if ( isset( $row[ 'variation_4_attribute_1_name' ] ) ) {
                    $attributes[] = [
                        'name'      => $row[ 'variation_4_attribute_1_name' ],
                        'value'     => $row[ 'variation_4_attribute_1_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_4_attribute_2_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_4_attribute_2_name' ],
                        'value' => $row[ 'variation_4_attribute_2_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_4_attribute_3_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_4_attribute_3_name' ],
                        'value' => $row[ 'variation_4_attribute_3_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_4_attribute_4_name' ] ) ) {
                    $attributes[] = [
                        'name'    => $row[ 'variation_4_attribute_4_name' ],
                        'value'   => $row[ 'variation_4_attribute_4_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_4_attribute_5_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_4_attribute_5_name' ],
                        'value' => $row[ 'variation_4_attribute_5_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_4_attribute_6_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_4_attribute_6_name' ],
                        'value' => $row[ 'variation_4_attribute_6_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
            // end: adding variation attributes
            
            $product->attributes = json_encode( $attributes );
            $product->variation_data = json_encode( [
                'title' => $row['variation_4_title'],
                'value' => null,
                'type' => 'physical',
                'thumbnail' => $row['variation_4_thumbnail'],
            ] );


            if ($productVariation) {
                $product->update();
            } else {
                $product->save();
            }

            if (!$productVariation) {

                $parent = Product::find($product_id);

                if (is_null($parent->variations)) {
                    $parent->variations = $product->id;
                } else {
                    $parent->variations = $parent->variations . ',' . $product->id;
                }

                $parent->save();

                $lang = Language::where('code', 'en')->first();

                $abx = $lang->basic_extended;

                if ( is_null($abx->product_variations ) ) {
                    $global_variations = [];
                } else {
                    $global_variations = (array) json_decode( $abx->product_variations );
                }

                $global_variations[] = [
                    'product_id' => $parent->id,
                    'variation_id' => $product->id
                ];

                $abx->product_variations = json_encode( $global_variations );

                $abx->save();
            }
        }
        /* end: storing variation 4 details */


        /* start: storing variation 5 details */
        if ( isset( $row['variation_5_title'] ) ) {

            // modal init for variation check
                $productModel = Product::withoutGlobalScope('variation');
            // end modal init for variation check

            // first check if variation already exists then update previous else add new
            $variationDetails = $productModel->where('title', '=', $row['variation_5_title'])->first();
            $productVariation = $variationDetails?$product->whereRaw("FIND_IN_SET($variationDetails->id, variations) > 0")->first():null;

            if ($productVariation) {
                $product = $variationDetails;
            } else {
                $product = Product::create($in);
            }

            // $product = Product::create($in);


            // $in['summary']      = trim(e($importer->parse_digital_links($product, $importer->parse_tabs($row['short_description']))));
            // $in['description']  = trim(e($importer->parse_digital_links($product, $importer->parse_tabs($row['description']))));
            

            
            $product->title = $row['variation_5_title'];
            $product->sku = null;
            $product->tags = null;
            // $product->slug = make_slug($row['variation_1_title']);
            $product->current_price = $row['variation_5_regular_price'];
            $product->current_price_international = $row['variation_5_foreign_price'];
            $product->type = 'physical';


            // start: adding variation attributes
                $attributes = [];

                if ( isset( $row[ 'variation_5_attribute_1_name' ] ) ) {
                    $attributes[] = [
                        'name'      => $row[ 'variation_5_attribute_1_name' ],
                        'value'     => $row[ 'variation_5_attribute_1_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_5_attribute_2_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_5_attribute_2_name' ],
                        'value' => $row[ 'variation_5_attribute_2_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_5_attribute_3_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_5_attribute_3_name' ],
                        'value' => $row[ 'variation_5_attribute_3_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_5_attribute_4_name' ] ) ) {
                    $attributes[] = [
                        'name'    => $row[ 'variation_5_attribute_4_name' ],
                        'value'   => $row[ 'variation_5_attribute_4_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_5_attribute_5_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_5_attribute_5_name' ],
                        'value' => $row[ 'variation_5_attribute_5_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_5_attribute_6_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_5_attribute_6_name' ],
                        'value' => $row[ 'variation_5_attribute_6_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
            // end: adding variation attributes
            
            $product->attributes = json_encode( $attributes );
            $product->variation_data = json_encode( [
                'title' => $row['variation_5_title'],
                'value' => null,
                'type' => 'physical',
                'thumbnail' => $row['variation_5_thumbnail'],
            ] );


            if ($productVariation) {
                $product->update();
            } else {
                $product->save();
            }

            if (!$productVariation) {

                $parent = Product::find($product_id);

                if (is_null($parent->variations)) {
                    $parent->variations = $product->id;
                } else {
                    $parent->variations = $parent->variations . ',' . $product->id;
                }

                $parent->save();

                $lang = Language::where('code', 'en')->first();

                $abx = $lang->basic_extended;

                if ( is_null($abx->product_variations ) ) {
                    $global_variations = [];
                } else {
                    $global_variations = (array) json_decode( $abx->product_variations );
                }

                $global_variations[] = [
                    'product_id' => $parent->id,
                    'variation_id' => $product->id
                ];

                $abx->product_variations = json_encode( $global_variations );

                $abx->save();
            }
        }
        /* end: storing variation 5 details */


        /* start: storing variation 6 details */
        if ( isset( $row['variation_6_title'] ) ) {

            // modal init for variation check
                $productModel = Product::withoutGlobalScope('variation');
            // end modal init for variation check

            // first check if variation already exists then update previous else add new
            $variationDetails = $productModel->where('title', '=', $row['variation_6_title'])->first();
            $productVariation = $variationDetails?$product->whereRaw("FIND_IN_SET($variationDetails->id, variations) > 0")->first():null;

            if ($productVariation) {
                $product = $variationDetails;
            } else {
                $product = Product::create($in);
            }

            // $product = Product::create($in);

            
            $product->title = $row['variation_6_title'];
            $product->sku = null;
            $product->tags = null;
            // $product->slug = make_slug($row['variation_6_title']);
            $product->current_price = $row['variation_6_regular_price'];
            $product->current_price_international = $row['variation_6_foreign_price'];
            $product->type = 'physical';


            // start: adding variation attributes
                $attributes = [];

                if ( isset( $row[ 'variation_6_attribute_1_name' ] ) ) {
                    $attributes[] = [
                        'name'      => $row[ 'variation_6_attribute_1_name' ],
                        'value'     => $row[ 'variation_6_attribute_1_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_6_attribute_2_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_6_attribute_2_name' ],
                        'value' => $row[ 'variation_6_attribute_2_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_6_attribute_3_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_6_attribute_3_name' ],
                        'value' => $row[ 'variation_6_attribute_3_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_6_attribute_4_name' ] ) ) {
                    $attributes[] = [
                        'name'    => $row[ 'variation_6_attribute_4_name' ],
                        'value'   => $row[ 'variation_6_attribute_4_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_6_attribute_5_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_6_attribute_5_name' ],
                        'value' => $row[ 'variation_6_attribute_5_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_6_attribute_6_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_6_attribute_6_name' ],
                        'value' => $row[ 'variation_6_attribute_6_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
            // end: adding variation attributes
            
            $product->attributes = json_encode( $attributes );
            $product->variation_data = json_encode( [
                'title' => $row['variation_6_title'],
                'value' => null,
                'type' => 'physical',
                'thumbnail' => $row['variation_6_thumbnail'],
            ] );


            if ($productVariation) {
                $product->update();
            } else {
                $product->save();
            }

            if (!$productVariation) {

                $parent = Product::find($product_id);

                if (is_null($parent->variations)) {
                    $parent->variations = $product->id;
                } else {
                    $parent->variations = $parent->variations . ',' . $product->id;
                }

                $parent->save();

                $lang = Language::where('code', 'en')->first();

                $abx = $lang->basic_extended;

                if ( is_null($abx->product_variations ) ) {
                    $global_variations = [];
                } else {
                    $global_variations = (array) json_decode( $abx->product_variations );
                }

                $global_variations[] = [
                    'product_id' => $parent->id,
                    'variation_id' => $product->id
                ];

                $abx->product_variations = json_encode( $global_variations );

                $abx->save();
            }
        }
        /* end: storing variation 6 details */


        /* start: storing variation 7 details */
        if ( isset( $row['variation_7_title'] ) ) {

            // modal init for variation check
                $productModel = Product::withoutGlobalScope('variation');
            // end modal init for variation check

            // first check if variation already exists then update previous else add new
            $variationDetails = $productModel->where('title', '=', $row['variation_7_title'])->first();
            $productVariation = $variationDetails?$product->whereRaw("FIND_IN_SET($variationDetails->id, variations) > 0")->first():null;

            if ($productVariation) {
                $product = $variationDetails;
            } else {
                $product = Product::create($in);
            }

            // $product = Product::create($in);

            
            $product->title = $row['variation_7_title'];
            $product->sku = null;
            $product->tags = null;
            // $product->slug = make_slug($row['variation_7_title']);
            $product->current_price = $row['variation_7_regular_price'];
            $product->current_price_international = $row['variation_7_foreign_price'];
            $product->type = 'physical';


            // start: adding variation attributes
                $attributes = [];

                if ( isset( $row[ 'variation_7_attribute_1_name' ] ) ) {
                    $attributes[] = [
                        'name'      => $row[ 'variation_7_attribute_1_name' ],
                        'value'     => $row[ 'variation_7_attribute_1_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_7_attribute_2_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_7_attribute_2_name' ],
                        'value' => $row[ 'variation_7_attribute_2_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_7_attribute_3_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_7_attribute_3_name' ],
                        'value' => $row[ 'variation_7_attribute_3_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_7_attribute_4_name' ] ) ) {
                    $attributes[] = [
                        'name'    => $row[ 'variation_7_attribute_4_name' ],
                        'value'   => $row[ 'variation_7_attribute_4_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_7_attribute_5_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_7_attribute_5_name' ],
                        'value' => $row[ 'variation_7_attribute_5_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_7_attribute_6_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_7_attribute_6_name' ],
                        'value' => $row[ 'variation_7_attribute_6_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
            // end: adding variation attributes
            
            $product->attributes = json_encode( $attributes );
            $product->variation_data = json_encode( [
                'title' => $row['variation_7_title'],
                'value' => null,
                'type' => 'physical',
                'thumbnail' => $row['variation_7_thumbnail'],
            ] );


            if ($productVariation) {
                $product->update();
            } else {
                $product->save();
            }

            if (!$productVariation) {

                $parent = Product::find($product_id);

                if (is_null($parent->variations)) {
                    $parent->variations = $product->id;
                } else {
                    $parent->variations = $parent->variations . ',' . $product->id;
                }

                $parent->save();

                $lang = Language::where('code', 'en')->first();

                $abx = $lang->basic_extended;

                if ( is_null($abx->product_variations ) ) {
                    $global_variations = [];
                } else {
                    $global_variations = (array) json_decode( $abx->product_variations );
                }

                $global_variations[] = [
                    'product_id' => $parent->id,
                    'variation_id' => $product->id
                ];

                $abx->product_variations = json_encode( $global_variations );

                $abx->save();
            }
        }
        /* end: storing variation 7 details */



        /* start: storing variation 8 details */
        if ( isset( $row['variation_8_title'] ) ) {

            // modal init for variation check
                $productModel = Product::withoutGlobalScope('variation');
            // end modal init for variation check

            // first check if variation already exists then update previous else add new
            $variationDetails = $productModel->where('title', '=', $row['variation_8_title'])->first();
            $productVariation = $variationDetails?$product->whereRaw("FIND_IN_SET($variationDetails->id, variations) > 0")->first():null;
            
            if ($productVariation) {
                $product = $variationDetails;
            } else {
                $product = Product::create($in);
            }

            // $product = Product::create($in);

            
            $product->title = $row['variation_8_title'];
            $product->sku = null;
            $product->tags = null;
            // $product->slug = make_slug($row['variation_8_title']);
            $product->current_price = $row['variation_8_regular_price'];
            $product->current_price_international = $row['variation_8_foreign_price'];
            $product->type = 'physical';


            // start: adding variation attributes
                $attributes = [];

                if ( isset( $row[ 'variation_8_attribute_1_name' ] ) ) {
                    $attributes[] = [
                        'name'      => $row[ 'variation_8_attribute_1_name' ],
                        'value'     => $row[ 'variation_8_attribute_1_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_8_attribute_2_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_8_attribute_2_name' ],
                        'value' => $row[ 'variation_8_attribute_2_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_8_attribute_3_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_8_attribute_3_name' ],
                        'value' => $row[ 'variation_8_attribute_3_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_8_attribute_4_name' ] ) ) {
                    $attributes[] = [
                        'name'    => $row[ 'variation_8_attribute_4_name' ],
                        'value'   => $row[ 'variation_8_attribute_4_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_8_attribute_5_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_8_attribute_5_name' ],
                        'value' => $row[ 'variation_8_attribute_5_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_8_attribute_6_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_8_attribute_6_name' ],
                        'value' => $row[ 'variation_8_attribute_6_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
            // end: adding variation attributes
            
            $product->attributes = json_encode( $attributes );
            $product->variation_data = json_encode( [
                'title' => $row['variation_8_title'],
                'value' => null,
                'type' => 'physical',
                'thumbnail' => $row['variation_8_thumbnail'],
            ] );


            if ($productVariation) {
                $product->update();
            } else {
                $product->save();
            }

            if (!$productVariation) {

                $parent = Product::find($product_id);

                if (is_null($parent->variations)) {
                    $parent->variations = $product->id;
                } else {
                    $parent->variations = $parent->variations . ',' . $product->id;
                }

                $parent->save();

                $lang = Language::where('code', 'en')->first();

                $abx = $lang->basic_extended;

                if ( is_null($abx->product_variations ) ) {
                    $global_variations = [];
                } else {
                    $global_variations = (array) json_decode( $abx->product_variations );
                }

                $global_variations[] = [
                    'product_id' => $parent->id,
                    'variation_id' => $product->id
                ];

                $abx->product_variations = json_encode( $global_variations );

                $abx->save();
            }
        }
        /* end: storing variation 8 details */


        /* start: storing variation 9 details */
        if ( isset( $row['variation_9_title'] ) ) {

            // modal init for variation check
                $productModel = Product::withoutGlobalScope('variation');
            // end modal init for variation check

            // first check if variation already exists then update previous else add new
            $variationDetails = $productModel->where('title', '=', $row['variation_9_title'])->first();
            $productVariation = $variationDetails?$product->whereRaw("FIND_IN_SET($variationDetails->id, variations) > 0")->first():null;

            if ($productVariation) {
                $product = $variationDetails;
            } else {
                $product = Product::create($in);
            }

            // $product = Product::create($in);

            
            $product->title = $row['variation_9_title'];
            $product->sku = null;
            $product->tags = null;
            // $product->slug = make_slug($row['variation_9_title']);
            $product->current_price = $row['variation_9_regular_price'];
            $product->current_price_international = $row['variation_9_foreign_price'];
            $product->type = 'physical';


            // start: adding variation attributes
                $attributes = [];

                if ( isset( $row[ 'variation_9_attribute_1_name' ] ) ) {
                    $attributes[] = [
                        'name'      => $row[ 'variation_9_attribute_1_name' ],
                        'value'     => $row[ 'variation_9_attribute_1_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_9_attribute_2_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_9_attribute_2_name' ],
                        'value' => $row[ 'variation_9_attribute_2_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_9_attribute_3_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_9_attribute_3_name' ],
                        'value' => $row[ 'variation_9_attribute_3_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_9_attribute_4_name' ] ) ) {
                    $attributes[] = [
                        'name'    => $row[ 'variation_9_attribute_4_name' ],
                        'value'   => $row[ 'variation_9_attribute_4_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_9_attribute_5_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_9_attribute_5_name' ],
                        'value' => $row[ 'variation_9_attribute_5_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_9_attribute_6_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_9_attribute_6_name' ],
                        'value' => $row[ 'variation_9_attribute_6_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
            // end: adding variation attributes
            
            $product->attributes = json_encode( $attributes );
            $product->variation_data = json_encode( [
                'title' => $row['variation_9_title'],
                'value' => null,
                'type' => 'physical',
                'thumbnail' => $row['variation_9_thumbnail'],
            ] );


            if ($productVariation) {
                $product->update();
            } else {
                $product->save();
            }

            if (!$productVariation) {

                $parent = Product::find($product_id);

                if (is_null($parent->variations)) {
                    $parent->variations = $product->id;
                } else {
                    $parent->variations = $parent->variations . ',' . $product->id;
                }

                $parent->save();

                $lang = Language::where('code', 'en')->first();

                $abx = $lang->basic_extended;

                if ( is_null($abx->product_variations ) ) {
                    $global_variations = [];
                } else {
                    $global_variations = (array) json_decode( $abx->product_variations );
                }

                $global_variations[] = [
                    'product_id' => $parent->id,
                    'variation_id' => $product->id
                ];

                $abx->product_variations = json_encode( $global_variations );

                $abx->save();
            }
        }
        /* end: storing variation 9 details */

        /* start: storing variation 10 details */
        if ( isset( $row['variation_10_title'] ) ) {

            // modal init for variation check
                $productModel = Product::withoutGlobalScope('variation');
            // end modal init for variation check

            // first check if variation already exists then update previous else add new
            $variationDetails = $productModel->where('title', '=', $row['variation_10_title'])->first();
            $productVariation = $variationDetails?$product->whereRaw("FIND_IN_SET($variationDetails->id, variations) > 0")->first():null;

            if ($productVariation) {
                $product = $variationDetails;
            } else {
                $product = Product::create($in);
            }

            // $product = Product::create($in);

            
            $product->title = $row['variation_10_title'];
            $product->sku = null;
            $product->tags = null;
            // $product->slug = make_slug($row['variation_10_title']);
            $product->current_price = $row['variation_10_regular_price'];
            $product->current_price_international = $row['variation_10_foreign_price'];
            $product->type = 'physical';


            // start: adding variation attributes
                $attributes = [];

                if ( isset( $row[ 'variation_10_attribute_1_name' ] ) ) {
                    $attributes[] = [
                        'name'      => $row[ 'variation_10_attribute_1_name' ],
                        'value'     => $row[ 'variation_10_attribute_1_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_10_attribute_2_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_10_attribute_2_name' ],
                        'value' => $row[ 'variation_10_attribute_2_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_10_attribute_3_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_10_attribute_3_name' ],
                        'value' => $row[ 'variation_10_attribute_3_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_10_attribute_4_name' ] ) ) {
                    $attributes[] = [
                        'name'    => $row[ 'variation_10_attribute_4_name' ],
                        'value'   => $row[ 'variation_10_attribute_4_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_10_attribute_5_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_10_attribute_5_name' ],
                        'value' => $row[ 'variation_10_attribute_5_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_10_attribute_6_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_10_attribute_6_name' ],
                        'value' => $row[ 'variation_10_attribute_6_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
            // end: adding variation attributes
            
            $product->attributes = json_encode( $attributes );
            $product->variation_data = json_encode( [
                'title' => $row['variation_10_title'],
                'value' => null,
                'type' => 'physical',
                'thumbnail' => $row['variation_10_thumbnail'],
            ] );


            if ($productVariation) {
                $product->update();
            } else {
                $product->save();
            }

            if (!$productVariation) {

                $parent = Product::find($product_id);

                if (is_null($parent->variations)) {
                    $parent->variations = $product->id;
                } else {
                    $parent->variations = $parent->variations . ',' . $product->id;
                }

                $parent->save();

                $lang = Language::where('code', 'en')->first();

                $abx = $lang->basic_extended;

                if ( is_null($abx->product_variations ) ) {
                    $global_variations = [];
                } else {
                    $global_variations = (array) json_decode( $abx->product_variations );
                }

                $global_variations[] = [
                    'product_id' => $parent->id,
                    'variation_id' => $product->id
                ];

                $abx->product_variations = json_encode( $global_variations );

                $abx->save();
            }
        }
        /* end: storing variation 10 details */


        /* start: storing variation 11 details */
        if ( isset( $row[ 'variation_11_title' ] ) ) {
            dd($row['variation_11_title']);
            // modal init for variation check
                $productModel = Product::withoutGlobalScope('variation');
            // end modal init for variation check

            // first check if variation already exists then update previous else add new
            $variationDetails = $productModel->where('title', '=', $row['variation_11_title'])->first();
            $productVariation = $variationDetails?$product->whereRaw("FIND_IN_SET($variationDetails->id, variations) > 0")->first():null;

            if ($productVariation) {
                $product = $variationDetails;
            } else {
                $product = Product::create($in);
            }

            // $product = Product::create($in);

            
            $product->title = $row['variation_11_title'];
            $product->sku = null;
            $product->tags = null;
            // $product->slug = make_slug($row['variation_11_title']);
            $product->current_price = $row['variation_11_regular_price'];
            $product->current_price_international = $row['variation_11_foreign_price'];
            $product->type = 'physical';


            // start: adding variation attributes
                $attributes = [];

                if ( isset( $row[ 'variation_11_attribute_1_name' ] ) ) {
                    $attributes[] = [
                        'name'      => $row[ 'variation_11_attribute_1_name' ],
                        'value'     => $row[ 'variation_11_attribute_1_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_11_attribute_2_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_11_attribute_2_name' ],
                        'value' => $row[ 'variation_11_attribute_2_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_11_attribute_3_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_11_attribute_3_name' ],
                        'value' => $row[ 'variation_11_attribute_3_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_11_attribute_4_name' ] ) ) {
                    $attributes[] = [
                        'name'    => $row[ 'variation_11_attribute_4_name' ],
                        'value'   => $row[ 'variation_11_attribute_4_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_11_attribute_5_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_11_attribute_5_name' ],
                        'value' => $row[ 'variation_11_attribute_5_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_11_attribute_6_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_11_attribute_6_name' ],
                        'value' => $row[ 'variation_11_attribute_6_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
            // end: adding variation attributes
            
            $product->attributes = json_encode( $attributes );
            $product->variation_data = json_encode( [
                'title' => $row['variation_11_title'],
                'value' => null,
                'type' => 'physical',
                'thumbnail' => $row['variation_11_thumbnail'],
            ] );


            if ($productVariation) {
                $product->update();
            } else {
                $product->save();
            }

            if (!$productVariation) {

                $parent = Product::find($product_id);

                if (is_null($parent->variations)) {
                    $parent->variations = $product->id;
                } else {
                    $parent->variations = $parent->variations . ',' . $product->id;
                }

                $parent->save();

                $lang = Language::where('code', 'en')->first();

                $abx = $lang->basic_extended;

                if ( is_null($abx->product_variations ) ) {
                    $global_variations = [];
                } else {
                    $global_variations = (array) json_decode( $abx->product_variations );
                }

                $global_variations[] = [
                    'product_id' => $parent->id,
                    'variation_id' => $product->id
                ];

                $abx->product_variations = json_encode( $global_variations );

                $abx->save();
            }
        }
        /* end: storing variation 11 details */


        /* start: storing variation 12 details */
        if ( isset( $row[ 'variation_12_title' ] ) ) {

            // modal init for variation check
                $productModel = Product::withoutGlobalScope('variation');
            // end modal init for variation check

            // first check if variation already exists then update previous else add new
            $variationDetails = $productModel->where('title', '=', $row['variation_12_title'])->first();
            $productVariation = $variationDetails?$product->whereRaw("FIND_IN_SET($variationDetails->id, variations) > 0")->first():null;

            if ($productVariation) {
                $product = $variationDetails;
            } else {
                $product = Product::create($in);
            }

            // $product = Product::create($in);

            
            $product->title = $row['variation_12_title'];
            $product->sku = null;
            $product->tags = null;
            // $product->slug = make_slug($row['variation_12_title']);
            $product->current_price = $row['variation_12_regular_price'];
            $product->current_price_international = $row['variation_12_foreign_price'];
            $product->type = 'physical';


            // start: adding variation attributes
                $attributes = [];

                if ( isset( $row[ 'variation_12_attribute_1_name' ] ) ) {
                    $attributes[] = [
                        'name'      => $row[ 'variation_12_attribute_1_name' ],
                        'value'     => $row[ 'variation_12_attribute_1_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_12_attribute_2_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_12_attribute_2_name' ],
                        'value' => $row[ 'variation_12_attribute_2_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_12_attribute_3_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_12_attribute_3_name' ],
                        'value' => $row[ 'variation_12_attribute_3_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_12_attribute_4_name' ] ) ) {
                    $attributes[] = [
                        'name'    => $row[ 'variation_12_attribute_4_name' ],
                        'value'   => $row[ 'variation_12_attribute_4_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_12_attribute_5_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_12_attribute_5_name' ],
                        'value' => $row[ 'variation_12_attribute_5_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_12_attribute_6_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_12_attribute_6_name' ],
                        'value' => $row[ 'variation_12_attribute_6_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
            // end: adding variation attributes
            
            $product->attributes = json_encode( $attributes );
            $product->variation_data = json_encode( [
                'title' => $row['variation_12_title'],
                'value' => null,
                'type' => 'physical',
                'thumbnail' => $row['variation_12_thumbnail'],
            ] );


            if ($productVariation) {
                $product->update();
            } else {
                $product->save();
            }

            if (!$productVariation) {

                $parent = Product::find($product_id);

                if (is_null($parent->variations)) {
                    $parent->variations = $product->id;
                } else {
                    $parent->variations = $parent->variations . ',' . $product->id;
                }

                $parent->save();

                $lang = Language::where('code', 'en')->first();

                $abx = $lang->basic_extended;

                if ( is_null($abx->product_variations ) ) {
                    $global_variations = [];
                } else {
                    $global_variations = (array) json_decode( $abx->product_variations );
                }

                $global_variations[] = [
                    'product_id' => $parent->id,
                    'variation_id' => $product->id
                ];

                $abx->product_variations = json_encode( $global_variations );

                $abx->save();
            }
        }
        /* end: storing variation 12 details */


        /* start: storing variation 13 details */
        if ( isset( $row[ 'variation_13_title' ] ) ) {

            // modal init for variation check
                $productModel = Product::withoutGlobalScope('variation');
            // end modal init for variation check

            // first check if variation already exists then update previous else add new
            $variationDetails = $productModel->where('title', '=', $row['variation_13_title'])->first();
            $productVariation = $variationDetails?$product->whereRaw("FIND_IN_SET($variationDetails->id, variations) > 0")->first():null;

            if ($productVariation) {
                $product = $variationDetails;
            } else {
                $product = Product::create($in);
            }

            // $product = Product::create($in);

            
            $product->title = $row['variation_13_title'];
            $product->sku = null;
            $product->tags = null;
            // $product->slug = make_slug($row['variation_13_title']);
            $product->current_price = $row['variation_13_regular_price'];
            $product->current_price_international = $row['variation_13_foreign_price'];
            $product->type = 'physical';


            // start: adding variation attributes
                $attributes = [];

                if ( isset( $row[ 'variation_13_attribute_1_name' ] ) ) {
                    $attributes[] = [
                        'name'      => $row[ 'variation_13_attribute_1_name' ],
                        'value'     => $row[ 'variation_13_attribute_1_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_13_attribute_2_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_13_attribute_2_name' ],
                        'value' => $row[ 'variation_13_attribute_2_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_13_attribute_3_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_13_attribute_3_name' ],
                        'value' => $row[ 'variation_13_attribute_3_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_13_attribute_4_name' ] ) ) {
                    $attributes[] = [
                        'name'    => $row[ 'variation_13_attribute_4_name' ],
                        'value'   => $row[ 'variation_13_attribute_4_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_13_attribute_5_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_13_attribute_5_name' ],
                        'value' => $row[ 'variation_13_attribute_5_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_13_attribute_6_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_13_attribute_6_name' ],
                        'value' => $row[ 'variation_13_attribute_6_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
            // end: adding variation attributes
            
            $product->attributes = json_encode( $attributes );
            $product->variation_data = json_encode( [
                'title' => $row['variation_13_title'],
                'value' => null,
                'type' => 'physical',
                'thumbnail' => $row['variation_13_thumbnail'],
            ] );


            if ($productVariation) {
                $product->update();
            } else {
                $product->save();
            }

            if (!$productVariation) {

                $parent = Product::find($product_id);

                if (is_null($parent->variations)) {
                    $parent->variations = $product->id;
                } else {
                    $parent->variations = $parent->variations . ',' . $product->id;
                }

                $parent->save();

                $lang = Language::where('code', 'en')->first();

                $abx = $lang->basic_extended;

                if ( is_null($abx->product_variations ) ) {
                    $global_variations = [];
                } else {
                    $global_variations = (array) json_decode( $abx->product_variations );
                }

                $global_variations[] = [
                    'product_id' => $parent->id,
                    'variation_id' => $product->id
                ];

                $abx->product_variations = json_encode( $global_variations );

                $abx->save();
            }
        }
        /* end: storing variation 13 details */


        /* start: storing variation 14 details */
        if ( isset( $row[ 'variation_14_title' ] ) ) {

            // modal init for variation check
                $productModel = Product::withoutGlobalScope('variation');
            // end modal init for variation check

            // first check if variation already exists then update previous else add new
            $variationDetails = $productModel->where('title', '=', $row['variation_14_title'])->first();
            $productVariation = $variationDetails?$product->whereRaw("FIND_IN_SET($variationDetails->id, variations) > 0")->first():null;

            if ($productVariation) {
                $product = $variationDetails;
            } else {
                $product = Product::create($in);
            }

            // $product = Product::create($in);

            
            $product->title = $row['variation_14_title'];
            $product->sku = null;
            $product->tags = null;
            // $product->slug = make_slug($row['variation_14_title']);
            $product->current_price = $row['variation_14_regular_price'];
            $product->current_price_international = $row['variation_14_foreign_price'];
            $product->type = 'physical';


            // start: adding variation attributes
                $attributes = [];

                if ( isset( $row[ 'variation_14_attribute_1_name' ] ) ) {
                    $attributes[] = [
                        'name'      => $row[ 'variation_14_attribute_1_name' ],
                        'value'     => $row[ 'variation_14_attribute_1_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_14_attribute_2_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_14_attribute_2_name' ],
                        'value' => $row[ 'variation_14_attribute_2_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_14_attribute_3_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_14_attribute_3_name' ],
                        'value' => $row[ 'variation_14_attribute_3_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_14_attribute_4_name' ] ) ) {
                    $attributes[] = [
                        'name'    => $row[ 'variation_14_attribute_4_name' ],
                        'value'   => $row[ 'variation_14_attribute_4_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_14_attribute_5_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_14_attribute_5_name' ],
                        'value' => $row[ 'variation_14_attribute_5_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_14_attribute_6_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_14_attribute_6_name' ],
                        'value' => $row[ 'variation_14_attribute_6_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
            // end: adding variation attributes
            
            $product->attributes = json_encode( $attributes );
            $product->variation_data = json_encode( [
                'title' => $row['variation_14_title'],
                'value' => null,
                'type' => 'physical',
                'thumbnail' => $row['variation_14_thumbnail'],
            ] );


            if ($productVariation) {
                $product->update();
            } else {
                $product->save();
            }

            if (!$productVariation) {

                $parent = Product::find($product_id);

                if (is_null($parent->variations)) {
                    $parent->variations = $product->id;
                } else {
                    $parent->variations = $parent->variations . ',' . $product->id;
                }

                $parent->save();

                $lang = Language::where('code', 'en')->first();

                $abx = $lang->basic_extended;

                if ( is_null($abx->product_variations ) ) {
                    $global_variations = [];
                } else {
                    $global_variations = (array) json_decode( $abx->product_variations );
                }

                $global_variations[] = [
                    'product_id' => $parent->id,
                    'variation_id' => $product->id
                ];

                $abx->product_variations = json_encode( $global_variations );

                $abx->save();
            }
        }
        /* end: storing variation 14 details */


        /* start: storing variation 15 details */
        if ( isset( $row[ 'variation_15_title' ] ) ) {

            // modal init for variation check
                $productModel = Product::withoutGlobalScope('variation');
            // end modal init for variation check

            // first check if variation already exists then update previous else add new
            $variationDetails = $productModel->where('title', '=', $row['variation_15_title'])->first();
            $productVariation = $variationDetails?$product->whereRaw("FIND_IN_SET($variationDetails->id, variations) > 0")->first():null;

            if ($productVariation) {
                $product = $variationDetails;
            } else {
                $product = Product::create($in);
            }

            // $product = Product::create($in);

            
            $product->title = $row['variation_15_title'];
            $product->sku = null;
            $product->tags = null;
            // $product->slug = make_slug($row['variation_15_title']);
            $product->current_price = $row['variation_15_regular_price'];
            $product->current_price_international = $row['variation_15_foreign_price'];
            $product->type = 'physical';


            // start: adding variation attributes
                $attributes = [];

                if ( isset( $row[ 'variation_15_attribute_1_name' ] ) ) {
                    $attributes[] = [
                        'name'      => $row[ 'variation_15_attribute_1_name' ],
                        'value'     => $row[ 'variation_15_attribute_1_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_15_attribute_2_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_15_attribute_2_name' ],
                        'value' => $row[ 'variation_15_attribute_2_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_15_attribute_3_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_15_attribute_3_name' ],
                        'value' => $row[ 'variation_15_attribute_3_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_15_attribute_4_name' ] ) ) {
                    $attributes[] = [
                        'name'    => $row[ 'variation_15_attribute_4_name' ],
                        'value'   => $row[ 'variation_15_attribute_4_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_15_attribute_5_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_15_attribute_5_name' ],
                        'value' => $row[ 'variation_15_attribute_5_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
                if ( isset( $row[ 'variation_15_attribute_6_name' ] ) ) {
                    $attributes[] = [
                        'name' => $row[ 'variation_15_attribute_6_name' ],
                        'value' => $row[ 'variation_15_attribute_6_value'],
                        'visible'   => 1,
                        'global'    => 1
                    ];
                }
            // end: adding variation attributes
            
            $product->attributes = json_encode( $attributes );
            $product->variation_data = json_encode( [
                'title' => $row['variation_15_title'],
                'value' => null,
                'type' => 'physical',
                'thumbnail' => $row['variation_15_thumbnail'],
            ] );


            if ($productVariation) {
                $product->update();
            } else {
                $product->save();
            }

            if (!$productVariation) {

                $parent = Product::find($product_id);

                if (is_null($parent->variations)) {
                    $parent->variations = $product->id;
                } else {
                    $parent->variations = $parent->variations . ',' . $product->id;
                }

                $parent->save();

                $lang = Language::where('code', 'en')->first();

                $abx = $lang->basic_extended;

                if ( is_null($abx->product_variations ) ) {
                    $global_variations = [];
                } else {
                    $global_variations = (array) json_decode( $abx->product_variations );
                }

                $global_variations[] = [
                    'product_id' => $parent->id,
                    'variation_id' => $product->id
                ];

                $abx->product_variations = json_encode( $global_variations );

                $abx->save();
            }
        }
        /* end: storing variation 15 details */
        
    }

    public function setProductTabs(Product $product, Array $row)
    {
        $tabs                   = [];

        for ($a=0; $a<20; $a++)
        {
            $tab_title          = "tab_".$a."_tittle";
            $tab_content        = "tab_".$a."_content";
            if ( isset( $row[$tab_title] ) && trim( $row[$tab_title] ) != '' ) {
                $tabs[]         = [
                    'title'     => $row[$tab_title],
                    'content'   => $row[$tab_content],
                ];
            }
        }
        $product->tabs      = json_encode( $tabs );

        $product->save();
    }


    public function setProductImages(Product $product, Array $row)
    {
        foreach ($product->product_images as $imp)
        {
            $imp->delete();
        }


        $image_links    = explode(',', $row['images'] );
        $sliders        = [];

        $product->feature_image = isset($image_links[0]) ? $this->parse_google_drive(trim($image_links[0])) : '';
        $product->save();

        //if(isset($image_links[0])) unset($image_links[0]); //prevent using main image in banner too
        $sliders        = $image_links;


        foreach ($sliders as $slider)
        {
            $pi             = new ProductImage;
            $pi->product_id = $product->id;
            $pi->image      = $this->parse_google_drive(trim($slider));
            $pi->save();
        }

        $product->save();


    }


    public function parse_google_drive($link): string
    {
        try
        {
            ///parse Url
            $url    = parse_url(trim($link));

            if($url['host'] == "drive.google.com")
            {
                //process google link
                $url_array  = explode("/", $url['path']);
                $file_id    = trim($url_array[3]);

                //return "https://drive.google.com/uc?id=$file_id&export=download";
                return "https://drive.google.com/uc?id=$file_id";
            }
            return $link;
        }catch(\Exception $e){}
        return $link;
    }


    public function parse_tabs($html)
    {
        try
        {
            $html_template = '
            <table id="tabs-a">
            <tr>
                <td>t==111 Lorem ipsum.</td>
                <td>t==222 Lorem ipsum.</td>
                <td>t==333 Lorem ipsum.</td>
            </tr>
            <tr>
                <td>111==Lorem ipsum dolor sit.</td>
                <td>222==Lorem ipsum dolor sit amet, consectetur.</td>
                <td>333==Lorem ipsum dolor sit amet, consectetur adipisicing.</td>
            </tr>
            </table>
            <table id="tabs">
            <tr>
                <td>t1 Lorem ipsum.</td>
                <td>t2 Lorem ipsum.</td>
                <td>t3 Lorem ipsum.</td>
            </tr>
            <tr>
                <td>Lorem ipsum dolor sit.</td>
                <td>Lorem ipsum dolor sit amet, consectetur.</td>
                <td>Lorem ipsum dolor sit amet, consectetur adipisicing.</td>
            </tr>
            </table>
            <table id="tabs-z">
            <tr>
                <td>t111 Lorem ipsum.</td>
                <td>t222 Lorem ipsum.</td>
                <td>t333 Lorem ipsum.</td>
            </tr>
            <tr>
                <td>111Lorem ipsum dolor sit.</td>
                <td>222Lorem ipsum dolor sit amet, consectetur.</td>
                <td>333Lorem ipsum dolor sit amet, consectetur adipisicing.</td>
            </tr>
            </table>';


            $index          = 0;
            $html_t         = "";
            $html_d         = "";
            $html_x         = "";
            $titles         = array();
            $descriptions   = array();
            $crawler        = new Crawler($html);
            $crawler        = $crawler->filter('table#tabs > tr');
            $crawler_t_tr   = $crawler->eq(0);
            $crawler_d_tr   = $crawler->eq(1);

            foreach ($crawler_t_tr->filter('td') as $node) { array_push($titles, $node->nodeValue); }
            foreach ($crawler_d_tr->filter('td') as $node) { array_push($descriptions, $node->nodeValue); }


            foreach ($titles as $title)
            {
                $tab_id         = "tab-".rand(0, 777);
                $active_status  = $index == 0 ? " active " : "";
                $description    = isset($descriptions[$index]) ? $descriptions[$index] : "";
                $html_t         .= "<li class='nav-item'><a class='nav-link $active_status' data-toggle='tab' href='#$tab_id' role='tab'>$title</a></li>";
                $html_d         .= "<div class='tab-pane $active_status' id='$tab_id' role='tabpanel'>$description</div>";
                $index++;
            }
            $html_x .= "<ul class='nav nav-pills mb-3' role='tablist'>$html_t</ul>";
            $html_x .= "<div class='tab-content'>$html_d</div>";

            //////////////
//            $crawler        = new Crawler($html);
//            $a = $crawler->filter('table#tabs');
//            $b = $crawler->addContent('///////////');
//            return $b;
            /// ///////////

            return intval($index) >= 1 ? "<div class='py-2 pt-5'>$html_x</div>" : trim($html);
        }
        catch (\Exception $exception)
        { return trim($html); }
        return trim($html);
    }


    public function parse_digital_links(Product $product, string $string)
    {
        if (!Str::contains("$string", "**DL**")) /* $product->digital   = '0'; $product->save();*/ return trim($string);


        $lang               = Language::where('code', request()->has('language') ? request()->has('language') : 'en')->first();

        $bse                = BasicExtended::query();
        $bse->when($lang, function ($query) use ($lang){
            return $query->where('language_id', $lang->id);
        });
        $bse->orderBy('id', 'DESC');

        $data               = $bse->get()->first();
        // $product->digital   = '1';
        // $product->save();

        $digital_link       = $data->digital_resource_link;
        $digital_text       = $data->digital_resource_text;
        $digital_html       = "<a target='_blank' href='$digital_link' class='btn btn-link px-2'>$digital_text</a>";

        return  str_replace("**DL**", " $digital_html ", trim($string));
    }
}
