<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use App\Models\UserFollow;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return response()->json([
            'message' => 'Success!'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function follow(Request $request)
    {
        $status = false;
        $user_follow = '';
        $message = '';

        try {
            if ($request->to_user_id && $user_follow = UserFollow::where([
                ['user_id', Auth::user()->id],
                ['to_user_id', $request->to_user_id],
            ])->first()) {
                $message = 'запись уже существует 1';

            } else if ($request->to_school_id && $user_follow = UserFollow::where([
               ['user_id', Auth::user()->id],
               ['to_school_id', $request->to_school_id],
           ])->first()) {
               $message = 'запись уже существует 2';

           } else {
               $user_follow = new UserFollow;
               $user_follow->user_id = Auth::user()->id;
               $user_follow->to_user_id = $request->to_user_id;
               $user_follow->to_school_id = $request->to_school_id;
               $user_follow->save();

               $status = true;
               $message = 'Success';
           }
        } catch (Exception $e) {
            $message = $e;
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
            "user_follow" => $user_follow,
        ])->setStatusCode(200);
    }

    public function unfollow(Request $request)
    {
        $status = false;
        $user_follow = '';
        $message = '';

        if ($request->to_user_id || $request->to_school_id) {
            try {
                if ($user_follow = UserFollow::where([
                    ['user_id', Auth::user()->id],
                    ['to_user_id', $request->to_user_id],
                ])->orWhere([
                    ['user_id', Auth::user()->id],
                    ['to_school_id', $request->to_school_id],
                ])->first()) {
                    $user_follow->delete();

                    $status = true;
                    $message = 'Success';
                } else {
                    $message = 'Подписка не найдена';
                }
            } catch (Exception $e) {
                $message = $e;
            }
        } else {
            $message = 'Required parameters are missing';
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
        ])->setStatusCode(200);
    }
}
