 // テキストフィールドの要素を取得
var keywordInput = document.querySelector('.search');

// 検索ボタンの要素を取得
var searchButton = document.querySelector('#searchButton');

// テキストフィールドの入力内容が変更されたときの処理
keywordInput.addEventListener('input', function() {
    // 入力内容が空白でなければ検索ボタンを有効化し、空白なら無効化
    if (keywordInput.value.trim() !== '') {
        searchButton.removeAttribute('disabled');
    } else {
        searchButton.setAttribute('disabled', 'disabled');
    }
});