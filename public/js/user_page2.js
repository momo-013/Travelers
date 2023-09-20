const startTimeInput = document.getElementById('startTime');
const endTimeInput = document.getElementById('endTime');

startTimeInput.addEventListener('change', function() {
// startTimeの値を取得
const startTime = startTimeInput.value;

// endTimeの値をチェック
if (endTimeInput.value < startTime) {
  endTimeInput.value = startTime;
}
});

endTimeInput.addEventListener('change', function() {
// startTimeの値を取得
const startTime = startTimeInput.value;

// endTimeの値をチェック
if (endTimeInput.value < startTime) {
  endTimeInput.value = startTime;
}
});
