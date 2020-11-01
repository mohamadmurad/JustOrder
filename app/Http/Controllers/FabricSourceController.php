<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFabricSourceRequest;
use App\Models\FabricSource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FabricSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $FabricSources = FabricSource::paginate();

        return view('FabricSource.index',compact('FabricSources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('FabricSource.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFabricSourceRequest $request)
    {


        FabricSource::create($request->only(['name']));

        return redirect()->route('FabricSource.index')
            ->with('success','Fabric source created successfully.');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FabricSource  $fabricSource
     * @return \Illuminate\Http\Response
     */
    public function show(FabricSource $fabricSource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FabricSource  $fabricSource
     * @return \Illuminate\Http\Response
     */
    public function edit(FabricSource $FabricSource)
    {
      //  dd($fabricSource);
        return view('FabricSource.edit',compact('FabricSource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FabricSource  $fabricSource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FabricSource $FabricSource)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique($FabricSource->getTable())->ignore($FabricSource->id),
                ],
        ]);


        $FabricSource->fill([
            'name' => $request->get('name'),
        ]);


        $FabricSource->update();

        return redirect()->route('FabricSource.index')
            ->with('success','Fabric Source updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FabricSource  $fabricSource
     * @return \Illuminate\Http\Response
     */
    public function destroy(FabricSource $FabricSource)
    {
        $FabricSource->delete();

        return redirect()->route('FabricSource.index')
            ->with('success','Fabric Source deleted successfully');
    }
}
