<?php


namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        // $this->middleware('auth-admin:api');
    }
    
    public function index()
    {
       $comment = Comment::all();

       return response()->json(['data' => $comment], 200);
       
    }

    public function show($id)
    {
        $comment = Comment::find($id);

        if(!$comment) {
            return response()->json(['data' => 'comment not found'], 400);
        }else {
            return response()->json(['data' => $comment], 200);
        }
    }
    
}
