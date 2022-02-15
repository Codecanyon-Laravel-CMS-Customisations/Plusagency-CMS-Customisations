<?php

namespace AngelBooks\Plugins\Exports;

use App\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('plugins::export', [
            'products' => Product::all()
        ]);
    }
}
