<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>商品レビュー登録確認</title>
<link rel="stylesheet" href="">

</head>
<body>
<header>
<h1>商品レビュー登録確認</h1>
  <input type="button" value="トップに戻る" onclick="location.href='/index'">
</header>
  <div>
    <div style="border-bottom: 1px solid #000;">
      <div>
        <div>
          @if(isset($inputs['image_1']))
            <img src="{{ asset($inputs['image_1']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @endif
        </div>

        <div>
          @if(isset($inputs['image_2']))
            <img src="{{ asset($inputs['image_2']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @endif
        </div>

        <div>
          @if(isset($inputs['image_3']))
            <img src="{{ asset($inputs['image_3']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
          @endif
        </div>

        <div>
          @if(isset($inputs['image_4']))
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

    <form action="review_regist_complete" method="POST">
    @csrf
      <div>
        <div>
          <span style="margin-right: 10px;">商品評価　　</span>
          <span>{{ $inputs2['evaluation'] }}</span>
        </div>

        <div style="display: flex;">
          <span style="margin-right: 10px;">商品コメント</span>
          <span>{!! nl2br(e($inputs2['comment'])) !!}</span>
        </div>
      </div>
      

      <div class="btn"><input  name="complete_btn" type="submit" value="登録する"></div>
      <div class="btn"><input name="prev_btn" type="button" value="前に戻る" onclick="history.back()"></div>

    </form>

  </div>
</body>
</html>