<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Models\supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = supplier::paginate();
        return view('supplier.index',compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSupplierRequest $request)
    {


        supplier::create($request->only([
            'name',
            'code' ,
            'address' ,
            'phone',
            'notes' ,
            ]));

        return redirect()->route('supplier.index')
            ->with('success','supplier created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(supplier $supplier)
    {
        return view('supplier.edit',compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, supplier $supplier)
    {
        $request->validate([
            'name' => [
                'required',
                'max:50',
                Rule::unique($supplier->getTable())->ignore($supplier->id),
            ],
            'code' => [
                'required',
                Rule::unique($supplier->getTable())->ignore($supplier->id),
            ],
            // 'address' => 'required|max:128',
            // 'phone' => 'required',
            // 'note' => 'required',
        ]);

        $supplier->fill([
            'name' => $request->get('name'),
            'code' => $request->get('code'),
            'address' => $request->get('address'),
            'phone' => $request->get('phone'),
            'notes' => $request->get('notes'),
        ]);


        $supplier->update();

        return redirect()->route('supplier.index')
            ->with('success','Supplier updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('supplier.index')
            ->with('success','supplier deleted successfully');
    }
}
