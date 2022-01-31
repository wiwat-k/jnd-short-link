@extends('layouts')
@section('content')

<div class="card mt-4">
    <div class="card-header">
        <div class="input-group mb-3">
            <input type="text" name="link" id="link" class="form-control" placeholder="URL"
                aria-describedby="basic-addon2">
            <button class="btn btn-success" type="button" id="btn-submit">สร้าง Short Link</button>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-hove dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Short Link</th>
                            <th>Link</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $('body').on('click', '#btn-submit', function () {
        if ($('#link').val().length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'โปรดระบุ URL',
                confirmButtonText: 'ตกลง'
            }).then(function () {

            });
            return
        }
        $.ajax({
            type: "POST",
            url: `{{ URL::to('/generate-shorten-link') }}`,
            data: {
                link: $('#link').val(),
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
                    }).then(function () {});
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
                table.ajax.reload()
            }
        });
    })
    // Datatable
    var shortLink = `{{ url('/') }}`;
    var table;
    $(document).ready(function () {

        function datatableOption() {
            var option = {
                "processing": false,
                "serverSide": true,
                "ajax": {
                    "data": function (d) {},
                    "url": "{{ URL::to('/short-link/datatable') }}",
                    "type": "GET"
                },
                "select": {
                    "style": 'os',
                    "selector": 'td:first-child'
                },
                "order": [
                    [0, "asc"],
                ],
                "columns": [{
                        "data": "id",
                        "name": "a.id",
                        "orderable": true,
                        "searching": false,
                        "className": "text-left",
                        "render": function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "data": "code",
                        "name": "a.code",
                        "className": "text-left text-nowrap",
                        "render": function (data, type, row, meta) {
                            return `${shortLink}/${data}`;
                        }
                    },
                    {
                        "data": "link",
                        "name": "a.link",
                        "className": "text-left text-nowrap",
                        "render": function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "data": "name",
                        "name": "b.name",
                        "className": "text-left text-nowrap",
                        "render": function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        'searchable': false,
                        'orderable': false,
                        'width': '120px',
                        "className": "text-left text-nowrap",
                        "data": "id",
                        "name": "id",
                        'render': function (data) {
                            var html = ``;
                            html +=
                                `<button data-id="${data}" class="btn btn-danger font-weight-bold btn-sm btnDelete">ลบ</button>`;
                            return html;
                        }
                    }
                ],
                "responsive": true,
                "destroy": true,
                "stateSave": true,
                "searching": true,
                "pageLength": 100,
            };
            return option;
        };

        table = $("table.dataTable").DataTable(datatableOption());

    });

    $('body').on('click', '.btnDelete', async function () {
        var id = $(this).data('id')
        let text = 'ยืนยันลบรายการ';
        var r = confirm(text);
        if (r == true) {
            await $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id
                },
                url: `{{ URL::to('/') }}/short-link/delete`,
                success: (response) => {
                    if (response.status === 'success') {
                        table.ajax.reload()
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ',
                            text: response.message,
                            confirmButtonText: 'ตกลง'
                        }).then(function () {});
                    } else if (response.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: response.message,
                            confirmButtonText: 'ตกลง'
                        }).then(function () {

                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'โปรดติดต่อผู้ดูแลระบบ',
                            confirmButtonText: 'ตกลง'
                        }).then(function () {

                        });
                    }
                }
            });
        }
    });

</script>
@endsection
