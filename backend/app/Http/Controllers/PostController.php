<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Post;
class PostController extends Controller
{

    function CreatePost(Request $req)
    {

        $validator = validator::make($req->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()
            ], 422);
        }

        // create Post 

        $post = Post::create([
            'title' => $req->title,
            'content' => $req->content,
            'user_id' => $req->user()->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post Created Successfully',
            'post' => $post
        ]);
    }

    function getPosts(Request $req){
    $posts = Post::where('user_id', $req->user()->id)->latest()->get();
    return response()->json([
        'posts' => $posts
    ]);


    }

    function userDashboard(Request $req){
        $user = $req->user();
        
        // Get user's posts count
        $totalPosts = Post::where('user_id', $user->id)->count();
        
        // Get recent posts (last 5)
        $recentPosts = Post::where('user_id', $user->id)
                           ->orderBy('created_at', 'desc')
                           ->take(5)
                           ->get();
        
        // Get total users
        $totalUsers = \App\Models\User::count();
        
        return response()->json([
            'totalPosts' => $totalPosts,
            'totalUsers' => $totalUsers,
            'comments' => 0,
            'recentPosts' => $recentPosts
        ]);
    }



}
