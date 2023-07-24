<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<title>商品情報</title>
<link rel="stylesheet" href="">
</head>

<body>
  <header>
    @if (isset($isEdit) && $isEdit)
      <h2>商品編集</h2>
      <input type="button" value="一覧へ戻る" onclick="location.href='{{ $url }}'">
    @else
      <h2>商品登録</h2>
      <input type="button" value="一覧へ戻る" onclick="location.href='product_list'">
    @endif
  </header>
  <div>
    @if (isset($isEdit) && $isEdit)
      <form action="" method="POST">
        @csrf
        <table>
          <tr>
            <td>ID</td>
            <td>{{ $currentId }}</td>
          </tr>
          <tr>
            <td style ="vertical-align: top;">商品名</td>
            <td>
              <input name="product_name" type="text" value="{{ old('product_name') ?? $inputs['product_name'] ?? $result['name'] ?? '' }}"><br>
              @foreach ($errors->get('product_name') as $message)
                <p class="error">{{ $message }}</p>
              @endforeach
            </td>
          </tr>
          <tr>
            <td style ="vertical-align: top;">商品カテゴリ</td>
            <td>
              <select name="category" id="category">
                <option value="" style="display: none;">選択してください</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ (old('category') == $category->id ||
                                                       (isset($inputs['category']) && $inputs['category'] == $category->id) ||
                                                       (isset($result['product_category_id']) && $result['product_category_id'] == $category->id && !isset($inputs['category']))) ? 'selected' : '' 
                                                    }}>{{ $category->name }}
                </option>
                @endforeach
              </select>
              <select name="sub_category" id="sub_category">
                <option value="">サブカテゴリを選択してください</option>
              </select>
              @foreach ($errors->get('category') as $message)
                <p class="error">{{ $message }}</p>
              @endforeach
              @foreach ($errors->get('sub_category') as $message)
                <p class="error">{{ $message }}</p>
              @endforeach
            </td>
          </tr>
          <tr>
            <td style ="vertical-align: top;">商品写真</td>
            <td>
              <p>写真1</p>
              <div id="preview1">
                @if(isset($inputs['path1']))
                <img src="{{ asset($inputs['path1']) }}" width="200">
                @elseif(isset($result['image_1']))
                <img src="{{ asset($result['image_1']) }}" width="200">
                @endif
              </div>
              <input id="uploadInput1" type="file" style="display: none;">
              <input type="hidden" id="path1" name="path1" value="{{ $inputs['path1'] ?? $result['image_1'] ?? '' }}">
              <button id="imageUpload1" type="button" onclick="selectFile(1)">アップロード</button>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <p>写真2</p>
              <div id="preview2">
                @if(isset($inputs['path2']))
                <img src="{{ asset($inputs['path2']) }}" width="200">
                @elseif(isset($result['image_2']))
                <img src="{{ asset($result['image_2']) }}" width="200">
                @endif
              </div>
              <input id="uploadInput2" type="file" style="display: none;">
              <input type="hidden" id="path2" name="path2" value="{{ $inputs['path2'] ?? $result['image_2'] ?? '' }}">
              <button id="imageUpload2" type="button" onclick="selectFile(2)">アップロード</button>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <p>写真3</p>
              <div id="preview3">
                @if(isset($inputs['path3']))
                <img src="{{ asset($inputs['path3']) }}" width="200">
                @elseif(isset($result['image_3']))
                <img src="{{ asset($result['image_3']) }}" width="200">
                @endif
              </div>
              <input id="uploadInput3" type="file" style="display: none;">
              <input type="hidden" id="path3" name="path3" value="{{ $inputs['path3'] ?? $result['image_3'] ?? '' }}">
              <button id="imageUpload3" type="button" onclick="selectFile(3)">アップロード</button>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <p>写真4</p>
              <div id="preview4">
              @if(isset($inputs['path4']))
                <img src="{{ asset($inputs['path4']) }}" width="200">
                @elseif(isset($result['image_4']))
                <img src="{{ asset($result['image_4']) }}" width="200">
                @endif
              </div>
              <input id="uploadInput4" type="file" style="display: none;">
              <input type="hidden" id="path4" name="path4" value="{{ $inputs['path4'] ?? $result['image_4'] ?? '' }}">
              <button id="imageUpload4" type="button" onclick="selectFile(4)">アップロード</button>
            </td>
          </tr>
          <tr>
            <td style ="vertical-align: top;">商品説明</td>
            <td>
              <textarea name="product_content" cols="50" rows="11">{{ old('product_content') ?? $inputs['product_content'] ?? $result['product_content'] ?? '' }}</textarea>
                @foreach ($errors->get('product_content') as $message)
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
            <td>ID</td>
            <td>登録後に自動採番</td>
          </tr>
          <tr>
            <td style ="vertical-align: top;">商品名</td>
            <td>
              <input name="product_name" type="text" value="{{ old('product_name') ?? $inputs['product_name'] ?? '' }}"><br>
              @foreach ($errors->get('product_name') as $message)
                <p class="error">{{ $message }}</p>
              @endforeach
            </td>
          </tr>
          <tr>
            <td style ="vertical-align: top;">商品カテゴリ</td>
            <td>
              <select name="category" id="category">
                <option value="" style="display: none;">選択してください</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category') == $category->id || (isset($inputs['category']) && $inputs['category'] == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
              </select>
              <select name="sub_category" id="sub_category">
                <option value="">サブカテゴリを選択してください</option>
              </select>
              @foreach ($errors->get('category') as $message)
                <p class="error">{{ $message }}</p>
              @endforeach
              @foreach ($errors->get('sub_category') as $message)
              <p class="error">{{ $message }}</p>
              @endforeach
            </td>
          </tr>
          <tr>
            <td style ="vertical-align: top;">商品写真</td>
            <td>
              <p>写真1</p>
              <div id="preview1">
                @if(isset($inputs['path1']))
                <img src="{{ asset($inputs['path1']) }}" width="200">
                @endif
              </div>
              <input id="uploadInput1" type="file" style="display: none;">
              <input type="hidden" id="path1" name="path1" value="{{ $inputs['path1'] ?? '' }}">
              <button id="imageUpload1" type="button" onclick="selectFile(1)">アップロード</button>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <p>写真2</p>
              <div id="preview2">
                @if(isset($inputs['path2']))
                <img src="{{ asset($inputs['path2']) }}" width="200">
                @endif
              </div>
              <input id="uploadInput2" type="file" style="display: none;">
              <input type="hidden" id="path2" name="path2" value="{{ $inputs['path2'] ?? '' }}">
              <button id="imageUpload2" type="button" onclick="selectFile(2)">アップロード</button>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <p>写真3</p>
              <div id="preview3">
                @if(isset($inputs['path3']))
                <img src="{{ asset($inputs['path3']) }}" width="200">
                @endif
              </div>
              <input id="uploadInput3" type="file" style="display: none;">
              <input type="hidden" id="path3" name="path3" value="{{ $inputs['path3'] ?? '' }}">
              <button id="imageUpload3" type="button" onclick="selectFile(3)">アップロード</button>
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <p>写真4</p>
              <div id="preview4">
                @if(isset($inputs['path4']))
                <img src="{{ asset($inputs['path4']) }}" width="200">
                @endif
              </div>
              <input id="uploadInput4" type="file" style="display: none;">
              <input type="hidden" id="path4" name="path4" value="{{ $inputs['path4'] ?? '' }}">
              <button id="imageUpload4" type="button" onclick="selectFile(4)">アップロード</button>
            </td>
          </tr>
          <tr>
            <td style ="vertical-align: top;">商品説明</td>
            <td>
              <textarea name="product_content" cols="50" rows="11">{{ old('product_content') ?? $inputs['product_content'] ?? '' }}</textarea>
                @foreach ($errors->get('product_content') as $message)
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
@if (isset($isEdit) && $isEdit)
  <script>
    function validateFile(file) {
      // 画像ファイルであること
      if (!file.type.startsWith('image/')) {
        alert('画像ファイルを選択してください。');
        return false;
      }
    
      // jpg, jpeg, png, gif形式であること
      const validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
      const fileExtension = file.name.split('.').pop().toLowerCase();
      if (!validExtensions.includes(fileExtension)) {
        alert('jpg, jpeg, png, gif形式の画像ファイルを選択してください。');
        return false;
      }
    
      // 10MB以下であること
      const maxSize = 10 * 1024 * 1024; // 10MB
      if (file.size > maxSize) {
        alert('ファイルサイズは10MB以下にしてください。');
        return false;
      }
    
      return true;
    }

    function selectFile(imageNumber) {
      document.getElementById('uploadInput' + imageNumber).click();
    }

    $(document).ready(function() {
      $('#uploadInput1').change(function() {
        var input = this;
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            

            // ファイルをアップロードする
            var formData = new FormData();
            formData.append('image1', input.files[0]);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // CSRFトークンを追加
            $.ajax({
              url: '/image_upload', // アップロード先のURLを指定
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              //バリデーションを間に挟む
              beforeSend: function() {
                if (!validateFile(input.files[0])) {
                  return false;
                }
              },

              success: function(response) {
                // アップロード成功時の処理
                alert('ファイルがアップロードされました！');
                $('#preview1').html('<img src="' + e.target.result + '" width="200">');
                $('#path1').val(response.path1);
              },
              error: function(xhr, status, error) {
                // アップロードエラー時の処理
                alert('ファイルのアップロードに失敗しました。');
              }
            });
          };
          reader.readAsDataURL(input.files[0]);
        }
      });
    });

    $(document).ready(function() {
      $('#uploadInput2').change(function() {
        var input = this;
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            
            // ファイルをアップロードする
            var formData = new FormData();
            formData.append('image2', input.files[0]);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // CSRFトークンを追加
            $.ajax({
              url: '/image_upload', // アップロード先のURLを指定
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              //バリデーションを間に挟む
              beforeSend: function() {
                if (!validateFile(input.files[0])) {
                  return false;
                }
              },
              success: function(response) {
                // アップロード成功時の処理
                alert('ファイルがアップロードされました！');
                $('#preview2').html('<img src="' + e.target.result + '" width="200">');
                $('#path2').val(response.path2);
              },
              error: function(xhr, status, error) {
                // アップロードエラー時の処理
                alert('ファイルのアップロードに失敗しました。');
              }
            });
          };
          reader.readAsDataURL(input.files[0]);
        }
      });
    });

    $(document).ready(function() {
      $('#uploadInput3').change(function() {
        var input = this;
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {

            // ファイルをアップロードする
            var formData = new FormData();
            formData.append('image3', input.files[0]);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // CSRFトークンを追加
            $.ajax({
              url: '/image_upload', // アップロード先のURLを指定
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              //バリデーションを間に挟む
              beforeSend: function() {
                if (!validateFile(input.files[0])) {
                  return false;
                }
              },
              success: function(response) {
                // アップロード成功時の処理
                alert('ファイルがアップロードされました！');
                $('#preview3').html('<img src="' + e.target.result + '" width="200">');
                $('#path3').val(response.path3);
              },
              error: function(xhr, status, error) {
                // アップロードエラー時の処理
                alert('ファイルのアップロードに失敗しました。');
              }
            });
          };
          reader.readAsDataURL(input.files[0]);
        }
      });
    });

    $(document).ready(function() {
      $('#uploadInput4').change(function() {
        var input = this;
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {

            // ファイルをアップロードする
            var formData = new FormData();
            formData.append('image4', input.files[0]);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // CSRFトークンを追加
            $.ajax({
              url: '/image_upload', // アップロード先のURLを指定
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              //バリデーションを間に挟む
              beforeSend: function() {
                if (!validateFile(input.files[0])) {
                  return false;
                }
              },
              success: function(response) {
                // アップロード成功時の処理
                alert('ファイルがアップロードされました！');
                $('#preview4').html('<img src="' + e.target.result + '" width="200">');
                $('#path4').val(response.path4);
              },
              error: function(xhr, status, error) {
                // アップロードエラー時の処理
                alert('ファイルのアップロードに失敗しました。');
              }
            });
          };
          reader.readAsDataURL(input.files[0]);
        }
      });
    });

    $(document).ready(function() {
  // サブカテゴリのプルダウンを動的に更新するための関数
  function updateSubCategories(categoryId, subCategoryId) {
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
          var selected = (value.id == subCategoryId) ? 'selected' : '';
          $('#sub_category').append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
        });
      }
    });
  }

  // カテゴリの選択値がある場合にサブカテゴリを更新する
  var selectedCategory = sessionStorage.getItem('category');
  var selectedSubCategory = sessionStorage.getItem('selectedSubCategory');
  if (selectedCategory) {
    updateSubCategories(selectedCategory, selectedSubCategory);
  } else {
    var productCategoryId = '{{ $result["product_category_id"] }}';
    var productSubCategoryId = '{{ $result["product_subcategory_id"] }}';
    if (productCategoryId && productSubCategoryId) {
      updateSubCategories(productCategoryId, productSubCategoryId);
    }
  }

  // カテゴリが変更されたときにサブカテゴリを更新する
  $('#category').on('change', function() {
    var categoryId = $(this).val();
    updateSubCategories(categoryId, null);
  });
});

