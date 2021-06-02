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

class FirstController extends Controller
{
	public function __construct() {
		$this->middleware('auth')->except(['index', 'show', 'order', 'guestOrder', 'search']);
	}

    // top page(公開済みの記事の一覧表示)
    public function index() {
    	$posts = Post::where('public_flag', '=', 1)->latest()->paginate(10);
        $tags = Tag::all();
        $name_flag = 1;
        $famousPosts = Post::where('public_flag', '=', 1)->orderBy('view_count', 'desc')->take(10)->get();
        if(session()->has('count')) {
            $count = session('count');
        } else {
            $count = 0;
        }
        $count++;
        session(['count' => "$count"]);
        $order = "new";
        return view('index', compact('posts', 'tags', 'name_flag', 'famousPosts', 'count', 'order'));
    }

    // TOP PAGEの記事を並べ替え
    public function orderNew() {
		$posts = Post::where('public_flag', '=', 1)->latest()->paginate(10);
    	$tags = Tag::all();
        $name_flag = 1;
        if(session()->has('count')) {
            $count = session('count');
        } else {
            $count = 0;
        }
        $count++;
        session(['count' => "$count"]);

        $isOrdered = true;
        $isOrderNew = true;
        $order = "new";

    	return view('index', compact('posts', 'tags', 'name_flag', 'count', 'order'));
    }

    // TOP PAGEの記事を並べ替え
    public function orderOld() {
        $posts = Post::where('public_flag', '=', 1)->oldest()->paginate(10);
        $tags = Tag::all();
        $name_flag = 1;
        if(session()->has('count')) {
            $count = session('count');
        } else {
            $count = 0;
        }
        $count++;
        session(['count' => "$count"]);

        $order = "old";

        return view('index', compact('posts', 'tags', 'name_flag', 'count', 'order'));
    }

    // TOP PAGEの記事を並べ替え
    public function orderPopular() {
        $posts = Post::where('public_flag', '=', 1)->orderBy('view_count', 'desc')->paginate(10);
        $tags = Tag::all();
        $name_flag = 1;
        if(session()->has('count')) {
            $count = session('count');
        } else {
            $count = 0;
        }
        $count++;
        session(['count' => "$count"]);

        $order = "popular";

        return view('index', compact('posts', 'tags', 'name_flag', 'count', 'order'));
    }

    // 検索機能
    public function search(Request $request) {
        $keyword = $request->keyword;
        $search_msg = '';
        if(!empty($keyword)) {
            // 記事名から検索
            $posts = Post::where('title', 'like', '%'.$keyword.'%')->where('public_flag', '=', 1)->latest()->paginate(10);
            $search_msg = '該当する記事が見つかりました';
        } else {
            $posts = Post::where('user_id', '=', Auth::id())->latest()->paginate(10);
            $search_msg = '該当する記事が見つかりませんでした';
        }
        $tags = Tag::all();
        $name_flag = 1;
        if(session()->has('count')) {
            $count = session('count');
        } else {
            $count = 0;
        }
        $count++;
        session(['count' => "$count"]);
        $order = 'search';

        return view('index', compact('posts', 'tags', 'name_flag', 'keyword', 'count', 'order'));
    }

    // // Top Page タグで絞込み
    // public function tag(Request $request) {
    // 	$posts = Post::where('user_id', '=', Auth::id())->paginate(10);
    // 	$tags = Tag::all();
    // 	return view('index', compact('posts', 'tags'));
    // }

    // // 自分以外公開済みの記事一覧を表示
    // public function release() {
    //     $posts = Post::where('public_flag', '=', 1)->where('user_id', '<>', Auth::id())->latest()->paginate(10);
    //     $tags = Tag::all();
    //     $name_flag = 1;
    //     return view('index', compact('posts', 'tags', 'name_flag'));
    // }

    // 記事の詳細表示(＋コメントの一覧表示)
    public function show(Post $post) {
    	$comments = Comment::where('post_id', '=', $post->id)->get();

        // 閲覧数update
        $post->view_count++;
        $post->save();

        $fromManager = false;

    	return view('show', [
            'post'        => $post, 
            'comments'    => $comments,
            'fromManager' => $fromManager
        ]);
    }

    // 新規作成画面の表示
    public function new() {
    	$tag_list = Tag::all();
    	return view('new', compact('tag_list'));
    }

    // 新規記事の保存
    public function create(PostRequest $request) {
        //画像があれば、画像ファイルをセット
    	if(isset($request->image)) {
    		$image_path = $request->image->store('public/post_images');
    	}

        //新規投稿の値を設定・保存
    	$post = new Post();
    	$post->title = $request->title;
    	$post->body = $request->body;
    	$post->user_id = Auth::user()->id;
        $post->public_flag = $request->public_flag;
    	if(isset($image_path)) {
    		$post->image_path = $image_path;
    	}
        $post->view_count = 0;
    	$post->save();

        //
    	$post->tags()->attach($request->input('tags'));

    	return redirect('/manager')
            ->with('success', '記事を作成しました');
    }

    // 記事編集画面の表示
    public function edit(Post $post) {
    	$tag_list = Tag::all();

    	return view('edit', compact('post', 'tag_list'));
    }

    // 記事の更新
    public function update(PostRequest $request, Post $post) {
        //画像
    	if(isset($request->image)) {
    		$image_path = $request->image->store('public/post_images');
    	}

        //編集内容の保存
    	$post->title = $request->title;
    	$post->body = $request->body;
        $post->public_flag = $request->public_flag;
    	if(isset($image_path)) {
    		$post->image_path = $image_path;
    	}
    	$post->save();

        //タグ？？
    	$post->tags()->sync($request->input('tags'));

    	return redirect('/manager')->with('success', ' "' . $post->title . '" ' . 'の内容を更新しました');
    }

    // 記事の削除
    public function destroy(Post $post) {
    	$post->delete();
    	return redirect('manager')->with('success', '記事を削除しました');
    }

    //記事の公開設定の切り替え
    public function publish(Post $post) {
        $post->public_flag = !$post->public_flag;
        $post->save();
        return 'success';
    }

}
