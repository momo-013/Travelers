/* global $ */

let like = $('.like-toggle'); // like-toggleのついたiタグを取得して代入
let likePostId; // 変数を宣言（ここで宣言する理由は後述）
like.on('click', function () { // clickイベントハンドラーを設定
    let $this = $(this); // this = イベントの発火した要素 (iタグ) を代入
    likePostId = $this.data('post-id'); // iタグに仕込んだdata-post-idの値を取得して変数に代入
    // ajax処理スタート
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/like', // 通信先アドレス (このURLをルートで設定します)
        method: 'POST', // HTTPメソッドの種別を指定
        data: { // サーバーに送信するデータ
            'post_id': likePostId,  // いいねされた投稿のidを送る
        },
    })
        //通信成功した時の処理
        .done(function (data) {
            $this.toggleClass('liked'); //likedクラスのON/OFF切り替え。
            $this.next('.like-counter').html(data.post_likes_count); // 修正: 'data.review_likes_count' → 'data.post_likes_count'
        })
        //通信失敗した時の処理
        .fail(function () {
            console.log('fail');
        });
});