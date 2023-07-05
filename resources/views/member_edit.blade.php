<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>会員情報変更</title>

</head>
<body>

  <div>
    <h1>会員情報登録</h1>

    <form action="/member_edit" method="POST">
      @csrf
      <div class ="name">
        <span>氏名</span>
        <span>姓<input name="name_sei" type="text" value="{{ old('name_sei') }}"></span>
        <span>名<input name="name_mei" type="text" value="{{ old('name_mei') }}"></span>
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

      <div class="btn">
        <input type="submit" value="確認画面へ"><br>
        <input type="button" value="マイページに戻る" onclick="location.href='/mypage'">
      </div>

    </form>


  </div>

</body>
</html>