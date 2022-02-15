<?php

namespace AngelBooks\Plugins\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Bus\DispatchesJobs;
use AngelBooks\Plugins\Exports\ProductsExport;
use AngelBooks\Plugins\Imports\ProductsImport;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ImportController extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function show() {
        return view( 'plugins::import' );
    }

    public function store( Request $request ) {
        ini_set('memory_limit','1024M');
        set_time_limit(0);
        $this->validate( $request, [
            'file' => 'required',
        ] );

        Excel::import( new ProductsImport, request()->file( 'file' ) );

        session()->flash('success', 'Products imported!');
        return redirect()->route('admin.product.index', ['language' => 'en']);

    }

    public function export()
    {
        // return view('plugins::export', [
        //     'products' => Product::all()
        // ]);
        return Excel::download(new ProductsExport, 'products.csv');
    }

}
