<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品レビュー情報確認</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

</head>
<body>
@if (isset($isEdit) && $isEdit)
<header>
    <h2>商品レビュー編集確認</h2>
    <input type="button" value="トップへ戻る" onclick="location.href='index'">
  </header>
    
  <div>
    <div style="display: flex;">
      <div>
          @if(isset($product->image_1))
            <img src="{{ asset($product->image_1) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @elseif(!isset($product->image_1) && isset($product->image_2))
            <img src="{{ asset($product->image_2) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @elseif(!isset($product->image_1) && !isset($product->image_2) && isset($product->image_3))
            <img src="{{ asset($product->image_3) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @elseif(!isset($product->image_1) && !isset($product->image_2) && !isset($product->image_3) && isset($product->image_4))
            <img src="{{ asset($product->image_4) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @endif
      </div>
      <div>
        <p>商品ID{{ $product['id'] }}</p>
        <p>{{ $product->name }}</p>
        <p>総合評価{{ $avg_stars }}{{ $avg_evaluation }}</p>
      </div>
    </div>
    <form action="" method="POST">
      @csrf
        <div style="border-top: 1px solid #000; padding: 10px;">
          <table>
            <tr>
              <td>ID</td>
              <td>{{ $currentId}}</td>
            </tr>
            <tr>
              <td>商品評価</td>
              <td>{{ $inputs['evaluation'] }}</td>
            </tr>
            <tr>
              <td style ="vertical-align: top;">商品コメント</td>
              <td>{!! nl2br($inputs['comment']) !!}</td>
            </tr>
          </table>
        </div>
        <div class="btn">
          <input type="submit" value="編集完了">
          <input type="button" value="前に戻る" onclick="location.href='review_edit'">
        </div>
    </form>
  </div>
@else
  <header>
    <h2>商品レビュー登録確認</h2>
    <input type="button" value="トップへ戻る" onclick="location.href='index'">
  </header>
    
  <div>
    <div style="display: flex;">
      <div>
          @if(isset($product->image_1))
            <img src="{{ asset($product->image_1) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @elseif(!isset($product->image_1) && isset($product->image_2))
            <img src="{{ asset($product->image_2) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @elseif(!isset($product->image_1) && !isset($product->image_2) && isset($product->image_3))
            <img src="{{ asset($product->image_3) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @elseif(!isset($product->image_1) && !isset($product->image_2) && !isset($product->image_3) && isset($product->image_4))
            <img src="{{ asset($product->image_4) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @endif
      </div>
      <div>
        <p>商品ID{{ $inputs['product'] }}</p>
        <p>{{ $product->name }}</p>
        <p>総合評価{{ $avg_stars }}{{ $avg_evaluation }}</p>
      </div>
    </div>
    <form action="" method="POST">
      @csrf
        <div style="border-top: 1px solid #000; padding: 10px;">
          <table>
            <tr>
              <td>ID</td>
              <td>登録後に自動採番</td>
            </tr>
            <tr>
              <td>商品評価</td>
              <td>{{ $inputs['evaluation'] }}</td>
            </tr>
            <tr>
              <td style ="vertical-align: top;">商品コメント</td>
              <td>{!! nl2br($inputs['comment']) !!}</td>
            </tr>
          </table>
        </div>
        <div class="btn">
          <input type="submit" value="登録完了">
          <input type="button" value="前に戻る" onclick="location.href='review_regist'">
        </div>
    </form>
  </div>
@endif
</body>
</html>