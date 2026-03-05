<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public  function showCreatePost()
    {
        return view('create-post');
    }

    public function storeNewPost(Request $request)
    {
        // Validation
        $incomingFields = $request->validate([
            'title' => ['required', 'max:255'],
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = Auth::id();

        // Store the post
        $newPost = Post::create($incomingFields);
        session()->flash('success', 'Vaš članak je uspešno kreiran.');
        return redirect("/post/{$newPost->id}");
        // return redirect("/post/{$newPost->id}")->with('success', 'Your post was created successfully.');
    }

    public function viewSinglePost(Post $post)
    {
        return view('single-post', ['post' => $post]);
    }
}
