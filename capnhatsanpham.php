<form">
    <div class="mb-3 mt-3">
        <label for="email" class="form-label">Nhập tên sản phẩm</label>
        <input type="text" class="form-control" id="name" placeholder="Enter email" name="email">
    </div>
    <div class="mb-3">
        <label for="pwd" class="form-label">Giá tiền</label>
        <input type="text" class="form-control" id="Price" placeholder="VNĐ" name="pswd">
    </div>
    <div class="mb-3">
        <label for="pwd" class="form-label">Nhập số lượng</label>
        <input type="text" class="form-control" id="StockQuantity" placeholder="Enter password" name="pswd">
    </div>


    <div class="input-group mb-3">
        <input type="file" class="form-control" id="inputGroupFile02">

        <label class="input-group-text" for="inputGroupFile02">Upload</label>
    </div>
    <div class="input-group mb-3">
        <div class="input-group mb-3">
            <textarea id="froala-editor"></textarea>
        </div>
        <script type="text/javascript" src="node_modules/froala-editor/js/froala_editor.pkgd.min.js"></script>
        <script>
        new FroalaEditor('textarea#froala-editor')
        </script>
    </div>
    <div class="mb-3">
        <select class="form-select" aria-label="Default select example" id="type">
            <option selected>Thể loại</option>
            <option value="1">Thú cưng</option>
            <option value="2">Phụ kiện</option>
            <option value="3">Thức ăn</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="pwd" class="form-label">Nhập tên danh mục</label>
        <input type="text" class="form-control" id="danhmuc" placeholder="Enter password">
    </div>
    <button id="submit" class="btn btn-primary">Submit</button>
    </form>
    <script>
    $(document).ready(function() {
        $("#submit").click(function(event) {
            event.preventDefault();
            var formData = new FormData();
            formData.append('ProductNme', $("#name").val());
            formData.append('Price', $("#Price").val());
            formData.append('StockQuantity', $("#StockQuantity").val());
            formData.append('IMG', $("#inputGroupFile02").prop('files')[
                0]); // Truyền toàn bộ đối tượng file vào
            formData.append('Describe', $("#froala-editor").val());
            formData.append('Type', $("#type").val());
            formData.append('danhmuc', $("#danhmuc").val());
            $.ajax({
                type: 'POST',
                url: "/api/quanli.php?action=createProduct",
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(result) {
                    if (result.status == 200) {
                        alert(result.msg);
                        location.reload();
                    } else if (result.status == 404) {
                        alert(result.msg);
                    } else if (result.status == 500) {
                        alert(result.msg);
                        $('input').val("");
                    }
                },
            });
        });
    });
    </script>