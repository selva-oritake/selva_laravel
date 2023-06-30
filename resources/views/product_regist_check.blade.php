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
          <p>写真1</p>
          @if(isset($inputs['path1']))
            <img src="{{ asset($inputs['path1']) }}" style="max-width: 200px; max-height: 200px;">
          @endif
        </div>

        <div>
          <p>写真2</p>
          @if(isset($inputs['path2']))
            <img src="{{ asset($inputs['path2']) }}" style="max-width: 200px; max-height: 200px;">
          @endif
        </div>

        <div>
          <p>写真3</p>
          @if(isset($inputs['path3']))
            <img src="{{ asset($inputs['path3']) }}" style="max-width: 200px; max-height: 200px;">
          @endif
        </div>

        <div>
          <p>写真4</p>
          @if(isset($inputs['path4']))
            <img src="{{ asset($inputs['path4']) }}" style="max-width: 200px; max-height: 200px;">
          @endif
        </div>


      </div>

      <div>
      <span>商品説明</span>
      <p>{!! nl2br(e($inputs['product_content'])) !!}</p>
      </div>

      <div class="btn"><input  name="complete_btn" type="submit" value="商品を登録する"></div>
      <div class="btn"><input name="prev_btn" type="button" value="前に戻る" onclick="location.href='/product_regist'"></div>

    </form>

  </div>
</body>
</html>