/* global $ */
$(document).ready(function () {
    // コメントを追加するフォームのクラスを指定して監視
    $('.comment-form-external input[name="reply[body]"], .comment-form input[name="reply[body]"]').on('input', function () {
        var inputIsEmpty = $(this).val().trim() === '';
        // フォームの送信ボタンの有効/無効を切り替える
        $(this).closest('form').find('.postComment').prop('disabled', inputIsEmpty);
    });
});