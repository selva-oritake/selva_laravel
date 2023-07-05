<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>メールアドレス変更</title>

</head>
<body>

  <div>
    <h1>メールアドレス変更 認証コード入力</h1>
    
    <div>
      <p>（※メールアドレスの変更はまだ完了していません）</p>
      <p>変更後のメールアドレスにお送りしましたメールに記載されている「認証コード」を入力してください。</p>
    </div>

    <form action="/email_edit_auth" method="POST">
      @csrf
      <div>
        <p>認証コード<input name="auth_code" type="number" min="000001" max="999999"></p>
        <p class="error">{{ $errors->first('auth_code') }}</p>
      </div>

      <div class="btn">
        <input type="submit" value="認証コードを送信してメールアドレスの変更を完了する">
      </div>
    </form>


  </div>

</body>
</html>