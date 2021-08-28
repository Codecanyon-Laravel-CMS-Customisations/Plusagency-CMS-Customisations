<?php

namespace AngelBooks\Plugins\Controllers;

use App\Product;
use App\Language;
use App\Pcategory;
use App\ChildCategory;
use App\Http\Controllers\Admin\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


    class ChildSubCategoriesController extends Controller {
        use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

        public function index(Request $request) {
            $lang = Language::where('code', $request->language)->first();
            $lang_id = $lang->id;
            $data['pcategories'] = Pcategory::with('parent_category')
            ->where('language_id', $lang_id)
            ->where('parent_menu_id', '!=', NULL)
            ->where('menu_level', '3')
            ->orderBy('id', 'DESC')->paginate(10);

            $data['parents'] = Pcategory::where('language_id', $lang_id)
            ->where('parent_menu_id', '!=', NULL)
            ->where('menu_level', '2')
            ->orderBy('name', 'ASC')
            ->pluck('id', 'name')
            ->prepend('', 'Please select');


            $data['lang_id'] = $lang_id;
            return view('plugins::sub-category',$data);
        }

        public function store(Request $request) {
            $messages = [
                'language_id.required' => 'The language field is required'
            ];

            $rules = [
                'parent_menu_id' => 'required|exists:pcategories,id',
                'language_id' => 'required',
                'name' => 'required|max:255',
                'status' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $errmsgs = $validator->getMessageBag()->add('error', 'true');
                return response()->json($validator->errors());
            }


            $data   = new Pcategory();
            $input  = $request->all();
            $input['slug'] =  make_slug($request->name);
            $input['is_child']      = 1;
            $input['menu_level']    = 3;
            $data->create($input);

            Session::flash('success', 'Category added successfully!');
            return "success";
        }

        public function edit($id)
        {
            $data['parents'] = Pcategory::where('parent_menu_id', '!=', NULL)
            ->where('menu_level', '2')
            ->orderBy('name', 'ASC')
            ->pluck('id', 'name')
            ;//->prepend('', 'Please select');

            $data['data']   = Pcategory::findOrFail($id);
            return view('plugins::category-edit',$data);
        }

        public function update(Request $request)
        {
            $data = Pcategory::findOrFail($request->category_id);
            $input = $request->all();
            $input['slug'] =  make_slug($request->name);
            $data->update($input);

            Session::flash('success', 'Category Update successfully!');
            return "success";
        }

        public function destroy(Request $request)
        {
            $category = Pcategory::findOrFail($request->category_id);
//        if ($category->products()->count() > 0) {
//            Session::flash('warning', 'First, delete all the product under the selected categories!');
//            return back();
//        }

            //$this->deleteFromMegaMenu($category);
            Product::where('sub_child_category_id', $category->id)->update(['sub_child_category_id' => NULL]);

            $category->delete();

            Session::flash('success', 'Category deleted successfully!');
            return back();
        }

        public function toggle_show_in_menu($id)
        {
            $product    = Pcategory::findOrFail($id);
            $new_value  = $product->show_in_menu == '1' ? 0 : 1;
            $product->show_in_menu  = $new_value;
            $product->save();

            session()->flash('success', $product->show_in_menu  == '1' ? 'Product category added to menu successfully!' : 'Product category removed from menu successfully!');
            return back();
        }

    }
