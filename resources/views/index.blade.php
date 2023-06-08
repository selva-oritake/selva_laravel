<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ホーム画面</title>
<link rel="stylesheet" href="index.css">
</head>
<body>
<header>
  <form action="" method="post">
    <div class="greeting">
      @auth
          <P>{{ Auth::user()->name_sei }}  {{ Auth::user()->name_mei }}様</P>
      @endauth
    </div>
    <div class="header_button">
      @guest
        <input type="button" value="新規会員登録" onclick="location.href='/member_regist'">
        <input type="button" value="ログイン" onclick="location.href='/login'">
      @endguest

      @auth
      <input type="button" class="dropdown-item" value="ログアウト" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> 
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>
      @endauth
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>      
    </div>
  </form>
</header>

</body>
</html>