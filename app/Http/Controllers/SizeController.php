<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSizeRequest;
use App\Models\size;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = size::paginate();

        return view('size.index',compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('size.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSizeRequest $request)
    {

        size::create($request->only(['name','code']));

        return redirect()->route('size.index')
            ->with('success','Size created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\size  $size
     * @return \Illuminate\Http\Response
     */
    public function show(size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\size  $size
     * @return \Illuminate\Http\Response
     */
    public function edit(size $size)
    {
        return view('size.edit',compact('size'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\size  $size
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, size $size)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique($size->getTable())->ignore($size->id),
            ],
            'code' => [

                Rule::unique($size->getTable())->ignore($size->id),
            ],


        ]);

        $size->fill([
            'name' => $request->get('name'),
            'code' => $request->get('code'),
        ]);


        $size->update();

        return redirect()->route('size.index')
            ->with('success','Size updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\size  $size
     * @return \Illuminate\Http\Response
     */
    public function destroy(size $size)
    {
        $size->delete();

        return redirect()->route('size.index')
            ->with('success','Size deleted successfully');
    }
}
