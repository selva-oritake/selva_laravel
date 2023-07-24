<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>カテゴリ情報登録</title>
<link rel="stylesheet" href="">

</head>
<body>
  <header>
    @if (isset($isEdit) && $isEdit)
      <h2>商品カテゴリ編集</h2>
      <input type="button" value="一覧へ戻る" onclick="location.href='{{ $url }}'">
    @else
      <h2>商品カテゴリ登録</h2>
      <input type="button" value="一覧へ戻る" onclick="location.href='product_category_list'">
    @endif
    
  </header>
  <div>
    @if (isset($isEdit) && $isEdit)
      <form action="" method="POST">
        @csrf
        <table>
          <tr>
            <td>商品大カテゴリID</td>
            <td>{{ $currentId }}</td>
          </tr>
          <tr>
            <td>商品大カテゴリ</td>
            <td>
              <input name="category" type="text" value="{{ old('category') ?? $inputs['category'] ?? $result['name'] }}"><br>
              @foreach ($errors->get('category') as $message)
                <p class="error">{{ $message }}</p>
              @endforeach
            </td>
          </tr>
          <input type="hidden" name="sub_categories" value="">
          <tr>
            <td>商品小カテゴリ</td>
            <td>
              <input name="sub_category1" type="text" value="{{ old('sub_category1') ?? $inputs['sub_category1'] ?? $result2[0]['name'] ?? '' }}"><br>
              @foreach ($errors->get('sub_category1') as $message)
                <span class="error">{{ $message }}</span>
              @endforeach
              @foreach ($errors->get('sub_categories') as $message)
                <span class="error">{{ $message }}</span>
              @endforeach
            </td>
          </tr>
          @for ($i = 2; $i <= 10; $i++)
            <tr>
              <td></td>
              <td>
                <input name="sub_category{{ $i }}" type="text" value="{{ old('sub_category'.$i) ?? $inputs['sub_category'.$i] ?? $result2[$i - 1]['name'] ?? '' }}"><br>
                @foreach ($errors->get("sub_category{$i}") as $message)
                  <span class="error">{{ $message }}</span>
                @endforeach
              </td>
            </tr>
          @endfor
        </table>
  
        <div class="btn">
          <input type="submit" value="確認画面へ">
        </div>
  
      </form>
    @else
      <form action="" method="POST">
        @csrf
        <table>
          <tr>
            <td>商品大カテゴリID</td>
            <td>登録後に自動採番</td>
          </tr>
          <tr>
            <td>商品大カテゴリ</td>
            <td>
              <input name="category" type="text" value="{{ old('category') ?? $inputs['category'] ?? '' }}"><br>
              @foreach ($errors->get('category') as $message)
                <p class="error">{{ $message }}</p>
              @endforeach
            </td>
          </tr>
          <input type="hidden" name="sub_categories" value="">
          <tr>
            <td>商品小カテゴリ</td>
            <td>
              <input name="sub_category1" type="text" value="{{ old('sub_category1') ?? $inputs['sub_category1'] ?? '' }}"><br>
              @foreach ($errors->get('sub_category1') as $message)
                <span class="error">{{ $message }}</span>
              @endforeach
              @foreach ($errors->get('sub_categories') as $message)
                <span class="error">{{ $message }}</span>
              @endforeach
            </td>
          </tr>
          @for ($i = 2; $i <= 10; $i++)
            <tr>
              <td></td>
              <td>
                <input name="sub_category{{ $i }}" type="text" value="{{ old('sub_category'.$i) ?? $inputs['sub_category'.$i] ?? '' }}"><br>
                @foreach ($errors->get("sub_category{$i}") as $message)
                  <span class="error">{{ $message }}</span>
                @endforeach
              </td>
            </tr>
          @endfor
        </table>
        <div class="btn">
          <input type="submit" value="確認画面へ">
        </div>
  
      </form>
    @endif

  </div>

</body>
</html>