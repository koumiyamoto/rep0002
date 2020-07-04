<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use App\Http\Requests\PostRequest;

class CommentsController extends Controller
{
    // コメントの投稿
    public function comment(Request $request, Post $post) {
    	$comment = new Comment();
    	$comment->body = $request->body;
    	$comment->name = $request->name;
    	$comment->post_id = $post->id;
    	$comment->save();
    	$comments = Comment::where('post_id', '=', $post->id)->get();

    	return redirect()->action('FirstController@show', ['post' => $post, 'comments' => $comments])->with('success', 'コメントを投稿しました！');
    }

    // コメントの削除
    public function destroy(Post $post, Comment $comment) {
    	$comment->delete();
    	$comments = Comment::where('post_id', '=', $post->id)->get();
    	return redirect()->action('FirstController@show', ['post' => $post, 'comments' => $comments])->with('success', 'コメントを削除しました');
    }
}
