<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $posts = Post::all();

        return response()->json(['data' => $posts], 200);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:100',
            'body' => 'required',
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'image_url' => $request->file('image_url')
        ]);
        
        
        return response()->json(['data' => $post], 200);
        


    }

    public function show($id)
    {
        $post =  Post::find($id);
        
                if (!$post) {
                    return response()->json(['data' => 'post not found'], 400); 
                }else {
                    return response()->json(['data' => $post], 200);
                }

    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if(!$post || $post->user_id != Auth::id()) {
            return response()->json(['data' => 'what\'s your own'], 400);
        } else {


                $post->title = $request->input('title');
                $post->body = $request->input('body');
                $post->image_url = $request->file('image_url');

                $post->save();

                return response()->json(['data' => $post], 400);
           
        }

    }

    public function destroy($id)
    {
        $post = Post::find($id);
        
        if(!$post || $post->user_id != Auth::id()) {
             return response()->json(['data' => 'Access denied'], 400);
        }else {
             $post->delete();
            return response()->json(['data' => 'Operation successful'], 200);
        }

    }
    
}
