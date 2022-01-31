<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        @import url("https://fonts.googleapis.com/css?family=Raleway:400,700");

        *,
        *:before,
        *:after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Raleway", sans-serif;
        }

        .container-content {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .container-content.show .top:before,
        .container-content.show .top:after,
        .container-content.show .bottom:before,
        .container-content.show .bottom:after {
            margin-left: 200px;
            transform-origin: -200px 50%;
            transition-delay: 0s;
        }

        .container-content.show .center,
        .container-content.show .center {
            opacity: 1;
            transition-delay: 0.2s;
        }

        .top:before,
        .top:after,
        .bottom:before,
        .bottom:after {
            content: "";
            display: block;
            position: absolute;
            width: 200vmax;
            height: 200vmax;
            top: 50%;
            left: 50%;
            margin-top: -100vmax;
            transform-origin: 0 50%;
            transition: all 0.5s cubic-bezier(0.445, 0.05, 0, 1);
            z-index: 10;
            opacity: 0.65;
            transition-delay: 0s;
        }

        .top:before {
            transform: rotate(45deg);
            background: #e46569;
        }

        .top:after {
            transform: rotate(135deg);
            background: #ecaf81;
        }

        .bottom:before {
            transform: rotate(-45deg);
            background: #60b8d4;
        }

        .bottom:after {
            transform: rotate(-135deg);
            background: #3745b5;
        }

        .center {
            position: absolute;
            width: 400px;
            height: 400px;
            top: 50%;
            left: 50%;
            margin-left: -200px;
            margin-top: -200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px;
            opacity: 0;
            transition: all 0.5s cubic-bezier(0.445, 0.05, 0, 1);
            transition-delay: 0s;
            color: #333;
        }

        input {
            width: 100%;
            padding: 15px;
            margin: 5px 0px;
            border-radius: 1px;
            border: 1px solid #ccc;
            font-family: inherit;
        }

        input:focus {
            outline: none !important;
            border: 1px solid #3745b5;
        }

        .btn-login,
        .btn-register {
            width: 100%;
            padding: 15px;
            margin: 5px 0px;
            border-radius: 1px;
            border: 1px solid #3745b5;
            font-family: inherit;
            cursor: pointer;
            color: #3745b5;
            background-color: #fff;
            transition: 0.5s;
        }

        .btn-login:hover,
        .btn-register:hover {
            color: #fff;
            background-color: #3745b5;
        }

        .register {
            margin: 10px;
            text-decoration: none;
            color: #3745b5;
            font-family: inherit;
        }

        h2,
        .text-primary {
            color: #3745b5;
        }

        .spinner {
            height: 60px;
            width: 60px;
            margin: auto;
            display: flex;
            position: absolute;
            -webkit-animation: rotation .6s infinite linear;
            -moz-animation: rotation .6s infinite linear;
            -o-animation: rotation .6s infinite linear;
            animation: rotation .6s infinite linear;
            border-left: 6px solid rgba(0, 174, 239, .15);
            border-right: 6px solid rgba(0, 174, 239, .15);
            border-bottom: 6px solid rgba(0, 174, 239, .15);
            border-top: 6px solid rgba(0, 174, 239, .8);
            border-radius: 100%;
        }

        @-webkit-keyframes rotation {
            from {
                -webkit-transform: rotate(0deg);
            }

            to {
                -webkit-transform: rotate(359deg);
            }
        }

        @-moz-keyframes rotation {
            from {
                -moz-transform: rotate(0deg);
            }

            to {
                -moz-transform: rotate(359deg);
            }
        }

        @-o-keyframes rotation {
            from {
                -o-transform: rotate(0deg);
            }

            to {
                -o-transform: rotate(359deg);
            }
        }

        @keyframes rotation {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(359deg);
            }
        }

        #overlay {
            position: absolute;
            display: none;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 20;
            cursor: pointer;
        }

        .overlay-dev {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }


        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 10;
            /* Sit on top */
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
            justify-content: center;
            align-items: center;
            -webkit-animation: fadeIn 0.5s;
            animation: fadeIn 0.5s;
        }

        @-webkit-keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 30px;
            border: 1px solid #888;
            width: 360px;
            position: relative;
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 0px;
            right: 8px;
            color: #ccc;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

    </style>
</head>

