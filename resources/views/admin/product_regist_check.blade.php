<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品情報確認画面</title>
<link rel="stylesheet" href="member_regist_check.css">

</head>
<body>
  @if (isset($isEdit) && $isEdit)
    <header>
      <h2>商品カテゴリ編集確認</h2>
      <input type="button" value="一覧へ戻る" onclick="location.href='product_category_list'">
    </header>
    <div>
      <form action="" method="POST">
      @csrf
      <table>
          <tr>
            <td>ID</td>
            <td>{{ $currentId }}</td>
          </tr>
          <tr>
            <td>商品名</td>
            <td>{{ $inputs['product_name'] }}</td>
          </tr>
          <tr>
            <td>商品カテゴリ</td>
            <td>{{ $category }}>{{ $sub_category }}</td>
          </tr>
          <tr>
            <td style ="vertical-align: top;">商品写真</td>
            <td>
              <span>写真1</span><br>
              @if(isset($inputs['path1']))
                <img src="{{ asset($inputs['path1']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
              @endif
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <span>写真2</span><br>
              @if(isset($inputs['path2']))
                <img src="{{ asset($inputs['path2']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
              @endif
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <span>写真3</span><br>
              @if(isset($inputs['path3']))
                <img src="{{ asset($inputs['path3']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
              @endif
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <span>写真4</span><br>
              @if(isset($inputs['path4']))
                <img src="{{ asset($inputs['path4']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
              @endif
            </td>
          </tr>
          <tr>
            <td style ="vertical-align: top;">商品説明</td>
            <td>
              <span>{!! nl2br(e($inputs['product_content'])) !!}</span>
            </td>
          </tr>
        </table>
        <div class="btn">
          <input  name="complete_btn" type="submit" value="編集完了">
          <input name="prev_btn" type="button" value="前に戻る" onclick="location.href='product_edit'">
        </div>
      </form>
    </div>
  @else
    <header>
      <h2>商品登録確認</h2>
      <input type="button" value="一覧へ戻る" onclick="location.href='product_category_list'">
    </header>
    <div>
      <form action="" method="POST">
        @csrf
        <table>
          <tr>
            <td>ID</td>
            <td>登録後に自動採番</td>
          </tr>
          <tr>
            <td>商品名</td>
            <td>{{ $inputs['product_name'] }}</td>
          </tr>
          <tr>
            <td>商品カテゴリ</td>
            <td>{{ $category }}>{{ $sub_category }}</td>
          </tr>
          <tr>
            <td style ="vertical-align: top;">商品写真</td>
            <td>
              <span>写真1</span><br>
              @if(isset($inputs['path1']))
                <img src="{{ asset($inputs['path1']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
              @endif
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <span>写真2</span><br>
              @if(isset($inputs['path2']))
                <img src="{{ asset($inputs['path2']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
              @endif
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <span>写真3</span><br>
              @if(isset($inputs['path3']))
                <img src="{{ asset($inputs['path3']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
              @endif
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <span>写真4</span><br>
              @if(isset($inputs['path4']))
                <img src="{{ asset($inputs['path4']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
              @endif
            </td>
          </tr>
          <tr>
            <td style ="vertical-align: top;">商品説明</td>
            <td>
              <span>{!! nl2br(e($inputs['product_content'])) !!}</span>
            </td>
          </tr>
        </table>
        <div class="btn">
          <input type="submit" value="登録完了">
          <input name="prev_btn" type="button" value="前に戻る" onclick="location.href='product_regist'">
        </div>
      </form>
    </div>
  @endif



</body>
</html>