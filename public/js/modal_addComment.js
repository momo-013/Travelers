/* global $ */
 $(document).ready(function () {
    // コメントフォームが送信されたときの処理
    $('.comment-form').submit(function (e) {
        e.preventDefault(); // フォームの通常の送信を防止

        var commentForm = $(this);
        var modal = commentForm.closest('.modal'); // フォームが含まれるモーダルを取得
        var postId = modal.find('.modal-title').attr('data-post-id'); // 投稿IDを取得

        $.ajax({
            type: 'POST',
            url: commentForm.attr('action'),
            data: commentForm.serialize(),
            success: function (response) {
                if (response.success) {
                    alert('コメントが送信されました。');// 送信成功時の処理（例：成功メッセージを表示）

                    // 新しいコメントをモーダル内に表示
                    var newComment = '<p>' + response.reply.user.name + ': ' + response.reply.body + '<a class="reply-link" data-username="' + response.reply.user.name + '">返信</a></p>';
                    modal.find('.modal-body .reply').append(newComment);


                    // フォームをクリア
                    commentForm[0].reset();
                    
                    // 送信ボタンを無効にする
                    commentForm.find('.postComment').prop('disabled', true);
                    
                    document.querySelectorAll('.reply-link').forEach(function(replyLink) {
                    replyLink.addEventListener('click', function() {
                        var username = this.getAttribute('data-username'); // ユーザー名を取得
                        var replyInput = this.closest('.post').querySelector('.reply-input'); // 同じ投稿内のコメント追加のinput要素を取得
                
                        // カーソルをinput要素に移動し、ユーザー名を挿入
                        replyInput.focus();
                        replyInput.value = '@' + username;
                    });
                });
                
                } else {
                    alert('コメントの送信中にエラーが発生しました。');
                }
            },
            error: function (error) {
                // 送信エラー時の処理
                alert('コメントの送信中にエラーが発生しました。');
            }
        });
    });
    // コメントフォームの入力値が変更されたときの処理
    $('.comment-form').on('input', function () {
        var commentForm = $(this);
        var inputValue = commentForm.find('.addComment').val();

        // 入力値が空でない場合、送信ボタンを有効にする
        commentForm.find('.postComment').prop('disabled', inputValue.trim() === '');
    });
    // ... その他のJavaScriptコード
});