<script>
$(document).ready(function() {
    $(".delete-btn").click(function() {
        var idCart = $(this).data("id");
        $.ajax({
            type: 'POST',
            url: "/api/quanli.php?action=delete",
            data: {
                id: idCart
            },
            dataType: 'json',
            success: function(result) {
                if (result.status == 200) {
                    alert(result.msg);
                    location.reload();
                } else if (result.status == 404) {
                    alert(result.msg);
                } else if (result.status == 500) {
                    alert(result.msg);
                }
            }
        });
    });
});
</script>
<script>
$(document).ready(function() {
    $("#capnhatsanpham").click(function(event) {
        // Ngăn chặn hành động mặc định của biểu mẫu (tránh trang web tải lại)
        event.preventDefault();
        $('#page').load('../capnhatsanpham.php');
    });
})

$(document).ready(function() {
    $("#edit").click(function(event) {
        // Ngăn chặn hành động mặc định của biểu mẫu (tránh trang web tải lại)
        event.preventDefault();
        $('#page').load('editProduct.php');
    });
})
</script>
<script>
const showMenu = (toggleId, navbarId, bodyId) => {
    const toggle = document.getElementById(toggleId),
        navbar = document.getElementById(navbarId),
        bodypadding = document.getElementById(bodyId)

    if (toggle && navbar) {
        toggle.addEventListener('click', () => {
            navbar.classList.toggle('show')
            toggle.classList.toggle('rotate')
            bodypadding.classList.toggle('expander')
        })
    }
}
showMenu('nav_toggle', 'navbar', 'main')
</script>
<!-- link boostrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
</script>
<script>
new DataTable('#example');
</script>

</body>

</html>