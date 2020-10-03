<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate();
        $sessions = DB::table('sessions')->get(['user_id','ip_address','last_activity']);

        return view('users.index',compact(['users','sessions']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {

        User::create([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'password' => Hash::make(($request->get('password'))),
            'isAdmin' => $request->get('isAdmin'),
            ]);

        return redirect()->route('users.index')
            ->with('success','تم انشاء حساب مستخدم جديد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit',compact(['user']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|min:2|max:50',
            'username' =>[
                'required',
                Rule::unique('users')
                    ->ignore($user->id),
                ],
            'password' => 'nullable|min:8|confirmed',
            'isAdmin' => 'required|in:1,0',

        ]);

        $user->fill([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'isAdmin' =>$request->get('isAdmin'),

        ]);

        if ($request->has('password')){
            $user->fill([
                'password' => Hash::make(($request->get('password'))),
            ]);
        }


        $user->update();

        return redirect()->route('users.index')
            ->with('success','تم تحديث معلومات المستخدم');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success','تم حذف المستخدم');
    }
}
