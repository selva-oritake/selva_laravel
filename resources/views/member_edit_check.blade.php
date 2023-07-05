<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>会員情報変更確認画面</title>

</head>
<body>
  <div class="member_regist_check">
    <h1>会員情報変更確認画面</h1>
    <form action="" method="POST">
    @csrf
      <div class="name">
        <span>氏名</span>
        <span>{{ $inputs['name_sei'] }}</span>
        <span>{{ $inputs['name_mei'] }}</span>
      </div>

      <div class="nickname">
        <span>ニックネーム</span>
        <span>{{ $inputs['nickname'] }}</span>
      </div>

      <div class="gender">
        <span>性別</span>
      @if($inputs['gender'] == 1)
        <span>男性</span>
      @elseif($inputs['gender'] == 2)
        <span>女性</span>
      @endif
      </div>

      <div class="btn"><input  name="complete_btn" type="submit" value="変更完了"></div>
      <div class="btn"><input name="prev_btn" type="button" value="前に戻る" onclick="history.back()"></div>

    </form>
  </div>
</body>
</html>