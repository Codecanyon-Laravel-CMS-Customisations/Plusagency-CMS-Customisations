<?php

namespace App\Http\Controllers\Admin;

use Session;
use Validator;
use App\Product;
use App\Language;
use App\Megamenu;
use App\Pcategory;
use App\BasicExtra;
use App\ProductImage;
use App\ProductOrder;
use App\ChildCategory;
use Illuminate\Support\Str;
use App\BasicExtended as BE;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['products'] = Product::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();
        $data['lang_id'] = $lang_id;
        return view('admin.product.index',$data);
    }


    public function type(Request $request) {
        $data['digitalCount'] = Product::where('type', 'digital')->count();
        $data['physicalCount'] = Product::where('type', 'physical')->count();
        return view('admin.product.type', $data);
    }


    public function create(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $abx = $lang->basic_extra;
        $product_fields = $lang->basic_extended->product_fields;
        //$categories = Pcategory::where('status',1)->get();
        $scategories = Pcategory::where('status',1)->where('is_child', 1)->get();


        $categories  = Pcategory::with('childs')
            ->where('language_id', $lang->id)
            ->where('status',1)->get();





        return view('admin.product.create',compact('categories','abx', 'product_fields', 'scategories'));
    }


    public function uploadUpdate(Request $request, $id)
    {
        $img = $request->file('file');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'file' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'slider']);
        }

        $product = Product::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/product/featured/', $filename);
            @unlink('assets/front/img/product/featured/' . $product->feature_image);
            $product->feature_image = $filename;
            $product->save();
        }

        return response()->json(['status' => "success", "image" => "Product image", 'product' => $product]);
    }


    public function getCategory(Request $request, $langid)
    {
//        $lang   = Language::where('id', $langid)->first();
//        $request['language']    = $lang->code;
//        return redirect()->route('admin.product.create');

        $category = Pcategory::with('childs')
            ->where('status',1)
            ->where('language_id', $langid)->get();
        return $category;
    }


    public function store(Request $request)
    {

        $lang = Language::where('code', 'en')->first();
        $custom_fields = $lang->basic_extended->product_fields;
        $product_fields = [];


        if($custom_fields){
            foreach ( json_decode( $custom_fields ) as $field) {
                $product_fields[] = [
                    'name' => $field->name,
                    'value' => $request->input( Str::slug( $field->name ) )
                ];
            }
        }

        if( $request->input('is_variation') ) {
            $in = $request->all();
            $in['language_id'] = 169;
            $in['is_variation'] = 1;

            $product = Product::create($in);
            $product->custom_fields = json_encode( $product_fields );
            // $featured_image = uniqid() .'.'.'png';
            $thubmnail = '';
            try {
                $thumbnail = $request->file('thumbnail')->store('front/img/product/featured', 'assets');
                // $thumbnail = Storage::disk('assets')->put( 'front/img/product/featured/', $request->thumbnail );
            } catch (\Exception $e) {}
            // $product->feature_image = $featured_image;
            $product->variation_data = json_encode( [
                'title' => $request->title,
                'value' => $request->value,
                'type' => $request->type,
                'thumbnail' => $thumbnail
            ] );
            $product->save();

            $parent = Product::find($request->input('product_id'));
            if (is_null($parent->variations)) {
                $parent->variations = $product->id;
            } else {
                $parent->variations = $parent->variations . ',' . $product->id;
            }

            $parent->save();

            $abx = $lang->basic_extended;

            if ( is_null($abx->product_variations ) ) {
                $global_variations = [];
            } else {
                $global_variations = (array) json_decode( $abx->product_variations );
            }

            // dd($global_variations);

            $global_variations[] = [
                'product_id' => $parent->id,
                'variation_id' => $product->id
            ];

            $abx->product_variations = json_encode( $global_variations );

            $abx->save();

            Session::flash('success', 'Product added successfully!');
            return "success";
        }


        $slug = make_slug($request->title);
        $bex = BasicExtra::firstOrFail();

        $sliders = !empty($request->slider) ? explode(',', $request->slider) : [];
        $featredImg = $request->featured_image;
        $extFeatured = pathinfo($featredImg, PATHINFO_EXTENSION);
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [];

        $rules = [
            'slider' => 'required',
            'language_id' => 'required',
            'title' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) use ($slug) {
                    $products = Product::all();
                    foreach ($products as $key => $product) {
                        if (strtolower($slug) == strtolower($product->slug)) {
                            $fail('The title field must be unique.');
                        }
                    }
                }
            ],
            'category_id' => 'required',
            'featured_image' => 'required',
            'status' => 'required'
        ];

        if ($bex->catalog_mode == 0) {
            $rules['current_price'] = 'required|numeric';
            $rules['previous_price'] = 'nullable|numeric';
        }

        if ($request->filled('slider')) {
            $rules['slider'] = [
                function ($attribute, $value, $fail) use ($sliders, $allowedExts) {
                    foreach ($sliders as $key => $slider) {
                        $extSlider = pathinfo($slider, PATHINFO_EXTENSION);
                        if (!in_array($extSlider, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg images are allowed");
                        }
                    }
                }
            ];
        }

        if ($request->filled('featured_image')) {
            $rules['featured_image'] = [
                function ($attribute, $value, $fail) use ($extFeatured, $allowedExts) {
                    if (!in_array($extFeatured, $allowedExts)) {
                        return $fail("Only png, jpg, jpeg image is allowed");
                    }
                }
            ];
        }

        // if product type is 'physical'
        if ($request->type == 'physical') {
            $rules['stock'] = 'required';
            $rules['sku'] = 'required|unique:products';
        }

        // if product type is 'digital'
        if ($request->type == 'digital') {
            $rules['file_type'] = 'required';

            // if 'file upload' is chosen
            if ($request->has('file_type') && $request->file_type == 'upload') {
                $allowedExts = array('zip');
                $rules['download_file'] = [
                    'required',
                    function ($attribute, $value, $fail) use ($request, $allowedExts) {
                        $file = $request->file('download_file');
                        $ext = $file->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only zip file is allowed");
                        }
                    }
                ];
            }
            // if 'file donwload link' is chosen
            elseif ($request->has('file_type') && $request->file_type == 'link') {
                $rules['download_link'] = 'required';
            }
        }

        $messages = [
            'language_id.required' => 'The language field is required',
            'category_id.required' => 'Category is required'
        ];


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $in = $request->all();
        $in['language_id'] = $request->language_id;
        $in['slug'] = $slug;

        // store featured image
        $filename = uniqid() .'.'. $extFeatured;
        @copy(str_replace(' ', '%20', $featredImg), 'assets/front/img/product/featured/' . $filename);
        $in['feature_image'] = $filename;

        // if the type is digital && 'upload file' method is selected, then store the downloadable file
        if ($request->type == 'digital' && $request->file_type == 'upload') {
            if ($request->hasFile('download_file')) {
                $digitalFile = $request->file('download_file');
                $filename = $slug . '-' . uniqid() . "." . $digitalFile->extension();
                $directory = 'core/storage/digital_products/';
                @mkdir($directory, 0775, true);
                $digitalFile->move($directory, $filename);

                $in['download_file'] = $filename;
            }
        }

        if ($request->type == 'physical') {
            $in['stock'] = $request->stock;
            $in['sku'] = $request->sku;
        }

        $in['description'] = str_replace(url('/') . '/assets/front/img/', "{base_url}/assets/front/img/", $request->description);

        $product = Product::create($in);
        $product->custom_fields = json_encode( $product_fields );
        $product->save();

        foreach ($sliders as $key => $slider) {
            $extSlider = pathinfo($slider, PATHINFO_EXTENSION);
            $filename = uniqid() .'.'. $extSlider;
            @copy(str_replace(' ', '%20', $slider), 'assets/front/img/product/sliders/' . $filename);

            $pi = new ProductImage;
            $pi->product_id = $product->id;
            $pi->image = $filename;
            $pi->save();
        }

        Session::flash('success', 'Product added successfully!');
        return "success";
    }


    public function edit(Request $request, $id)
    {
        $lang = Language::where('code', $request->language)->first();
        $abx = $lang->basic_extra;
        //$categories = $lang->pcategories()->where('status',1)->get();
        $scategories = $lang->pcategories()->where('status',1)->where('is_child', 1)->get();
        $product_fields = $lang->basic_extended->product_fields;
        $data = Product::findOrFail($id);
        $categories  = Pcategory::with('childs')
            ->where('language_id', $lang->id)
            ->where('status',1)->get();

        return view('admin.product.edit',compact('categories','data','abx', 'product_fields', 'scategories'));
    }

    public function images($portid)
    {
        $images = ProductImage::select('image')->where('product_id', $portid)->get();
        $convImages = [];

        foreach ($images as $key => $image) {
            // $convImages[] = url("assets/front/img/product/sliders/$image->image");
            $convImages[] = Str::startsWith($image->image, "http") ? url("$image->image") : url("assets/front/img/product/sliders/$image->image");
        }

        return $convImages;
    }

    public function update(Request $request)
    {
        $slug = make_slug($request->title);
        $product = Product::withoutGlobalScope('variation')->findOrFail($request->product_id);

        $lang = Language::where('code', 'en')->first();
        $custom_fields = $lang->basic_extended->product_fields;
        $product_fields = [];

        if($custom_fields){
            foreach ( json_decode( $custom_fields ) as $field) {
                $product_fields[] = [
                    'name' => $field->name,
                    'value' => $request->input( Str::slug( $field->name ) )
                ];
            }
        }

        $product->custom_fields = json_encode( $product_fields );
        if ($request->hasFile('thumbnail')) {
            try {

                // $thumbnail = Storage::disk('assets')->put( 'front/img/product/featured/', $request->thumbnail );
                $thumbnail = $request->file('thumbnail')->store('front/img/product/featured', 'assets');
            } catch (\Exception $e) {}
        } else {
            if ( !is_null($product->variation_data) ) {
                $thumbnail = json_decode($product->variation_data)->thumbnail;
            } else {
                $thumbnail = '';
            }
        }

        // $product->feature_image = $featured_image;
        $product->variation_data = json_encode( [
            'title' => $request->title,
            'value' => $request->value,
            'type' => $request->type,
            'thumbnail' => $thumbnail
        ] );
        $product->save();

        $productId = $product->id;

        $sliders = !empty($request->slider) ? explode(',', $request->slider) : [];
        $featredImg = $request->featured_image;
        $extFeatured = pathinfo($featredImg, PATHINFO_EXTENSION);
        $allowedExts = array('jpg', 'png', 'jpeg');

        if( ! $request->input('is_variation') ) {
            $rules = [
                'slider' => 'required',
                'title' => [
                    'required',
                    'max:255',
                    function ($attribute, $value, $fail) use ($slug, $productId) {
                        $products = Product::all();
                        foreach ($products as $key => $product) {
                            if ($product->id != $productId && strtolower($slug) == strtolower($product->slug)) {
                                $fail('The title field must be unique.');
                            }
                        }
                    }
                ],
                'category_id' => 'required',
                'status' => 'required'
            ];
            $bex = BasicExtra::firstOrFail();
            if ($bex->catalog_mode == 0) {
                $rules['current_price'] = 'required|numeric';
                $rules['previous_price'] = 'nullable|numeric';
            }

            if ($request->filled('slider')) {
                $rules['slider'] = [
                    function ($attribute, $value, $fail) use ($sliders, $allowedExts) {
                        foreach ($sliders as $key => $slider) {
                            $extSlider = pathinfo($slider, PATHINFO_EXTENSION);
                            if (!in_array($extSlider, $allowedExts)) {
                                return $fail("Only png, jpg, jpeg images are allowed");
                            }
                        }
                    }
                ];
            }

            if ($request->filled('featured_image')) {
                $rules['featured_image'] = [
                    function ($attribute, $value, $fail) use ($extFeatured, $allowedExts) {
                        if (!in_array($extFeatured, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                ];
            }

            // if product type is 'physical'
            if ($product->type == 'physical') {
                $rules['stock'] = 'required';
                $rules['sku'] = [
                    'required',
                    Rule::unique('products')->ignore($request->product_id),
                ];
            }

            // if product type is 'digital'
            if ($product->type == 'digital') {
                $rules['file_type'] = 'required';

                // if 'file upload' is chosen
                if ($request->has('file_type') && $request->file_type == 'upload') {

                    if (empty($product->download_file)) {
                        $rules['download_file'][] = 'required';
                    }
                    $rules['download_file'][] = function ($attribute, $value, $fail) use ($product, $request) {
                        $allowedExts = array('zip');
                        if ($request->hasFile('download_file')) {
                            $file = $request->file('download_file');
                            $ext = $file->getClientOriginalExtension();
                            if (!in_array($ext, $allowedExts)) {
                                return $fail("Only zip file is allowed");
                            }
                        }
                    };
                }
                // if 'file donwload link' is chosen
                elseif ($request->has('file_type') && $request->file_type == 'link') {
                    $rules['download_link'] = 'required';
                }
            }

            $messages = [
                'category_id.required' => 'Service is required',
                'description.min' => 'Description is required'
            ];



            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $errmsgs = $validator->getMessageBag()->add('error', 'true');
                return response()->json($validator->errors());
            }
        }

        $in = $request->all();
        $in['slug'] = $slug;

        // if the type is digital && 'link' method is selected, then store the downloadable file
        if ($product->type == 'digital' && $request->file_type == 'link') {
            @unlink('core/storage/digital_products/' . $product->download_file);
            $in['download_file'] = NULL;
        }

        // if the type is digital && 'upload file' method is selected, then store the downloadable file
        if ($product->type == 'digital' && $request->file_type == 'upload') {
            if ($request->hasFile('download_file')) {
                @unlink('core/storage/digital_products/' . $product->download_file);

                $digitalFile = $request->file('download_file');
                $filename = $slug . '-' . uniqid() . "." . $digitalFile->extension();
                $directory = 'core/storage/digital_products/';
                @mkdir($directory, 0775, true);
                $digitalFile->move($directory, $filename);

                $in['download_file'] = $filename;
                $in['download_link'] = NULL;
            }
        }
        $in['description'] = str_replace(url('/') . '/assets/front/img/', "{base_url}/assets/front/img/", $request->description);

        // update featured image
        if ($request->filled('featured_image')) {
            @unlink('assets/front/img/product/featured/' . $product->feature_image);
            $filename = uniqid() .'.'. $extFeatured;
            @copy(str_replace(' ', '%20', $featredImg), 'assets/front/img/product/featured/' . $filename);
            $in['feature_image'] = $filename;
        }

        $product->fill($in)->save();

        // copy the sliders first
        $fileNames = [];
        foreach ($sliders as $key => $slider) {
            $extSlider = pathinfo($slider, PATHINFO_EXTENSION);
            $filename = uniqid() .'.'. $extSlider;
            @copy(str_replace(' ', '%20', $slider), 'assets/front/img/product/sliders/' . $filename);
            $fileNames[] = $filename;
        }

        // delete & unlink previous slider images
        $pis = ProductImage::where('product_id', $product->id)->get();
        foreach ($pis as $key => $pi) {
            @unlink('assets/front/img/product/sliders/' . $pi->image);
            $pi->delete();
        }

        // store new slider images
        foreach ($fileNames as $key => $fileName) {
            $pi = new ProductImage;
            $pi->product_id = $product->id;
            $pi->image = $fileName;
            $pi->save();
        }

        Session::flash('success', 'Product updated successfully!');
        return "success";
    }

    public function toggleInPageBuilder($id)
    {
        $product    = Product::findOrFail($id);
        $new_value  = $product->show_in_page_builder == '1' ? 0 : 1;
        $product->show_in_page_builder  = $new_value;
        $product->save();

        session()->flash('success', $product->show_in_page_builder  == '1' ? 'Product added to page-builder successfully!' : 'Product removed from page-builder successfully!');
        return back();
    }


    public function deleteFromMegaMenu($product) {
        // unset service from megamenu for service_category = 1
        $megamenu = Megamenu::where('language_id', $product->language_id)->where('category', 1)->where('type', 'products');
        if ($megamenu->count() > 0) {
            $megamenu = $megamenu->first();
            $menus = json_decode($megamenu->menus, true);
            $catId = $product->category->id;
            if (is_array($menus) && array_key_exists("$catId", $menus)) {
                if (in_array($product->id, $menus["$catId"])) {
                    $index = array_search($product->id, $menus["$catId"]);
                    unset($menus["$catId"]["$index"]);
                    $menus["$catId"] = array_values($menus["$catId"]);
                    if (count($menus["$catId"]) == 0) {
                        unset($menus["$catId"]);
                    }
                    $megamenu->menus = json_encode($menus);
                    $megamenu->save();
                }
            }
        }
    }


    public function delete(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        foreach ($product->product_images as $key => $pi) {
            @unlink('assets/front/img/product/sliders/' . $pi->image);
            $pi->delete();
        }

        @unlink('assets/front/img/product/featured/' . $product->feature_image);
        @unlink('core/storage/digital_products/' . $product->download_file);

        $this->deleteFromMegaMenu($product);

        $product->delete();

        Session::flash('success', 'Product deleted successfully!');
        return back();
    }


    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $product = Product::findOrFail($id);
            foreach ($product->product_images as $key => $pi) {
                @unlink('assets/front/img/product/sliders/' . $pi->image);
                $pi->delete();
            }
        }

        foreach ($ids as $id) {
            $product = product::findOrFail($id);
            @unlink('assets/front/img/product/featured/' . $product->feature_image);

            $this->deleteFromMegaMenu($product);

            $product->delete();
        }

        Session::flash('success', 'Product deleted successfully!');
        return "success";
    }


    public function populerTag(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;
        $data = BE::where('language_id',$lang_id)->first();
        return view('admin.product.tag.index',compact('data'));
    }

    public function populerTagupdate(Request $request)
    {
        $rules = [
            'language_id' => 'required',
            'popular_tags' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $lang = Language::where('code', $request->language_id)->first();
        $be = BE::where('language_id',$lang->id)->first();
        $be->popular_tags = $request->popular_tags;
        $be->save();
        Session::flash('success', 'Populer tags update successfully!');
        return "success";
    }

    public function paymentStatus(Request $request) {
        $order = ProductOrder::find($request->order_id);
        $order->payment_status = $request->payment_status;
        $order->save();

        // $user = User::findOrFail($po->user_id);
        $be = BE::first();
        $sub = 'Payment Status Updated';

        $to = $order->billing_email;
        $fname = $order->billing_fname;

         // Send Mail to Buyer
         $mail = new PHPMailer(true);
         if ($be->is_smtp == 1) {
             try {
                 $mail->isSMTP();
                 $mail->Host       = $be->smtp_host;
                 $mail->SMTPAuth   = true;
                 $mail->Username   = $be->smtp_username;
                 $mail->Password   = $be->smtp_password;
                 $mail->SMTPSecure = $be->encryption;
                 $mail->Port       = $be->smtp_port;

                 //Recipients
                 $mail->setFrom($be->from_mail, $be->from_name);
                 $mail->addAddress($to, $fname);

                 // Content
                 $mail->isHTML(true);
                 $mail->Subject = $sub;
                 $mail->Body    = 'Hello <strong>' . $fname . '</strong>,<br/>Your payment status is changed to '.$request->payment_status.'.<br/>Thank you.';
                 $mail->send();
             } catch (Exception $e) {
                 // die($e->getMessage());
             }
         } else {
             try {

                 //Recipients
                 $mail->setFrom($be->from_mail, $be->from_name);
                 $mail->addAddress($to, $fname);


                 // Content
                 $mail->isHTML(true);
                 $mail->Subject = $sub ;
                 $mail->Body    = 'Hello <strong>' . $fname . '</strong>,<br/>Your payment status is changed to '.$request->payment_status.'.<br/>Thank you.';

                 $mail->send();
             } catch (Exception $e) {
                 // die($e->getMessage());
             }
         }

        Session::flash('success', 'Payment Status updated!');
        return back();
    }

    public function settings() {
        $data['abex'] = BasicExtra::first();
        return view('admin.product.settings', $data);
    }

    public function updateSettings(Request $request) {
        $bexs = BasicExtra::all();
        foreach($bexs as $bex) {
            $bex->product_rating_system = $request->product_rating_system;
            $bex->product_guest_checkout = $request->product_guest_checkout;
            $bex->is_shop = $request->is_shop;
            $bex->catalog_mode = $request->catalog_mode;
            $bex->tax = $request->tax ? $request->tax : 0.00;
            $bex->save();
        }

        $request->session()->flash('success', 'Settings updated successfully!');
        return back();
    }
}
