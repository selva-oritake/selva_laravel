<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品登録確認画面</title>
<link rel="stylesheet" href="">

</head>
<body>
  <div class="product_regist_check">
    <h1>商品登録確認画面</h1>
    <form action="index" method="POST">
    @csrf
      <div>
        <span>商品名</span>
        <span>{{ $inputs['product_name'] }}</span>
      </div>

      <div>
        <span>商品カテゴリ</span>
        <span>{{ $category }}>{{ $sub_category }}</span>
      </div>

      <div>
        <span>商品写真</span>
        <div>
          <span>写真1</span>
          <img src="{{ asset($inputs['image1']) }}" style="max-width: 200px; max-height: 200px;">
        </div>

        <div>
          <span>写真2</span>
          <img src="{{ asset($inputs['image2']) }}" style="max-width: 200px; max-height: 200px;">
        </div>

        <div>
          <span>写真3</span>
          <img src="{{ asset($inputs['image3']) }}" style="max-width: 200px; max-height: 200px;">
        </div>

        <div>
          <span>写真4</span>
          <img src="{{ asset($inputs['image4']) }}" style="max-width: 200px; max-height: 200px;">
        </div>


      </div>

      <div>
      <span>商品説明</span>
      <p>{!! nl2br(e($inputs['product_content'])) !!}</p>
      </div>

      <div class="btn"><input  name="complete_btn" type="submit" value="商品を登録する"></div>
      <div class="btn"><input name="prev_btn" type="button" value="前に戻る" onclick="history.back()"></div>

    </form>

  </div>
  @php
  dump($inputs);
@endphp
</body>
</html>