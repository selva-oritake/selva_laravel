<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品詳細</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

</head>
<body>
  <header>
    <h2>商品詳細</h2>
    <input type="button" value="一覧へ戻る" onclick="location.href='{{ $url }}'">
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
            <td>{{ $result['name'] }}</td>
          </tr>
          <tr>
            <td>商品カテゴリ</td>
            <td>{{ $category }}>{{ $sub_category }}</td>
          </tr>
          <tr>
            <td style ="vertical-align: top;">商品写真</td>
            <td>
              <span>写真1</span><br>
              @if(isset($result['image_1']))
                <img src="{{ asset($result['image_1']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
              @endif
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <span>写真2</span><br>
              @if(isset($result['image_2']))
                <img src="{{ asset($result['image_2']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
              @endif
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <span>写真3</span><br>
              @if(isset($result['image_3']))
                <img src="{{ asset($result['image_3']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
              @endif
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <span>写真4</span><br>
              @if(isset($result['image_4']))
                <img src="{{ asset($result['image_4']) }}" style="max-width: 200px; max-height: 200px; object-fit: contain;">
              @endif
            </td>
          </tr>
          <tr>
            <td style ="vertical-align: top; width: 100px;">商品説明</td>
            <td>
              <span>{!! nl2br(e($result['product_content'])) !!}</span>
            </td>
          </tr>
        </table>
      

        <div style="border-bottom: 1px solid #000; border-top: 1px solid #000;">
          <span>総合評価</span>
          <span>{{ $avg_stars }}{{ $avg_evaluation }}</span>
        </div>
        @foreach ($reviews as $review)
          <div style="border-bottom: 1px solid #000; padding: 10px;">
            <table>
              <tr>
                <td>商品レビューID</td>
                <td>{{ $review->id }}</td>
                <td></td>
              </tr>
              <tr>
                <td><a href="member_detail?id={{ $review->member_id }}">{{ $review->nickname }}さん</a></td>
                <td>
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
                </td>
                <td></td>
              </tr>
              <tr>
                <td>商品コメント</td>
                <td>{!! nl2br($review->comment) !!}</td>
                <td><input type="button" value="商品レビュー詳細" onclick="location.href='review_detail?id={{ $review->id }}'"></td>
              </tr>
            </table>
          </div>
        @endforeach

        @if ($reviews->isEmpty())
        <p>レビューはありません</p>
        @endif

        {{ $reviews->appends(request()->query())->links()}}

        <div class="btn">
          <input type="button" value="編集" onclick="location.href='product_edit?id={{ $currentId }}'">
          <input type="submit" value="削除">
        </div>
    </form>
  </div>

</body>
</html>