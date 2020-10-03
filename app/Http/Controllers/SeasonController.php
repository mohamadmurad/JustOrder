<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeasonRequest;
use App\Models\season;
use App\Models\Years;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seasons = season::with('year')->paginate();

        return view('season.index',compact('seasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $years = Years::all();
        return view('season.create',compact('years'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSeasonRequest $request)
    {
        $start = Carbon::make($request->get('start'));
        $end = Carbon::make($request->get('end'));

        season::create([
                'name' => $request->get('name'),
                'start' => $start,
                'end' => $end,
                'year_id' => $request->get('year_id'),
            ]);

        return redirect()->route('season.index')
            ->with('success','Season created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\season  $season
     * @return \Illuminate\Http\Response
     */
    public function show(season $season)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\season  $season
     * @return \Illuminate\Http\Response
     */
    public function edit(season $season)
    {
        $season->load('year');
        $years = Years::all();
        return view('season.edit',compact(['years','season']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\season  $season
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, season $season)
    {

        $request->validate([
            'name' => [
                'required',
                Rule::unique('seasons')
                    ->ignore($season->id)
                    ->where('year_id', $season->year_id),
            ],
            'year_id' =>  [
                'required',
                'exists:years,id',
                Rule::unique('seasons')
                    ->ignore($season->id)
                    ->where('name', $season->name),

            ],
            'start' => [
                'date',
                'required',
                'before:end',
            ],
            'end' => [
                'date',
                'required',
                'after:start',
            ],

        ]);

        $start = Carbon::make($request->get('start'));
        $end = Carbon::make($request->get('end'));

        $season->fill([
            'name' => $request->get('name'),
            'start' => $start,
            'end' => $end,
            'year_id' => $request->get('year_id'),
        ]);


        $season->update();

        return redirect()->route('season.index')
            ->with('success','Season updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\season  $season
     * @return \Illuminate\Http\Response
     */
    public function destroy(season $season)
    {
        $season->delete();
        return redirect()->route('season.index')
            ->with('success','seasons deleted successfully');
    }
}
