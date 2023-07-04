<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品レビュー登録完了</title>
<link rel="stylesheet" href="">

</head>
<body>
<header>
<h1>商品レビュー登録完了</h1>
  <input type="button" value="トップに戻る" onclick="location.href='/index'">
</header>
  <div>
    <p>商品のレビューの登録が完了しました。</p>
    
    <div class="btn"><input  name="complete_btn" type="button" value="商品レビュー一覧へ" onclick="location.href='/review_list?id={{ $inputs->id }}'"></div>
    <div class="btn"><input name="prev_btn" type="button" value="商品詳細に戻る" onclick="location.href='/product_detail'"></div>


  </div>
</body>
</html>