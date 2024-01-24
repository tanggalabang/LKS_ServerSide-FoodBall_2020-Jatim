<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Validator;

class PlayerController extends Controller
{
    protected $player;
    protected $token;

    public function __construct(Player $player, Request $request)
    {
        $this->player = $player;
        $this->token = $request->query('token');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = $this->player->all();

        if(!$datas) return response()->json(['error'=> 'No player found'], 404);

        return response()->json(['data'=> $datas], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name" => 'required',
            "position" => 'required',
            "back_number" => 'required|numeric',
        ],
        [
            'back_number.numeric' => 'Invalid number.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()
            ->put('created_at', now())
            ->toArray()],422);
        }

        /**
         * create data
         */

        $dataLogin = Controller::dataLogin($this->token);

        $response = collect($request->only($this->player->getFillable()))
            ->put('created_by', $dataLogin->id)
            ->toArray();

        $data = $this->player->create($response);

        return response()->json($data,200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->player->where('id', $id)->first();

        if(!$data) return response()->json(['error' => 'Player not found']);

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            "name" => 'required',
            "position" => 'required',
            "back_number" => 'required|numeric',
        ],
        [
            'back_number.numeric' => 'Invalid number.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()
            ->put('updated_at', now())
            ->toArray()],422);
        }

        /**
         * get request data via $fillable
         */
        
        $dataLogin = Controller::dataLogin($this->token);

        $response = collect($request->only($this->player->getFillable()))
            ->put('modified_by', $dataLogin->id)
            ->toArray();

        /**
         * update data
         */

        $data = $this->player->where('id', $id)->first();

        $data->update($response);

        return response()->json($data,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = $this->player->where('id', $id)->first();

        if(!$data) return response()->json(['error' => 'Player not found']);

        $data->delete();

        return response()->json(['success' => 'Data deleted successfully']);
    }
}
