@extends('layout')

@section('content')
	<div class="header">
		<div class="container right_btn">
			@auth
			<a href="{{ url('posts/new') }}" class="text-center create_btn right px-2">新規作成</a>
			@endauth
			<h1 class="py-4 text-left">My Blog</h1>
		</div>
	</div>

	@include('navbar')
	
	<div class="container-wrapper">
		<div class="container pt-4">
			@auth
				<!-- アラート表示 -->
				@if(session('success'))
				<div class="modal fade" data-keyboard="true" id="modal_box" tabindex="-1" role="dialog">
				  <div class="modal-dialog modal-dialog-centered" role="document">
				    <div class="modal-content">
				      <div class="modal-header bg-warning">
				        <h5 class="modal-title text-success font-weight-bold">処理結果</h5>
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

				<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_box">test</button> -->

				<!-- コンテンツ -->
				<div class="row content">

					<!-- 左サイドバー -->
					<div class="col-12 col-lg-4 col-2 pt-2 mb-3 pr-4">
						<div class="bg-white p-2 p-lg-4 rounded">
							<h2><span class="badge badge-pill badge-danger text-center d-block">管理画面</span></h2>
							<div class="text-center pt-2 pt-lg-3"><span class="font-weight-bold">{{ Auth::user()->name }}</span> さん</div>
							<div class="row mt-3">
								<div class="col-6 text-center font-weight-bold border-right">{{ $post_count }}</div>
								<div class="col-6 text-center font-weight-bold public-post-count">{{ $public_post_count }}</div>
								<div class="manager-profile-text col-6 text-center border-right">記事数</div>
								<div class="manager-profile-text col-6 text-center">公開中</div>
							</div>
							<div class="d-none d-lg-block mt-5">
								<!-- 並び替え -->
								<label class="font-weight-bold" for="order">並べ替え</label>
								<div class="order-wrapper py-1 px-3 mb-2 @if($order == 'new')bg-primary @endif rounded">
									<a href="{{ route('manageOrderNew') }}" class="d-block w-100 h-100 @if($order == 'new')text-white @endif order">新しい順</a>
								</div>
								<div class="order-wrapper py-1 px-3 mb-2 @if($order == 'old')bg-primary @endif rounded">
									<a href="{{ route('manageOrderOld') }}" class="d-block w-100 h-100 @if($order == 'old')text-white @endif order">古い順</a>
								</div>
								<div class="order-wrapper py-1 px-3 @if($order == 'popular')bg-primary @endif rounded">
									<a href="{{ route('manageOrderPopular') }}" class="d-block w-100 h-100 @if($order == 'popular')text-white @endif order">人気の高い順</a>
								</div>

								<!-- 検索フォーム -->
								<form class="mt-4" action="{{ route('managerSearch') }}" method="get">
									<!-- @csrf -->
									<div class="form-group">
										<label class="font-weight-bold" for="search">タイトル検索</label>
										<input class="form-control form-control-sm ml-3 mt-1 w-75"  type="text" name="keyword" value="" placeholder="タイトル検索" required>
									</div>
									<button id="search_btn" type="submit" class="btn btn-sm btn-primary ml-3">検索</button>
								</form>
							</div>
						</div>
					</div>

					<!-- メイン -->
					<div class="bg-white col-12 col-lg-8 mb-5 rounded pt-5">
						<!-- 記事一覧 -->
						<div class="d-flex flex-auto border-bottom align-items-center pb-3">
							<h2 class="pb-3 mb-0 mt-1 mr-auto">あなたが投稿した記事一覧</h2>
							@isset($keyword)
								<div class="">"{{ $keyword }}" の検索結果：{{ $posts->total() }}件</div>
							@endisset
						</div>
						@forelse($posts as $post)
							<div class="post py-2 d-flex flex-row align-items-center border-bottom">
								<a class="d-block rounded post_link pl-2 ml-1 mr-1 w-100 py-1 text-break" href="{{ action('ManagerController@show', $post) }}">{{ $post->title }}</a>

								@if($order == 'popular')
								<div class="pr-3 text-nowrap">{{ $post->view_count }} Views</div>
								@endif

								@if($post->public_flag == 1)
								<a href="#" class="text-decoration-none badge-link public-post" data-post-id="{{ $post->id }}">
									<span class="badge badge-danger mr-3 text-nowrap d-none d-md-block">公開済</span>
								</a>
								@else
								<a href="#" class="text-decoration-none badge-link private-post" data-post-id="{{ $post->id }}">
									<span class="badge mr-3 text-nowrap d-none d-md-block">非公開</span>
								</a>
								@endif


								<div class="pr-1 text-nowrap d-none d-md-block">投稿日　{{ $post->created_at->format('Y/m/d') }}</div>

								@auth
									<div class="d-flex flex-row post_list_right">
										<a href="{{ action('FirstController@edit', $post) }}" class="ml-1 btn btn-sm btn-outline-primary text-nowrap">編集</a>
										<a href="#" class="del ml-1 mr-2 btn btn-sm btn-outline-danger text-nowrap" data-id="{{ $post->id }}">削除</a>
										<form method="post" action="{{ url('/posts', $post->id) }}" id="form_{{ $post->id }}">
											@csrf
											{{ method_field('delete') }}
										</form>
									</div>
								@endauth
							</div>
						@empty
							<p class="d-block mt-3 mx-2"><span class="font-weight-bold px-2">{{ Auth::user()->name }}</span>さんが投稿した記事はまだありません</p>
							<a class="d-inline mt-3 mx-2" href="{{ url('posts/new') }}">記事を投稿する</a>
						@endforelse
						<div class="pagination w-100 pt-3">{{ $posts->appends(request()->input())->links() }}</div>
					</div>
				</div>
			@endauth
		</div>
	</div>
@endsection
@section('js')
<script src="{{ asset('/js/manager.js') }}"></script>
@endsection