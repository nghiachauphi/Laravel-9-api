@extends('layouts.app')

@section('content')
    <div>
        <div class="card-header text-center"><h2>Thông tin tài khoản</h2></div>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 mt-3">
                    @foreach($user as $value)
                        <form action="{{ url('user/'. $value->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                @if($value->avatar_upload == null)
                                    <img class="rounded-circle" src="{{Auth::user()->avatar}}"  max-width="520;" max-height="520;"/>
                                @else
                                    <img class="rounded-circle" src="{{asset('/upload/'.$value->avatar_upload)}}" width="320;" height="320;">

                                @endif
                                <input  type="hidden" id="old_image" name="old_image" value="{{$value->avatar}}" />
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-center card">
                                <input  type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar_upload" name="avatar_upload" required/>
                                @error('avatar')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                                <button type="submit" class="btn btn-primary"><i class="fal fa-save"></i> Thay đổi ảnh đại diện</button>
                            </div>
                        </form>
                </div>
                <div class="col-sm-1">
                </div>
                <div class="col-sm-7 mt-3">
                    <table class="table table-bordered table-hover">
                        <!-- xuất thông tin user -->
                        @foreach($user as $value)
                            <tr>
                                <td>Họ và tên</td>
                                <td>{{ $value->name }}</td>
                            </tr>

                            <tr>
                                <td>Tên tài khoản</td>
                                <td>{{ $value->username }}</td>
                            </tr>
                            <tr>
                                <td>Điện thoại</td>
                                <td>{{ $value->phone }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $value->email }}</td>
                            </tr>
{{--                            <tr>--}}
{{--                                <td class="text-center">--}}
{{--                                    <a class="btn btn-primary" name="SuaThongTin" href="{{ url('/nguoidung/sua/' . $value->id) }}">Sửa thông tin--}}
{{--                                        <i class="fal fa-edit"></i>--}}
{{--                                    </a>--}}
{{--                                </td>--}}
{{--                                <td class="text-center">--}}
{{--                                    <a class="btn btn-danger" name="XoaTaiKhoan" href="{{ url('/nguoidung/xoa/' . $value->id) }}">Xóa tài khoản--}}
{{--                                        <i class="fal fa-trash-alt text-warning"></i>--}}
{{--                                    </a>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
