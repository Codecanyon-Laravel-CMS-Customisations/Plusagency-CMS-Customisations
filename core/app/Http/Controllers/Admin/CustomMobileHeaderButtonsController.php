<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MobileHeaderCustomButton;

class CustomMobileHeaderButtonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links  = MobileHeaderCustomButton::all();

        return view('admin.custom-mobile-header-links.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        MobileHeaderCustomButton::create([
            'link_text'         => $request->link_text,
            'link_url'          => $request->link_url,
            'link_target'       => 'self',
            'description'       => $request->link_description,
            'link_rank'         => $request->link_order_number,
            'status'            => boolval($request->status)
        ]);

        //redirect
        if($request->expectsJson())
        {
            session()->flash('success', 'Link created successfully');
            session()->flash('message', 'Link created successfully');
            return 'success';
        }
        session()->flash('success', 'Link created successfully');
        session()->flash('message', 'Link created successfully');
        return redirect()->route('admin.custom-mobile-header-buttons.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $link                   = MobileHeaderCustomButton::findOrFail($request->link);
        $link->link_text        = $request->link_text;
        $link->link_url         = $request->link_url;
        $link->link_target      = 'self';
        $link->description      = $request->link_description;
        $link->link_rank        = $request->link_order_number;
        $link->status           = boolval($request->status);
        $link->save();

        //redirect
        if($request->expectsJson())
        {
            session()->flash('success', 'Link updated successfully');
            session()->flash('message', 'Link updated successfully');
            return 'success';
        }
        session()->flash('success', 'Link updated successfully');
        session()->flash('message', 'Link updated successfully');
        return redirect()->route('admin.custom-mobile-header-buttons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function toggle_activate(MobileHeaderCustomButton $MobileHeaderCustomButton, Request $request)
    {
        if($MobileHeaderCustomButton->status)
        {
            //deactivate
            $MobileHeaderCustomButton->status   = 0;
            $MobileHeaderCustomButton->save();

            session()->flash('success', 'link deactivated successfully');
            return redirect()->route('admin.custom-mobile-header-buttons.index');
        }

        //activate
        $MobileHeaderCustomButton->status       = 1;
        $MobileHeaderCustomButton->save();

        session()->flash('success', 'link activated successfully');
        return redirect()->route('admin.custom-mobile-header-buttons.index');
    }
}
