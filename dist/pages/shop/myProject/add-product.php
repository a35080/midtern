<?php
/************** 新增產品頁面 ****************/

# 要是管理者才可以看到這個頁面
// require __DIR__ . '/parts/admin-required.php';

require __DIR__ . '/parts/init.php';
$title = "新增商品";
$pageName = "add-upload";

// 查詢商品類別
$sql_category = "SELECT * FROM Categories ORDER BY category_id ";
$rows_category = $pdo->query($sql_category)->fetchAll();

?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/html-navbar.php' ?>
<style>
  form .mb-3 .form-text {
    display: none;
    /* color: red; */
  }

  form .mb-3.error input.form-control {
    border: 2px solid red;
  }

  form .mb-3.error .form-text {
    display: block;
    color: red;
  }
</style>
<div class="container">
  <div class="row">
    <div class="col-6">
      <div class="card">

        <div class="card-body">
          <h5 class="card-title">新增商品</h5>
          
          <form onsubmit="sendData(event)">
            <div class="mb-3">
              <img src="" alt="" class="photo" width="200px">
              <input type="hidden" name="photo" value="">
              <!-- 表單裡面 button 如果沒有設定 type 會視為 submit button -->
              <button type="button"
                class="btn btn-warning" onclick="document.upload_form.photo.click()">上傳圖片</button>
            </div>
            <div class="mb-3">
              <label for="product_name" class="form-label">商品名稱**</label>
              <input type="text" class="form-control" id="product_name" name="product_name">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="category" class="form-label">類別**</label>
              <select class="form-control form-select form-select-sm" id="category" name="category">
                <option value="">--請選擇--</option>
                <?php foreach($rows_category as $row_c): ?>
                <option value="<?=$row_c['category_id']?>"><?=$row_c['category_name']?></option>
                <?php endforeach?>
              </select>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">描述</label>
              <textarea class="form-control"
                id="description" name="description"></textarea>
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="price" class="form-label">價格**</label>
              <input type="number" class="form-control" id="price" name="price" >
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="stock" class="form-label">庫存**</label>
              <input type="number" class="form-control" id="stock" name="stock" >
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="product_status" class="form-label">狀態**</label>
              <select class="form-control form-select form-select-sm" id="product_status" name="product_status">
                <option value="上架">上架</option>
                <option value="下架">下架</option>
              </select>
              <div class="form-text"></div>
            </div>
            <button type="submit" class="btn btn-primary">新增</button>
          </form>

          <form name="upload_form" hidden>
            <input type="file" name="photo" accept="image/jpeg,image/png" />
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -新增結果-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">新增結果</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          資料新增成功
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
        <a class="btn btn-primary" href="list.php">回到列表頁</a>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/parts/html-scripts.php' ?>

<script>
  const productNameField = document.querySelector('#product_name');
  const descriptionField = document.querySelector('#description');
  const priceField = document.querySelector('#price');
  const stockField = document.querySelector('#stock');
  const statusField = document.querySelector('#product_status');
  const myModal = new bootstrap.Modal('#exampleModal');

  const sendData = e => {
    e.preventDefault(); // 不要讓表單以傳統的方式送出

    productNameField.closest('.mb-3').classList.remove('error');
    descriptionField.closest('.mb-3').classList.remove('error');
    priceField.closest('.mb-3').classList.remove('error');
    stockField.closest('.mb-3').classList.remove('error');
    statusField.closest('.mb-3').classList.remove('error');

    let isPass = true; // 有沒有通過檢查, 預設值是 true
    // TODO: 資料欄位的檢查
    // --------------------------------------------------------
    if (!productNameField.value) {
      isPass = false;
      productNameField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫商品名稱`;
      productNameField.closest('.mb-3').classList.add('error');
    }
    if (!priceField.value) {
      isPass = false;
      priceField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫商品價格`;
      priceField.closest('.mb-3').classList.add('error');
    }else if(priceField.value<0){
      isPass = false;
      priceField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫正確的價格`;
      priceField.closest('.mb-3').classList.add('error');
    }
    if (!stockField.value) {
      isPass = false;
      stockField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫商品庫存量`;
      stockField.closest('.mb-3').classList.add('error');
    }else if(stockField.value<0){
      isPass = false;
      stockField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請填寫正確的庫存量`;
      stockField.closest('.mb-3').classList.add('error');
    }
    if (!statusField.value) {
      isPass = false;
      statusField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請選擇商品狀態`;
      statusField.closest('.mb-3').classList.add('error');
    }else if(statusField.value !== '上架' && statusField.value !== '下架'  ){
      isPass = false;
      statusField.nextElementSibling.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> 請選取正確的商品狀態`;
      statusField.closest('.mb-3').classList.add('error');
    }
    // --------------------------------------------------------

    if (isPass) {
      const fd = new FormData(document.forms[0]);

      fetch(`add-upload-api.php`, {
          method: 'POST',
          body: fd
        }).then(r => r.json())
        .then(obj => {
          console.log(obj);
          if (!obj.success && obj.error) {
            alert(obj.error)
          }
          if (obj.success) {
            myModal.show(); // 呈現 modal
          }

        }).catch(console.warn);
    }


  }


  // ---------------- 做上傳處理 ---------------------------
  
  const photo = document.upload_form.photo; // 取得上傳的欄位

  photo.onchange = (e) => {
    const fd = new FormData(document.upload_form);

    // 檢查傳送的 FormData 是否正確
    console.log("FormData entries:");
    for (let [key, value] of fd.entries()) {
        console.log(key, value);
    }


    fetch("./upload-photos.php", {
        method: "POST",
        body: fd,
      })
      .then((r) => r.json())
      .then((obj) => {
        console.log(obj);
            if (obj.success && obj.file > 0) {
                const myImg = document.querySelector("img.photo");
                document.forms[0].photo.value = obj.files[0];
                myImg.src = `./uploads/${obj.file[0]}`;
            } else {
                alert("圖片上傳失敗，請再試一次！");
            }
      })
      .catch(console.warn);
  };
  
</script>
<?php include __DIR__ . '/parts/html-tail.php' ?>