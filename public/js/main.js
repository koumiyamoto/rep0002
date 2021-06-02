$(function() {
	'use strict'

	// コメント削除ボタン
	$(document).on('click', '.comment_del', function(e) {
		e.preventDefault();
		if(confirm("一度削除したコメントは元に戻すことができません。よろしいですか？")) {
			$(this).siblings('form').submit();
		}
	});

	// 選択削除ボタン
	// $(document).on('click', '#delete_selected', function(e) {
	// 	e.preventDefault();
	// 	if(confirm("一度削除した記事は元に戻すことができません。よろしいですか？")) {
	// 		$('#delete_selected_form').submit();
	// 	}
	// });

	// タグクラウド
	// $(document).on('click', '#tag_crowd', function(e) {
	// 	e.preventDefault();
	// 	let data = $(this).data();
	// 	$('#form_' + data.id).submit();
	// });

	// 画面遷移時にモーダル表示
	if($('#modal_box')[0]) { // if(session)で作られているか確認
		$('#modal_box').modal('show');
	}

	// textarea があるページで、入力文字数を取得
	if($('#textarea')[0]) { // textarea 存在確認
		// 文字数初期値を取得
		let count = $('#textarea').val().length;
		$('#text_count').text(count);

		// 入力のたびに文字数取得・表示
		$('#textarea').on('keyup', function() {
			count = $(this).val().length;
			$('#text_count').text(count);
		});
	}

	// 更新確認アラート
	$(document).on('click', '.edit_btn', function(e) {
		if(confirm('記事を更新します。よろしいですか？')) {

		} else {
			e.preventDefault();
			return false;
		}
	});

	$('#create_btn').on('click', function(e) {
		if(confirm('記事を作成します。よろしいですか？')) {

		} else {
			e.preventDefault();
			return false;
		}
	});


});