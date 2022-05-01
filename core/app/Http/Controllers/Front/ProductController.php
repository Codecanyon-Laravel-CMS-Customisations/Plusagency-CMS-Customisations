<?php

namespace App\Http\Controllers\Front;

use Auth;
use Session;
use App\Coupon;
use App\Ticket;
use XSSCleaner;
use App\Product;
use App\Language;
use App\Pcategory;
use Carbon\Carbon;
use App\BasicExtra;
use App\ProductReview;
use App\WebsiteColors;
use App\OfflineGateway;
use App\PaymentGateway;
use App\ShippingCharge;
use App\Models\Currency;
use App\Models\EasyForm;
use App\BasicSetting as BS;
use App\BasicExtended as BE;
use Illuminate\Http\Request;
use App\Models\SettingMagicZoom;
use PHPMailer\PHPMailer\PHPMailer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class ProductController extends Controller
{
    public $bex;
    public $forms_url   = "https://forms.upwork-plus.test";

    public function __construct()
    {
        $bs = BS::first();
        $be = BE::first();
        // $this->set_geo_currency();
    }

    public function set_geo_currency($bex = null)
    {
        $geo_data_base_currency             = angel_get_base_currency_id();//App\Models\Currency::find(81);
        $geo_data_user_currency             = angel_get_user_currency_id();//App\Models\Currency::find(23);

        // dd( $geo_data_base_currency);
        // echo json_encode( $geo_data_base_currency);return;
        // $bc_id      = App\Models\Currency::query()->where('name', App\BasicExtra::first()->base_currency_text)->orderBy('id', 'desc')->first();
        // echo json_encode($bc_id);//        return $bc_id->id;


        $bex_user_currency                  = Currency::find($geo_data_user_currency);
        $bex->base_currency_symbol          = '##';//$bex_user_currency->symbol;
        $bex->base_currency_symbol_position = strtolower($bex_user_currency->symbol_position);
        $bex->base_currency_text            = $bex_user_currency->name;
        $bex->base_currency_text_position   = strtolower($bex_user_currency->text_positio);

        $this->bex  = $bex;
    }

    public function product(Request $request)
    {
        // dd($request->all());
        $bex            = BasicExtra::first();
        $data['colors'] = WebsiteColors::all();
        if ($bex->is_shop == 0) {
            return back();
        }

        if (session()->has('lang')) {
            $currentLang = app()->make('currentLang');
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;
        $lang_id = $currentLang->id;

        $data['categories'] = Pcategory::where('status', 1)->where('language_id',$currentLang->id)->get();

        $search     = $request->search;
        $minprice = $request->minprice;
        $maxprice = $request->maxprice;
        $category = request('c-id') ?? request('category_id');
        $sub_category = request('sc-id');
        $category_model = Pcategory::find($category);
        $sub_category_model = Pcategory::find($sub_category);
        if(!$category_model){
            $category = null;
        }else {
            $data['category'] = $category_model;
        }
        if($sub_category_model){
            $data['sub_category'] = $sub_category_model;
            $data['category'] = $sub_category_model->parent_category;
        }
        $tag = $request->tag;

        if($request->type){
            $type = $request->type;
        }else{
            $type = 'new';
        }
        $tag = $request->tag;
        $review = $request->review;

        $data['products'] =
            Product::has('category')->with('category')
            ->when($category, function ($query, $category) {
                return $query->where('category_id', $category);
            })
            ->when($request->has('c-id'), function ($query) {
                return trim(request('c-id')) == '' ? $query : $query->where('category_id', request('c-id'));
            })
            ->when($request->has('sub_category_id'), function ($query) {
                return trim(request('sub_category_id')) == '' ? $query : $query->where('sub_category_id', request('sub_category_id'));
            })
            ->when($request->has('sc-id'), function ($query) {
                return trim(request('sc-id')) == '' ? $query : $query->where('sub_category_id', request('sc-id'));
            })
            ->when($request->has('scc-id'), function ($query) {
                return trim(request('scc-id')) == '' ? $query : $query->where('sub_child_category_id', request('scc-id'));
            })
            ->when($lang_id, function ($query, $lang_id) {
                return $query->where('language_id', $lang_id);
            })
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%')->orwhere('summary', 'like', '%' . $search . '%')->orwhere('description', 'like', '%' . $search . '%');
                // return trim($search) == '' ? $query : $query->where('title', 'like','%'. $search .'%');
            })
            ->when($minprice, function ($query, $minprice) {
                return $query->where('current_price', '>=', $minprice);
            })
            ->when($maxprice, function ($query, $maxprice) {
                return $query->where('current_price', '<=', $maxprice);
            })
            ->when($tag, function ($query, $tag) {
                return $query->where('tags', 'like', '%' . $tag . '%');
            })
            ->when($review, function ($query, $review) {
                return $query->where('rating', '>=', $review);
            })

            ->when($type, function ($query, $type) {
                if ($type == 'new') {
                    return $query->orderBy('id', 'DESC');
                } elseif ($type == 'old') {
                    return $query->orderBy('id', 'ASC');
                } elseif ($type == 'high-to-low') {
                    return $query->orderBy('current_price', 'DESC');
                } elseif ($type == 'low-to-high') {
                    return $query->orderBy('current_price', 'ASC');
                }
            })

            ->where('status', 1)->paginate(9);

            $version = $be->theme_version;

            if ($version == 'dark') {
                $version = 'default';
            }

            $data['version'] = $version;

            if($be->theme_version == 'bookworm') {  
                return view('front.bookworm.products', $data);
            } else {

                return view('front.product.product', $data);
            }


    }

    public function productDetails($slug)
    {

        $product_details = Product::where('slug', $slug)->first();
        
        $request = false;
        $current_uri = $_SERVER['REQUEST_URI'];
        if (str_contains($current_uri, '/product/')) { 
            $request = true;
        }
        
        
        if( !$product_details && $request === false )
        {
            // dd($product_details);
            session()->flash('error', 'Product not found!');
            return redirect()->to('products');
        } 

        if ( $product_details ) {
            session()->forget('error');
        }

        $bex = BasicExtra::first();
        if ($bex->is_shop == 0) {
            return back();
        }

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        session()->put('link', url()->current());
        $data['product']    = Product::where('slug', $slug)->where('language_id',$currentLang->id)->first();
        $data['categories'] = Pcategory::where('status', 1)->where('language_id',$currentLang->id)->get();

        ///dd($data);

        $data['related_product'] = Product::where('category_id', $data['product']->category_id)->where('language_id',$currentLang->id)->where('id', '!=', $data['product']->id)->get();

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['payload']    = $this->getForm();

        $data['version']    = $version;
        $data['mzoom']      = SettingMagicZoom::query()->where('id', '>=', 1)->orderBy('id', 'desc')->first();

        if($be->theme_version == 'bookworm') {
            return view('front.bookworm.product', $data);
        } else {
            return view('front.product.details', $data);
        }
    }


    public function cart()
    {
        $bex = BasicExtra::first();
        if ($bex->is_shop == 0 || $bex->catalog_mode == 1) {
            return back();
        }

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        if (session()->has('cart')) {
            $cart = session()->get('cart');
        } else {
            $cart = null;
        }

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;
        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.product.cart', compact('cart', 'version'));
    }

    public function product_categories()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }


        $pcategories    = Pcategory::all()
        ->where('show_in_menu', '1')
        ->where('language_id', $currentLang->id)
        ->sortBy('name', 0, false);


        $be                 = $currentLang->basic_extended;
        $version            = $be->theme_version;
        if ($version        == 'dark') {
            $version        = 'default';
        }

        return view('front.product.product_categories', compact('pcategories', 'be', 'version'));
    }

    
    /* start: previous function addToCart commented by zeeshan because it has no variation logic */
    /*
    public function addToCart(Request $request, $id)
    {
        $cart = session()->get('cart');
        if (strpos($id, ',,,') == true) {
            $data = explode(',,,', $id);
            $id = $data[0];
            $qty = $data[1];

            $product = Product::findOrFail($id);
            if ($product->type != 'digital') {
                if(!empty($cart) && array_key_exists($id, $cart)){
                    if($product->stock < $cart[$id]['qty'] + $qty){
                        if(request()->expectsJson())
                        {
                            return response()->json(['error' => 'Out of Stock']);
                        }
                        else
                        {
                            session()->flash('error', 'Out of Stock');
                            session()->flash('danger', 'Out of Stock');
                            return redirect()->back();
                        }
                    }
                }else{
                    if($product->stock < $qty){
                        if(request()->expectsJson())
                        {
                            return response()->json(['error' => 'Out of Stock']);
                        }
                        else
                        {
                            session()->flash('error', 'Out of Stock');
                            session()->flash('danger', 'Out of Stock');
                            return redirect()->back();
                        }
                    }
                }
            }

            if (!$product) {
                abort(404);
            }
            $cart = session()->get('cart');
            // if cart is empty then this the first product
            if (!$cart) {

                $cart = [
                    $id => [
                        "name" => $product->title,
                        "qty" => $qty,
                        "price" => $product->current_price,
                        "photo" => $product->feature_image,
                        "type" => $product->type
                    ]
                ];

                session()->put('cart', $cart);
                if(request()->expectsJson())
                {
                    return response()->json(['message' => 'Product added to cart successfully!']);
                }
                else
                {
                    session()->flash('message', 'Product added to cart successfully!');
                    session()->flash('success', 'Product added to cart successfully!');
                    return redirect()->back();
                }
            }


            // if cart not empty then check if this product exist then increment quantity
            if (isset($cart[$id])) {
                $cart[$id]['qty'] +=  $qty;
                session()->put('cart', $cart);
                if(request()->expectsJson())
                {
                    return response()->json(['message' => 'Product added to cart successfully!']);
                }
                else
                {
                    session()->flash('message', 'Product added to cart successfully!');
                    session()->flash('success', 'Product added to cart successfully!');
                    return redirect()->back();
                }
            }

            // if item not exist in cart then add to cart with quantity = 1
            $cart[$id] = [
                "name" => $product->title,
                "qty" => $qty,
                "price" => $product->current_price,
                "photo" => $product->feature_image,
                "type" => $product->type
            ];
        } else {

            $id = $id;
            $product = Product::findOrFail($id);
            if (!$product) {
                abort(404);
            }

            if ($product->type != 'digital') {
                if(!empty($cart) && array_key_exists($id, $cart)){
                    if($product->stock < $cart[$id]['qty'] + 1){
                        if(request()->expectsJson())
                        {
                            return response()->json(['error' => 'Out of Stock']);
                        }
                        else
                        {
                            session()->flash('error', 'Out of Stock');
                            session()->flash('danger', 'Out of Stock');
                            return redirect()->back();
                        }
                    }
                }else{
                    if($product->stock < 1){
                        if(request()->expectsJson())
                        {
                            return response()->json(['error' => 'Out of Stock']);
                        }
                        else
                        {
                            session()->flash('error', 'Out of Stock');
                            session()->flash('danger', 'Out of Stock');
                            return redirect()->back();
                        }
                    }
                }
            }


            $cart = session()->get('cart');
            // if cart is empty then this the first product
            if (!$cart) {

                $cart = [
                    $id => [
                        "name" => $product->title,
                        "qty" => 1,
                        "price" => $product->current_price,
                        "photo" => $product->feature_image,
                        "type" => $product->type
                    ]
                ];

                session()->put('cart', $cart);
                if(request()->expectsJson())
                {
                    return response()->json(['message' => 'Product added to cart successfully!']);
                }
                else
                {
                    session()->flash('message', 'Product added to cart successfully!');
                    session()->flash('success', 'Product added to cart successfully!');
                    return redirect()->back();
                }
            }

            // if selected product is digital , then check if the product is already in the cart
            // digital product can only be added once in cart
            // if ($product->type == 'digital') {
            //     if (is_array($cart) && array_key_exists($id, $cart)) {
            //         return response()->json(['error' => 'Already added to cart!']);
            //     }
            // }

            // if cart not empty then check if this product exist then increment quantity
            if (isset($cart[$id])) {
                $cart[$id]['qty']++;
                session()->put('cart', $cart);
                if(request()->expectsJson())
                {
                    return response()->json(['message' => 'Product added to cart successfully!']);
                }
                else
                {
                    session()->flash('message', 'Product added to cart successfully!');
                    session()->flash('success', 'Product added to cart successfully!');
                    return redirect()->back();
                }
            }

            // if item not exist in cart then add to cart with quantity = 1
            $cart[$id] = [
                "name" => $product->title,
                "qty" => 1,
                "price" => $product->current_price,
                "photo" => $product->feature_image,
                "type" => $product->type
            ];
        }

        session()->put('cart', $cart);
        if(request()->expectsJson())
        {
            return response()->json(['message' => 'Product added to cart successfully!']);
        }
        else
        {
            session()->flash('message', 'Product added to cart successfully!');
            session()->flash('success', 'Product added to cart successfully!');
            return redirect()->back();
        }
    }
    */
    /* end: previous function addToCart commented by zeeshan because it has no variation logic */

    // added variations code to addToCart
    public function addToCart(Request $request, $id)
    {
        // dd($id);
        
        $cart = session()->get('cart');
        $variation = null;

        if (strpos($id, ',,,') == true) {
            $data = explode(',,,', $id);
            $id = $data[0];
            $qty = $data[1];

            // $product = Product::findOrFail($id);
            $product = \DB::table('products')->where('id','=',$id)->first();
            
            if ( $product->is_variation == 1 ) {
                $variation = $product;
                
                // $product = Product::where('variations', 847)->first();
                $product = Product::whereRaw("FIND_IN_SET($id, variations) > 0")->first();
                
                $id = $product->id;
            }

            if ($product->type != 'digital') {
                if(!empty($cart) && array_key_exists($id, $cart)){
                    if($product->stock < $cart[$id]['qty'] + $qty){
                        if(request()->expectsJson())
                        {
                            return response()->json(['error' => 'Out of Stock']);
                        }
                        else
                        {
                            session()->flash('error', 'Out of Stock');
                            session()->flash('danger', 'Out of Stock');
                            return redirect()->back();
                        }
                    }
                }else{
                    if($product->stock < $qty){
                        if(request()->expectsJson())
                        {
                            return response()->json(['error' => 'Out of Stock']);
                        }
                        else
                        {
                            session()->flash('error', 'Out of Stock');
                            session()->flash('danger', 'Out of Stock');
                            return redirect()->back();
                        }
                    }
                }
            }

            if (!$product) {
                abort(404);
            }
            $cart = session()->get('cart');
            // if cart is empty then this the first product
            if (!$cart) {

                $cart = [
                    $id => [
                        "name" => $product->title,
                        "qty" => $qty,
                        "price" => (isset($variation))?$variation->current_price:$product->current_price,
                        "photo" => $product->feature_image,
                        "type" => $product->type,
                        "selected_variation_id" => (isset($variation))?$variation->id:null,
                    ]
                ];

                session()->put('cart', $cart);
                if(request()->expectsJson())
                {
                    return response()->json(['message' => 'Product added to cart successfully!']);
                }
                else
                {
                    session()->flash('message', 'Product added to cart successfully!');
                    session()->flash('success', 'Product added to cart successfully!');
                    return redirect()->back();
                }
            }


            // if cart not empty then check if this product exist then increment quantity
            if (isset($cart[$id])) {
                $cart[$id]['qty'] +=  $qty;
                session()->put('cart', $cart);
                if(request()->expectsJson())
                {
                    return response()->json(['message' => 'Product added to cart successfully!']);
                }
                else
                {
                    session()->flash('message', 'Product added to cart successfully!');
                    session()->flash('success', 'Product added to cart successfully!');
                    return redirect()->back();
                }
            }


            // if item not exist in cart then add to cart with quantity = 1
            $cart[$id] = [
                "name" => $product->title,
                "qty" => $qty,
                "price" => $product->current_price,
                "photo" => $product->feature_image,
                "type" => $product->type
            ];
        } else {

            // $product = Product::findOrFail($id);


            $product = \DB::table('products')->where('id','=',$id)->first();
            
            if ( $product->is_variation == 1 ) {
                $variation = $product;

                // $product = Product::where('variations', 847)->first();
                $product = Product::whereRaw("FIND_IN_SET($id, variations) > 0")->first();

                $id = $product->id;
            }
            
            if (!$product) {
                abort(404);
            }

            if ($product->type != 'digital') {
                if(!empty($cart) && array_key_exists($id, $cart)){
                    if($product->stock < $cart[$id]['qty'] + 1){
                        if(request()->expectsJson())
                        {
                            return response()->json(['error' => 'Out of Stock']);
                        }
                        else
                        {
                            session()->flash('error', 'Out of Stock');
                            session()->flash('danger', 'Out of Stock');
                            return redirect()->back();
                        }
                    }
                }else{
                    if($product->stock < 1){
                        if(request()->expectsJson())
                        {
                            return response()->json(['error' => 'Out of Stock']);
                        }
                        else
                        {
                            session()->flash('error', 'Out of Stock');
                            session()->flash('danger', 'Out of Stock');
                            return redirect()->back();
                        }
                    }
                }
            }


            $cart = session()->get('cart');
            // if cart is empty then this the first product
            if (!$cart) {

                $cart = [
                    $id => [
                        "name" => $product->title,
                        "qty" => 1,
                        "price" => (isset($variation))?$variation->current_price:$product->current_price,
                        "photo" => $product->feature_image,
                        "type" => $product->type,
                        "selected_variation_id" => (isset($variation))?$variation->id:null,
                    ]
                ];

                session()->put('cart', $cart);
                if(request()->expectsJson())
                {
                    return response()->json(['message' => 'Product added to cart successfully!']);
                }
                else
                {
                    session()->flash('message', 'Product added to cart successfully!');
                    session()->flash('success', 'Product added to cart successfully!');
                    return redirect()->back();
                }
            }

            // if selected product is digital , then check if the product is already in the cart
            // digital product can only be added once in cart
            // if ($product->type == 'digital') {
            //     if (is_array($cart) && array_key_exists($id, $cart)) {
            //         return response()->json(['error' => 'Already added to cart!']);
            //     }
            // }

            // if cart not empty then check if this product exist then increment quantity
            if (isset($cart[$id])) {
                $cart[$id]['qty']++;
                session()->put('cart', $cart);
                if(request()->expectsJson())
                {
                    return response()->json(['message' => 'Product added to cart successfully!']);
                }
                else
                {
                    session()->flash('message', 'Product added to cart successfully!');
                    session()->flash('success', 'Product added to cart successfully!');
                    return redirect()->back();
                }
            }

            // if item not exist in cart then add to cart with quantity = 1
            $cart[$id] = [
                "name" => $product->title,
                "qty" => 1,
                // "price" => $product->current_price,
                "price" => (isset($variation))?$variation->current_price:$product->current_price,
                "photo" => $product->feature_image,
                "type" => $product->type,
                "selected_variation_id" => (isset($variation))?$variation->id:null,
            ];
        }

        session()->put('cart', $cart);
        if(request()->expectsJson())
        {
            return response()->json(['message' => 'Product added to cart successfully!']);
        }
        else
        {
            session()->flash('message', 'Product added to cart successfully!');
            session()->flash('success', 'Product added to cart successfully!');
            return redirect()->back();
        }
    }


    public function updatecart(Request $request)
    {
        if (session()->has('cart')) {
            $cart = session()->get('cart');
            foreach ($request->product_id as $key => $id) {
                $product = Product::findOrFail($id);
                if ($product->type != 'digital') {
                    if($product->stock < $request->qty[$key]){
                        return response()->json(['error' => $product->title .' stock not available']);
                    }
                }
                if (isset($cart[$id])) {
                    $cart[$id]['qty'] =  $request->qty[$key];
                    session()->put('cart', $cart);
                }
            }
        }
        $total = 0;
        $count = 0;
        $product_ids = [];
        $product_quantities = [];
        foreach ($cart as $key => $i) {
            $product    = Product::findOrFail($key);

            $variation = null;
            if(isset($i['selected_variation_id'])) {
                $variation = \App\Product::withoutGlobalScope('variation')->find($i['selected_variation_id']);
                
                if($variation) {
                    $total += $variation->price * $i['qty'];
                }
                else {
                    $total += $product->price * $i['qty'];
                }
            }
            else {
                $total += $product->price * $i['qty'];
            }

            $count += $i['qty'];
            $product_ids[]= $product->id;
            $product_quantities[] = $i['qty'];
        }

        $total = round($total, 2);

        return response()->json(['message' => 'Cart Update Successfully.', 'total' => $total, 'count' => $count, 'product_ids' => $product_ids, 'product_quantities' => $product_quantities]);
    }


    public function updateSingleCartItem(Request $request)
    {
        
        if (session()->has('cart')) {
            $cart = session()->get('cart');
            
            $product = Product::findOrFail($request->product_id);
            
            if ($product->type != 'digital') {
                if($product->stock < $request->quantity){
                    return response()->json(['error' => $product->title .' stock not available']);
                }
            }

            
            if (isset($cart[$request->product_id])) {
                $cart[$request->product_id]['qty'] =  $request->quantity;

                $sub_total = $product->price*$request->quantity;

                session()->put('cart', $cart);
            }
        }
        $total = 0;
        $count = 0;
        foreach ($cart as $key => $i) {
            $product    = Product::findOrFail($key);

            $variation = null;
            if(isset($i['selected_variation_id'])) {
                $variation = \App\Product::withoutGlobalScope('variation')->find($i['selected_variation_id']);
                
                if($variation) {
                    $total += $variation->price * $i['qty'];
                }
                else {
                    $total += $product->price * $i['qty'];
                }
            }
            else {
                $total += $product->price * $i['qty'];
            }

            // $total += $product->price * $i['qty'];
            $count += $i['qty'];
        }

        $total = round($total, 2);


        return response()->json(['message' => 'Cart Update Successfully.', 'total' => $total, 'count' => $count, 'sub_total' => $sub_total]);
    }


    public function cartitemremove(Request $request, $id)
    {
        if ($id) {
            $cart = session()->get('cart');
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }

            $total = 0;
            $count = 0;
            foreach ($cart as $i) {
                $total += $i['price'] * $i['qty'];
                $count += $i['qty'];
            }
            $total = round($total, 2);

            if ($request->expectsJson())
            {
                return response()->json(['message' => 'Product removed successfully', 'count' => $count, 'total' => $total]);
            }
            session()->flash('count', $count);
            session()->flash('total', $total);
            session()->flash('message', 'Product removed successfully');
            session()->flash('success', 'Product removed successfully');
            return redirect()->back();
        }
    }


    public function checkout(Request $request)
    {
        $bex = BasicExtra::first();
        if ($bex->is_shop == 0 || $bex->catalog_mode == 1) {
            return back();
        }
        $data['bex'] = $bex;

        if(!Auth::check()) {
            if ($bex->product_guest_checkout == 1) {
                if($request->type != 'guest') {
                    session()->put('link', route('front.checkout'));
                    return redirect(route('user.login', ['redirected' => 'checkout']));
                } elseif (containsDigitalItemsInCart()) {
                    session()->put('link', route('front.checkout'));
                    return redirect(route('user.login', ['redirected' => 'checkout']));
                }
            } elseif ($bex->product_guest_checkout == 0) {
                session()->put('link', route('front.checkout'));
                return redirect(route('user.login', ['redirected' => 'checkout']));
            }
        }


        if (!session()->get('cart')) {
            session()->flash('error', 'Your cart is empty.');
            return back();
        }

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        if (session()->has('cart')) {
            $data['cart'] = session()->get('cart');
        } else {
            $data['cart'] = null;
        }
        $paymentGateways = PaymentGateway::all();
        $data['shippings'] = ShippingCharge::where('language_id',$currentLang->id)->get();
        $data['ogateways'] = $currentLang->offline_gateways()->where('product_checkout_status', 1)->orderBy('serial_number')->get();
        $data['stripe'] = $paymentGateways->where('id',14)->first();
        $data['paypal'] = $paymentGateways->where('id',15)->first();
        $data['paystackData'] = $paymentGateways->where('keyword', 'paystack')->first();
        $data['paystack'] = $data['paystackData']->convertAutoData();
        $data['flutterwave'] = $paymentGateways->where('id',6)->first();
        $data['razorpay'] =$paymentGateways->where('id',9)->first();
        $data['instamojo'] =$paymentGateways->where('id', 13)->first();
        $data['paytm'] =$paymentGateways->where('id', 11)->first();
        $data['mollie'] = $paymentGateways->where('id', 17)->first();
        $data['mercadopago'] = $paymentGateways->where('id', 19)->first();
        $data['payumoney'] = $paymentGateways->where('id', 18)->first();
        $data['discount'] = session()->has('coupon') && !empty(session()->get('coupon')) ? session()->get('coupon') : 0;

        // determining the theme version selected
        $be = $currentLang->basic_extended;
        $version = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.product.checkout', $data);


    }


    public function Prdouctcheckout(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        if (!$product) {
            abort(404);
        }

        if ($request->qty) {
            $qty = $request->qty;
        } else {
            $qty = 1;
        }


        $cart = session()->get('cart');
        $id = $product->id;
        // if cart is empty then this the first product
        if (!($cart)) {
            if($product->type != 'digital' && $product->stock <  $qty){
                session()->flash('error','Out of stock');
                return back();
            }

            $cart = [
                $id => [
                    "name" => $product->title,
                    "qty" => $qty,
                    "price" => $product->current_price,
                    "photo" => $product->feature_image,
                    'type' => $product->type
                ]
            ];

            session()->put('cart', $cart);
            if (!Auth::user()) {
                session()->put('link', url()->current());
                return redirect(route('user.login'));
            }
            return redirect(route('front.checkout'));
        }


        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$id])) {

            if($product->type != 'digital' && $product->stock < $cart[$id]['qty'] + $qty){
                session()->flash('error','Out of stock');
                return back();
            }
            $qt = $cart[$id]['qty'];
            $cart[$id]['qty'] = $qt + $qty;

            session()->put('cart', $cart);
                if (!Auth::user()) {
                session()->put('link', url()->current());
                return redirect(route('user.login'));
            }
            return redirect(route('front.checkout'));
        }

        if($product->type != 'digital' && $product->stock <  $qty){
            session()->flash('error','Out of stock');
            return back();
        }


        $cart[$id] = [
            "name" => $product->title,
            "qty" => $qty,
            "price" => $product->current_price,
            "photo" => $product->feature_image,
            'type' => $product->type
        ];
        session()->put('cart', $cart);



        if (!Auth::user()) {
            session()->put('link', url()->current());
            return redirect(route('user.login'));
        }
        return redirect(route('front.checkout'));
    }

    public function coupon(Request $request) {
        $coupon = Coupon::where('code', $request->coupon);
        $bex = BasicExtra::first();

        if ($coupon->count() == 0) {
            return response()->json(['status' => 'error', 'message' => "Coupon is not valid"]);
        } else {
            $coupon = $coupon->first();
            if (cartTotal() < $coupon->minimum_spend) {
                return response()->json(['status' => 'error', 'message' => "Cart Total must be minimum " . $coupon->minimum_spend . " " . $bex->base_currency_text]);
            }
            $start = Carbon::parse($coupon->start_date);
            $end = Carbon::parse($coupon->end_date);
            $today = Carbon::now();
            // return response()->json($end->lessThan($today));

            // if coupon is active
            if ($today->greaterThanOrEqualTo($start) && $today->lessThan($end)) {
                $cartTotal = cartTotal();
                $value = $coupon->value;
                $type = $coupon->type;

                if ($type == 'fixed') {
                    if ($value > cartTotal()) {
                        return response()->json(['status' => 'error', 'message' => "Coupon discount is greater than cart total"]);
                    }
                    $couponAmount = $value;
                } else {
                    $couponAmount = ($cartTotal * $value) / 100;
                }
                session()->put('coupon', round($couponAmount, 2));

                return response()->json(['status' => 'success', 'message' => "Coupon applied successfully"]);
            } else {
                return response()->json(['status' => 'error', 'message' => "Coupon is not valid"]);
            }
        }
    }

    public function product_iquiries(Product $product)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bse                = $currentLang->basic_extra;
        $currentLang        = $currentLang;

        $be                     = $currentLang->basic_extended;
        $version                = $be->theme_version;

        if ($version == 'dark') {
            $version = 'default';
        }

        return view('front.product_offline_inquiry'
            , compact('product', 'bse', 'currentLang', 'version')
        );
    }

    public function product_iquiries_store(Request $request, Product $product)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $bs = $currentLang->basic_setting;

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha'  => 'Captcha error! try again later or contact site admin.',
        ];

        $rules = [
            'name'                          => 'required',
            'email'                         => 'required|email',
            'whatsapp_number'               => 'nullable',
            'preferred_communication'       => 'nullable',
            'subject'                       => 'required',
            'message'                       => 'required'
        ];
        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules, $messages);

        $request->validate($rules, $messages);

        $be             = BE::firstOrFail();
        $from           = $request->email;
        $to             = $be->to_mail;
        $subject        = $request->subject;
        $message        = XSSCleaner::clean($request->message);


        ///create a ticket
        $input['subject']       = $subject;
        $input['message']       = $message;
        $input['user_id']       = auth()->check() ? Auth::user()->id : NULL;
        //$input['product_id']    = $product->id;
        $input['ticket_number'] = rand(1000000,9999999);
        $input['last_message']  = Carbon::now();


        //send email
        try {

            $mail       = new PHPMailer(true);
            $mail->setFrom($from, $request->name);
            $mail->addAddress($to);     // Add a recipient

            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message." <br/> <small>ticket number <strong>#".$input['ticket_number']."</strong></small>";

            $mail->send();
        }catch (\Exception $e) { }

        $pivot              = [];
        if(auth()->check())
        {
            foreach($request->products as $key => $value)
            {
                $pivot[$value]                  = [
                    'user_id'                   => auth()->id(),
                    'email'                     => auth()->user()->email,
                    'whatsapp_number'           => trim($request->whatsapp_number),
                    'preferred_communication'   => trim($request->preferred_communication),
                ];
            }
        }
        else
        {
            foreach($request->products as $key => $value)
            {
                $pivot[$value]                  = [
                    'email'                     => $request->email,
                    'whatsapp_number'           => trim($request->whatsapp_number),
                    'preferred_communication'   => trim($request->preferred_communication),
                ];
            }
        }



        $ticket                 = Ticket::firstOrCreate($input);
        if(auth()->check()) $ticket->user_id    = auth()->id();
        $ticket->products()->sync($pivot);

        session()->flash('product_ids', $request->products);
        session()->flash('success', 'Email sent successfully!');
        return back();
    }

    public function product_iquiries_bulk(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $bs = $currentLang->basic_setting;

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha'  => 'Captcha error! try again later or contact site admin.',
        ];

        $rules = [
            'name'                          => 'required',
            'email'                         => 'required|email',
            'message'                       => 'required',
            'products'                       => 'required'
        ];
        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules, $messages);

        $request->validate($rules, $messages);

        $be             = BE::firstOrFail();
        $from           = $request->email;
        $to             = $be->to_mail;
        $subject        = "Books Enquiry";
        $products       = Product::query()->whereIn('id', $request->products)->get();
        $message        = XSSCleaner::clean($request->message);


        ///create a ticket
        $input['subject']       = $subject;
        $input['message']       = $message;
        $input['user_id']       = auth()->check() ? Auth::user()->id : NULL;
        //$input['product_id']    = $product->id;
        $input['ticket_number'] = rand(1000000,9999999);
        $input['last_message']  = Carbon::now();

        $products_string        = "<hr/><table>
        <thead>
        <td>PRODUCTS</td>
        </thead>
        <tbody>";

        foreach ($products as $product)
        {
            $products_string       .= "
        <tr>
        <td style='display: flex;'>
        <img style='max-width:7rem;' src='$product->feature_image'/>
        <div>
        <p>$product->title</p>
        <p>PRICE: $product->current_price</p>
        <p>SKU  : $product->sku</p>
        </div>
        </td>
        </tr>";
        }

        $products_string       .= "</tbody></table>";

        //return $message.$products_string." <hr/> <small>ticket number <strong>#".$input['ticket_number']."</strong></small>";


        //send email
        try {
            $message = $message . $products_string . " <hr/> <small>ticket number <strong>#" . $input['ticket_number'] . "</strong></small>";
            // Content
            Mail::html($message, function ($msg) use ($to, $request,$from,$subject) {
                $msg->from($from, $request->name)->to($to)->subject($subject);
            });
        }catch (\Exception $e) { }

        $pivot              = [];
        if(auth()->check())
        {
            foreach($request->products as $key => $value)
            {
                $pivot[$value]                  = [
                    'user_id'                   => auth()->id(),
                    'email'                     => auth()->user()->email,
                    'whatsapp_number'           => trim($request->whatsapp_number),
                    'preferred_communication'   => trim($request->preferred_communication),
                ];
            }
        }
        else
        {
            foreach($request->products as $key => $value)
            {
                $pivot[$value]                  = [
                    'email'                     => $request->email,
                    'whatsapp_number'           => trim($request->whatsapp_number),
                    'preferred_communication'   => trim($request->preferred_communication),
                ];
            }
        }



        $ticket                 = Ticket::firstOrCreate($input);
        if(auth()->check()) $ticket->user_id    = auth()->id();
        $ticket->products()->sync($pivot);

        session()->flash('product_ids', $request->products);
        session()->flash('success', 'Email sent successfully!');
        return back();
    }



    public function getForm()
    {
        try
        {
            $hash               = md5('Angel');
            $resource_url       = env("ANGEL_URL", "https://angelbookhouse.com");
            $payload            = EasyForm::count() >= 1 ? EasyForm::first() : new EasyForm();


            // dd($payload);

            $this->forms_url    = trim(html_entity_decode($payload->easy_form_server_url));
            $crawler            = new Crawler(html_entity_decode($payload->easy_form_restricted));

            //form
            $form               = $crawler->filter("body form");

            //styles
            $style_links        = $crawler->filter("link")->each(function($link)
            {
                $link           = $this->make_abs_url($link->outerHtml(), "href");
                if (!str_contains($link, 'bootstrap.min.css') ) return  $link;
            });
            $style_tags     = $crawler->filter("style");

            //scripts
            $script_links   = $crawler->filter("script[src]")->each(function($script)
            {
                $link           = $this->make_abs_url($script->outerHtml(), "src");
                if (!str_contains($link, 'static_files/js/libs/jquery.js') ) return  $link;
            });
            $script_tags     = $crawler->filter("script");




            // return $form->html("");
            //return $form->outerHtml("");
            // dd("<style>".$style_tags->eq(0)->html('')."</style>");
            // dd($style_links);
            // dd("<script>".$script_tags->eq(0)->html('')."</script>");
            // dd($script_links);

            return [
                "form"      => [
                    "inner" => $form->html(""),
                    "outer" => $form->outerHtml(""),
                ],
                "styles"    => [
                    "tags"  => "<style>".str_replace('body', '.body', $style_tags->eq(0)->html("") )." body{padding:0px !important}</style>",
                    "links" => str_replace('/static_files/css/bootstrap.min.css', '', $style_links),
                ],
                "scripts"   => [
                    "tags"  => "<script>".$script_tags->eq(0)->html("")."</script>",
                    "links" => $script_links,
                ],
            ];
        }
        catch(\Exception $exception)
        {
            return [
                "form"      => [
                    "inner" => "<div class='text-center py-5'><h2 class=''></h2></div>",
                    "outer" => "<div class='text-center py-5'><h2 class=''></h2></div>",
                ],
                "styles"    => [
                    "tags"  => "",
                    "links" => array(),
                ],
                "scripts"   => [
                    "tags"  => "",
                    "links" => array(),
                ],
            ];
        }
    }

    public function make_abs_url(string $link, $needle = "href")
    {
        return str_replace("$needle=\"", "$needle=\"$this->forms_url/static_files/", $link);
    }

    public function wishlist()
    {
        $bex = BasicExtra::first();
        if ($bex->is_shop == 0 || $bex->catalog_mode == 1) {
            return back();
        }

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        if (session()->has('wishlist')) {
            $wishlist = session()->get('wishlist');
        } else {
            $wishlist = null;
        }

        $be = $currentLang->basic_extended;
        $version = $be->theme_version;
        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.product.wishlist', compact('wishlist', 'version'));
    }
    public function updateWishlist(Request $request)
    {
        if (session()->has('wishlist')) {
            $wishlist = session()->get('wishlist');
            foreach ($request->product_id as $key => $id) {
                $product = Product::findOrFail($id);
                if ($product->type != 'digital') {
                    if($product->stock < $request->qty[$key]){
                        return response()->json(['error' => $product->title .' stock not available']);
                    }
                }
                if (isset($wishlist[$id])) {
                    $wishlist[$id]['qty'] =  $request->qty[$key];
                    session()->put('wishlist', $wishlist);
                }
            }
        }
        $total = 0;
        $count = 0;
        foreach ($wishlist as $key => $i) {
            $product    = Product::findOrFail($key);
            $total += $product->price * $i['qty'];
            $count += $i['qty'];
        }

        $total = round($total, 2);

        return response()->json(['message' => 'Wishlist Updated Successfully.', 'total' => $total, 'count' => $count]);
    }
    public function addWishlistToCart(Request $request)
    {
        try
        {
            $wishlist = session()->get('wishlist');
            if (is_array($wishlist))
            {
                foreach ($wishlist as $key => $value)
                {
                    $req_pids   = array_filter(explode('-', $request->products));
                    $product    = \App\Models\Unscoped\Product::find($key);
                    if(count($req_pids) >= 1 && !in_array($product->id, $req_pids)) continue;
                    if (session()->has("cart.$key"))
                    {
                        //update quantity
                        $qty1           = session("cart.$key.qty");
                        session()->put("cart.$key.qty", $qty1 + $value["qty"] > $product->stock ? $product->stock : $qty1 + $value["qty"]);
                    }
                    else
                    {
                        //create a new entry
                        session()->put("cart.$key", $value);
                    }

                    //clear wishlish
                    session()->forget("wishlist.$key");
                }
            }
            if(request()->expectsJson())
            {
                return response()->json(['message' => 'Wishlist items added to cart successfully']);
            }
            else
            {
                session()->flash('message', 'Wishlist items added to cart successfully');
                session()->flash('success', 'Wishlist items added to cart successfully');
                return redirect()->route('front.cart');
            }
        }
        catch (\Exception $exception)
        {
            if(request()->expectsJson())
            {
                session()->flash('danger', 'Error adding Wishlist items to cart');
                return response()->json(['error' => 'Error adding Wishlist items to cart']);
            }
            else
            {
                session()->flash('error', 'Error adding Wishlist items to cart');
                session()->flash('danger', 'Error adding Wishlist items to cart');
                return redirect()->route('front.wishlist');
            }
        }
    }
    public function addToWishlist(Product $product, $quantity = 1)
    {
        $id         = $product->id;
        $wishlist = session()->get('wishlist');
        if (strpos($id, ',,,') == true) {
            $data = explode(',,,', $id);
            $id = $data[0];
            $qty = $data[$quantity];

            //$product = Product::findOrFail($id);

            if ($product->type != 'digital') {
                if(!empty($wishlist) && array_key_exists($id, $wishlist)){
                    if($product->stock < $wishlist[$id]['qty'] + $qty){
                        if(request()->expectsJson())
                        {
                            return response()->json(['error' => 'Out of Stock']);
                        }
                        else
                        {
                            session()->flash('error', 'Out of Stock');
                            session()->flash('danger', 'Out of Stock');
                            return redirect()->back();
                        }
                    }
                }else{
                    if($product->stock < $qty){
                        if(request()->expectsJson())
                        {
                            return response()->json(['error' => 'Out of Stock']);
                        }
                        else
                        {
                            session()->flash('error', 'Out of Stock');
                            session()->flash('danger', 'Out of Stock');
                            return redirect()->back();
                        }
                    }
                }
            }

            if (!$product) {
                abort(404);
            }
            $wishlist = session()->get('wishlist');
            // if wishlist is empty then this the first product
            if (!$wishlist) {

                $wishlist = [
                    $id => [
                        "name" => $product->title,
                        "qty" => $qty,
                        "price" => $product->current_price,
                        "photo" => $product->feature_image,
                        "type" => $product->type
                    ]
                ];

                session()->put('wishlist', $wishlist);
                if(request()->expectsJson())
                {
                    return response()->json(['message' => 'Product added to wishlist successfully!']);
                }
                else
                {
                    session()->flash('message', 'Product added to wishlist successfully!');
                    session()->flash('success', 'Product added to wishlist successfully!');
                    return redirect()->back();
                }
            }


            // if wishlist not empty then check if this product exist then increment quantity
            if (isset($wishlist[$id])) {
                $wishlist[$id]['qty'] +=  $qty;
                session()->put('wishlist', $wishlist);
                if(request()->expectsJson())
                {
                    return response()->json(['message' => 'Product added to wishlist successfully!']);
                }
                else
                {
                    session()->flash('message', 'Product added to wishlist successfully!');
                    session()->flash('success', 'Product added to wishlist successfully!');
                    return redirect()->back();
                }
            }

            // if item not exist in wishlist then add to wishlist with quantity = 1
            $wishlist[$id] = [
                "name" => $product->title,
                "qty" => $qty,
                "price" => $product->current_price,
                "photo" => $product->feature_image,
                "type" => $product->type
            ];
        }
        else
        {

            $id = $id;
            //$product = Product::findOrFail($id);
            if (!$product) {
                abort(404);
            }

            if ($product->type != 'digital') {
                if(!empty($wishlist) && array_key_exists($id, $wishlist)){
                    if($product->stock < $wishlist[$id]['qty'] + $quantity){
                        if(request()->expectsJson())
                        {
                            return response()->json(['error' => 'Out of Stock']);
                        }
                        else
                        {
                            session()->flash('error', 'Out of Stock');
                            session()->flash('danger', 'Out of Stock');
                            return redirect()->back();
                        }
                    }
                }
                else
                {
                    if($product->stock < 1){
                        if(request()->expectsJson())
                        {
                            return response()->json(['error' => 'Out of Stock']);
                        }
                        else
                        {
                            session()->flash('error', 'Out of Stock');
                            session()->flash('danger', 'Out of Stock');
                            return redirect()->back();
                        }
                    }
                }
            }


            $wishlist = session()->get('wishlist');
            // if wishlist is empty then this the first product
            if (!$wishlist) {

                $wishlist = [
                    $id => [
                        "name" => $product->title,
                        "qty" => $quantity,
                        "price" => $product->current_price,
                        "photo" => $product->feature_image,
                        "type" => $product->type
                    ]
                ];

                session()->put('wishlist', $wishlist);
                if(request()->expectsJson())
                {
                    return response()->json(['message' => 'Product added to wishlist successfully!']);
                }
                else
                {
                    session()->flash('message', 'Product added to wishlist successfully!');
                    session()->flash('success', 'Product added to wishlist successfully!');
                    return redirect()->back();
                }
            }

            // if selected product is digital , then check if the product is already in the wishlist
            // digital product can only be added once in wishlist
            // if ($product->type == 'digital') {
            //     if (is_array($wishlist) && array_key_exists($id, $wishlist)) {
            //         return response()->json(['error' => 'Already added to wishlist!']);
            //     }
            // }

            // if wishlist not empty then check if this product exist then increment quantity
            if (isset($wishlist[$id])) {
                $wishlist[$id]['qty']+= $quantity;
                session()->put('wishlist', $wishlist);
                if(request()->expectsJson())
                {
                    return response()->json(['message' => 'Product added to wishlist successfully!']);
                }
                else
                {
                    session()->flash('message', 'Product added to wishlist successfully!');
                    session()->flash('success', 'Product added to wishlist successfully!');
                    return redirect()->back();
                }
            }

            // if item not exist in wishlist then add to wishlist with quantity = $quantity
            $wishlist[$id] = [
                "name" => $product->title,
                "qty" => $quantity,
                "price" => $product->current_price,
                "photo" => $product->feature_image,
                "type" => $product->type
            ];
        }

        session()->put('wishlist', $wishlist);
        if(request()->expectsJson())
        {
            return response()->json(['message' => 'Product added to wishlist successfully!']);
        }
        else
        {
            session()->flash('message', 'Product added to wishlist successfully!');
            session()->flash('success', 'Product added to wishlist successfully!');
            return redirect()->back();
        }
    }
    public function wishlistItemRemove(Request $request, Product $product)
    {
        $id     = $product->id;
        if ($id) {
            $wishlist = session()->get('wishlist');
            if (isset($wishlist[$id])) {
                unset($wishlist[$id]);
                session()->put('wishlist', $wishlist);
            }

            $total = 0;
            $count = 0;
            foreach ($wishlist as $i) {
                $total += $i['price'] * $i['qty'];
                $count += $i['qty'];
            }
            $total = round($total, 2);

            if ($request->expectsJson())
            {
                return response()->json(['message' => 'Product removed successfully', 'count' => $count, 'total' => $total]);
            }
            session()->flash('count', $count);
            session()->flash('total', $total);
            session()->flash('message', 'Product removed successfully');
            session()->flash('success', 'Product removed successfully');
            return redirect()->back();
        }
    }
}
