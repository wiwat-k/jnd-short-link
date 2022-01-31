<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">

    <title>{{ config('app.name') }} | @yield('title', $page_title ?? 'JND')</title>

    <meta name="description" content="@yield('page_description', $page_description ?? '')" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

</head>

<body>

    <div class="container">
        @yield('content')
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (data.status === 'success') {

                } else
                if (data.status === 'msg') {
                    alert(data.msg);
                } else {
                    alert("เกิดข้อผิดพลาด, โปรดลองใหม่ในภายหลัง");
                }
            },
            error: function (response) {
                if (response.status === 419 || response.status === 401) {
                    alert(
                        "เกิดข้อผิดพลาด, เนื่องจากคุณไม่ได้ทำรายการเป็นเวลานานโปรดเข้าสู่ระบบใหม่");
                    location.reload()
                }
                if (response.status === 400) {
                    alert("เกิดข้อผิดพลาด, โปรดระบุข้อมูลให้ครบถ้วน");
                }
            },
            complete: function () {

            }
        });

    </script>

    @yield('script')
</body>

</html>
