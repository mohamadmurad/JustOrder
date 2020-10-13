<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubGroupRequest;
use App\Models\group;
use App\Models\subgroup;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubgroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subgroups = subgroup::with('group')->paginate();

        return view('subgroup.index',compact('subgroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = group::all();
        return view('subgroup.create',compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubGroupRequest $request)
    {
        subgroup::create($request->only(['idNum','name','group_id']));

        return redirect()->route('subgroup.index')
            ->with('success','Sub Group created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\subgroup  $subgroup
     * @return \Illuminate\Http\Response
     */
    public function show(subgroup $subgroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\subgroup  $subgroup
     * @return \Illuminate\Http\Response
     */
    public function edit(subgroup $subgroup)
    {
        $subgroup->load('group');
        $groups = group::all();
        return view('subgroup.edit',compact(['groups','subgroup']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\subgroup  $subgroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, subgroup $subgroup)
    {

        $request->validate([
            'idNum'=>[
                'required',
//                Rule::unique('subgroups')->where(function ($query) use ($request) {
//
//                    return $query
//                        ->where('id',$request->get('id'))
//                        ->where('group_id','=',$request->get('group_id'));
//                })->ignore($subgroup->id),
//                Rule::unique('subgroups')
//                    ->ignore($subgroup->id)
//                    ->where('group_id', $subgroup->group_id),
            ],
            'name' => [
                'required',
            ],
            'group_id' =>  [
                'required',
                'exists:groups,id',
//                Rule::unique('subgroups')->where(function ($query) use ($request) {
//
//                    return $query
//                        ->where('id',$request->get('id'))
//                        ->where('group_id','=',$request->get('group_id'));
//                })->ignore($subgroup->id),
//                Rule::unique('subgroups')
//                    ->ignore($subgroup->id)
//                    ->where('name', $subgroup->id),

            ],

        ]);

        $subgroup->fill([
            'idNum' => $request->get('id'),
            'name' => $request->get('name'),
            'group_id' => $request->get('group_id'),
        ]);


        $subgroup->update();

        return redirect()->route('subgroup.index')
            ->with('success','Group updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\subgroup  $subgroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(subgroup $subgroup)
    {
        $subgroup->delete();
        return redirect()->route('subgroup.index')
            ->with('success','Group deleted successfully');
    }
}
