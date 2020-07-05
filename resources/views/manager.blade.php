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
			<div class="row">

				<!-- 左サイドバー -->
				<div class="col-6 col-md-2 pt-2">
					<h5 class="bg-danger text-white text-center d-block rounded-pill">管理画面</h5>
					<div class="d-none d-lg-block">
						<!-- 並び替え -->
						<form id="form_order" class="" action="{{ route('managerOrder') }}" method="post">
							@csrf
							<div class="form-group">
								<label class="font-weight-bold" for="order">並べ替え</label>
								<select id="order" class="form-control form-control-sm ml-3 mt-1 w-75" name="order">
									<option value=""></option>
									<option value="new">新しい順</option>
									<option value="old">古い順</option>
								</select>
							</div>
							<button id="order_btn" type="submit" class="btn btn-sm btn-primary ml-3">並び替え</button>
						</form>

						<!-- 検索フォーム -->
						<form class="mt-4" action="{{ route('managerSearch') }}" method="post">
							@csrf
							<div class="form-group">
								<label class="font-weight-bold" for="search">タイトル検索</label>
								<input class="form-control form-control-sm ml-3 mt-1 w-75"  type="text" name="keyword" value="" placeholder="タイトル検索">
							</div>
							<button id="search_btn" type="submit" class="btn btn-sm btn-primary ml-3">検索</button>
						</form>
					</div>
				</div>

				<!-- メイン -->
				<div class="col-12 col-md-10">
					<!-- 記事一覧 -->
					<div class="d-flex flex-auto border-bottom align-items-center pb-3">
						<h2 class="pb-3 mb-0 mt-1 mr-auto">自分の投稿した記事一覧</h2>
						<!-- <a id="delete_selected" href="#" class="">選択削除</a> -->
					</div>

						@forelse($posts as $post)
							<div class="post py-2 d-flex flex-row align-items-center border-bottom">
								<a class="d-block rounded post_link pl-2 ml-1 mr-1 w-100 py-2 text-break" href="{{ action('FirstController@show', $post) }}">{{ $post->title }}</a>
								<div class="pr-1 text-nowrap d-none d-md-block">{{ $post->created_at->format('Y/m/d') }}</div>

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

					<div class="pagination w-100 pt-3">{{ $posts->links() }}</div>
				</div>
			</div>

		@endauth
	</div>
	
@endsection