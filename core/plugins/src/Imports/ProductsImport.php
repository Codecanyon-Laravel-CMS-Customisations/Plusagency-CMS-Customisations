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

        if (strlen(trim(convertUtf8($row['name']))) > 1)
        {
            $product                = Product::firstOrCreate([
                'sku'               => trim(convertUtf8($row['sku'])),
                // 'status'    => 1,
            ]);

            $product_categories         = $this->setProductCategories($row);

            $parent_category            = $product_categories['parent_category'];
            $sub_category               = $product_categories['sub_category'];
            $sub_child_category         = $product_categories['sub_child_category'];


            $product->title             = convertUtf8($row['name']);
            $product->slug              = trim(Str::slug(convertUtf8($row['name'])));
            $product->language_id       = trim(169);
            $product->stock             = trim($row['stock']);
            $product->category_id       = trim($parent_category->id);
            $product->sub_category_id   = $sub_category ? trim($sub_category->id) : NULL;
            $product->sub_child_category_id     = $sub_child_category ? trim($sub_child_category->id) : NULL;
            $product->tags              = trim($row['tags']);
    //        $product->feature_image     = trim(explode(',', $row['images'])[0]);
            //$product->pending_images_download   = trim(trim($row['images']));
            $product->summary           = trim(e($this->parse_tabs($row['short_description'])));
            $product->description       = trim(e($this->parse_tabs($row['description'])));
            $product->current_price     = trim(trim(preg_replace("/[^\d\.]/", "", $row['regular_price'])) != "" ? preg_replace("/[^\d\.]/", "", $row['regular_price']) : '0.00');
            $product->is_feature        = trim($row['is_featured']);
            $product->status            = trim(1);
            $product->rating            = trim('0.00');
            $product->type              = trim('physical');
            $product->save();

             $this->setProductImages($product, $row);
            // $this->setChildSubCategory($product, $row);
            // $this->setProductAttributes($product, $row);
        }

    }

    public function setCategory(Product $product, Array $row)
    {
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
        if (!isset($row['sub_child_categories']))   $row['sub_child_categories'] = "Default Category";
        $category_col           = trim($row['categories']);
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

            return "<div class='py-2 pt-5'>$html_x</div>";
        }
        catch (\Exception $exception)
        { return $html; }
    }
}
