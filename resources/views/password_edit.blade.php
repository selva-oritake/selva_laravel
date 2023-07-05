<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>パスワード変更</title>

</head>
<body>

  <div>
    <h1>パスワード変更</h1>

    <form action="/password_edit" method="POST">
      @csrf
      <div class="password">
        <p>パスワード<input name="password" type="password"></p>
        @foreach ($errors->get('password') as $message)
        <p class="error">{{ $message }}</p>
        @endforeach
      </div>

      <div class="password_confirmation">
        <p>パスワード確認<input name="password_confirmation" type="password"></p>
        @error('password_confirmation')
          <p class="error">＊パスワードを8~20文字の半角英数字で入力してください</p>
        @enderror
        <?php if(!empty($error["password"]) && $error['password'] === 'disagreement'): ?>
          <p>＊パスワードが一致しません。</p>
        <?php endif; ?>
      </div>

      <div class="btn">
        <input type="submit" value="パスワードを変更"><br>
        <input type="button" value="マイページに戻る" onclick="location.href='/mypage'">
      </div>

    </form>


  </div>

</body>
</html>