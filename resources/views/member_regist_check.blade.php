<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>会員情報確認画面</title>
<link rel="stylesheet" href="member_regist_check.css">

</head>
<body>
  <div class="member_regist_check">
    <h1>会員情報確認画面</h1>
    <form action="member_regist_complete" method="POST">
    @csrf
      <div class="name">
        <p>氏名</p>
        <p>{{ $inputs['name_sei'] }}</p>
        <p>{{ $inputs['name_mei'] }}</p>
      </div>

      <div class="nickname">
        <p>ニックネーム</p>
        <p>{{ $inputs['nickname'] }}</p>
      </div>

      <div class="gender">
        <p>性別</p>
      @if($inputs['gender'] == 1)
        <p>男性</p>
      @elseif($inputs['gender'] == 2)
        <p>女性</p>
      @endif
      </div>

      <div class="password">
        <p>パスワード</p>
        <p>セキュリティのため非表示</p>
      </div>

      <div class="email">
        <p>メールアドレス</p>
        <p>{{ $inputs['email'] }}</p>
      </div>

      <div class="btn"><input  name="complete_btn" type="submit" value="登録完了"></div>
      <div class="btn"><input name="prev_btn" type="button" value="前に戻る" onclick="history.back()"></div>

    </form>

  </div>




</body>
</html>