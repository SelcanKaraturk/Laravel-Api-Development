<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $offset = $request->has('offset') ? $request->offset : 0;
        $limit = $request->has('limit') ? $request->limit : 10;

        $db = User::query();
        if ($request->has('q'))
            $db = $db->where('name', 'like', '%' . $request->get('q') . '%');

        if ($request->has('sortBy'))
            $db = $db->orderBy($request->get('sortBy'),$request->get('sort','DESC'));

        $data = $db->offset($offset)->limit($limit)->get();
        $data->each->setAppends(['full_name']);//sadece bir yerde column özelleştirirken
        return response($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        //$input['email_verified_at']=now()->format('Y-m-d H:i:s');
        $input['password'] =Hash::make($request->password);
        $user = User::create($input);
        return response([
            'data' => $input,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $user->update($input);
        return response([
            'data' => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response([
            'message' => 'User deleted'
        ]);
    }
}
