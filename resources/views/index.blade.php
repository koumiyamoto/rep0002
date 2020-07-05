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

		<!-- コンテンツ -->
		<!-- モーダルアラート -->
		@if(session('success'))
		<div class="modal fade" id="modal_box" tabindex="-1" role="dialog">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header bg-success">
		        <h5 class="modal-title text-primary">処理結果</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <p class="">{{ session('success') }}</p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>
		@endif

		<div class="d-flex flex-row border-bottom">
			<h2 class="pb-2 mr-auto">Home</h2>
		</div>

		@guest
			<!-- ログイン・新規登録誘導 -->
			<div class="login_box bg-white font-weight-bold mt-4 col-8 col-lg-3 mx-auto shadow-lg text-center rounded-lg pt-3">
				<div class="p-3">
					<p>
						<a class="" href="{{ route('login') }}">ログイン</a>
					</p>
					<p class="d-block mt-3 mx-2">または</p>
					<p>
						<a class="" href="{{ route('register') }}">新規登録</a>
					</p>
				</div>
			</div>
		@endguest

		<div class="row mt-5">

			<!-- 左サイドバー -->
			<div class="col-2 pt-2 d-none d-lg-block">
				<!-- 並び替え -->
				<form id="form_order" class="" action="{{ route('guestOrder') }}" method="post">
					@csrf
					<div class="form-group">
						<label class="font-weight-bold" for="order">全ての記事をソート</label>
						<select id="order" class="form-control form-control-sm ml-3 mt-1 w-75" name="order">
							<option value=""></option>
							<option value="new">新しい順</option>
							<option value="old">古い順</option>
						</select>
					</div>
					<button id="order_btn" type="submit" class="btn btn-sm btn-primary ml-3">並び替え</button>
				</form>

				<!-- 検索フォーム -->
				<form class="mt-4" action="{{ route('search') }}" method="post">
					@csrf
						<div class="form-group">
							<label class="font-weight-bold" for="search">公開記事を検索</label>
							<input class="form-control form-control-sm ml-3 mt-1 w-75"  type="text" name="keyword" value="" placeholder="タイトル検索">
						</div>
						<button id="search_btn" type="submit" class="btn btn-sm btn-primary ml-3">検索</button>
				</form>
			</div>

			<!-- メイン -->
			<div class="col-12 col-lg-10 mb-5">
				<!-- 記事一覧 -->
				<div class="border-bottom align-items-center pb-3">
					<h2 class="pb-3 mb-0 mt-1 mr-auto">最新の公開記事</h2>
					@isset($keyword)
						<div class="">"{{ $keyword }}" の検索結果：{{ count($posts) }}件</div>
					@endisset
				</div>

					@forelse($posts as $post)
						<div class="post py-1 d-flex flex-row align-items-center border-bottom">
							<a class="d-block rounded post_link pl-2 ml-1 mr-1 w-100 py-2 text-truncate" href="{{ action('FirstController@show', $post) }}">{{ $post->title }}</a>


							@isset($name_flag)
							<div class="pr-3 text-nowrap d-none d-md-block">{{ $post->user->name }} さん</div>
							@endisset

							<div class="pr-1 text-nowrap d-none d-md-block">{{ $post->created_at->format('Y/m/d') }}</div>
						</div>
					@empty
						<p class="d-block mt-3 mx-2">
							投稿された記事はまだありません
						</p>
					@endforelse
					<div class="pagination w-100 pt-3">{{ $posts->links() }}</div>

					@isset($famousPosts)
						<div class="mt-5 border-bottom align-items-center">
							<h2 class="pb-3 mb-0 mt-1 mr-auto">人気の記事 top10</h2>
							<!-- <a id="delete_selected" href="#" class="">選択削除</a> -->
						</div>
						@foreach($famousPosts as $famousPost)
							<div class="post py-1 d-flex flex-row align-items-center border-bottom">
								<a class="d-block rounded post_link pl-2 ml-1 mr-1 w-100 py-2 text-truncate" href="{{ action('FirstController@show', $famousPost) }}">{{ $famousPost->title }}</a>


								@isset($name_flag)
								<div class="pr-3 text-nowrap">{{ $famousPost->user->name }} さん</div>
								@endisset
								<div class="text-nowrap mr-3 d-none d-md-block"><span class="font-weight-bold mr-1">{{ $famousPost->view_count }}</span>views</div>

								<div class="pr-1 text-nowrap d-none d-md-block">{{ $famousPost->created_at->format('Y/m/d') }}</div>
							</div>
						@endforeach
					@endisset
			</div>
		</div>
	</div>
	
@endsection