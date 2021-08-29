<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CategoryMenuBuilder;
use App\Language;
use App\Megamenu;
use App\Menu;
use App\Page;

class CategoryMenuBuilderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;

        // set language
        app()->setLocale($lang->code);

        $lang = Language::where('code', $request->language)->firstOrFail();

        $data['cats'] = $lang->pcategories()->where('status', 1)
                    ->where('parent_menu_id', NULL)
                    ->where('menu_level', '1')->select('id', 'name')->get();

        // get previous menus
        $menu = Menu::where('language_id', $lang->id)->where('is_product', 1)->first();
        $data['prevMenu'] = '';

        if (!empty($menu)) {
            $data['prevMenu'] = $menu->menus;
        }

        return view('admin.menu_builder.category_menus', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin\CategoryMenuBuilder  $categoryMenuBuilder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoryMenuBuilder $categoryMenuBuilder)
    {
        $menus = json_decode($request->str, true);
        foreach ($menus as $key => $menu) {
            if (strpos($menu['type'], 'megamenu') !== false) {
                if (array_key_exists('children', $menu) && !empty($menu['children'])) {
                    return response()->json(['status' => 'error', 'message' => 'Product Mega Menu cannot contain children!']);
                }
            }
            if (array_key_exists('children', $menu) && !empty($menu['children'])) {
                $allChildren = json_encode($menu['children']);
                if (strpos($allChildren, '-megamenu') !== false) {
                    return response()->json(['status' => 'error', 'message' => 'Product Mega Menu cannot be children of a Menu!']);
                }
            }
        }

        Menu::where('language_id', $request->language_id)->where('is_product', '!=', 0)->delete();

        $menu = new Menu;
        $menu->language_id = $request->language_id;
        $menu->menus = json_encode($menus);
        $menu->is_product = 1;
        $menu->save();

        return response()->json(['status' => 'success', 'message' => 'Product Menu updated successfully!']);
    }

    public function categorymegamenus(Request $request) {
        $lang = Language::where('code', $request->language)->firstOrFail();

        // for 'products' mega menu
        $data['cats'] = $lang->pcategories()->
                        where('status', 1)->
                        with('childs')->
                        get();
        $megamenu = Megamenu::where('language_id', $lang->id)->where('type', 'product_categories')->where('category', 1);
        $catStatus = 1;

        $data['lang'] = $lang;

        if ($megamenu->count() == 0) {
            $megamenu = new Megamenu;
            $megamenu->language_id = $lang->id;
            $megamenu->type = 'product_categories';
            $megamenu->menus = json_encode([]);
            $megamenu->category = $catStatus;
            $megamenu->save();
        } else {
            $megamenu = $megamenu->first();
        }
        $data['megamenu'] = $megamenu;
        $data['mmenus'] = json_decode($megamenu->menus, true);
        $data['subcat'] = json_decode($megamenu->subcat, true);

        return view('admin.menu_builder.categorymegamenus.categorymegamenus', $data);
    }

    public function megaMenuEdit(Request $request) {
        $lang = Language::where('code', $request->language)->firstOrFail();
        // for 'products' mega menu
        $data['cats'] = $lang->pcategories()->
                        where('status', 1)->
                        where('parent_menu_id', $request->category_id)->
                        get();
        $megamenu = Megamenu::where('language_id', $lang->id)->where('type', 'product_categories')->where('category', 1);
        $catStatus = 1;

        $data['lang'] = $lang;

        if ($megamenu->count() == 0) {
            $megamenu = new Megamenu;
            $megamenu->language_id = $lang->id;
            $megamenu->type = 'product_categories';
            $megamenu->menus = json_encode([]);
            $megamenu->category = $catStatus;
            $megamenu->save();
        } else {
            $megamenu = $megamenu->first();
        }
        $data['megamenu'] = $megamenu;
        $data['mmenus'] = json_decode($megamenu->menus, true);
        $data['subcat'] = json_decode($megamenu->subcat, true);
        // dd($data['mmenus']);
        return view('admin.menu_builder.categorymegamenus.edit', $data);
    }

    public function megaMenuUpdate(Request $request) {
        $menus = [];
        $subcats = [];
        $unique_subcat = [];
        $unique_menus = [];
        $items = $request->items;
        $subcat = $request->subcat;
        $langid = $request->language_id;
        if (!empty($items)) {
            foreach ($items as $key => $item) {
                $item = json_decode($item, true);
                $catid = $item[0];
                $menus["$catid"][] = $item[1];
            }

            $megamenu = Megamenu::where('language_id', $langid)->where('type', 'product_categories')->where('category', 1)->firstOrFail();
        }

        if(!empty($subcat)) {
            foreach ($subcat as $key => $value) {
                $catd = json_decode($value, true);
                $subcats[] = $catd;
            }
            $megamenu = Megamenu::where('language_id', $langid)->where('type', 'product_categories')->where('category', 1)->firstOrFail();
        }
        // if(!empty($megamenu)) {
        //     if(!empty($megamenu->subcat)) {
        //         $existing_subcats = json_decode($megamenu->subcat, true);
        //         $new_subcats = array_merge($existing_subcats, $subcats);
        //         $unique_subcat = array_unique($new_subcats, SORT_REGULAR);
        //     }
        //     else {
        //         $unique_subcat = $subcats;
        //     }

        //     if (!empty($megamenu->menus)) {
        //         $newmenus = [];
        //         $existing_menus = json_decode($megamenu->menus, true);
        //         foreach ($existing_menus as $key => $menu) {
        //             foreach ($menus as $key2 => $value2) {
        //                 if($key == $key2) {
        //                     $mergedArray = array_merge($menu, $value2);
        //                     $unqiueArray = array_unique($mergedArray, SORT_REGULAR);
        //                     $newmenus["$key"] = $unqiueArray;
        //                 }
        //                 else {
        //                     $newmenus["$key2"] = $value2;
        //                 }
        //             }
        //             $newmenus["$key"] = $menu;
        //         }
        //         $unique_menus = $newmenus;
        //     }
        //     else {
        //         $unique_menus = $menus;
        //     }
        // }
        // else {
        //     $unique_subcat = $subcats;
        //     $unique_menus = $menus;
        // }

        // dd($megamenu);

        $unique_menus = json_encode($menus);
        $unique_subcat = json_encode($subcats);
        $megamenu->menus = $unique_menus;
        $megamenu->subcat = $unique_subcat;
        $megamenu->save();

        $request->session()->flash('success', 'Product Mega Menu updated for Product Categories');
        return back();
    }

}
