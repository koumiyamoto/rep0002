@extends('layout')

@section('content')
<h1 class="text-center bg-success m-0 py-4">about page</h1>
<p class="text-center my-4">当サイトはブログサイトです。</p>
<div class="text-center my-4">
	<a class="" href="{{ route('contact') }}">お問い合わせはこちらから</a>
</div>

@endsection