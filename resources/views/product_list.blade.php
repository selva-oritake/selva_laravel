<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品一覧</title>
<link rel="stylesheet" href="">
</head>
<body>
  <header>
    @auth
      <input type="button" value="商品登録" onclick="location.href='/product_regist'">
    @endauth
  </header>
  
  <form action="" method="GET">
    <div>
      <span>カテゴリ</span>
      <select name="category" id="category">
        <option value="" style="display: none;">カテゴリー</option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>  
      
      <select name="sub_category" id="sub_category">
        <option value="">サブカテゴリー</option>
      </select>
      
      <span>フリーワード</span>
      <input type="text" name="keyword" id="keyword">
    </div>
    
    <button type="submit">検索</button>
  </form>

  <script>
    $(document).ready(function() {
        //サブカテゴリー
        $('#category').on('change', function() {
            var categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: '/get_subcategories',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        categoryId: categoryId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {   
                        $.each(data, function(key, value) {
                          $('#sub_category').append('<option value="' + value.id + '" ' + '>' + value.name + '</option>');
                        });
                    }
                });
            }
        });
    });
  </script>

</body>
</html>