// フォームが送信されたときにセッションストレージに入力値を保存する
$('form').on('submit', function() {
  sessionStorage.setItem('category', $('#category').val());
  sessionStorage.setItem('selectedSubCategory', $('#sub_category').val());
});
  </script>
@else
  <script>
    function validateFile(file) {
      // 画像ファイルであること
      if (!file.type.startsWith('image/')) {
        alert('画像ファイルを選択してください。');
        return false;
      }
    
      // jpg, jpeg, png, gif形式であること
      const validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
      const fileExtension = file.name.split('.').pop().toLowerCase();
      if (!validExtensions.includes(fileExtension)) {
        alert('jpg, jpeg, png, gif形式の画像ファイルを選択してください。');
        return false;
      }
    
      // 10MB以下であること
      const maxSize = 10 * 1024 * 1024; // 10MB
      if (file.size > maxSize) {
        alert('ファイルサイズは10MB以下にしてください。');
        return false;
      }
    
      return true;
    }

    function selectFile(imageNumber) {
      document.getElementById('uploadInput' + imageNumber).click();
    }

    $(document).ready(function() {
      $('#uploadInput1').change(function() {
        var input = this;
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            

            // ファイルをアップロードする
            var formData = new FormData();
            formData.append('image1', input.files[0]);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // CSRFトークンを追加
            $.ajax({
              url: '/image_upload', // アップロード先のURLを指定
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              //バリデーションを間に挟む
              beforeSend: function() {
                if (!validateFile(input.files[0])) {
                  return false;
                }
              },

              success: function(response) {
                // アップロード成功時の処理
                alert('ファイルがアップロードされました！');
                $('#preview1').html('<img src="' + e.target.result + '" width="200">');
                $('#path1').val(response.path1);
              },
              error: function(xhr, status, error) {
                // アップロードエラー時の処理
                alert('ファイルのアップロードに失敗しました。');
              }
            });
          };
          reader.readAsDataURL(input.files[0]);
        }
      });
    });

    $(document).ready(function() {
      $('#uploadInput2').change(function() {
        var input = this;
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            
            // ファイルをアップロードする
            var formData = new FormData();
            formData.append('image2', input.files[0]);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // CSRFトークンを追加
            $.ajax({
              url: '/image_upload', // アップロード先のURLを指定
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              //バリデーションを間に挟む
              beforeSend: function() {
                if (!validateFile(input.files[0])) {
                  return false;
                }
              },
              success: function(response) {
                // アップロード成功時の処理
                alert('ファイルがアップロードされました！');
                $('#preview2').html('<img src="' + e.target.result + '" width="200">');
                $('#path2').val(response.path2);
              },
              error: function(xhr, status, error) {
                // アップロードエラー時の処理
                alert('ファイルのアップロードに失敗しました。');
              }
            });
          };
          reader.readAsDataURL(input.files[0]);
        }
      });
    });

    $(document).ready(function() {
      $('#uploadInput3').change(function() {
        var input = this;
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {

            // ファイルをアップロードする
            var formData = new FormData();
            formData.append('image3', input.files[0]);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // CSRFトークンを追加
            $.ajax({
              url: '/image_upload', // アップロード先のURLを指定
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              //バリデーションを間に挟む
              beforeSend: function() {
                if (!validateFile(input.files[0])) {
                  return false;
                }
              },
              success: function(response) {
                // アップロード成功時の処理
                alert('ファイルがアップロードされました！');
                $('#preview3').html('<img src="' + e.target.result + '" width="200">');
                $('#path3').val(response.path3);
              },
              error: function(xhr, status, error) {
                // アップロードエラー時の処理
                alert('ファイルのアップロードに失敗しました。');
              }
            });
          };
          reader.readAsDataURL(input.files[0]);
        }
      });
    });

    $(document).ready(function() {
      $('#uploadInput4').change(function() {
        var input = this;
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {

            // ファイルをアップロードする
            var formData = new FormData();
            formData.append('image4', input.files[0]);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // CSRFトークンを追加
            $.ajax({
              url: '/image_upload', // アップロード先のURLを指定
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              //バリデーションを間に挟む
              beforeSend: function() {
                if (!validateFile(input.files[0])) {
                  return false;
                }
              },
              success: function(response) {
                // アップロード成功時の処理
                alert('ファイルがアップロードされました！');
                $('#preview4').html('<img src="' + e.target.result + '" width="200">');
                $('#path4').val(response.path4);
              },
              error: function(xhr, status, error) {
                // アップロードエラー時の処理
                alert('ファイルのアップロードに失敗しました。');
              }
            });
          };
          reader.readAsDataURL(input.files[0]);
        }
      });
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
                if ($('#sub_category option[value="' + selectedSubCategory + '"]').length > 0) {
                  $('#sub_category').val(selectedSubCategory);
                } else {
                  sessionStorage.removeItem('selectedSubCategory');
                }
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
@endif
</body>
</html>