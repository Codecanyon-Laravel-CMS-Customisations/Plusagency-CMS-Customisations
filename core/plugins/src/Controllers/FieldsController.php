<?php

namespace AngelBooks\Plugins\Controllers;

use App\Product;
use App\Language;
use App\Pcategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class FieldsController extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function show(Request $request) {
        $lang = Language::where('code', $request->language)->first();
        $abx = $lang->basic_extended;
        $product_fields = $abx->product_fields;
        $products = Product::all();
        $categories = Pcategory::all();

        return view( 'plugins::fields', compact('product_fields', 'products', 'categories') );
    }

    public function store( Request $request ) {
        $this->validate( $request, [
            'name' => 'required',
            'type' => 'required'
        ] );

        $lang = Language::where('code', 'en')->first();
        $abx = $lang->basic_extended;

        $fields = $abx->product_fields;

        if ( is_null( $fields ) ) {
            $fields = [];
        } else {
            $fields = json_decode( $fields );
        }

        $field = [];

        $field[ 'name' ] = $request->name;
        $field[ 'type' ] = $request->type;
        $field[ 'display' ] = $request->display;
        $field[ 'id' ] = $request->id;

        switch ( $request->type ) {
            case 'select':
                $field[ 'options' ] = $request->select_options;
                break;
            case 'radio':
                $field[ 'options' ] = $request->radio_options;
                break;
            case 'checkbox':
                $field[ 'options' ] = $request->checkbox_options;
                break;
            default:
                $field[ 'options' ] = null;
                break;
        }

        // if ( ! is_null( $abx->product_fields ) ) {
        //     ( new \ArrayObject( $fields ) )->offsetSet(null, $field);
        // } else {
        // }
        $fields[] = $field;

        // $fields[] = $field;

        $abx->product_fields = json_encode( $fields );
        $abx->save();

        return redirect()->route( 'plugins.fields.show', [ 'language' => 'en' ] );

    }

    public function edit( Request $request ) {
        $lang = Language::where('code', 'en')->first();
        $abx = $lang->basic_extended;
        $product_fields = $abx->product_fields;
        $product_fields = collect( json_decode( $product_fields ) );

        $fieldc = $product_fields->filter( function( $value, $key ) use ( $request ) {
            return $value->name == urldecode( $request->field );
        } );

        foreach ($fieldc as $t) {
            $field = $t;
            break;
        }

        return view( 'plugins::fields-edit', compact( 'field' ) );

    }

    public function update( Request $request) {
        $this->validate( $request, [
            'name' => 'required',
            'type' => 'required'
        ] );

        $lang = Language::where('code', 'en')->first();
        $abx = $lang->basic_extended;
        $product_fields = $abx->product_fields;
        $product_fields = collect( json_decode( $product_fields ) );

        $fields = $product_fields->filter( function( $value, $key ) use ( $request ) {
            return $value->name != $request->field;
        } );

        $field = [];

        $field[ 'name' ] = $request->name;
        $field[ 'type' ] = $request->type;
        $field[ 'display' ] = $request->display;
        $field[ 'id' ] = $request->id;

        switch ( $request->type ) {
            case 'select':
                $field[ 'options' ] = $request->select_options;
                break;
            case 'radio':
                $field[ 'options' ] = $request->radio_options;
                break;
            case 'checkbox':
                $field[ 'options' ] = $request->checkbox_options;
                break;
            default:
                $field[ 'options' ] = null;
                break;
        }

        $fields[] = $field;

        $abx->product_fields = json_encode( $fields );
        $abx->save();
       
        return redirect()->route('plugins.fields.show', ['language' => 'en']); 
    }

    public function destroy( Request $request ) {
        $lang = Language::where('code', 'en')->first();
        $abx = $lang->basic_extended;
        $product_fields = $abx->product_fields;
        $product_fields = collect( json_decode( $product_fields ) );

        $fields = $product_fields->filter( function( $value, $key ) use ( $request ) {
            return $value->name != $request->field;
        } );

        $abx->product_fields = json_encode( $fields );
        $abx->save();
       
        return redirect()->back();
    }

}