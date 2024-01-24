<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;
use Validator;

class ActorController extends Controller
{

    protected $actor;
    protected $token;

    public function __construct(Actor $actor, Request $request)
    {
        $this->actor = $actor;
        $this->token = $request->query('token');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = $this->actor->all();

        if(!$datas) return response()->json(['error'=> 'No user found'], 404);

        return response()->json(['data'=> $datas], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
    }
        

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
         * create data
         */

        $response = collect($request->only($this->actor->getFillable()))
            ->put('password', md5($request->password))
            ->put('created_at', now())
            ->toArray();

        $data = $this->actor->create($response);

    
        return response()->json($data, 200);
    
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->actor->where('id', $id)->first();

        if(!$data) return response()->json(['error' => 'User not found']);

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Actor $actor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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
            return response()->json(['errors'=>$validator->errors()
            ->put('updated_at', now())
            ->toArray()]);
        }

        /**
         * get request data via $fillable
         */

        $request = collect($request->only($this->actor->getFillable()))
            ->put('password', md5($request->password))
            ->toArray();

        /**
         * update data
         */

        $data = $this->actor->where('id', $id)->first();

        $data->update($request);

        return response()->json($data,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = $this->actor->where('id', $id)->first();

        if(!$data) return response()->json(['error' => 'User not found']);

        $data->delete();

        return response()->json(['success' => 'Data deleted successfully']);
    }
}
