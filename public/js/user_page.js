// いつからの入力値が変更されたときのイベントリスナーを追加
document.getElementById("startDate").addEventListener("change", function() {
// いつからの入力値を取得
var startDate = new Date(this.value);

// いつまでの入力要素
var endDateInput = document.getElementById("endDate");

// いつからの日付よりも前の日付を選択できないようにする
endDateInput.min = this.value;

// いつまでの入力値をチェックし、いつからの日付よりも前の場合は初期化する
var endDate = new Date(endDateInput.value);
if (endDate < startDate) {
  endDateInput.value = "";
}
});






