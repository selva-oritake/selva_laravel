<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>会員詳細</title>
<link rel="stylesheet" href="member_regist_check.css">

</head>
<body>
  <header>
    <h2>会員詳細</h2>
    <input type="button" value="一覧へ戻る" onclick="location.href='member_list'">
  </header>
  <div>
    <span>ID</span>
    <span>{{ $currentId }}</span>

    <form action="" method="POST">
    @csrf
      <div class="name">
        <span>氏名</span>
        <span>{{ $result['name_sei'] }}</span>
        <span>{{ $result['name_mei'] }}</span>
      </div>

      <div class="nickname">
        <span>ニックネーム</span>
        <span>{{ $result['nickname'] }}</span>
      </div>

      <div class="gender">
        <span>性別</span>
      @if($result['gender'] == 1)
        <span>男性</span>
      @elseif($result['gender'] == 2)
        <span>女性</span>
      @endif
      </div>

      <div class="password">
        <span>パスワード</span>
        <span>セキュリティのため非表示</span>
      </div>

      <div class="email">
        <span>メールアドレス</span>
        <span>{{ $result['email'] }}</span>
      </div>

      <div class="btn"><input type="button" value="編集" onclick="location.href='member_edit?id={{ $currentId }}'"></div>
      <div class="btn"><input type="submit" value="削除" ></div>

    </form>

  </div>




</body>
</html>