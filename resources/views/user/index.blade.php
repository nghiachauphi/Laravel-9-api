@extends('layouts.app')

@section('content')
    <div>
        <div class="card-header text-center"><h2>Thông tin tài khoản</h2></div>
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
@endsection
<script>
    function GetDataUser(){
        axios.get('http://103.162.31.19:1818/api/emr/user')
            .then(function (response) {
                // handle success
                axiosInstance.defaults.headers["Authorization"] = "Bearer " + "629b81504e7400009d000bc0|TodidCkL4vK2L1qD8OTT4WOOmo7FUtHGiMwYkojK";
                var payload = CheckArrayOrObjectBindData(response.data);
                console.log(payload);
                BindTextValue("bind_name",payload ,"name");
                BindTextValue("bind_token",payload ,"api_token");
                BindTextValue("bind_phone",payload ,"phone");
                BindTextValue("bind_email",payload ,"email");
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
    }

    // window.onload = function(){
    //     GetDataUser();
    // };
</script>
