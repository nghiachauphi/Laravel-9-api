@extends('layouts.app')

@section('content')
    <div id="main">
        <div class="card-header text-center">
            <h2>DANH MỤC</h2>
        </div>

        <div class="w-100">
            <div class="row">
                <div class="col d-flex justify-content-end align-items-end">
                    <a class="btn btn-primary m-3" id="btn_import_excel">Nhập Excel</a>
                    <a href="{{route('category.export')}}" class="btn btn-primary m-3">Xuất Excel</a>
                    <a class="btn btn-primary m-3" id="btn_add">Thêm</a>
                </div>
            </div>

            <div class="row d-flex justify-content-center align-items-center">
                <form id="form_category" method="POST" class="w-75 border rounded" hidden>
                    @csrf
                    <div class="row mt-3">
                        <div class="col d-flex align-items-end justify-content-end">
                            <i id="btn_close" class="fa-solid fa-circle-xmark fa-2x"></i>
                        </div>
                        <div><hr></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm">
                            <label>Tên danh mục</label>
                            <input class="form-control" id="name" name="name">
                        </div>

                        <div class="col-sm">
                            <label>Mô tả</label>
                            <input class="form-control" id="discription" name="discription">
                        </div>

                        <div class="col-sm-2">
                            <label for="btn_submit">&emsp;</label>
                            <input id="btn_submit_create" onclick="APICreateCategory()" class="form-control btn btn-primary" value="Lưu">
                            <input id="btn_submit_update" onclick="APIUpdateCategory()" class="form-control btn btn-primary" value="Cập nhật">
                        </div>
                    </div>

                    <div class="row mb-3 p-0 m-0">
                        <div role="alert" id="label_update"></div>
                    </div>

                </form>
            </div>
        </div>

        <table class="table align-middle table-hover">
            <tr>
                <th class="text-center">STT</th>
                {{--                <th>ID danh mục</th>--}}
                <th class="w-25">Tên danh mục</th>
                <th class="w-25">Người tạo/Người sửa</th>
                <th class="w-25">Mô tả</th>
                <th class="text-center">Sửa</th>
                <th class="text-center">Xóa</th>
            </tr>
            <tbody id="tbody">
            </tbody>
        </table>

        <ul class="pagination d-flex justify-content-end m-3" id="main_pagination">
            <li class="page-item" id="previous_click">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <span class="pagination" id="page_number">

            </span>

            <li class="page-item" id="next_click">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="modal fade modal scroll-width-one" id="import_excel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel">Nhập Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('category.import')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm">
                                <label for="recipient-name" class="label">Chọn tập tin excel</label>
                                <input type="file" class="form-control" id="file_import" name="file_import">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm d-flex justify-content-end align-content-end">
                                <a type="button" class="btn btn-secondary w-25 me-3" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Hùy bỏ</a>
                                <button type="submit" class="btn btn-primary w-25">Nhập</button>
{{--                                <a type="button" class="btn btn-primary w-25" onclick="APIImportExcel()">Nhập</a>--}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    var const_delete_category = "delete_category";
    var code_delete = null;

    function CreateRowItem(data, stt)
    {
        var tbody = document.getElementById("tbody");

        var itemTr = document.createElement("tr");

        var arrStt = document.createElement("td");
        arrStt.setAttribute("class", "text-center");
        arrStt.innerText = stt + 1;

        // var itemId = document.createElement("td");
        // if (data.hasOwnProperty("_id")) {
        //     itemId.innerText = data._id;
        // }

        var itemName = document.createElement("td");
        if (data.hasOwnProperty("name")) {
            itemName.innerText = data.name;
        }

        var itemAuthor = document.createElement("td");
        if(data.hasOwnProperty("author_update")) {
            itemAuthor.innerText = data.author_update;
        }else if (data.hasOwnProperty("author")) {
            itemAuthor.innerText = data.author;
        }

        var itemDisc = document.createElement("td");
        if (data.hasOwnProperty("discription")) {
            itemDisc.innerText = data.discription;
        }

        var itemEdit = document.createElement("td");
        itemEdit.setAttribute("class", "text-center");
        itemEdit.onclick = () => {
            ClearForm();
            BindTextValue("name", data, "name");
            BindTextValue("discription", data, "discription");
            HiddenElement("btn_submit_create", true);
            HiddenElement("btn_submit_update", false);
            HiddenElement("form_category", false);
            code_delete = data._id;
        }

        var iEdit = document.createElement("i");
        iEdit.setAttribute('class',"fa-solid fa-pen-to-square");
        itemEdit.append(iEdit);

        var itemDelete = document.createElement("td");
        itemDelete.setAttribute("class", "text-center");
        itemDelete.onclick = () => {
            AlertDelete_Category(data);
            code_delete = data._id;
        }

        var iDelete = document.createElement("i");
        iDelete.setAttribute('class',"fa-solid fa-circle-minus");
        itemDelete.append(iDelete);

        itemTr.append(arrStt);
        // itemTr.append(itemId);
        itemTr.append(itemName);
        itemTr.append(itemAuthor);
        itemTr.append(itemDisc);
        itemTr.append(itemEdit);
        itemTr.append(itemDelete);

        tbody.append(itemTr);
        return;
    }

    function AlertDelete_Category(data)
    {
        if (data.hasOwnProperty("name"))
        {
            HisShowConfirm(const_delete_category, "Xóa danh mục", "Xác nhận xóa danh mục: " + '<br/>' +'<strong>' + data.name +'</strong>');
        }
    }

    function ConfirmYesDelete_Handler(code_delete)
    {
        axios.post('/api/category/delete',{
            _id: code_delete
        })
            .then(function (response) {
                var payload = response.data.message;

                APIGetCategory(paginate_now);
                HisShowConfirmSucessResult(const_delete_category, payload);

            })
            .catch(function (error) {
                console.log(error);
                HisShowConfirmErrorResult(const_delete_category, payload);
            });
    }

    function RegisterEvents()
    {
        $("#btn_import_excel").click( () => {
            $("#import_excel").modal('show');
        })

        $('#btn_close').click( () => {
            ClearForm();
            HiddenElement("form_category", true);
        });

        $('#btn_add').click( () => {
            ClearForm();
            HiddenElement("form_category", false);
            HiddenElement("btn_submit_update", true);
            HiddenElement("btn_submit_create", false);
        });

        HisRegistHandlerConfirmYes(const_delete_category, function() {
            ConfirmYesDelete_Handler(code_delete);
        });

        HisRegistHandlerConfirmNo(const_delete_category, function() {
            HisClearAndHideConfirm(const_delete_category);
        });
    }

    function ClearForm()
    {
        ClearValidateForm("form_category");
        hide_result("label_update");

        BindTextValue("name", "");
        BindTextValue("discription", "");
    }

    function LoadPaginate(data, item_paginate)
    {
        Paginator(data, APIGetCategory);
        HighlightPaginate(item_paginate);
    }

    function APIGetCategory(item_paginate)
    {
        HisSpinner();

        if (paginate_now == null)
            paginate_now = item_paginate;

        if (item_paginate == null)
            item_paginate = 1; //nếu null load page 1

        axios.get('/api/category/',{ params: {
                page_number: item_paginate
            } })
            .then(function (response) {
                var payload = response.data.data;

                document.getElementById("tbody").innerText = "";
                document.getElementById("page_number").innerText = "";

                LoadPaginate(response.data,item_paginate);

                if (payload.length != 0)
                {
                    let stt = (item_paginate-1)*paginate_max;

                    for (let i = 0; i < payload.length; i++) {
                        CreateRowItem(payload[i], stt++ );
                    }
                }

                HisSpinner(false);
            })
            .catch(function (error) {
                console.log(error);
                HisSpinner(false);
            });
    }

    function APICreateCategory()
    {
        axios.post('/api/category/create', {
            name: document.getElementById('name').value,
            discription: document.getElementById('discription').value,
        })
            .then(function (response) {
                APIGetCategory(paginate_now);
                show_result("label_update", response.data.message, "col-12 h-100 alert alert-success text-center");
            })
            .catch(function (error) {
                let stringdata = error.response.data.message;
                let message = stringdata[Object.keys(stringdata)[0]][0];
                show_result("label_update", message, "col-12 h-100 alert alert-danger text-center");
            });
    }

    function APIUpdateCategory()
    {
        axios.post('/api/category/update', {
            _id: code_delete,
            name: document.getElementById('name').value,
            discription: document.getElementById('discription').value,
        })
            .then(function (response) {
                console.log(response);
                APIGetCategory(paginate_now);
                show_result("label_update", response.data.message, "col-12 h-100 alert alert-success text-center");
            })
            .catch(function (error) {
                console.log(error);
                let stringdata = error.response.data.message;
                let message = stringdata[Object.keys(stringdata)[0]][0];
                show_result("label_update", message, "col-12 h-100 alert alert-danger text-center");
            });
    }

    function APICreateCategory()
    {
        var formData = new FormData();
        var file = document.querySelector('#file_import');
        formData.append("file_import", file.files[0]);

        axios.post('/api/category/import', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
            .then(function (response) {
                APIGetCategory(paginate_now);
                show_result("label_update_import", response.data.message, "col-12 h-100 alert alert-success text-center");
            })
            .catch(function (error) {
                let stringdata = error.response.data.message;
                let message = stringdata[Object.keys(stringdata)[0]][0];
                show_result("label_update_import", message, "col-12 h-100 alert alert-danger text-center");
            });
    }

    window.onload = function(){
        document.getElementById("main").append(GenerateAlertModal());
        document.getElementById("main").append(GenerateConfirmModal(const_delete_category));

        RegisterEvents();
        APIGetCategory();
    };
</script>
