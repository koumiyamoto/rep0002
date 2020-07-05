@extends('layout')

@section('content')
	<div class="header_new">
		<div class="container">
			<a href="{{ url('/manager') }}" class="text-center right_new px-2">← 管理画面</a>
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
			    <li class="breadcrumb-item active" aria-current="page">新規作成</li>
		  	</ol>
		</nav>
	</div>
	
	<div class="bottom-spacer">
		<form class="container mt-2 needs-validation" method="post" action="{{ action('FirstController@create') }}" enctype="multipart/form-data" novalidate>
			<h2 class="py-2">新規作成</h2>
			@csrf
			<div class="w-100 my-4 form-group">
				<label class="font-weight-bold" for="text">タイトル</label>
				<input class="w-100 form-control @if($errors->has('title')) is-invalid @endif" id="text" type="text" name="title" placeholder="タイトルを入力してください" value="{{ old('title') }}" required>
				<small class="form-text text-muted">
					タイトルは3文字以上120文字以下で入力してください。
				</small>
				@if ($errors->has('title'))
					<div class="invalid-feedback">{{ $errors->first('title') }}</div>
				@endif
			</div>
			<div class="form-group my-4 mt-4 col-12 col-lg-6 px-0">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="font-weight-bold input-group-text bg-primary text-white">記事画像</span>
					</div>
					<div class="custom-file">
						<label class="custom-file-label" for="image" data-browse="画像を選択">アップロード</label><br>
						<input class="custom-file-input" id="image" type="file" name="image">
					</div>
					<!-- <div class="input-group-append d-none d-md-block">
						<button type="button" class="btn btn-outline-primary">解除</button>
					</div> -->
				</div>
				@if ($errors->has('image'))
					<div class="invalid-feedback">{{ $errors->first('image') }}</div>
				@endif
			</div>
			<div class="w-100 form-group mt-4">
				<label class="font-weight-bold" for="textarea">本文</label>
				<textarea id="textarea" class="form-control new_body w-100 @if($errors->has('body')) is-invalid @endif" name="body" placeholder="本文を入力してください" required>{{ old('body') }}</textarea>
				@if ($errors->has('body'))
					<div class="invalid-feedback">{{ $errors->first('body') }}</div>
				@endif
			</div>
			<div class="w-100 form-group mt-4">
				<h5>Tags</h5>
				@foreach($tag_list as $tag)
				<div class="form-check form-check-inline">
						<input type="checkbox" class="form-check-input" id="tags_{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}">
						<label class="form-check-label" for="tags_{{ $tag->id }}">{{ $tag->name }}</label>	
				</div>
				@endforeach
			</div>
			<div class="mt-4">
				<lavel>記事を公開する</lavel>
				<select name="public_flag">
					<option value="0">非公開</option>
					<option value="1">公開</option>
				</select>
			</div>
			<div class="mt-4">
				<input id="create_btn" type="submit" class="btn btn-primary" name="submit" value="記事を作成" placeholder="">
			</div>
		</form>
	</div>
@endsection
