@extends('layouts.app')

@section('content')
    <div id="main">
        <div class="card-header text-center"><h2>DANH MỤC</h2></div>

        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal_show">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">THÔNG TIN LỖI</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center" id="">
                        <table class="table">
                            <tr>
                                <td>Người tạo</td>
                                <td id="label_acc_name"></td>
                            </tr>
                            <tr>
                                <td>Thời gian tạo</td>
                                <td id="label_date_time"></td>
                            </tr>
                            <tr>
                                <td>Nội dung</td>
                                <th id="label_content"></th>
                            </tr>
                            <tr>
                                <td>Mức độ</td>
                                <td id="label_rate"></td>
                            </tr>
                            <tr>
                                <td>Tình trạng xử lý</td>
                                <td id="label_state"></td>
                            </tr>
                            <tr>
                                <td>Người xử lý</td>
                                <td id="label_assigned"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <table class="table align-middle table-hover">
            <tr>
                <th class="text-center">STT</th>
                <th>ID danh mục</th>
                <th>Tên danh mục</th>
                <th class="">Người tạo</th>
                <th class="">Mô tả</th>
                <th class="text-center">Sửa</th>
                <th class="text-center">Xóa</th>
            </tr>
            <tbody id="tbody">
            </tbody>
        </table>
    </div>
@endsection

<script>
    var const_delete_category = "delete_category";
    var code_delete = null;

    function AlertDelete_Category(data)
    {
        if (data.hasOwnProperty("name"))
        {
            HdmShowConfirm(const_delete_category, "Xóa danh mục", "Xác nhận xóa danh mục: " + '<br/>' +'<strong>' + data.name +'</strong>');
        }
    }

    function CreateRowItem(data, stt) {
        var tbody = document.getElementById("tbody");

        var itemTr = document.createElement("tr");

        var arrStt = document.createElement("td");
        arrStt.setAttribute("class", "text-center");
        arrStt.innerText = stt + 1;

        var itemId = document.createElement("td");
        if (data.hasOwnProperty("_id")) {
            itemId.innerText = data._id;
        }

        var itemName = document.createElement("td");
        if (data.hasOwnProperty("name")) {
            itemName.innerText = data.name;
        }

        var itemAuthor = document.createElement("td");
        if (data.hasOwnProperty("author")) {
            itemAuthor.innerText = data.author;
        }

        var itemDisc = document.createElement("td");
        if (data.hasOwnProperty("discription")) {
            itemDisc.innerText = data.discription;
        }

        var itemEdit = document.createElement("td");
            itemEdit.setAttribute("class", "text-center");
        var iEdit = document.createElement("i");
            iEdit.setAttribute('class',"fa-solid fa-pen-to-square");
        itemEdit.append(iEdit);

        var itemDelete = document.createElement("td");
            itemDelete.setAttribute("class", "text-center");
            itemDelete.onclick = () => {
                AlertDelete_Category(data);
                console.log("aaa", data._id);
                code_delete = data._id;
            }

        var iDelete = document.createElement("i");
            iDelete.setAttribute('class',"fa-solid fa-circle-minus");
        itemDelete.append(iDelete);

        itemTr.append(arrStt);
        itemTr.append(itemId);
        itemTr.append(itemName);
        itemTr.append(itemAuthor);
        itemTr.append(itemDisc);
        itemTr.append(itemEdit);
        itemTr.append(itemDelete);

        tbody.append(itemTr);
        return;
    }

    function GetCategory()
    {
        document.getElementById("tbody").innerText = "";

        axios.get('/api/category/')
            .then(function (response) {
                var payload = response.data.data;
                console.log(payload);

                if (payload.length != 0) {
                    for (let i = 0; i < payload.length; i++) {
                        CreateRowItem(payload[i], i);
                    }
                }

            })
            .catch(function (error) {
                console.log(error);
            });
    }

    function ConfirmYesDelete_Handler(code_delete)
    {
        axios.post('/api/category/delete',{
            _id: code_delete
        })
            .then(function (response) {
                var payload = response.data.message;

                GetCategory();
                HdmShowConfirmSucessResult(const_delete_category, payload);

            })
            .catch(function (error) {
                console.log(error);
                HdmShowConfirmErrorResult(const_delete_category, payload);
            });
    }

    function RegisterEvents()
    {
        HdmRegistHandlerConfirmYes(const_delete_category, function() {
            ConfirmYesDelete_Handler(code_delete);
        });

        HdmRegistHandlerConfirmNo(const_delete_category, function() {
            HdmClearAndHideConfirm(const_delete_category);
        });

    }

    window.onload = function(){
        document.getElementById("main").append(GenerateAlertModal());
        document.getElementById("main").append(GenerateConfirmModal(const_delete_category));

        RegisterEvents();
        GetCategory();
    };
</script>

