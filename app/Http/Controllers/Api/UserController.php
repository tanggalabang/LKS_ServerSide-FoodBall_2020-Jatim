<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Validator;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user, Request $request)
    {
        $this->user = $user;
    }

    public function index() {

        $datas = User::all();

        if(!$datas) return response()->json(['error'=> 'No user found'], 404);

       return response()->json(['data'=> $datas], 200);
    }

    public function store(Request $request) {
         /**
         * validation custom
         */

         $validator = Validator::make($request->all(),[
            'username' => 'required|alpha_num|min:4',
            'password' => 'required|alpha_num|min:6|max:8',
        ], 
        [
            'username.alpha_num' => 'Invalid username',
            'username.min' => 'Invalid username',
            'password.min' => 'Password is to short.',
            'password.max' => 'Password is to long.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->toArray()]);
        }

         /**
         * create data
         */
    
        $credentials = collect($request->only($this->user->getFillable()))
            ->put('password', Hash::make($request->password))
            ->put('created_date', now())
            ->toArray();

        $data = $this->user->create($credentials);
    
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $data = $this->user->where('id', $id)->first();

        if(!$data) return response()->json(['error' => 'User not found']);

        return response()->json($data, 200);
    }

    public function update($id, Request $request)
    {
        /**
         * validation custom
         */

         $validator = Validator::make($request->all(),[
            'username' => 'required|alpha_num|min:4',
            'password' => 'required|alpha_num|min:6|max:8',
        ], 
        [
            'username.alpha_num' => 'Invalid username',
            'username.min' => 'Invalid username',
            'password.min' => 'Password is to short.',
            'password.max' => 'Password is to long.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->toArray()]);
        }

        /**
         * get request data via $fillable
         */

        $request = collect($request->only($this->user->getFillable()))
            ->put('password', Hash::make($request->password))
            ->put('modified_date', now())
            ->toArray();

        /**
         * update data
         */

        $data = $this->user->where('id', $id)->first();

        $data->update($request);

        return response()->json($data,200);
    }

    public function destroy($id)
    {
        $data = $this->user->where('id', $id)->first();

        if(!$data) return response()->json(['error' => 'User not found']);

        $data->delete();

        return response()->json(['success' => 'Data deleted successfully']);
    }
    
}
