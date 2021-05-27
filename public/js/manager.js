$(() => {
  'use strict';

  //公開済バッジをクリックした際の挙動
  $('.badge-link').on('click', function(e) {
    e.preventDefault();
    let postId = $(this).data("post-id");
    let public_status = $(this).hasClass('public-post') ? '公開済' : '非公開';
    let rev_public_status = $(this).hasClass('public-post') ? '非公開' : '公開済';
    if(confirm('現在は「' + public_status + '」です。この記事を「' + rev_public_status + '」に設定しますか？')) {
      $.ajax({
        type: 'GET',
        url: './posts/' + postId + '/publish',
      }).done((data) => {
        if($(this).hasClass('public-post')) {
          $(this).removeClass('public-post').addClass('private-post');
          $(this).children('span').removeClass('badge-danger');
        } else {
          $(this).removeClass('private-post').addClass('public-post');
          $(this).children('span').addClass('badge-danger');
        }
        $(this).children('span').text(rev_public_status);
      });
    }
  });
});