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
                <div class="">{{ $user->deliveryAddress->name ?? 'Chưa đặt tên' }}</div>
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
        <div class="main-info mt-5">
            <h2>Change infomation</h2>
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


                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade border p-3 show active" id="home" role="tabpanel"
                        aria-labelledby="home-tab">
                        <div class="mb-3">

                            <label>Username</label></br>
                            <input type="text" name="fullname" id="fullname"
                                value="{{ $user->deliveryAddress->fullname ?? '' }}" class="form-control"></br>
                        </div>

                        <div class="mb-3">
                            <label>Phone</label></br>
                            <input type="text" name="phone" id="phone"
                                value="{{ $user->deliveryAddress->phone ?? '' }}" class="form-control"></br>
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
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>
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
                    result = <?php echo $address; ?>.find(item => item._name == response.data);
                    console.log(result.ward)
                    const select = document.getElementById('district');
                    for (let i = select.options.length - 1; i > 0; i--) {
                        select.remove(i);
                    }

                    const options = result.district.map((item) => {
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

        function changdistrict(click) {
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
                    const ward = result.ward.filter(item => item._district_id == response.name.id);
                    console.log([response.name, ward])
                    const select = document.getElementById('wards');
                    for (let i = select.options.length - 1; i > 0; i--) {
                        select.remove(i);
                    }
                    const options = ward.map((item) => {
                        const option = document.createElement("option");
                        option.value = item._prefix + ' ' + item._name;
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
    </script>
@endsection
