@extends('layouts.app')

@section('content')
    <div>
        <div class="card-header text-center"><h2>Thông tin tài khoản</h2></div>

        <div class="row mt-3">
            <div class="col-4">
                <div class="d-flex justify-content-center align-items-center">
                    <img class="rounded w-75" id="bind_avatar" onclick="ChangeAvatar();">
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" class="form-control w-75" id="avatar_upload" name="avatar_upload">
                    </form>
                </div>
                <div class="row mb-3 p-0 m-0">
                    <div role="alert" id="label_update"></div>
                </div>
            </div>

            <div class="col-8">
                <table class="table table-bordered table-hover">
                    <tr>
                        <td>Họ và tên</td>
                        <td id="bind_name"></td>
                    </tr>
                    <tr>
                        <td>Điện thoại</td>
                        <td id="bind_phone"></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td id="bind_email"></td>
                    </tr>
                    <tr>
                        <td>Token</td>
                        <td id="bind_token"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
<script>
    function GetDataUser(){
        axios.get('/api/user')
            .then(function (response) {
                // handle success
                var payload = CheckArrayOrObjectBindData(response.data);
                console.log(payload);

                BindInnerTextValue("bind_name",payload ,"name");
                BindInnerTextValue("bind_token",payload ,"api_token");
                BindInnerTextValue("bind_phone",payload ,"phone");
                BindInnerTextValue("bind_email",payload ,"email");

                var src = document.getElementById("bind_avatar");
                src.setAttribute("src", payload.avatar_upload);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
    }

    function ChangeAvatar()
    {
        $('#avatar_upload').change( (event) => {

            var formData = new FormData();
            var imagefile = document.querySelector('#avatar_upload');
            formData.append("avatar_upload", imagefile.files[0]);

            axios.post('/api/user/image', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(function (response) {
                    console.log(response);
                    GetDataUser();
                    show_result("label_update", response.data.message, "col-12 h-100 alert alert-success text-center");
                })
                .catch(function (error) {
                    console.log(error);
                    show_result("label_update", error.response.message, "col-12 h-100 alert alert-danger text-center");
                });
        });
    }

    window.onload = function(){
        GetDataUser();
        ChangeAvatar()
    };
</script>
