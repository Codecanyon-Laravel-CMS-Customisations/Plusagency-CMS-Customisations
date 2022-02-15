<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SettingMagicZoom;

class MagicZoomController extends Controller
{
    public function MagicZoom()
    {
        $d_set  = SettingMagicZoom::D_SETTINGS;
        $m_set  = SettingMagicZoom::M_SETTINGS;
        $model  = SettingMagicZoom::query()->where('id', '>=', 1)->orderBy('id', 'desc')->first();
        if(!$model) $model          = SettingMagicZoom::create();

        return view('admin.magic-zoom.index', compact('model', 'd_set', 'm_set'));
    }

    public function updateMagicZoom(Request $request)
    {
        // return response()->json($request);

        $model  = SettingMagicZoom::query()->where('id', '>=', 1)->orderBy('id', 'desc')->first();
        if(!$model) $model          = SettingMagicZoom::create();
        $model->desktop_options     = $request->desktop_options;
        $model->mobile_options      = $request->mobile_options;
        $model->save();

        return redirect()
        ->route('admin.magic-zoom')
        ->with('success', 'Magic-Zoom updated successfully');
    }

}
