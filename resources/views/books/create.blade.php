<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Itinerary</title>
        <!-- Fonts -->
        <link href="/css/style4.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        
    </head>
    <body>
      <div class='fixed-top'>
        <header>
        <h1 class="headTitle">Travelers</h1>
        </header>
      </div>
      <div class='container2'>
        <div class='body-left'>
          <div class='book'>　
            <div class='book-content'>
              <div>{{ $book->title }}</div>
              <div class="date">
                  <div>{{ $book->start_at }}<span>~</span>{{ $book->finish_at }}</div>
              </div>
            </div>
          </div>
            <a class='back-link' href="/books/index">戻る</a><br>
        </div>
        
        <div class='body-center'>
          <div class='schedules'>
            @php
              $sortedSchedules = $book->schedules->sortBy(function($schedule) {
                return $schedule->date . $schedule->start_at;
              });
              $groupedSchedules = $sortedSchedules->groupBy('date');
        
            @endphp
          
            @foreach($groupedSchedules as $date => $schedules)
              @php
                $formattedDate = date('n月j日', strtotime($date));
              @endphp
          
              
              <h4>{{ $formattedDate }}</h4>
              
              @foreach($schedules as $schedule)
               <div class='schedule' id='scheduleData{{ $schedule->id }}' onclick='editSchedule({{ $schedule->id }})'>
                <div class='date'>
                  <div>{{ date('H:i', strtotime($schedule->start_at)) }}</div>
                <p>~</p>
                <div>{{ date('H:i', strtotime($schedule->finish_at)) }}</div>
                </div>
                
                <div class='title'>{{ $schedule->title }}</div>
              </div>
              
              <!--モーダルウィンドウ-->
              <div class="modal fade" id="exampleModal{{ $schedule->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">スケジュール</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      
                      <div class="modal-body">
                        <form action="/schedules/{{ $schedule->id }}" method="POST">
                          @csrf
                          @method('PUT')
                          <input type="hidden" name="schedule[itinerary_id]" value={{ $book->id }}>
                          <div class="mb-3">
                            <label for="message-text" class="col-form-label">日付</label>
                            <input type="date" name="schedule[date]" class="form-control" id="Date" required min={{ $book->start_at }} max={{ $book->finish_at }} value='{{ $schedule->date}}'>
                          </div>
                          <div class="mb-3">
                            <label for="message-text" class="col-form-label">時間</label>
                            <input type="time" name="schedule[start_at]" class="form-control" id="startTime" value="{{ $schedule->start_at }}" required>
                            <span>~</span>
                            <input type="time" name="schedule[finish_at]" class="form-control" id="endTime" value="{{ $schedule->finish_at }}" required>
                          </div>
                          <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">タイトル</label>
                            <input type="text" name="schedule[title]" class="form-control" id="title-name" value="{{ $schedule->title }}" required>
                          </div>
                          
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">保存</button>
                          
                        </form>
                          <form action="/schedules/{{ $schedule->id }}" method="post">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-primary">削除</button>
                          </form>
                          </div>
                        
                      </div>
                      
                    </div>
                  </div>
              </div>
              
              @endforeach
              
              
            @endforeach
          </div>
        </div>
        
        <div class='body-right'>
          <div class='addSchedule'>
            <div class='add-botton'>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="">スケジュール追加</button>
            </div>
            
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">スケジュール</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  
                  <div class="modal-body">
                    <form action="/schedules" method="POST">
                      @csrf
                      <input type="hidden" name="schedule[itinerary_id]" value={{ $book->id }}>
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">日付</label>
                        <input type="date" name="schedule[date]" class="form-control" id="Date" required min={{ $book->start_at }} max={{ $book->finish_at }} >
                      </div>
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">時間</label>
                        <input type="time" name="schedule[start_at]" class="form-control" id="startTime" required>
                        <span>~</span>
                        <input type="time" name="schedule[finish_at]" class="form-control" id="endTime" required>
                      </div>
                      <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">タイトル</label>
                        <input type="text" name="schedule[title]" class="form-control" id="title-name" required>
                      </div>
                      
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">作成</button>
                      </div>
                    </form>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <script src="/js/user_page2.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      <script>
         function editSchedule(scheduleId) {
          // スケジュールの`id`に基づいてモーダルウィンドウの`id`を作成
          const modalId = `exampleModal${scheduleId}`;
          
          // モーダルウィンドウを表示
          const modal = new bootstrap.Modal(document.getElementById(modalId));
          modal.show();
        }
        
        function deleteSchedule(scheduleId) {
          // 削除処理の実装
          // 適切なAPIリクエストなどを行ってスケジュールを削除します
          
          // モーダルウィンドウを閉じる
          const modalId = `exampleModal${scheduleId}`;
          const modal = new bootstrap.Modal(document.getElementById(modalId));
          modal.hide();
        }
        </script>
        
        
       
        
    </body>
</html>