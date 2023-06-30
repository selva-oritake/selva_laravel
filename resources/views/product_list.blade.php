<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<title>商品一覧</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
  <header>
    @auth
      <input type="button" value="新規商品登録" onclick="location.href='/product_regist'">
    @endauth
  </header>
  
  <form action="" method="GET">
  @csrf
    <div>
      <span>カテゴリ</span>
      <select name="category" id="category">
        <option value="" style="display: none;">カテゴリ</option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>  
      
      <select name="sub_category" id="sub_category">
        <option value="">サブカテゴリ</option>
      </select>
      
      <span>フリーワード</span>
      <input type="text" name="keyword" id="keyword">
    </div>
    
    <button type="submit">検索</button>
  </form>

  <div style="padding: 10px 0;">
    @foreach ($products as $product)
      <div style="border-top: 1px solid #000; padding: 10px 0;">
        <p>{{ $product->category_name }}>{{ $product->subcategory_name }}</p>
        <p>商品名：{{ $product->name }}</p>
        @if(isset($product->image_1))
          <img src="{{ $product->image_1 }}" style="max-width: 100px; max-height: 100px;">
        @endif
      </div>
    @endforeach
  </div>

  {{ $products->appends(request()->query())->links()}}

  <input type="button" value="トップに戻る" onclick="location.href='/index'" style="margin: 10px 0;">


  <script>
    $(document).ready(function() {
      // サブカテゴリーのプルダウンを動的に更新するための関数
      function updateSubCategories(categoryId) {
        $('#sub_category').empty();
        $('#sub_category').append('<option value="">サブカテゴリ</option>');
  
        $.ajax({
          url: '/get_subcategories2',
          type: 'POST',
          dataType: 'json',
          data: {
            categoryId: categoryId,
            _token: '{{ csrf_token() }}'
          },
          success: function(data) {
            $.each(data, function(key, value) {
              $('#sub_category').append('<option value="' + value.id + '">' + value.name + '</option>');
            });
          }
        });
      }

    // カテゴリの選択値がある場合にサブカテゴリを更新する
    var selectedCategory = sessionStorage.getItem('category');
    if (selectedCategory) {
      updateSubCategories(selectedCategory);
    }

    // カテゴリが変更されたときにサブカテゴリを更新する
    $('#category').on('change', function() {
      var categoryId = $(this).val();
      updateSubCategories(categoryId);
    });
  });
  </script>

</body>
</html>