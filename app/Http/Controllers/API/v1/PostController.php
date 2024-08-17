<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = false;
        $posts = '';
        $message = '';

        try {
            if ($posts = Post::where([
                ['school_id', $request->school_id],
                ['parent_id', '!==', 0],
            ])->with('user', 'childPosts')->orderBy('id', 'desc')->get()) {
                $status = true;
                $message = 'Success';
            }
        } catch (Exception $e) {
            $message = $e;
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
            "posts" => $posts,
        ])->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $status = false;
        $post = '';
        $message = '';

        $validatedData = $request->validate([
            'content' => ['required', 'max:1000'],
            'user_id' => ['required', 'integer'],
            'school_id' => ['required', 'integer'],
            'parent_id' => ['integer'],
        ]);

        if ($validatedData) {
            try {
                $post = new Post;
                $post->user_id = Auth::user()->id;
                $post->title = '';
                $post->content = $request->content;
                $post->school_id = $request->school_id;
                $post->parent_id = $request->parent_id | 0;
                $post->save();

                $status = true;
                $message = 'Success';
            } catch (Exception $e) {
                $message = $e;
            }
        } else {
            $message = 'Validate error';
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
            "post" => $post,
        ])->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $status = false;
        $post = '';
        $message = '';

        try {
            if ($post = Post::with('user', 'childPosts')->find($id)) {
                $status = true;
                $message = 'Success';
            }
        } catch (Exception $e) {
            $message = $e;
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
            "post" => $post,
        ])->setStatusCode(200);
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
        $status = false;
        $message = '';

        if ($post = Post::find($id)) {
            if ($post->user_id === Auth::user()->id) {
                $post->delete();

                $status = true;
                $message = 'Success';
            } else {
                $message = 'Permission Denied';
            }
        } else {
            $message = 'Post not found';
        }

        return response()->json([
            "status" => $status,
            "message" => $message,
        ])->setStatusCode(200);
    }
}
