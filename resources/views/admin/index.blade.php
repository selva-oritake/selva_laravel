<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<title>ホーム画面</title>
<link rel="stylesheet" href="">
</head>
  <body>
  <header>
    <div>
      <h2>管理画面メインメニュー</h2>
    </div>
    <div>
      <div class="greeting">
  
        @if (Auth::guard('admin')->check())
        <P>ようこそ{{ Auth::guard('admin')->user()->name }}さん</P>
        @endif
      </div>
      <div class="header_button">
        @if (Auth::guard('admin')->check())
          <input type="button" class="dropdown-item" value="ログアウト" onclick="location.href='logout'"> 
        @endif
      </div>
    </div>
  </header>

  <input type="button" value="会員一覧" onclick="location.href='member_list'"> 

</body>
</html>