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
      <div class="greeting">
            <h2>マイページ</h2>
      </div>
      <div class="header_button">
          <input type="button" value="トップに戻る" onclick="location.href='/index'">
          <input type="button" class="dropdown-item" value="ログアウト" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> 
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form> 
      </div>
    </form>
  </header>

  <div>
    <table>
      <tr>
        <td>氏名</td>
        <td>{{ $user->name_sei }}　{{ $user->name_mei }}</td>
      </tr>
      <tr>
        <td>ニックネーム</td>
        <td>{{ $user->nickname }}</td>
      </tr>
      <tr>
        <td>性別</td>
        @if($user->gender == 1)
        <td>男性</td>
        @elseif($user->gender == 2)
        <td>女性</td>
        @endif
      </tr>
      <tr>
        <td>パスワード</td>
        <td>セキュリティのため表示</td>
      </tr>
      <tr>
        <td>メールアドレス</td>
        <td>{{ $user->email }}</td>
      </tr>
    </table>
  </div>

  <input type="button" value="退会" onclick="location.href='/withdrawal'">

</body>
</html>