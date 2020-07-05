@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    ログインしました！
                </div>
                <div class="card-footer d-flex">
                    <div class="mr-auto"><a href="{{ route('home') }}">Home に戻る</a></div>
                    <div><a href="{{ route('manager') }}">管理画面へ進む</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
