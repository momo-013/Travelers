/* global $ */

$(document).ready(function() {
    $('.like-link').click(function(e) {
      e.preventDefault(); // デフォルトのリンクアクションを無効にする

      var post_id = $(this).data('post_id'); // 投稿のIDを取得
      var url = $(this).attr('href'); // リクエスト先のURLを取得

      // Ajaxリクエストを送信
      $.ajax({
        url: url,
        method: 'GET', // もしくは'GET'
        data: { post_id: post_id }, // リクエストに必要なデータを指定 (例: 投稿ID)
        success: function(response) {
          // 成功時の処理
          // レスポンスに応じたDOMの変更などを行う
        },
        error: function(xhr, status, error) {
          // エラー時の処理
          // エラーメッセージの表示などを行う
        }
      });
    });
  });