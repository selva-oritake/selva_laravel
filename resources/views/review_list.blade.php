<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>商品レビュー一覧</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

</head>
<body>
<header>
<h1>商品レビュー一覧</h1>
  <input type="button" value="トップに戻る" onclick="location.href='/index'">
</header>
  <div>
    <div style="border-bottom: 1px solid #000;">
      <div style="display: flex;">
        <div>
          @if(isset($inputs['image_1']))
            <img src="{{ asset($inputs['image_1']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @elseif(!isset($inputs['image_1']) && isset($inputs['image_2']))
            <img src="{{ asset($inputs['image_2']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @elseif(!isset($inputs['image_1']) && !isset($inputs['image_2']) && isset($inputs['image_3']))
            <img src="{{ asset($inputs['image_3']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @elseif(!isset($inputs['image_1']) && !isset($inputs['image_2']) && !isset($inputs['image_3']) && isset($inputs['image_4']))
            <img src="{{ asset($inputs['image_4']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @endif
        </div>
      </div>
      <div>
        <p>{{ $inputs['name'] }}</p>
        <span>総合評価</span>
        <span>{{ $avg_stars }}</span>
        <span>{{ $avg_evaluation }}</span>
      </div>
      
    </div>

    <div style="padding: 10px 0;">
    @foreach ($reviews as $review)
      <div style="border-bottom: 1px solid #000; padding: 10px;">
        <div>
          <div>
            <span style="margin-right: 10px;">{{ $review->nickname }}さん</span>
            <span style="margin-right: 10px;">
              @if($review->evaluation == 1)
                ★
              @elseif($review->evaluation == 2)
                ★★
              @elseif($review->evaluation == 3)
                ★★★
              @elseif($review->evaluation == 4)
                ★★★★
              @elseif($review->evaluation == 5)
                ★★★★★
              @endif
            </span>
            <span>{{ $review->evaluation }}</span>
          </div>

          <div style="display: flex;">
            <span style="margin-right: 10px;">商品コメント</span>
            <span>{!! nl2br($review->comment) !!}</span>
          </div>
        </div>     
      </div>
    @endforeach
    </div>

    {{ $reviews->appends(request()->query())->links()}}
    
    <div class="btn"><input name="prev_btn" type="button" value="商品詳細に戻る" onclick="location.href='/product_detail'"></div>

  </div>
</body>
</html>