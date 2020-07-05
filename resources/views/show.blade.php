@extends('layout')

@section('content')
	
	<div class="header">
		<div class="container">
			<a href="{{ route('home') }}" class="text-center back_btn right px-2">← HOME に戻る</a>
			<h1 class="py-4 text-left">My Blog</h1>
		</div>
	</div>

	@include('navbar')

	<!-- パンくず -->
	<div class="container mt-4">
		<nav aria-label="breadcrumb">
		  	<ol class="breadcrumb mb-0">
			    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
			    <li class="breadcrumb-item active text-break" aria-current="page">記事タイトル：{{ $post->title }}</li>
		  	</ol>
		</nav>
	</div>

	<!-- 記事内容 -->
	<div class="container mt-3">

		<!-- モーダルアラート -->
			@if(session('success'))
			<div class="modal fade" id="modal_box" tabindex="-1" role="dialog">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content border-0">
			      <div class="modal-header bg-warning text-success">
			        <h5 class="modal-title font-weight-bold">処理結果</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <p>{{ session('success') }}</p>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>
			@endif
		<!-- モーダルアラート -->
	
		<!-- 本体 -->
		<h2 class="post-title d-block col-11 pl-0 text-break ">{{ $post->title }}</h2>
		<div class="d-flex flex-row mb-5 mt-4">
			<div class="mr-4">作成日：{{ $post->created_at->format('Y/m/d') }}</div>
			<div>総閲覧数：{{ $post->view_count }}</div>
		</div>

		@if($post->image_path)
		<div class="post_top_image text-left mb-5">
			<img src="../../storage/app/{{ $post->image_path }}" alt="" height="500" class="w-75">
		</div>
		@endif
		
		<div class="mb-4 post-body">
			<p class="">{!! nl2br(e($post->body)) !!}</p>
		</div>

		<!-- タグ -->
		@unless($post->tags->isEmpty())
			<div class="">
				<ul class="tag_list d-flex p-0">
					@foreach($post->tags as $tag)
					<li class="tag rounded mr-3 p-1">{{ $tag->name }}</li>
					@endforeach
				</ul>
			</div>
		@endunless
	</div>


	<!-- コメント内容 -->
	<div class="container mt-5">
		<div class="mb-4">
			<h4 class="py-2 font-weight-bold"><span class="mr-2"><img class="comment_icon" src="{{ asset('/img/comment.png') }}"></span>コメント</h4>
		</div>
		@forelse($comments as $comment)
		<div class="mb-4 border-bottom">
			<div class="d-flex flex-row">
				<div class="comment_number pl-2 font-weight-bold mr-auto">{{ $loop->iteration }}. {{ $comment->name }}さん</div>
				<div class="comment_created_at">{{ $comment->created_at->format('Y年m月d日') }}</div>
			</div>
			<p class="comment pl-4">{!! nl2br(e($comment->body)) !!}</p>
			<div class="d-flex flex-row pb-4">
				<a href="#" class="comment_del ml-auto" data-post="{{ $post->id }}" data-comment="{{ $comment->id }}"><img class="comment_icon" src="{{ asset('/img/trash_box.png') }}" alt=""></a>
				<form method="post" action="{{ action('CommentsController@destroy', [$post->id, $comment->id]) }}" id="form_{{ $comment->id }}">
					@csrf
					{{ method_field('delete') }}
				</form>
			</div>
		</div>
		@empty
			<div class="comment pb-4 mb-5">※コメントはありません</div>
		@endforelse
	</div>

	<!-- コメント投稿フォーム -->
	<form class="container" method="post" action="{{ action('CommentsController@comment', $post) }}">
		@csrf
		<div class="w-100 form-group">
			<input class="mb-2 col-12 col-lg-6 form-control" type="text" name="name" value="名無し" placeholder="コメントの名前を入力してください">
			<textarea id="textarea" class="comment_body col-12 col-lg-6 form-control" name="body" placeholder="コメントを入力してください" required>{{ old('body') }}</textarea>
			<!-- @if ($errors->has('body'))
			<span class="error mt-3">{{ $errors->first('body') }}</span>
			@endif -->
		</div>
		<p class="pb-5 mb-5">
			<input type="submit" class="btn btn-sm btn-primary" name="submit" value="コメントを投稿" placeholder="">
		</p>
	</form>
@endsection
