<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Itinerary</title>
        <!-- Fonts -->
        <link href="/css/style3.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        
    </head>
    <body>
      <div class='contents'>
        <div class="container1">
  <!-- Content here -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">旅程</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              
              <div class="modal-body">
                <form action="/books" method="POST">
                  @csrf
                  <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">タイトル</label>
                    <input type="text" name="book[title]" class="form-control" id="recipient-name" required>
                  </div>
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">いつから</label>
                    <input type="date" name="book[start_at]" class="form-control" id="startDate" required>
                  </div>
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">いつまで</label>
                    <input type="date" name="book[finish_at]" class="form-control" id="endDate" required>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">作成</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div><br>
        
          <h2>一覧</h2>
         <div class='books'>
                @foreach($books as $book)  
                <div class='book'>
                    <div class="book-edit" id="bookData{{ $book->id }}" onclick="editBook({{ $book->id }})">
                      <i class="fa-solid fa-pen"></i>
                    </div>　
                    <a href="/books/create/{{ $book->id }}">
                    <div>{{ $book->title }}</div>
                    <div class="date">
                        <div>{{ $book->start_at }}<span>~</span>{{ $book->finish_at }}</div>
                    </div>
                    </a>
                </div>
                
                <!--モーダルウィンドウforedit-->
                <div class="modal fade" id="exampleModal{{ $book->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">旅程</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      
                      <div class="modal-body">
                        <form action="/books/{{ $book->id }}" method="POST">
                          @csrf
                          @method('PUT')
                          <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">タイトル</label>
                            <input type="text" name="book[title]" class="form-control" id="recipient-name" value="{{ $book->title }}" required>
                          </div>
                          <div class="mb-3">
                            <label for="message-text" class="col-form-label">いつから</label>
                            <input type="date" name="book[start_at]" class="form-control" id="startDate" value="{{ $book->start_at }}" required>
                          </div>
                          <div class="mb-3">
                            <label for="message-text" class="col-form-label">いつまで</label>
                            <input type="date" name="book[finish_at]" class="form-control" id="endDate" value="{{ $book->finish_at }}" required>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">保存</button>
                        </form>
                          <form action="/books/{{ $book->id }}" id="form_{{ $book->id }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="button" onclick="confirmDelete({{ $book->id }})" class="btn btn-primary">削除</button>
                          </form>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
          </div> 
      </div>
       
        
        
        <div class="navigation">
          <h1 style="margin-left: 25px">Travelers</h1>
          <div class=navigationMenu>
                  
                  <button type="button" class="button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever=""><i class="fa-solid fa-square-plus"></i>新規作成</button><br>
                  <a href="/"><i class="fa-solid fa-rotate-left"></i>戻る</a><br>
      
                  
                  <form method="POST" action="{{ route('logout') }}" class="logout">
                      @csrf

                      <x-dropdown-link :href="route('logout')"
                              onclick="event.preventDefault();
                                          this.closest('form').submit();" class='logout'>
                          <i class="fa-solid fa-right-from-bracket"></i>
                          {{ __('ログアウト') }}
                      </x-dropdown-link>
                  </form>
          </div>
        </div>
      </div>
      
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="/js/user_page.js"></script>
        <script>
          function editBook(bookId){
            const modalId = `exampleModal${bookId}`;
            
            const modal = new bootstrap.Modal(document.getElementById(modalId));
            modal.show();
          }
        </script>
        <script>
        function confirmDelete(id) {
            if (confirm('本当に削除しますか？')) {
                document.getElementById(`form_${id}`).submit();
            }
        }
        </script>
    </body>
</html>