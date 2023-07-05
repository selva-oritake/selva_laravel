<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品レビュー削除確認</title>
<link rel="stylesheet" href="">

</head>
<body>
<header>
<h1>商品レビュー削除確認</h1>
  <input type="button" value="トップに戻る" onclick="location.href='/index'">
</header>
  <div>
    <div style="border-bottom: 1px solid #000;">
      <div>
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
        <div>
          <div>
            <span style="margin-right: 10px;">商品評価　　</span>
            <span>{{ $inputs['evaluation'] }}</span>
          </div>
  
          <div style="display: flex;">
            <span style="margin-right: 10px;">商品コメント</span>
            <span>{!! nl2br(e($inputs['comment'])) !!}</span>
          </div>
        </div>

        <form method="post" action="{{ route('MyreviewDelete') }}">
        @csrf
        @method('delete')
          <input  name="complete_btn" type="submit" value="レビューを削除する">
        </form>
        


        <div class="btn"><input name="prev_btn" type="button" value="前に戻る" onclick="history.back()"></div>

  </div>
</body>
</html>