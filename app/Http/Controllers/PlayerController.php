<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /** Store player name + phone when game starts, return player_id */
    public function start(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'phone' => 'required|string|max:30',
        ]);

        $player = Player::create([
            'name'       => trim($request->name),
            'phone'      => trim($request->phone),
            'difficulty' => $request->integer('difficulty', 3),
        ]);

        return response()->json(['player_id' => $player->id]);
    }

    /** Update result after the game ends */
    public function result(Request $request)
    {
        $request->validate([
            'player_id' => 'required|integer',
            'result'    => 'required|in:win,timeout',
            'moves'     => 'nullable|integer',
            'time_taken'=> 'nullable|integer',
            'difficulty'=> 'nullable|integer',
        ]);

        Player::where('id', $request->player_id)->update([
            'result'     => $request->result,
            'moves'      => $request->moves,
            'time_taken' => $request->time_taken,
            'difficulty' => $request->integer('difficulty', 3),
        ]);

        return response()->json(['success' => true]);
    }
}
