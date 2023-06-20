<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<title>商品登録</title>
<link rel="stylesheet" href="">
</head>
<body>

  <div class="product_regist_form">
    <h1>商品登録</h1>

    <form action="/product_regist_check" method="POST" enctype="multipart/form-data">
      @csrf
      <div>
        <span>商品名</span>
        <input type="text" name="product_name" value="{{ old('product_name') }}">
        @error('product_name')
        <p class="error">＊商品名を100文字の以内で入力してください</p>
        @enderror
      </div>

      <div>
        <span>商品カテゴリ</span>
      </div>
        
      <div>
        <select name="category" id="category">
          <option value="" style="display: none;">選択してください</option>
          @foreach ($categories as $category)
          <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
          @endforeach
        </select>

        
        <select name="sub_category" id="sub_category">
          <option value="">サブカテゴリを選択してください</option>
        </select>
      </div>

      @error('category')
        <p class="error">＊カテゴリを選択してください</p>
      @enderror
      @error('sub_category')
        <p class="error">＊サブカテゴリを選択してください</p>
      @enderror

      <div>
        <span>商品写真</span>
        
        <div>
          <span>写真1</span>
          <div id="preview1"></div>
          <input type="file" name="image1" accept="image/jpg, image/jpeg, image/png, image/gif" onchange="previewImage(this, 'preview1')" value="{{ old('image1') }}"/>
          @error('image1')
          <p class="error">＊jpg、jpeg、png、gif形式で10MB以下の画像をアップロードしてください</p>
          @enderror
        </div>

        <div>
          <span>写真2</span>
          <div id="preview2"></div>
          <input type="file" name="image2" accept="image/jpg, image/jpeg, image/png, image/gif" onchange="previewImage(this, 'preview2')" value="{{ old('image2') }}"/>
          @error('image2')
          <p class="error">＊jpg、jpeg、png、gif形式で10MB以下の画像をアップロードしてください</p>
          @enderror
        </div>

        <div>
          <span>写真3</span>
          <div id="preview3"></div>
          <input type="file" name="image3" accept="image/jpg, image/jpeg, image/png, image/gif" onchange="previewImage(this, 'preview3')" value="{{ old('image3') }}"/>
          @error('image3')
          <p class="error">＊jpg、jpeg、png、gif形式で10MB以下の画像をアップロードしてください</p>
          @enderror
        </div>

        <div>
          <span>写真4</span>
          <div id="preview4"></div>
          <input type="file" name="image4" accept="image/jpg, image/jpeg, image/png, image/gif" onchange="previewImage(this, 'preview4')" value="{{ old('image4') }}"/>
          @error('image4')
          <p class="error">＊jpg、jpeg、png、gif形式で10MB以下の画像をアップロードしてください</p>
          @enderror
        </div>
      </div>

      <div>
        <span>商品説明</span><br>
        <textarea name="product_content" cols="50" rows="11">{{ old('product_content') }}</textarea>
        @error('product_content')
        <p class="error">＊商品説明を500字以内で入力してください</p>
      @enderror
      </div>
      <div class="btn">
        <input type="submit" value="確認画面へ">
      </div>
    </form>
    <input type="button" value="トップに戻る" onclick="location.href='/index'">
  </div>
  
  <script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#' + previewId).html('<img src="' + e.target.result + '" style="max-width: 200px; max-height: 200px;" />');
                //セッションストレージに画像プレビューを保存
                sessionStorage.setItem('previewImage' + previewId, e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            var previewImage = sessionStorage.getItem('previewImage' + previewId);
            if (previewImage) {
                $('#' + previewId).html('<img src="' + previewImage + '" style="max-width: 200px; max-height: 200px;" />');
            }
        }
    }

    // ページ読み込み時にフォームの値をプレビュー表示するための処理
    $(document).ready(function() {
        var previewIds = ['preview1', 'preview2', 'preview3', 'preview4'];
        for (var i = 0; i < previewIds.length; i++) {
            var previewId = previewIds[i];
            var previewImage = sessionStorage.getItem('previewImage' + previewId);
            if (previewImage) {
                $('#' + previewId).html('<img src="' + previewImage + '" style="max-width: 200px; max-height: 200px;" />');
            }
        }
    });

    $(document).ready(function() {
      // サブカテゴリーのプルダウンを動的に更新するための関数
      function updateSubCategories(categoryId) {
        $('#sub_category').empty();
        $('#sub_category').append('<option value="">サブカテゴリを選択してください</option>');
  
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
              $('#sub_category').append('<option value="' + value.id + '">' + value.name + '</option>');
            });
  
            // セッションストレージから選択されたサブカテゴリを設定する
            var selectedSubCategory = sessionStorage.getItem('selectedSubCategory');
            if (selectedSubCategory) {
              $('#sub_category').val(selectedSubCategory);
            }
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

    
    // フォームが送信されたときにセッションストレージに入力値を保存する
    $('form').on('submit', function() {
      sessionStorage.setItem('category', $('#category').val());
      sessionStorage.setItem('selectedSubCategory', $('#sub_category').val());
    });
  </script>
</body>
</html>