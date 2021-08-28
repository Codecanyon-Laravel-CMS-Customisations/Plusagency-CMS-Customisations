<?php

namespace AngelBooks\Plugins\Controllers;

use App\Product;
use App\Language;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class VariationsController extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function show() {
        $products = Product::orderBy( 'title', 'ASC' )->get();
        $lang = Language::where('code', 'en')->first();
        $product_fields = $lang->basic_extended->product_fields;
        $product_variations = $lang->basic_extended->product_variations;
        return view( 'plugins::variations', compact('products', 'product_fields', 'product_variations') );
    }

    public function edit(Request $request) {
        $lang = Language::where('code', 'en')->first();
        $abx = $lang->basic_extended;
        $product_variations = $abx->product_variations;
        $product_variations = collect( json_decode( $product_variations ) );

        $tabc = $product_variations->filter( function( $value, $key ) use ( $request ) {
            return $value->variation_id == $request->variation;
        } );

        foreach ($tabc as $t) {
            $variation = $t;
            break;
        }
        $products = Product::orderBy( 'title', 'ASC' )->get();
        $lang = Language::where('code', 'en')->first();
        $product_fields = $lang->basic_extended->product_fields;
        $product_variations = $lang->basic_extended->product_variations;
        $parent_id = $variation->product_id;
        $variation = \App\Product::withoutGlobalScope('variation')->find($request->variation);
        // dd($variation);
        return view( 'plugins::variations-edit', compact('products', 'product_fields', 'product_variations', 'variation', 'parent_id') );
    }

    public function destroy(Request $request) {
        $variation = \App\Product::withoutGlobalScope('variation')->find($request->variation);
        $lang = Language::where('code', 'en')->first();
        $abx = $lang->basic_extended;
        $product_variations = $abx->product_variations;
        $product_variations = collect( json_decode( $product_variations ) );
        
        // echo "<pre>";
        // var_dump($product_variations);
        // dd($product_variations);
        // echo "</pre>";

        $tabc = $product_variations->filter( function( $value, $key ) use ( $request ) {
            return $value->variation_id == $request->variation;
        } );

        foreach ($tabc as $t) {
            $variation = $t;
            break;
        }
        $parent_id = $variation->product_id;
        $parent = \App\Product::find($variation->product_id);
        
        
        
        // echo "<pre>";
        // var_dump($variation->product_id);
        // dd($variation);
        // echo "</pre>";
        
        if ($parent) $parent->variations = str_replace( ',' . $request->variation, '', $parent->variations );
        if ($parent) $parent->variations = str_replace( $request->variation . ',' , '', $parent->variations );
        if ($parent) $parent->variations = str_replace( $request->variation, '', $parent->variations );
        if ($parent) {
            if (! $parent->variations) {
                $parent->variations = null;
            }
            $parent->save();
        }


        $variations = $product_variations->filter( function( $value, $key ) use ( $request ) {
            return $value->variation_id != $request->variation;
        } );

        $abx->product_variations = json_encode( $variations );
        $abx->save();
       
        return redirect()->back();
    }

}