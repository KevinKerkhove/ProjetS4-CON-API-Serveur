<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationFormRequest;
use App\Http\Resources\PersonneResource;
use App\Http\Resources\PlayerResource;
use App\Model\Personne;
use App\Model\Role;
use App\Modeles\Player;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PlayerController extends Controller {

    /**
     * PlayerController constructor.
     */
    public function __construct() {
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function index() {
        $players = Player::all();
        $data = PlayerResource::collection($players);
        return jsend_success($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(RegistrationFormRequest $request) {
        try {
            DB::transaction(function () use ($request) {
                $user = factory(User::class)->create([
                    'name' => $request->prenom . ' ' . $request->nom,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                ]);
                $user->role()->save(factory(Role::class)->make(['user_id' => $user->id, 'role' => 'player']));

                $player = factory(Player::class)->create([
                    'playTime' => $request->playTime,
                    'playerName' => $request->playerName,
                    'bestScore' => $request->bestScore,
                    'avatar' => 'avatars/anonymous.png',
                    'user_id' => $user->id,
                ]);
                $path = null;
                if ($request->hasFile('avatar')) {
                    $path = $request->file('avatar')->storeAs('avatars', 'avatar_de_' . $player->id . '.' . $request->file('avatar')->extension(), 'public');
                    $player->avatar = $path;
                    $player->save();
                }
            });
        } catch (Exception $e) {
            return jsend_error($e->getMessage(), $e->getCode());
        }
        $player = Player::select(['players.*', 'users.id', 'users.email'])->join('users', 'users.id', '=', 'players.user_id')->where('users.email', $request->email)->first();
        $data = new PlayerResource($player);
        return jsend_success(["data" => $data]);
    }

    public function update(Request $request, $id) {
        try {
            $player = Player::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return jsend_fail([
                "title" => "Player not found.",
            ], 422);
        }

        $user = $player->user;
        if ($request->has('email') && $player->user->email != $request->email) {
            $validator = Validator::make($request->all(),
                [
                    'nom' => 'required|string',
                    'prenom' => 'required|string',
                    'email' => ['required', 'email', Rule::unique('users')->ignore($user)],
                ]);
            if ($validator->fails()) {
                return jsend_fail([
                    "title" => "Updating failed",
                    "body" => $validator->errors()
                ], 422);
            }
        }
        $path = $player->avatar;
        if ($request->hasFile('avatar')) {
            Storage::disk('public')->delete($player->avatar);
            $path = $request->file('avatar')->storeAs('avatars', 'avatar_de_' . $player->id . '.' . $request->file('avatar')->extension(), 'public');
        }
        $player->nom = $request->get('nom');
        $player->prenom = $request->get('prenom');
        $user->name = $request->prenom . ' ' . $request->nom;
        $user->email = $request->get('email');
        if ($request->has('password')) {
            $user->password = bcrypt($request->get('password'));
        }
        if ($request->has('playTime')) {
            $player->playTime = $request->get('playTime');
        }
        if ($request->has('bestScore')) {
            $player->bestScore = $request->get('bestScore');
        }
        $player->avatar = $path;
        $player->save();
        $user->save();
        $data = new PlayerResource($player);
        return jsend_success($data);
    }

    public function show($id) {
        try {
            $player = Player::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return jsend_fail([
                "title" => "Player not found.",
            ], 422);
        }
        $data = new PlayerResource($player);
        return jsend_success( $data);
    }

    public function destroy($id) {
        try {
            $player = Player::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return jsend_fail([
                "title" => "Player not found.",
            ], 422);
        }
        try {
            DB::transaction(function () use ($player) {
                Storage::disk('public')->delete($player->avatar);
                $user = $player->user;
                $user->delete();
            });
        } catch (Exception $e) {
            return jsend_error($e->getMessage(), $e->getCode());
        }
        return jsend_success(['message' => 'Player deleted successfully.'], 204);
    }


    public function getPlayer() {
        $user = Auth::user();
        $data = new PlayerResource($user->player);
        return jsend_success($data);
    }

}
