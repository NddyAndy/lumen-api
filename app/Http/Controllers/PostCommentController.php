<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostCommentController extends Controller
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
    public function index($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['data' => 'posts not found'], 400);
        }else {

            $comments = $post->comments;
            if ($comments) {
                return response()->json(['data' => $comments], 200);
            }
            
        }
    }
    
    public function store(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['data' => 'no commenting to ghost posts'], 400);
        }
        $this->validate($request, [
            'body' => 'required|max:255'
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'body' => $request->input('body')
        ]);

        return response()->json(['data' => $comment], 200);


    }

    public function show()
    {

    }

    public function update(Request $request, $p_id, $c_id)
    {
        
        $this->validate($request, [
            'body' => 'required|max:255'
        ]);
        
        $post = Post::find($p_id);
        $comment = Comment::find($c_id);

        if(!$post || !$comment || $comment->id != Auth::id())
        {
            return response()->json(['data'=>'access denied'], 400);
        }
       

        $comment->body = $request->input('body');

        $comment->save();

        return response()->json(['data' => 'update successful'], 200);
        
    }

    public function destroy($c_id, $p_id)
    {
        $post = Post::find($p_id);
        $comment = Comment::find($c_id);

        if(!$post || !$comment  || $comment->user_id != Auth::id()) {
            return response()->json(['data' => 'records not found'], 400);
        } else if (!$post->commentS()->find($c_id)){
            return response()->json(['data' => 'records not found'], 400);
        } else {

            $comment->delete();

            return response()->json(['data' => 'comment deleted'], 200);
        }

    }
    
}
