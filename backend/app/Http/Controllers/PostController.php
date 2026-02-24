<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Post;
class PostController extends Controller
{
    
function CreatePost(Request $req){

    $validator = validator::make($req->all(),[
        'title'=> 'required|string|max:255',
        'content'=> 'required|string',
        'user_id'=> 'required|exists:users,id'
    ]);

    if($validator->fails()){
        return response()->json([
            'success' => false,
            'error'=> $validator->errors()
        ], 422);
    }

        // create Post 

        $post = Post::create([
            'title'=>$req->title,
            'content'=>$req->content,
            'user_id'=> $req->user_id
        ]);

    return response()->json([
        'success'=> true,
        'message'=> 'Post Created Successfully',
        'post' => $post
    ]);
}
}
