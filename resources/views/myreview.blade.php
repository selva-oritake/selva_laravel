<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<title>商品レビュー管理</title>

</head>
<body>
<header>
<h1>商品レビュー管理</h1>
  <input type="button" value="トップに戻る" onclick="location.href='/index'">
</header>
  <div>
    <div style="border-top: 1px solid #000;">
      @foreach ($myreviews as $myreview)
      <div style="display: flex; border-bottom: 1px solid #000;">
        <div style="width: 200px; height: 200px;">
          @if(isset($myreview->image_1))
            <img src="{{ $myreview->image_1 }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @elseif(!isset($myreview->image_1) && isset($myreview->image_2))
            <img src="{{ $myreview->image_2 }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @elseif(!isset($myreview->image_1) && !isset($myreview->image_2) && isset($myreview->image_3))
            <img src="{{ $myreview->image_3 }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @elseif(!isset($myreview->image_1) && !isset($myreview->image_2) && !isset($myreview->image_3) && isset($myreview->image_4))
            <img src="{{ $myreview->image_4 }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @endif
        </div>

        <div>
        <p>{{ $myreview->category }}>{{ $myreview->subcategory }}</p>
        <p>{{ $myreview->name }}</p>
        <p>
          @if($myreview->evaluation == 1)
             ★
          @elseif($myreview->evaluation == 2)
            ★★
          @elseif($myreview->evaluation == 3)
            ★★★
          @elseif($myreview->evaluation == 4)
            ★★★★
          @elseif($myreview->evaluation == 5)
            ★★★★★
          @endif
          {{ $myreview->evaluation }}
        </p>
        <p>{{ mb_strlen($myreview->comment, 'UTF-8') > 15 ? mb_substr($myreview->comment, 0, 15, 'UTF-8') . '...' : $myreview->comment }}</p>
        <input type="button" value="レビュー編集" onclick="location.href='/myreview_edit?id={{ $myreview->id }}'">
        <input type="button" value="レビュー削除" onclick="location.href='/myreview_delete?id={{ $myreview->id }}'">
        </div>
      </div>    
      @endforeach
    </div>

    {{ $myreviews->appends(request()->query())->links()}}
    
    <div class="btn"><input name="prev_btn" type="button" value="マイページに戻る" onclick="location.href='/mypage'"></div>

  </div>
</body>
</html>