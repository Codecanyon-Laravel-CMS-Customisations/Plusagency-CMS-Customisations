<?php

namespace AngelBooks\Plugins\Controllers;

use App\Product;
use App\Language;
use App\BasicExtended;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class TabsController extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function show(Request $request) {
        $lang = Language::where('code', $request->language)->first();
        $abx = $lang->basic_extended;
        $product_tabs = $abx->product_tabs;
        $products = Product::orderBy( 'title', 'ASC' )->get();
        return view( 'plugins::tabs', compact('abx', 'product_tabs', 'products') );
    }

    public function store( Request $request ) {

        $this->validate( $request, [
            'title' => 'required',
            'type' => 'required'
        ] );

        $lang = Language::where('code', 'en')->first();
        $abx = $lang->basic_extended;

        if ( is_null( $abx->product_tabs ) ) {
            $tabs = [
                [
                    'title' => $request->title,
                    'type' => $request->type,
                    'content' => $request->content,
                    'link' => $request->link,
                    'global' => $request->global,
                    'product_id' => $request->product_id
                ]
            ];
        } else {
            $tabs = (array) json_decode( $abx->product_tabs );
            // ( new \ArrayObject( $tabs ) )->offsetSet(null, [
            //     'title' => $request->title,
            //     'type' => $request->type,
            //     'content' => $request->content,
            //     'link' => $request->link,
            //     'global' => $request->global,
            //     'product_id' => $request->product_id
            // ]);
            // dd($tabs);
            $tabs[] = [
                'title' => $request->title,
                'type' => $request->type,
                'content' => $request->content,
                'link' => $request->link,
                'global' => $request->global,
                'product_id' => $request->product_id
            ];
        }

        // dd($tabs);

        $abx->product_tabs = json_encode( $tabs );
        $abx->save();
       
        return redirect()->back();

    }

    public function edit(Request $request) {
        $lang = Language::where('code', 'en')->first();
        $abx = $lang->basic_extended;
        $product_tabs = $abx->product_tabs;
        $product_tabs = collect( json_decode( $product_tabs ) );

        $tabc = $product_tabs->filter( function( $value, $key ) use ( $request ) {
            return $value->title == urldecode( $request->tab );
        } );

        foreach ($tabc as $t) {
            $tab = $t;
            break;
        }

        $products = Product::orderBy( 'title', 'ASC' )->get();

        return view( 'plugins::tabs-edit', compact( 'tab', 'products') );

    }

    public function destroy(Request $request) {
        $lang = Language::where('code', 'en')->first();
        $abx = $lang->basic_extended;
        $product_tabs = $abx->product_tabs;
        $product_tabs = collect( json_decode( $product_tabs ) );

        $tabs = $product_tabs->filter( function( $value, $key ) use ( $request ) {
            return $value->title != $request->tab;
        } );

        $abx->product_tabs = json_encode( $tabs );
        $abx->save();
       
        return redirect()->back();

    }

    public function update(Request $request) {
        $this->validate( $request, [
            'title' => 'required',
            'type' => 'required'
        ] );

        $lang = Language::where('code', 'en')->first();
        $abx = $lang->basic_extended;
        $product_tabs = $abx->product_tabs;
        $product_tabs = collect( json_decode( $product_tabs ) );

        $tabs = $product_tabs->filter( function( $value, $key ) use ( $request ) {
            return $value->title != $request->tab;
        } );

        $tabs[] = [
            'title' => $request->title,
            'type' => $request->type,
            'content' => $request->content,
            'link' => $request->link,
            'global' => $request->global,
            'product_id' => $request->product_id
        ];

        $abx->product_tabs = json_encode( $tabs );
        $abx->save();
       
        return redirect()->route('plugins.tabs.show', ['language' => 'en']);       
    }

}