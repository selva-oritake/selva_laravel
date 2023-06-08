<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>会員情報登録</title>
<link rel="stylesheet" href="member_regist.css">

</head>
<body>

  <div class="member_regist_form">
    <h1>会員情報登録</h1>

    <form action="/member_regist_check" method="POST">
      @csrf
      <div class ="name">
        <p>氏名</p>
        <p>姓<input name="name_sei" type="text" value="{{ old('name_sei') }}"></p>
        <p>名<input name="name_mei" type="text" value="{{ old('name_mei') }}"></p>
      @error('name_sei')
        <p class="error">＊姓を20文字以内で入力してください</p>
      @enderror
      @error('name_mei')
        <p class="error">＊名を20文字以内で入力してください</p>
      @enderror
      </div>
      

      <div class ="nickname">
        <p>ニックネーム<input name="nickname" type="text" value="{{ old('nickname') }}"></p>
      @error('nickname')
        <p class="error">＊ニックネームを10文字以内で入力してください</p>
      @enderror
      </div>

      <div class="gender">
        <p>性別</p>
        <input class="radio_button" type="hidden" name="gender" value="" checked>
        @foreach(config('master.gender') as $index => $value)
        <p><input type="radio" name="gender" value="{{ $index }}" {{ old("gender") == $index ? "checked" : "" }}>{{ $value ?? "" }}</p>
        @endforeach
      </div>
      @error('gender')
        <p class="error">＊性別を選択してください</p>
      @enderror

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

      <div class="email">
        <p>メールアドレス<input name="email" type="text" value="{{ old('email') }}"></p>
        <p class="error">{{ $errors->first('email') }}</p>
      </div>

      <div class="btn">
        <input type="submit" value="確認画面へ"><br>
        <input type="button" value="トップに戻る" onclick="location.href='/index'">
      </div>

    </form>


  </div>

</body>
</html>