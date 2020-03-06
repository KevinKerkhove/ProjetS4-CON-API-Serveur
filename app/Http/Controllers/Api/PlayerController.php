<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationFormRequest;
use App\Http\Resources\PlayerResource;
use App\Modeles\Player;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PlayerController extends Controller {
    protected $data = [];

    /**
     * PlayerController constructor.
     */
    public function __construct() {
        $this->data = [
            'status' => false,
            'code' => 401,
            'data' => null,
            'err' => [
                'code' => 1,
                'message' => 'Unauthorized'
            ]
        ];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $players = Player::all();
        $this->data['status'] = true;
        $this->data['code'] = 200;
        $this->data['data'] = PlayerResource::collection($players);
        $this->data['err'] = null;
        return response()->json($this->data, $this->data['code']);

    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(RegistrationFormRequest $request) {
        try {
            DB::transaction(function () use ($request) {
                $user = factory(User::class)->create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                ]);
                $player = factory(Player::class)->create([
                    'playerName' => $request->username,
                    'bestScore' => null,
                    'playTime' => null,
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
            $this->data['status'] = false;
            $this->data['code'] = 422;
            $this->data['data'] = null;
            $this->data['err'] = [
                'code' => 1,
                'message' => $e->getMessage(),
            ];
            return response()->json($this->data, $this->data['code']);
        }
        $player = Player::select(['players.*', 'users.id', 'users.email'])->join('users', 'users.id', '=', 'players.user_id')->where('users.email', $request->email)->first();
        $this->data['status'] = true;
        $this->data['code'] = 200;
        $this->data['data'] = new PlayerResource($player);
        $this->data['err'] = null;
        return response()->json($this->data, $this->data['code']);
    }

    public function update(Request $request, $id) {
        $player = Player::find($id);
        if (!$player) {
            $this->data['status'] = false;
            $this->data['code'] = 422;
            $this->data['data'] = null;
            $this->data['err'] = [
                'code' => 1,
                'message' => sprintf('Le joueur avec l\'id : %d n\'est pas dans la base', $id),
            ];
            return response()->json($this->data, $this->data['code']);
        }
        $user = $player->user;
        if ($request->has('email') && $player->user->email != $request->email) {
            $validator = Validator::make($request->all(),
                [
                    'username' => 'required|string',
                    'email' => ['required', 'email', Rule::unique('users')->ignore($user)],
                ]);
            if ($validator->fails()) {
                $this->data['code'] = 422;
                $this->data['err'] = [
                    'code' => 1,
                    'message' => $validator->errors(),
                ];
                return response()->json($this->data, $this->data['code']);
            }
        }
        $path = $player->avatar;
        if ($request->hasFile('avatar')) {
            Storage::disk('public')->delete($player->avatar);
            $path = $request->file('avatar')->storeAs('avatars', 'avatar_de_' . $player->id . '.' . $request->file('avatar')->extension(), 'public');
        }
        $player->username = $request->get('username');
        $user->name = $request->username;
        $user->email = $request->get('email');
        if ($request->has('password'))
            $user->password = bcrypt($request->get('password'));
        $player->avatar = $path;
        $player->save();
        $user->save();
        $this->data['status'] = true;
        $this->data['code'] = 200;
        $this->data['data'] = new PlayerResource($player);
        $this->data['err'] = null;
        return response()->json($this->data, $this->data['code']);
    }

    public function show($id) {
        $player = Player::find($id);
        if (!$player) {
            $this->data['status'] = false;
            $this->data['code'] = 422;
            $this->data['data'] = null;
            $this->data['err'] = [
                'code' => 1,
                'message' => sprintf('Le joueur avec l\'id : %d n\'est pas dans la base', $id),
            ];
        } else {
            $this->data['status'] = true;
            $this->data['code'] = 200;
            $this->data['data'] = new PlayerResource($player);
            $this->data['err'] = null;
        }
        return response()->json($this->data, $this->data['code']);
    }

    public function destroy($id)
    {
        $player = Player::find($id);
        if (!$player) {
            $this->data['status'] = false;
            $this->data['code'] = 422;
            $this->data['data'] = null;
            $this->data['err'] = [
                'code' => 1,
                'message' => sprintf('Le joueur avec l\'id : %d n\'est pas dans la base', $id),
            ];
            return response()->json($this->data, $this->data['code']);
        }
        Log::info('path de l\'avatar à supprimer : '.$player->avatar);
        Storage::disk('public')->delete($player->avatar);
        $user = $player->user;
        if ($user->delete()) {
            return response()->json([
                'success' => true
            ], 204);
        } else {
            $this->data['status'] = false;
            $this->data['code'] = 422;
            $this->data['data'] = null;
            $this->data['err'] = [
                'code' => 1,
                'message' => sprintf('Le joueur avec l\'id : %d ne peut pas être supprimée', $id),
            ];
            return response()->json($this->data, $this->data['code']);
        }
    }
}
