<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeColorRequest;
use App\Http\Requests\storeRequest;
use App\Models\color;
use App\Models\departments;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = departments::paginate();

        return view('departments.index',compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        departments::create($request->only(['name']));

        return redirect()->route('departments.index')
            ->with('success','departments created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\color  $color
     * @return \Illuminate\Http\Response
     */
    public function show(color $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\color  $color
     * @return \Illuminate\Http\Response
     */
    public function edit(departments $department)
    {
        return view('departments.edit',compact('departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\color  $color
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, departments $department)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique($department->getTable())->ignore($department->id),
            ],

        ]);

        $department->fill([
            'name' => $request->get('name'),
        ]);


        $department->update();

        return redirect()->route('departments.index')
            ->with('success','departments updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\color  $color
     * @return \Illuminate\Http\Response
     */
    public function destroy(color $department)
    {
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success','departments deleted successfully');
    }
}
