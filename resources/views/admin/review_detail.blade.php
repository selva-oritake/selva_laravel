<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品レビュー詳細</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

</head>
<body>
  <header>
    <h2>商品レビュー詳細</h2>
    <input type="button" value="トップへ戻る" onclick="location.href='index'">
  </header>
    
  <div>
    <div style="display: flex;">
      <div>
          @if(isset($result['image_1']))
            <img src="{{ asset($result['image_1']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @elseif(!isset($result['image_1']) && isset($result['image_2']))
            <img src="{{ asset($result['image_2']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @elseif(!isset($result['image_1']) && !isset($result['image_2']) && isset($result['image_3']))
            <img src="{{ asset($result['image_3']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @elseif(!isset($result['image_1']) && !isset($result['image_2']) && !isset($result['image_3']) && isset($result['image_4']))
            <img src="{{ asset($result['image_4']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @endif
      </div>
      <div>
        <p>商品ID{{ $result['id'] }}</p>
        <p>{{ $result['name'] }}</p>
        <p>総合評価{{ $avg_stars }}{{ $avg_evaluation }}</p>
      </div>
    </div>
    <form action="" method="POST">
      @csrf
        <div style="border-top: 1px solid #000; padding: 10px;">
          <table>
            <tr>
              <td>ID</td>
              <td>{{ $review->id }}</td>
            </tr>
            <tr>
              <td>商品評価</td>
              <td>{{ $review->evaluation }}</td>
            </tr>
            <tr>
              <td style ="vertical-align: top;">商品コメント</td>
              <td>{!! nl2br($review->comment) !!}</td>
            </tr>
          </table>
        </div>
        <div class="btn">
          <input type="button" value="編集" onclick="location.href='review_edit?id={{ $currentId }}'">
          <input type="submit" value="削除">
        </div>
    </form>
  </div>

</body>
</html>