<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>メールアドレス変更</title>

</head>
<body>

  <div>
    <h1>メールアドレス変更</h1>
    
    <div class="email">
      <p>現在のメールアドレス{{ $user->email }}</p>
    </div>

    <form action="" method="POST">
      @csrf
      <div class="email">
        <p>変更後のメールアドレス<input name="email" type="text" value="{{ old('email') }}"></p>
        <p class="error">{{ $errors->first('email') }}</p>
      </div>

      <div class="btn">
        <input type="submit" value="認証メール送信"><br>
        <input type="button" value="マイページに戻る" onclick="location.href='/mypage'">
      </div>
    </form>
  </div>

</body>
</html>