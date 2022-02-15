<?php

namespace AngelBooks\Plugins\Controllers;

use App\Product;
use App\Language;
use App\Pcategory;
use App\ChildCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ChildCategoriesController extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request) {
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;
        $data['pcategories'] = Pcategory::with('parent_category')
        ->where('language_id', $lang_id)
        ->where('parent_menu_id', '!=', NULL)
        ->where('menu_level', '2')
        ->orderBy('id', 'DESC')->paginate(10);

        $data['parents'] = Pcategory::where('language_id', $lang_id)
        ->where('parent_menu_id', '=', NULL)
        ->where('menu_level', '1')
        ->orderBy('name', 'ASC')
        ->pluck('id', 'name')
        ->prepend('', 'Please select');


        $data['lang_id'] = $lang_id;
        return view('plugins::category',$data);
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
        $input['menu_level']    = 2;
        $data->create($input);

        Session::flash('success', 'Category added successfully!');
        return "success";
    }

    public function edit($id)
    {
        $data['parents'] = Pcategory::where('parent_menu_id', '=', NULL)
        ->where('menu_level', '1')
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
        $sub_child_ids  = Pcategory::query()->where('parent_menu_id', $category->id)->pluck('id');

        Product::where('sub_category_id', $category->id)->update(['sub_category_id' => NULL]);
        Product::whereIn('sub_child_category_id', $sub_child_ids)->update(['sub_child_category_id' => NULL]);

        foreach ($sub_child_ids as $id) {
            $pcategory = Pcategory::findOrFail($id);
            $pcategory->delete();
        }

        $category->delete();

        Session::flash('success', 'Category deleted successfully!');
        return back();
    }

}
