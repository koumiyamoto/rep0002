@extends('layout')

@section('content')

<h1 class="text-center py-4 bg-dark">contact page</h1>

<div class="container mt-5 bottom-spacer">
	<form class="col-12 col-md-9 col-lg-6 mx-auto needs-validation" method="post" action="{{ route('mail') }}">
		@csrf
		<div class="form-group">
			<label for="name">お名前</label>
			<input id="name" class="form-control @if($errors->has('name')) is-invalid @endif" type="text" name="name" value="{{ old('name') }}" placeholder="お名前を入力してください" required>
			@if($errors->has('name'))
				<div class="invalid-feedback">{{ $errors->first('name') }}</div>
			@endif
		</div>
		<div class="form-group pt-3">
			<label for="title">件名</label>
			<input id="title" class="form-control @if($errors->has('title')) is-invalid @endif" type="text" name="title" value="{{ old('title') }}" placeholder="件名" required>
			@if($errors->has('title'))
				<div class="invalid-feedback">{{ $errors->first('title') }}</div>
			@endif
		</div>
		<div class="form-group pt-3">
			<label for="mail">Eメール</label>
			<input type="email" id="mail" class="form-control @if($errors->has('email')) is-invalid @endif" type="text" name="email" value="{{ old('email') }}" placeholder="Eメールを入力してください" required>
			@if($errors->has('email'))
				<div class="invalid-feedback">{{ $errors->first('email') }}</div>
			@endif
		</div>
		<div class="form-group pt-3">
			<label for="textarea">お問い合わせ内容</label>
			<textarea id="textarea" class="form-control @if($errors->has('body')) is-invalid @endif" name="body" value="{{ old('body') }}" placeholder="お問い合わせ内容を入力してください" required></textarea>
			@if($errors->has('body'))
				<div class="invalid-feedback">{{ $errors->first('body') }}</div>
			@endif
		</div>
		<div>
			<button type="submit" class="btn btn-primary w-100 mt-5">送信</button>
		</div>
	</form>	
	<div class="text-center mt-5">
		<a href="{{ route('home') }}">トップページへ戻る</a>
	</div>
</div>
@endsection