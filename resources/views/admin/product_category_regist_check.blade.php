<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>カテゴリ情報確認画面</title>
<link rel="stylesheet" href="">

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
            <td>商品大カテゴリID</td>
            <td>{{ $currentId }}</td>
          </tr>
          <tr>
            <td>商品大カテゴリ</td>
            <td>{{ $inputs['category'] }}</td>
          </tr>
          <tr>
            <td>商品小カテゴリ</td>
            <td>{{ $inputs['sub_category1'] }}</td>
          </tr>
          @for ($i = 2; $i <= 10; $i++)
            <tr>
              <td></td>
              <td>{{ $inputs['sub_category'.$i] }}</td>
            </tr>
          @endfor
        </table>
        <div class="btn">
          <input  name="complete_btn" type="submit" value="編集完了">
          <input name="prev_btn" type="button" value="前に戻る" onclick="location.href='product_category_edit'">
        </div>
      </form>
    </div>
  @else
    <header>
      <h2>商品カテゴリ登録確認</h2>
      <input type="button" value="一覧へ戻る" onclick="location.href='product_category_list'">
    </header>
    <div>
      <form action="" method="POST">
        @csrf
        <table>
          <tr>
            <td>商品大カテゴリID</td>
            <td>登録後に自動採番</td>
          </tr>
          <tr>
            <td>商品大カテゴリ</td>
            <td>{{ $inputs['category'] }}</td>
          </tr>
          <tr>
            <td>商品小カテゴリ</td>
            <td>{{ $inputs['sub_category1'] }}</td>
          </tr>
          @for ($i = 2; $i <= 10; $i++)
            <tr>
              <td></td>
              <td>{{ $inputs['sub_category'.$i] }}</td>
            </tr>
          @endfor
        </table>
        <div class="btn">
          <input type="submit" value="登録完了">
          <input name="prev_btn" type="button" value="前に戻る" onclick="location.href='product_category_regist'">
        </div>
      </form>
    </div>
  @endif



</body>
</html>