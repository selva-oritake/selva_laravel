<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>商品レビュー登録</title>
<link rel="stylesheet" href="">

</head>
<body>
<header>
<h1>商品レビュー登録</h1>
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

    <form action="review_regist_check" method="POST">
    @csrf
      <div>
        <div>
          <span>商品評価　　</span>
          <select name="evaluation">
            <option value="1" {{ old('evaluation') == 1 ? 'selected' : '' }}>1　　</option>
            <option value="2" {{ old('evaluation') == 2 ? 'selected' : '' }}>2　　</option>
            <option value="3">3　　</option>
            <option value="4">4　　</option>
            <option value="5">5　　</option>
           </select>
           @error('evaluation')
             <p class="error">＊評価を選択してください</p>
           @enderror
        </div>

        <div>
          <span>商品コメント</span>
          <textarea name="comment" cols="50" rows="11">{{ old('comment') }}</textarea>
          @foreach ($errors->get('comment') as $message)
            <p class="error">{{ $message }}</p>
          @endforeach
        </div>
      </div>
      
      <div class="btn"><input  name="complete_btn" type="submit" value="商品レビュー登録確認"></div>
      <div class="btn"><input name="prev_btn" type="button" value="前に戻る" onclick="location.href='/product_detail'"></div>

    </form>

  </div>
</body>
</html>