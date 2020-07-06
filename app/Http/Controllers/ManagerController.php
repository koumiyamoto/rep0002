<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Article;
use App\Tag;
use App\Post;
use App\PostTag;
use App\Comment;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    // 管理画面
    public function manager() {
        $posts = Post::where('user_id', '=', Auth::id())->latest()->paginate(10);
        $tags = Tag::all();
        $order = 'new';
        return view('manager', compact('posts', 'tags', 'order'));
    }

    // 
    public function show(Post $post) {
        $comments = Comment::where('post_id', '=', $post->id)->get();

        // 閲覧数update
        $post->view_count++;
        $post->save();

        $fromManager = true;

        return view('show', [
            'post'        => $post, 
            'comments'    => $comments,
            'fromManager' => $fromManager
        ]);
    }

    // 管理画面の記事を並べ替え
    public function manageOrderNew() {
		$posts = Post::where('user_id', '=', Auth::id())->latest()->paginate(10);
    	$tags = Tag::all();
        $order = 'new';
    	return view('manager', compact('posts', 'tags', 'order'));
    }

    // 管理画面の記事を並べ替え
    public function manageOrderOld() {
        $posts = Post::where('user_id', '=', Auth::id())->oldest()->paginate(10);
        $tags = Tag::all();
        $order = 'old';
        return view('manager', compact('posts', 'tags', 'order'));
    }

    // 管理画面の記事を並べ替え
    public function manageOrderPopular() {
        $posts = Post::where('user_id', '=', Auth::id())->orderBy('view_count', 'desc')->paginate(10);
        $tags = Tag::all();
        $order = 'popular';
        return view('manager', compact('posts', 'tags', 'order'));
    }

    // 検索機能
    public function search(Request $request) {
        $keyword = $request->keyword;
        $search_msg = '';
        if(!empty($keyword)) {
            // 記事名から検索
            $posts = Post::where('user_id', '=', Auth::id())->where('title', 'like', '%'.$keyword.'%')->where('public_flag', '=', 1)->latest()->paginate(10);
            $search_msg = '該当する記事が見つかりました';
        } else {
            $posts = Post::where('user_id', '=', Auth::id())->latest()->paginate(10);
            $search_msg = '該当する記事が見つかりませんでした';
        }
        $tags = Tag::all();
        $name_flag = 1;
        $order = 'search';

        return view('manager', compact('posts', 'tags', 'name_flag', 'keyword', 'order'));
    }
}
