@extends('frontend.pages.profile.layout')
@section('profile')
    <div class="bg-white rounded p-4">
        <div class="main-wrapper">
            <div class="main-box">
                <div class="main-tittle">Tên đăng nhập</div>
                <div class="">{{ $user->name }}</div>
            </div>
            <div class="main-box">
                <div class="main-tittle">Email</div>
                <div class="">{{ $user->email }}</div>
            </div>
            <div class="main-box">
                <div class="main-tittle">Họ và tên</div>
                <div class=""></div>
            </div>
            <div class="main-box">
                <div class="main-tittle">Nhóm khách hàng</div>
                <div class="">
                    <div style="display:inline;"><img style="width: 21px;
                                height: 18px; "
                            loading="lazy" src="https://cdn.divineshop.vn/image/catalog/Banner/vip/silver.png"
                            alt="Vip Bạc" title="Vip Bạc">
                        <span>Vip Bạc</span>
                    </div>
                </div>
            </div>
            <div class="main-box">
                <div class="main-tittle">Đã tích lũy</div>
                <div class="">{{ $user->orders->sum('totalAmount') }}</div>
            </div>
            <div class="main-box">
                <div class="main-tittle">Ngày tham gia</div>
                <div class="">{{ $user->created_at }}</div>
            </div>
        </div>
        <div class="border my-5"></div>
        <div class="address">
            @if (session('deladd'))
                <h2 class="alert alert-success">{{ session('deladd') }}</h2>
            @endif
            @if ($useraddress->count('user_id') < 3)
                @foreach ($useraddress as $item)
                    <div class="card d-flex flex-row justify-content-between w-50 align-items-center p-3">
                        <div class="d-flex flex-column">
                            <small>Địa chỉ {{ $loop->iteration }}</small>
                            <small
                                style="width:200px;overflow: hidden;
                            white-space: nowrap; 
                            text-overflow: ellipsis;">{{ $item->address ?? '' }}</small>
                        </div>
                        <div class="d-flex flex-column">
                            <a class="btn btn-sm btn-primary fix" add_id="{{ $item->delivery_id }}">Sửa</a>
                            <a href="{{ route('user.deladd', $item->delivery_id) }}"
                                class="btn mt-1 btn-sm btn-danger">Xoá</a>
                        </div>
                    </div>
                @endforeach
                <a class="btn btn-sm btn-primary" id="add_info">Thêm địa chỉ mới</a>
            @else
                @foreach ($useraddress as $item)
                    <div class="card d-flex flex-row justify-content-between w-50 align-items-center p-3">
                        <div class="d-flex flex-column">
                            <small>Địa chỉ {{ $loop->iteration }}</small>
                            <small
                                style="width:200px;overflow: hidden;
                            white-space: nowrap; 
                            text-overflow: ellipsis;">{{ $item->address ?? '' }}</small>
                        </div>
                        <div class="d-flex flex-column">
                            <a class="btn btn-sm btn-primary fix" add_id="{{ $item->delivery_id }}">Sửa</a>
                            <a href="{{ route('user.deladd', $item->delivery_id) }}"
                                class="btn mt-1 btn-sm btn-danger">Xoá</a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="main-info mt-5" id="infomation" style="display:none">
            <h2 class="title">Change infomation</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('user.update', ['id' => Auth::id()]) }}" method="post">
                {!! csrf_field() !!}
                @method('POST')
                <input type="hidden" name="status" id='status' value="">
                <input type="hidden" name="_tokenadd" id='_tokenadd' value="">

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade border p-3 show active" id="home" role="tabpanel"
                        aria-labelledby="home-tab">
                        <div class="mb-3">

                            <label>Username</label></br>
                            <input type="text" name="fullname" id="fullname" value="" class="form-control"></br>
                        </div>
                        <div class="mb-3">
                            <label>email</label></br>
                            <input type="text" name="email" id="email" value="" class="form-control"></br>
                        </div>
                        <div class="mb-3">
                            <label>Phone</label></br>
                            <input type="text" name="phone" id="phone" value="" class="form-control"></br>
                        </div>
                        <div class="mb-3">
                            <label for="">Choose the city</label>
                            <select name="province" id="province" class="form-control  choose" onchange="changcity()">
                                <option value="">--Select city--</option>
                                @foreach ($address as $key => $item)
                                    <option value="{{ $item->_name }}">{{ $item->_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="">Choose Province</label>
                            <select name="district" id="district" class="form-control input-sm m-bot15 province choose"
                                onchange="changdistrict()">
                                <option value="">--Select district--</option>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Choose Wards</label>
                            <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                                <option value="">--Choose a commune--</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">chi tiet</label>
                            <input type="text" name="chitiet" id="chitiet" class="form-control">
                        </div>
                    </div>

                    <br>
                    <input type="submit" value="Update" class="btn btn-success"></br>
            </form>
        </div>

    </div>

    {{-- clear value and change to create form --}}
    <script>
        $('#add_info').click(function() {
            $('#infomation').css('display', 'block')
            $('#province option[value=""]').prop('selected', true);
            $('#district option[value=""]').prop('selected', true);
            $('#wards option[value=""]').prop('selected', true);
            $('input[name="fullname"]').val('');
            $('input[name="phone"]').val('');
            $('input[name="chitiet"]').val('');
            $('.title').html('Create infomation')
            $('#status').val('create')
        })
    </script>
    <script>
        $(document).ready(function() {
            $('.fix').click(function() {
                const add_id = $(this).attr('add_id')
                $.ajax({
                    url: '{{ route('user.changeAdd', Auth::id()) }}',
                    type: 'POST',
                    data: {
                        add_id: add_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('.title').html('change infomation')
                        $('#create').css('display', 'none')
                        $('#infomation').css('display', 'block')
                        $('#status').val('update')
                        $('#_tokenadd').val(res._token)
                        $('#province').val(res.province);
                        $('#fullname').val(res.fullname);
                        changcity()
                        setTimeout(() => {
                            $('#district').val(res.district);
                            changdistrict()
                        }, 1000);
                        $('#phone').val(res.phone);
                        setTimeout(() => {
                            $('#wards').val(res.ward);
                            console.log(res.ward)
                        }, 2000);

                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            })
        })
    </script>
    <script>
        let result;

        function changcity() {
            $.ajax({
                url: '{{ route('user.ajaxRequest', ['id' => Auth::id()]) }}',
                type: 'POST',
                data: {
                    city: document.getElementById("province").value,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    const selectDistrict = $('#district');
                    const select = document.getElementById('district');
                    for (let i = select.options.length - 1; i > 0; i--) {
                        select.remove(i);
                    }
                    const options = response.data.map((item) => {
                        const option = document.createElement("option");
                        option.value = item._name;
                        option.text = item._prefix + ' ' + item._name;
                        return option;
                    });
                    options.sort().forEach((option) => {
                        select.appendChild(option);
                    });

                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        function changdistrict() {
            const add_id = $('.fix').attr('add_id');
            $.ajax({
                url: '{{ route('user.ajaxRequest', ['id' => Auth::id()]) }}',
                type: 'POST',
                data: {
                    district: document.getElementById("district").value,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    const district = document.getElementById('district').value;
                    const ward = document.getElementById('wards').value;
                    $.ajax({
                        url: '{{ route('user.changeAdd', Auth::id()) }}',
                        type: 'POST',
                        data: {
                            add_id: add_id,
                            district: district,
                            ward: ward
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                    console.log(response.data);
                    const select = document.getElementById('wards');
                    for (let i = select.options.length - 1; i > 0; i--) {
                        select.remove(i);
                    }
                    const selectDistrict = $('#wards');
                    const districtOptions = response.data.map((district) => {
                        return $('<option>').val(district._name).text(
                            `${district._prefix} ${district._name}`);
                    });
                    console.log(response.data)
                    selectDistrict.append(districtOptions);
                    $('#wards').val(ward);
                    $('#district').val(district);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    </script>

@endsection