<body>
    <div id="overlay">
        <div class="overlay-dev">
            <div class="spinner"></div>
        </div>
    </div>
    <div class="container-fluid container-content">
        <div class="top"></div>
        <div class="bottom"></div>
        <div class="center">
            <h2>เข้าสู่ระบบ</h2>
            <input type="text" id="email" placeholder="อีเมล" autocomplete="off" />
            <input type="password" id="password" placeholder="รหัสผ่าน" autocomplete="off" />
            <button type="button" class="btn-login">เข้าสู่ระบบ</button>
            <a href="#" class="register" id="register">สมัครสมาชิก</a>
            <h2>&nbsp;</h2>
        </div>
    </div>
    <!-- The Modal -->
    <div id="modal-register" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="text-primary">สมัครสมาชิก</div>
            <input type="text" id="registerEmail" placeholder="อีเมล" />
            <input type="password" id="registerPassword" placeholder="รหัสผ่าน" />
            <button type="button" class="btn-register">สมัคร</button>
        </div>

    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                error: function (response) {
                    if (response.status === 419 || response.status === 401) {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'เนื่องจากคุณไม่ได้ทำรายการเป็นเวลานานโปรดเข้าสู่ระบบใหม่',
                            confirmButtonText: 'ตกลง'
                        }).then(function () {
                            location.reload()
                        });
                    }
                    if (response.status === 400) {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'โปรดระบุข้อมูลให้ครบถ้วน',
                            confirmButtonText: 'ตกลง'
                        }).then(function () {

                        });
                    }

                },
                complete: function () {}
            });
            $('.container-content').addClass('show');
            // Get the modal
            var modal = document.getElementById("modal-register");

            // Get the button that opens the modal
            var btn = document.getElementById("register");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal 
            btn.onclick = function () {
                modal.style.display = "flex";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function () {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        });

        function loading() {
            document.getElementById("overlay").style.display = "flex";
        }

        function loaded() {
            document.getElementById("overlay").style.display = "none";
        }
        $('body').on('click', '.btn-login', function () {
            if ($('#email').val().length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'โปรดระบุอีเมล',
                    confirmButtonText: 'ตกลง'
                }).then(function () {

                });
                return
            }
            if ($('#password').val().length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'โปรดระบุรหัสผ่าน',
                    confirmButtonText: 'ตกลง'
                }).then(function () {

                });
                return
            }
            loading()
            $.ajax({
                type: "POST",
                url: `{{ URL::to('/auth/login') }}`,
                data: {
                    email: $('#email').val(),
                    password: $('#password').val(),
                },
                dataType: 'json',
                async: true,
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ',
                            text: response.message,
                            confirmButtonText: 'ตกลง'
                        }).then(function () {
                            window.location.replace(`{{ URL::to('/login')}}`);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: response.message,
                            confirmButtonText: 'ตกลง'
                        }).then(function () {

                        });
                    }
                },
                complete: function (data) {
                    loaded();
                }
            });
        })
        $('body').on('click', '.btn-register', function () {
            if ($('#registerEmail').val().length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'โปรดระบุอีเมล',
                    confirmButtonText: 'ตกลง'
                }).then(function () {

                });
                return
            }
            if (!validateEmail($('#registerEmail').val())) {
                Swal.fire({
                    icon: 'warning',
                    title: 'รูปแบบอีเมลไม่ถูกต้อง',
                    confirmButtonText: 'ตกลง'
                }).then(function () {

                });
                return
            }
            if ($('#registerPassword').val().length < 8) {
                Swal.fire({
                    icon: 'warning',
                    title: 'รหัสผ่านไม่ต่ำกว่า 8 ตัวอักษร',
                    confirmButtonText: 'ตกลง'
                }).then(function () {

                });
                return
            }
            loading()
            $.ajax({
                type: "POST",
                url: `{{ URL::to('/auth/register') }}`,
                data: {
                    email: $('#registerEmail').val(),
                    password: $('#registerPassword').val(),
                },
                dataType: 'json',
                async: true,
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ',
                            text: response.message,
                            confirmButtonText: 'ตกลง'
                        }).then(function () {
                            $('#modal-register').hide()
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: response.message,
                            confirmButtonText: 'ตกลง'
                        }).then(function () {

                        });
                    }
                },
                error: function (response) {
                    console.log(response);
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'โปรดติดต่อผู้ดูแลระบบ',
                        confirmButtonText: 'ตกลง'
                    }).then(function () {

                    });
                },
                complete: function (data) {
                    loaded();
                }
            });
        })

        function validateEmail(email) {
            var re = /\S+@\S+\.\S+/;
            return re.test(email);
        }

    </script>
</body>
