$(() => {
  'use strict';

  // 削除ボタン
	$(document).on('click', '.del', function(e) {
		e.preventDefault();
		if(confirm("一度削除した記事は元に戻すことができません。よろしいですか？")) {
			$(this).siblings('form').submit();
		}
	});

  /**
   * 公開バッジをクリックすると、公開設定を変更できる
   */
  $('.badge-link').on('click', function(e) {
    e.preventDefault();
    let postId = $(this).data("post-id");
    let public_status = $(this).hasClass('public-post') ? '公開済' : '非公開';
    let rev_public_status = $(this).hasClass('public-post') ? '非公開' : '公開済';
    let public_post_count = parseInt($('.public-post-count').text()); //公開中の記事数

    if(confirm('現在は「' + public_status + '」です。この記事を「' + rev_public_status + '」に設定しますか？')) {
      $.ajax({
        type: 'GET',
        url: './posts/' + postId + '/publish',
      }).done((data) => {
        //公開中バッヂを非公開に
        if($(this).hasClass('public-post')) {
          $(this).removeClass('public-post').addClass('private-post');
          $(this).children('span').removeClass('badge-danger');
          $('.public-post-count').text(public_post_count - 1);

        //非公開バッヂを公開中に
        } else {
          $(this).removeClass('private-post').addClass('public-post');
          $(this).children('span').addClass('badge-danger');
          $('.public-post-count').text(public_post_count + 1);
        }
        $(this).children('span').text(rev_public_status);
      });
    }
  });
});