<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品レビュー情報</title>

</head>
<body>
  <header>
    @if (isset($isEdit) && $isEdit)
      <h2>商品レビュー編集</h2>
    @else
      <h2>商品レビュー登録</h2>
    @endif
    <input type="button" value="一覧へ戻る" onclick="location.href='review_list'">
  </header>
  <div>
    @if (isset($isEdit) && $isEdit)
      <form action="" method="POST">
        @csrf
        <table>
          <tr>
            <td style ="vertical-align: top;">商品</td>
            <td>{{ $product['name'] }}</td>
          </tr>
          <tr>
            <td>ID</td>
            <td>{{ $currentId }}</td>
          </tr>
          <tr>
            <td style ="vertical-align: top;">商品評価</td>
            <td>
              <select name="evaluation">
                  <option value="" style="display: none;">選択してください</option>
                  @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ (old('evaluation') == $i ||
                                                (isset($inputs['evaluation']) && $inputs['evaluation'] == $i) ||
                                                (isset($result['evaluation']) && $result['evaluation'] == $i && !isset($inputs['evaluation']))) ? 'selected' : '' 
                                             }}>{{ $i }}
                    </option>
                  @endfor
              </select>
              @error('evaluation')
                <p class="error">＊評価を選択してください</p>
              @enderror      
            </td>
          </tr>
          <tr>
            <td style ="vertical-align: top;">商品コメント</td>
            <td>
              <textarea name="comment" cols="50" rows="11">{{ old('comment') ?? $inputs['comment'] ?? $result['comment'] ?? '' }}</textarea>
                @foreach ($errors->get('comment') as $message)
                <p class="error">{{ $message }}</p>
                @endforeach
            </td>
          </tr>
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
            <td style ="vertical-align: top;">商品</td>
            <td>
              <select name="product">
                <option value="" style="display: none;">選択してください</option>
                  @foreach ($products as $product)
                    <option value="{{ $product->id }}" {{ old('product') == $product->id || (isset($inputs['product']) && $inputs['product'] == $product->id) ? 'selected' : '' }}>{{ $product->name }}</option>
                  @endforeach
              </select>
              @error('product')
                <p class="error">＊商品を選択してください</p>
              @enderror
            </td>
          </tr>
          <tr>
            <td>ID</td>
            <td>登録後に自動採番</td>
          </tr>
          <tr>
            <td style ="vertical-align: top;">商品評価</td>
            <td>
              <select name="evaluation">
                  <option value="" style="display: none;">選択してください</option>
                  @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('evaluation') == $i || (isset($inputs['evaluation']) && $inputs['evaluation'] == $i) ? 'selected' : '' }}>{{ $i }}　　</option>
                  @endfor
              </select>
              @error('evaluation')
                <p class="error">＊評価を選択してください</p>
              @enderror      
            </td>
          </tr>
          <tr>
            <td style ="vertical-align: top;">商品コメント</td>
            <td>
              <textarea name="comment" cols="50" rows="11">{{ old('comment') ?? $inputs['comment'] ?? '' }}</textarea>
                @foreach ($errors->get('comment') as $message)
                <p class="error">{{ $message }}</p>
                @endforeach
            </td>
          </tr>
        </table>
        <div class="btn">
          <input type="submit" value="確認画面へ">
        </div>
      </form>
    @endif

  </div>

</body>
</html>