@extends('layout')

@section('content')
	<div class="header_edit">
		<div class="container">
			<a href="{{ url('/manager') }}" class="text-center back_btn right_edit px-2">← 管理画面</a>
			<h1 class="py-4 text-left">My Blog</h1>
		</div>
	</div>

	@include('navbar')

	<!-- パンくず -->
	<div class="container mt-4">
		<nav aria-label="breadcrumb">
		  	<ol class="breadcrumb mb-0">
			    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
			    <li class="breadcrumb-item"><a href="{{ route('manager') }}">管理画面</a></li>
			    <li class="breadcrumb-item active text-break" aria-current="page">記事編集（タイトル：{{ $post->title }}）</li>
		  	</ol>
		</nav>
	</div>

	<!-- 作成フォーム -->
	<form class="container mt-2 needs-validation" method="post" action="{{ url('posts', $post->id) }}" enctype="multipart/form-data">
		<h2 class="py-2">記事編集</h2>
		@csrf
		{{ method_field('patch') }}
		<div class="w-100 mb-4 form-group">
			<label for="text">タイトル</label>
			<input class="w-100 form-control @if($errors->has('title')) is-invalid @endif" id="text" type="text" name="title" placeholder="タイトルを入力してください" value="{{ old('title', $post->title) }}" required>
			<small class="form-text text-muted">入力文字は3文字以上120文字以下にしてください</small>
			@if ($errors->has('title'))
				<span class="invalid-feedback">{{ $errors->first('title') }}</span>
			@endif
		</div>
		<!-- <div class="form-group my-4 col-12 col-lg-6 px-0">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-primary text-white">記事画像</span>
				</div>
				<div class="custom-file">
					<label class="custom-file-label" for="image" data-browse="画像を選択">アップロード</label><br>
					<input class="custom-file-input" id="image" type="file" name="image">
				</div>
				<div class="input-group-append d-none d-md-block">
					<button type="button" class="btn btn-outline-primary">解除</button>
				</div>
			</div>
			<small class="form-text text-muted">jpeg,png,jpg,gif形式のファイルのみ投稿できます</small>
			@if ($errors->has('image'))
				<div class="invalid-feedback">{{ $errors->first('image') }}</div>
			@endif
		</div> -->
		<div class="w-100 mb-0 form-group">
			<label for="textarea">本文</label>
			<textarea id="textarea" class="new_body w-100 form-control @if($errors->has('body')) is-invalid @endif" name="body" placeholder="本文を入力してください" required>{{ old('body', $post->body) }}</textarea>
			<div class="d-flex flex-row">
				<!-- <small class="form-text text-muted mr-auto">必須項目です</small> -->
				<div><span id="text_count" class="pr-2">0</span>文字</div>
			</div>
			@if ($errors->has('body'))
				<span class="invalid-feedback">{{ $errors->first('body') }}</span>
			@endif
		</div>
		<div class="w-100 form-group mt-4">
			<h5 for="tags">Tags</h5>
			@foreach($tag_list as $tag)
			<div class="form-check form-check-inline">
					<input type="checkbox" class="form-check-input" id="tags_{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}">
					<label class="form-check-label" for="tags_{{ $tag->id }}">{{ $tag->name }}</label>	
			</div>
			@endforeach
		</div>
		<div class="form-group mt-4">
			<label for="select">記事の公開設定</label>
			<select id="select" class="form-control col-12 col-md-3" name="public_flag">
				<option value="0">非公開</option>
				<option value="1">公開</option>
			</select>
		</div>
		<div class="mb-5 pb-5">
			<input type="submit" class="edit_btn btn btn-primary" name="submit" value="記事を変更" placeholder="">
		</div>
	</form>
@endsection