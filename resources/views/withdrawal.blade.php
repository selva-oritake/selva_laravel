<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<title>マイページ</title>
</head>
<body>
  <header>
    <form action="" method="post">
      <div class="header_button">
        <input type="button" value="トップに戻る" onclick="location.href='/index'">
        <input type="button" value="ログアウト" onclick="location.href='/logout'"> 
      </div>
    </form>
  </header>

  <div>
    <p>退会します。よろしいですか？</p>
    <input type="button" value="マイページに戻る" onclick="location.href='/mypage'">
    <form method="post" action="{{ route('MemberDelete') }}">
      @csrf
      @method('delete')
      <input type="submit" value="退会する">
    </form>
  </div>



</body>
</html>