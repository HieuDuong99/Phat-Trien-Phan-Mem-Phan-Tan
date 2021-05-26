<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="<?= STATIC_DIR ?>/css/bootstrap.min.css">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="<?= STATIC_DIR ?>/css/login.css">
    <script src="<?= STATIC_DIR ?>/js/jquery-3.4.0.min.js"></script>
</head>
<body>
    <div class="container">
            <div class="login-box bg-dark text-white p-4 rounded" style="width:340px">
                <form action="?cn=login" method="POST" >
                    <div class="box-header text-center form-group">
                            <h2>Đăng nhập</h2>
                    </div>
                    <div class="form-group">
                        <label for="username">Tên đăng nhập</label>
                        <input class="form-control" type="text" name="txtTenDangNhap" id="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input class="form-control" type="password" name="txtMatKhau" id="password">
                    </div>
                    <div class="form-group custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" name="ckRemember" id="remember">
                        <label class="custom-control-label" for="remember">Ghi nhớ đăng nhập</label>
                    </div>
                    <div class="form-group text-center">
                        <input class="btn btn-primary" type="button" id="btnSubmit" name="btnSubmit" value="Đăng nhập"/>
                    </div>
                </form>
            </div>
    </div>
    <script src="<?= STATIC_DIR ?>/js/bootstrap.min.js"></script>
    <script>
        $(function() {
            $('#btnSubmit').on('click', function() {
                let username = $('#username').val();
                let password = $('#password').val();
                let remember = $('#remember').prop("checked");

                if (username == "" || password == "") {
                    $('#username').addClass('is-invalid');
                    $('#password').addClass('is-invalid');
                    $(".login-box").append('<div class="alert alert-danger alert-dismissible fade show" role="alert">Tài khoản và mật khẩu không được để rỗng !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    return false;
                }

                $.ajax({
                    url: '?cn=login',
                    type: 'POST',
                    data: {username: username, password: password, remember: remember},
                    success: function(result) {
                        if (JSON.parse(result).status == 1) {
                            window.location.href = "";
                        } else {
                            $('#username').addClass('is-invalid');
                            $('#password').addClass('is-invalid');
                            if ($('.alert').length > 0) {
                                $('.alert').remove();
                                $(".login-box").append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+JSON.parse(result).message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $(".login-box").append('<div class="alert alert-danger alert-dismissible fade show" role="alert">'+JSON.parse(result).message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            }
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }      
                });
            });
        });
    </script>
</body>
</html>
