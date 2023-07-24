<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>会員情報確認画面</title>
<link rel="stylesheet" href="member_regist_check.css">

</head>
<body>
  @if (isset($isEdit) && $isEdit)
    <header>
      <h2>会員編集</h2>
      <input type="button" value="一覧へ戻る" onclick="location.href='member_list'">
    </header>
    <div class="member_regist_check">
      <span>ID</span>
      <span>{{ $currentId }}</span>
  
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
  
        <div class="password">
          <span>パスワード</span>
          <span>セキュリティのため非表示</span>
        </div>
  
        <div class="email">
          <span>メールアドレス</span>
          <span>{{ $inputs['email'] }}</span>
        </div>
  
        <div class="btn"><input  name="complete_btn" type="submit" value="編集完了"></div>
        <div class="btn"><input name="prev_btn" type="button" value="前に戻る" onclick="location.href='member_edit?id={{ $id }}'"></div>
  
      </form>
  
    </div>
  @else
    <header>
      <h2>会員登録</h2>
      <input type="button" value="一覧へ戻る" onclick="location.href='{{ $url }}'">
    </header>
    <div class="member_regist_check">
      <span>ID</span>
      <span>登録後に自動採番</span>
  
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
  
        <div class="password">
          <span>パスワード</span>
          <span>セキュリティのため非表示</span>
        </div>
  
        <div class="email">
          <span>メールアドレス</span>
          <span>{{ $inputs['email'] }}</span>
        </div>
  
        <div class="btn"><input  name="complete_btn" type="submit" value="登録完了"></div>
        <div class="btn"><input name="prev_btn" type="button" value="前に戻る" onclick="location.href='member_regist'"></div>
  
      </form>
  
    </div>
  @endif



</body>
</html>