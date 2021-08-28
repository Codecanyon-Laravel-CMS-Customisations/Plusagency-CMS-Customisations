<?php

namespace App\Http\Controllers\Admin;

use App\WebsiteColors;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

class WebsiteColorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['colors'] = WebsiteColors::get();
        // $data['message'] = "";
        return view('admin.colors.index', $data);
    }

    /**
     * Store the newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'element' => 'required|unique:website_colors',
            'attribute' => 'required',
            'color' => 'required',
        ]);

        if ($validator->fails()) {
            Session::put('data', "0"); 
            return back()->withErrors($validator);
        } 

        $websiteColor = new WebsiteColors;
        $websiteColor->element = $request->element;
        $websiteColor->attribute = $request->attribute;
        $websiteColor->value = $request->color;
        $websiteColor->save();
        Session::flash('success', 'Website Color added successfully!');
        Session::forget('data'); 
        return back();
    }

    /**
     * Store the newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'element' => 'required|unique:website_colors',
            'attribute' => 'required',
            'color' => 'required',
        ]);

        if ($validator->fails()) {
            Session::put('data', "1"); 
            return back()->withErrors($validator);
        } 

        $websiteColor = new WebsiteColors;
        $websiteColor->element = $request->element;
        $websiteColor->attribute = $request->attribute;
        $websiteColor->value = $request->color;
        $websiteColor->save();
        Session::flash('success', 'Website Color added successfully!');
        Session::forget('data'); 
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WebsiteColors  $websiteColors
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WebsiteColors $websiteColor)
    {
        $validator = Validator::make($request->all(), [
            'color' => 'required',
        ]);

        if ($validator->fails()) {
            Session::put('data', "2"); 
            return back()->withErrors($validator);
        } 

        $websiteColor->value = $request->color;
        $websiteColor->update();
        Session::flash('success', 'Website Colors updated successfully!');
        Session::forget('data'); 
        return back();
    }

    public function destroy(WebsiteColors $websiteColor) {
        $websiteColor->delete();
        Session::flash('success', 'Website Color deleted successfully!');
        return back();
    }
}
