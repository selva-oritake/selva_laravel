<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<title>商品詳細</title>
<link rel="stylesheet" href="">
</head>
<body>
  <header>
    <h1>商品詳細</h1>
    <input type="button" value="トップに戻る" onclick="location.href='/index'">
  </header>
  <div>
    <div>
      <p>{{ $product['category_name'] }}>{{ $product['subcategory_name'] }}</p>
    </div>

    <div>
      <span style="margin-right: 30px;">{{ $product['name'] }}</span><span>更新日時：{{ $updated_at ?? '' }}</span>
    </div>

    <div style="display: flex;">
      @if(isset($product['image_1']))
        <img src="{{ $product['image_1'] }}" style="margin: 10px; max-width: 200px; max-height: 200px; object-fit: contain;">
      @endif
      @if(isset($product['image_2']))
        <img src="{{ $product['image_2'] }}" style="margin: 10px; max-width: 200px; max-height: 200px; object-fit: contain;">
      @endif
      @if(isset($product['image_3']))
        <img src="{{ $product['image_3'] }}" style="margin: 10px; max-width: 200px; max-height: 200px; object-fit: contain;">
      @endif
      @if(isset($product['image_4']))
        <img src="{{ $product['image_4'] }}" style="margin: 10px; max-width: 200px; max-height: 200px; object-fit: contain;">
      @endif
    </div>

    <div>
      <p>■商品説明</p>
      <p>{!! nl2br($product['product_content']) !!}</p>
    </div>

    <div>
      <p>■商品レビュー</p>
      <span>総合評価</span>
      <span>{{ $avg_stars }}</span>
      <span>{{ $avg_evaluation }}</span>
      <a href="/review_list?id={{ $product->id }}" style="display: block;">>>レビューを見る</a>
    </div>

  </div>
  @auth
  <div><input type="button" value="この商品についてのレビューを登録" onclick="location.href='/review_regist'"></div>
  @endauth
  <div><input type="button" value="商品一覧に戻る" onclick="location.href='{{ $url2 }}'"></div>
  
</body>
</html>