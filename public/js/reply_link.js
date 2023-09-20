 // 返信リンクをクリックしたときの処理
document.querySelectorAll('.reply-link').forEach(function(replyLink) {
    replyLink.addEventListener('click', function() {
        var username = this.getAttribute('data-username'); // ユーザー名を取得
        var replyInput = this.closest('.post').querySelector('.reply-input'); // 同じ投稿内のコメント追加のinput要素を取得
        // カーソルをinput要素に移動し、ユーザー名を挿入
        replyInput.focus();
        replyInput.value = '@' + username;
    });
});