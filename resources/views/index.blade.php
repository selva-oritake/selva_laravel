<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <input type="button" value="商品一覧" onclick="location.href='/product_list'">
        <input type="button" value="新規会員登録" onclick="location.href='/member_regist'">
        <input type="button" value="ログイン" onclick="location.href='/login'">
      @endguest

      @auth
        <input type="button" value="商品一覧" onclick="location.href='/product_list'">
        <input type="button" value="新規商品登録" onclick="location.href='/product_regist'">
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