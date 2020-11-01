<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFabricRequest;
use App\Http\Resources\FabricResource;
use App\Models\fabric;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FabricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fabrics = fabric::paginate();

        return view('fabric.index',compact('fabrics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fabric.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFabricRequest $request)
    {
        fabric::create($request->only(['name','code']));

        return redirect()->route('fabric.index')
            ->with('success','fabric created successfully.');
    }

    public function addFromOrder(Request $request)
    {

       /* $this->validate($request,[
            'name' => 'required|unique:fabrics,name'
        ]);*/
        fabric::create($request->only(['name','code']));
        $fabric = fabric::all()->sortBy('name');

        return FabricResource::collection($fabric);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\fabric  $fabric
     * @return \Illuminate\Http\Response
     */
    public function show(fabric $fabric)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\fabric  $fabric
     * @return \Illuminate\Http\Response
     */
    public function edit(fabric $fabric)
    {
        return view('fabric.edit',compact('fabric'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\fabric  $fabric
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, fabric $fabric)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique($fabric->getTable())->ignore($fabric->id),
            ],
            'code' => [
                'nullable',
                Rule::unique($fabric->getTable())->ignore($fabric->id),
            ],
        ]);


        $fabric->fill([
            'name' => $request->get('name'),
            'code' => $request->get('code'),
        ]);


        $fabric->update();

        return redirect()->route('fabric.index')
            ->with('success','Fabric updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\fabric  $fabric
     * @return \Illuminate\Http\Response
     */
    public function destroy(fabric $fabric)
    {
        $fabric->delete();

        return redirect()->route('fabric.index')
            ->with('success','Fabric deleted successfully');
    }
}
