<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<title>会員一覧</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
  <header>
    <h2>会員一覧</h2>
    <input type="button" value="トップへ戻る" onclick="location.href='index'">
  </header>

  <input type="button" value="会員登録" onclick="location.href='member_regist'">
  
  <form action="" method="GET">
  @csrf
    <table>
      <tr>
        <td>ID</td>
        <td><input type="text" name="id"></td>
      </tr>
      <tr>
        <td>性別</td>
        <td>
          <input type="checkbox" name="male" value="1">男性
          <input type="checkbox" name="female" value="2">女性
        </td>
      </tr>
      <tr>
        <td>フリーワード</td>
        <td><input type="text" name="keyword"></td>
      </tr>
    </table>
    
    <button type="submit">検索する</button>
  </form>

  <div style="padding: 10px 0;">
  
    <table>
      <tr>
        <td>ID<a href="javascript:void(0);" onclick="toggleIdSortOrder();">▼</a></td>
        <td>氏名</td>
        <td>メールアドレス</td>
        <td>性別</td>
        <td>登録日時<a href="javascript:void(0);" onclick="toggleCreatedAtSortOrder();">▼</a></td>
        <td>編集</td>
        <td>詳細</td>
      </tr>
      @foreach ($members as $member)
      <tr>
        <td>{{ $member->id }}</td>
        <td><a href="member_detail?id={{ $member->id }}">{{ $member->name_sei }}{{ $member->name_mei }}</a></td>
        <td>{{ $member->email }}</td>
        <td>
          @if($member->gender == 1)
          男性
          @elseif($member->gender == 2)
          女性
          @endif
        </td>
        <td>{{ $member->created_at->format('Y/m/d') }}</td>
        <td><a href="member_edit?id={{ $member->id }}">編集</a></td>
        <td><a href="member_detail?id={{ $member->id }}">詳細</a></td>
      </tr>
      @endforeach
    </table>

    {{ $members->appends(request()->query())->links()}}
  
  </div>

<script>
  function toggleIdSortOrder() {
    var currentOrder = "{{ request('id_order') }}"; // 現在のIDの並び順を取得

    // 降順と昇順を切り替える
    var newOrder = (currentOrder === 'asc') ? 'desc' : 'asc';

    // クエリパラメータとして新しい並び順を付加して、ページをリロードする
    var currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('id_order', newOrder);
    currentUrl.searchParams.delete('created_at_order'); // 登録日時の並び順をリセット
    window.location.href = currentUrl.href;
  }

  function toggleCreatedAtSortOrder() {
    var currentOrder = "{{ request('created_at_order') }}"; // 現在の登録日時の並び順を取得

    // 降順と昇順を切り替える
    var newOrder = (currentOrder === 'asc') ? 'desc' : 'asc';

    // クエリパラメータとして新しい並び順を付加して、ページをリロードする
    var currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('created_at_order', newOrder);
    currentUrl.searchParams.delete('id_order'); // IDの並び順をリセット
    window.location.href = currentUrl.href;
  }
</script>

</body>
</html>