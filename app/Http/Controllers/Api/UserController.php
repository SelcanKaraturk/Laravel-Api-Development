<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
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
            $db = $db->orderBy($request->get('sortBy'), $request->get('sort', 'DESC'));

        $data = $db->offset($offset)->limit($limit)->get();
        $data->each->setAppends(['full_name']);//sadece bir yerde column özelleştirirken
        return response($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        /*$validator = $this->validate($request, [
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);*/
        /*$validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        if ($validator->fails()){
            return $this->apiResponse(ResoultType::Error,$validator->errors(),'validasyon hatası',422);
        }*/
        $input = $request->all();
        //$input['email_verified_at']=now()->format('Y-m-d H:i:s');
        $input['password'] = Hash::make($request->password);
        $user = User::create($input);
        return response([
            'data' => $input,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
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
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response([
            'message' => 'User deleted'
        ]);
    }

    public function custom1()
    {
        //$user=User::find(2);      //Tek bir kayıt dönerken
        UserResource::withoutWrapping(); //sadece buradaki sorguda data wrapi kaldırır.
        //return new UserResource($user);

        $users = User::all();          //Birden fazla kayıt dönerken
        //return UserResource::collection($users);

        //return new UserCollection($users); //collection kullanarak farklı kolonlar eklenebilir.
        return UserResource::collection($users);
        return UserResource::collection($users)->additional([ //UserCollection kullanmadan ek kolonlar eklenmek istenirse additional kullanılır
            'meta' => [
                'total_value' => $users->count(),
                'custom' => 'value'
            ]
        ]);


    }
}
