<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeColorRequest;
use App\Http\Requests\storeRequest;
use App\Models\color;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = color::paginate();

        return view('color.index',compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('color.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeColorRequest $request)
    {
        color::create($request->only(['name']));

        return redirect()->route('color.index')
            ->with('success','Color created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\color  $color
     * @return \Illuminate\Http\Response
     */
    public function show(color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\color  $color
     * @return \Illuminate\Http\Response
     */
    public function edit(color $color)
    {
        return view('color.edit',compact('color'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\color  $color
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, color $color)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique($color->getTable())->ignore($color->id),
            ],

        ]);

        $color->fill([
            'name' => $request->get('name'),
        ]);


        $color->update();

        return redirect()->route('color.index')
            ->with('success','Color updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\color  $color
     * @return \Illuminate\Http\Response
     */
    public function destroy(color $color)
    {
        $color->delete();

        return redirect()->route('color.index')
            ->with('success','Color deleted successfully');
    }
}
