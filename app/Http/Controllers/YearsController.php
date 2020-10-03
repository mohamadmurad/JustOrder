<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreYearRequest;
use App\Models\Years;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class YearsController extends Controller
{

    public  $title = 'years';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $years = Years::paginate();
        return view('years.index',compact(['years']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('years.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreYearRequest $request)
    {
        Years::create($request->only(['name']));

        return redirect()->route('years.index')
            ->with('success','year created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Years  $years
     * @return \Illuminate\Http\Response
     */
    public function show(Years $years)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Years  $years
     * @return \Illuminate\Http\Response
     */
    public function edit(Years $year)
    {
        return view('years.edit',compact('year'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Years  $years
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Years $year)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique($year->getTable())->ignore($year->id),
            ],
        ]);

        $year->fill([
            'name' => $request->get('name'),
        ]);


        $year->update();

        return redirect()->route('years.index')
            ->with('success','Supplier updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Years  $years
     * @return \Illuminate\Http\Response
     */
    public function destroy(Years $year)
    {
        $year->delete();

        return redirect()->route('years.index')
            ->with('success','year deleted successfully');
    }
}
