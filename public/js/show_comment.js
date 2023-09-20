/* global $ */
 $('.showComment').click(function () {
    var postId = $(this).data('post-id'); // 対象の投稿IDを取得
    loadComments(postId); // コメントデータを非同期で読み込む関数を呼び出す
});

function loadComments(postId) {
    $.ajax({
        type: 'GET',
        url: '/get-comments/' + postId, // コメントデータを取得するルートを指定
        success: function (response) {
            if (response.comments) {
                var comments = response.comments;
                var modal = $('#exampleModal' + postId); // 対応するモーダルを取得

                // モーダル内のコメントをクリア
                modal.find('.modal-body .reply').empty();

                // 新しいコメントを追加
                for (var i = 0; i < comments.length; i++) {
                var comment = comments[i];
                var newComment = '<p>' + comment.user.name + ': ' + comment.body + '<a class="reply-link" data-username="' + comment.user.name + '">返信</a></p>';
                modal.find('.modal-body .reply').append(newComment);
                
                document.querySelectorAll('.reply-link').forEach(function(replyLink) {
                    replyLink.addEventListener('click', function() {
                        var username = this.getAttribute('data-username'); // ユーザー名を取得
                        var replyInput = this.closest('.post').querySelector('.reply-input'); // 同じ投稿内のコメント追加のinput要素を取得
                
                        // カーソルをinput要素に移動し、ユーザー名を挿入
                        replyInput.focus();
                        replyInput.value = '@' + username;
                    });
                });
            }
                // モーダルを表示
                modal.modal('show');
            }
        },
        error: function (error) {
            alert('コメントデータの取得中にエラーが発生しました.');
        }
    });
}