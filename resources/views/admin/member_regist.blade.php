<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>会員情報登録</title>
<link rel="stylesheet" href="member_regist.css">

</head>
<body>
  <header>
    @if (isset($isEdit) && $isEdit)
      <h2>会員編集</h2>
    @else
      <h2>会員登録</h2>
    @endif
    <input type="button" value="一覧へ戻る" onclick="location.href='member_list'">
  </header>
  <div class="member_regist_form">
    @if (isset($isEdit) && $isEdit)
      <span>ID</span>
      <span>{{ $currentId }}</span>
      <form action="" method="POST">
        @csrf
        <div class ="name">
          <span>氏名</span>
          <span>姓<input name="name_sei" type="text" value="{{ old('name_sei') ?? $inputs['name_sei'] ?? $result['name_sei'] }}"></span>
          <span>名<input name="name_mei" type="text" value="{{ old('name_mei') ?? $inputs['name_mei'] ?? $result['name_mei'] }}"></span>
        @error('name_sei')
          <p class="error">＊姓を20文字以内で入力してください</p>
        @enderror
        @error('name_mei')
          <p class="error">＊名を20文字以内で入力してください</p>
        @enderror
        </div>
        
  
        <div class ="nickname">
          <p>ニックネーム<input name="nickname" type="text" value="{{ old('nickname') ?? $inputs['nickname'] ?? $result['nickname'] }}"></p>
        @error('nickname')
          <p class="error">＊ニックネームを10文字以内で入力してください</p>
        @enderror
        </div>
  
        <div class="gender">
          <p>性別</p>
          <input class="radio_button" type="hidden" name="gender" value="" checked>
          @foreach(config('master.gender') as $index => $value)
          <p><input type="radio" name="gender" value="{{ $index }}" {{ (($inputs && $inputs['gender'] == $index) || ($result && $result['gender'] == $index) || old("gender") == $index) ? "checked" : "" }}>{{ $value ?? "" }}</p>
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
          <p>メールアドレス<input name="email" type="text" value="{{ old('email') ?? $inputs['email'] ?? $result['email'] }}"></p>
          <p class="error">{{ $errors->first('email') }}</p>
        </div>
  
        <div class="btn">
          <input type="submit" value="確認画面へ">
        </div>
  
      </form>
    @else
      <span>ID</span>
      <span>登録後に自動採番</span>
      <form action="" method="POST">
        @csrf
        <div class ="name">
          <span>氏名</span>
          <span>姓<input name="name_sei" type="text" value="{{ old('name_sei') ?? $inputs['name_sei'] ?? '' }}"></span>
          <span>名<input name="name_mei" type="text" value="{{ old('name_mei') ?? $inputs['name_mei'] ?? '' }}"></span>
        @error('name_sei')
          <p class="error">＊姓を20文字以内で入力してください</p>
        @enderror
        @error('name_mei')
          <p class="error">＊名を20文字以内で入力してください</p>
        @enderror
        </div>
        
  
        <div class ="nickname">
          <p>ニックネーム<input name="nickname" type="text" value="{{ old('nickname') ?? $inputs['nickname'] ?? '' }}"></p>
        @error('nickname')
          <p class="error">＊ニックネームを10文字以内で入力してください</p>
        @enderror
        </div>
  
        <div class="gender">
          <p>性別</p>
          <input class="radio_button" type="hidden" name="gender" value="" checked>
          @foreach(config('master.gender') as $index => $value)
          <p><input type="radio" name="gender" value="{{ $index }}" {{ (($inputs && $inputs['gender'] == $index) || old("gender") == $index) ? "checked" : "" }}>{{ $value ?? "" }}</p>
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
          <p>メールアドレス<input name="email" type="text" value="{{ old('email') ?? $inputs['email'] ?? '' }}"></p>
          <p class="error">{{ $errors->first('email') }}</p>
        </div>
  
        <div class="btn">
          <input type="submit" value="確認画面へ">
        </div>
  
      </form>
    @endif

  </div>

</body>
</html>