@extends('layouts.app')

@section('content')
    <div>
        <div class="card-header text-center"><h2>DANH MỤC</h2></div>

        <div class="m-3 d-flex justify-content-center align-items-center">
            <form method="POST" class="w-50">
                @csrf
                <div class="row mb-3">
                    <div class="col-sm">
                        <label>Tên danh mục</label>
                        <input class="form-control" id="name" name="name">
                    </div>

                    <div class="col-sm">
                        <label>Mô tả</label>
                        <input class="form-control" id="discription" name="discription">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm d-flex justify-content-end">
                        {{--                        <button type="submit" class="btn btn-primary">LƯU</button>--}}
                        <a onclick="category()" class="btn btn-primary">LƯU</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    function category()
    {
        axios.post('/api/category/create', {
            name: document.getElementById('name').value,
            discription: document.getElementById('discription').value,
        })
            .then(function (response) {
                console.log(response);

                window.location = "/category";
            })
            .catch(function (error) {
                console.log(error);
            });
    }
</script>

