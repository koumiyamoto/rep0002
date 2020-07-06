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
			
			<div class="w-100">
				@auth
				<div class="d-flex flex-row border-bottom">
					<h2 class="pb-2 mr-auto">Home</h2>
				</div>
				@endauth

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
				@else

				<div class="content row mt-3">
					<!-- 左サイドバー -->
					<div class="col-2 pt-2 d-none d-lg-block">
						<!-- 並び替え -->
							<label class="font-weight-bold" for="order">並べ替え</label>
							<div class="order-wrapper py-1 px-3 mb-2 @if($order == 'new')bg-primary @endif rounded">
								<a href="{{ route('orderNew') }}" class="d-block w-100 h-100 @if($order == 'new')text-white @endif order">新しい順</a>
							</div>
							<div class="order-wrapper py-1 px-3 mb-2 @if($order == 'old')bg-primary @endif rounded">
								<a href="{{ route('orderOld') }}" class="d-block w-100 h-100 @if($order == 'old')text-white @endif order">古い順</a>
							</div>
							<div class="order-wrapper py-1 px-3 @if($order == 'popular')bg-primary @endif rounded">
								<a href="{{ route('orderPopular') }}" class="d-block w-100 h-100 @if($order == 'popular')text-white @endif order">人気の高い順</a>
							</div>

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
					<div class="bg-white col-12 col-lg-10 mb-5 rounded pt-5">
						<!-- 記事一覧 -->
						<div class="border-bottom align-items-center pb-3">
							<div class="d-flex align-itmes-center">
								<h2 class="pb-3 mb-0 ml-4 mt-1 mr-auto">全ユーザーの公開中の記事一覧</h2>
							</div>
							@isset($keyword)
								<div class="">"{{ $keyword }}" の検索結果：{{ count($posts) }}件</div>
							@endisset
						</div>

							@forelse($posts as $post)
								<div class="post py-1 d-flex flex-row align-items-center border-bottom">
									<a class="d-block rounded post_link pl-2 ml-1 mr-1 w-100 py-2 text-break" href="{{ action('FirstController@show', $post) }}">{{ $post->title }}</a>


									@isset($name_flag)
									<div class="pr-3 text-nowrap">{{ $post->user->name }} さん</div>
									@endisset

									@if($order == 'popular')
									<div class="pr-3 text-nowrap">{{ $post->view_count }} Views</div>
									@endif

									<div class="pr-1 text-nowrap d-none d-md-block">{{ $post->created_at->format('Y/m/d') }}</div>
								</div>
							@empty
								<p class="d-block mt-3 mx-2">
									投稿された記事はまだありません
								</p>
							@endforelse
							<div class="pagination w-100 pt-3">{{ $posts->links() }}</div>
					</div>
				</div>
			</div>
			@endguest
		</div>
	</div>
	
@endsection