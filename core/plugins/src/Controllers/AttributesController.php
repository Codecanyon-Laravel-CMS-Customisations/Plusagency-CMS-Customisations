<?php

namespace AngelBooks\Plugins\Controllers;

use App\Product;
use App\Language;
use App\BasicExtended;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class AttributesController extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function show(Request $request) {
        $lang = Language::where('code', $request->language)->first();
        $abx = $lang->basic_extended;
        $product_attributes = $abx->product_attributes;
        $products = Product::orderBy( 'title', 'ASC' )->get();
        return view( 'plugins::attributes', compact('abx', 'product_attributes', 'products') );
    }

    public function store( Request $request ) {

        if ( ! $request->input('attributes') ){
            return redirect()->back();
        }

        $lang = Language::where('code', 'en')->first();
        $abx = $lang->basic_extended;
        

        // dd(json_decode($request->input('attributes')));

        if ( is_null( $abx->product_attributes ) ) {
            $attributes = json_decode($request->input('attributes'));
        } else {
            $attributes = (array) json_decode( $abx->product_attributes );
            // ( new \ArrayObject( $attributes ) )->offsetSet(null, [
            //     'title' => $request->title,
            //     'type' => $request->type,
            //     'content' => $request->content,
            //     'link' => $request->link,
            //     'global' => $request->global,
            //     'product_id' => $request->product_id
            // ]);
            // dd($attributes);
            foreach (json_decode($request->input('attributes')) as $att) {
                $attributes[] = $att;
            }
        }

        // dd($tabs);

        $abx->product_attributes = json_encode( $attributes );
        $abx->save();
       
        return redirect()->back();

    }

    public function create() {
        Artisan::call('up');
    }

    public function cache() {
        Artisan::call('down');
    }

    public function edit(Request $request) {
        $lang = Language::where('code', 'en')->first();
        $abx = $lang->basic_extended;
        $product_attributes = $abx->product_attributes;
        $product_attributes = collect( json_decode( $product_attributes ) );

        $tabc = $product_attributes->filter( function( $value, $key ) use ( $request ) {
            return $value->name == urldecode( $request->attribute );
        } );

        foreach ($tabc as $t) {
            $attribute = $t;
            break;
        }

        $products = Product::orderBy( 'title', 'ASC' )->get();

        return view( 'plugins::attributes-edit', compact( 'attribute', 'products') );

    }

    public function destroy(Request $request) {
        $lang = Language::where('code', 'en')->first();
        $abx = $lang->basic_extended;
        $product_attributes = $abx->product_attributes;
        $product_attributes = collect( json_decode( $product_attributes ) );

        $attributes = $product_attributes->filter( function( $value, $key ) use ( $request ) {
            return $value->name != $request->attribute;
        } );

        $abx->product_attributes = json_encode( $attributes );
        $abx->save();
       
        return redirect()->back();

    }

    public function update(Request $request) {

        $lang = Language::where('code', 'en')->first();
        $abx = $lang->basic_extended;
        $product_attributes = $abx->product_attributes;
        $product_attributes = collect( json_decode( $product_attributes ) );

        $attributes = $product_attributes->filter( function( $value, $key ) use ( $request ) {
            return $value->name != $request->attribute;
        } );

        $attributes[] = [
            'name' => $request->name,
            'value' => $request->value,
        ];

        $abx->product_attributes = json_encode( $attributes );
        $abx->save();
       
        return redirect()->route('plugins.attributes.show', ['language' => 'en']);       
    }

}