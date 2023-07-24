<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品カテゴリ詳細</title>
<link rel="stylesheet" href="">

</head>
<body>
  <header>
    <h2>商品カテゴリ詳細</h2>
    <input type="button" value="一覧へ戻る" onclick="location.href='{{ $url }}'">
  </header>
  <div>
    <form action="" method="POST">
      @csrf
        <table>
          <tr>
            <td>商品大カテゴリID</td>
            <td>{{ $currentId }}</td>
          </tr>
          <tr>
            <td>商品大カテゴリ</td>
            <td>{{ $result['name'] }}</td>
          </tr>
          <tr>
            <td>商品小カテゴリ</td>
            <td>{{ $result2[0]['name'] ?? ''}}</td>
          </tr>
          @for ($i = 2; $i <= 10; $i++)
            <tr>
              <td></td>
              <td>{{ $result2[$i - 1]['name'] ?? '' }}</td>
            </tr>
          @endfor
        </table>
        <div class="btn">
          <input type="button" value="編集" onclick="location.href='product_category_edit?id={{ $currentId }}'">
          <input type="submit" value="削除">
        </div>
    </form>
  </div>




</body>
</html>