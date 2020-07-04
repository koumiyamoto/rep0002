@extends('layout')

@section('content')
<div class="container mt-3">
	<h1>other</h1>
	{!! Form::open(['url' => '#']) !!}
	<div class="form-group row">
		{{ Form::label('hoge', 'テスト') }}
		{{ Form::text('aaa', 'aaa') }}
	</div>
	{!! Form::close() !!}
</div>
@endsection