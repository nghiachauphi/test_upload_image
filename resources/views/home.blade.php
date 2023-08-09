@extends('layouts.app')

@section('content')

{{--    <div class="container" hidden>--}}
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-8">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">{{ __('Dashboard') }}</div>--}}

{{--                    <div class="card-body">--}}
{{--                        @if (session('status'))--}}
{{--                            <div class="alert alert-success" role="alert">--}}
{{--                                {{ session('status') }}--}}
{{--                            </div>--}}
{{--                        @endif--}}

{{--                        {{ __('You are logged in!') }}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class=" col-12">--}}
{{--            <canvas id="chart_test"></canvas>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- Modal Contact-->
    <div class="modal fade" id="modal_contact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Liên Hệ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('contact')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm">
                                <label class="label">Họ và Tên</label>
                                <input class="form-control" id="name" name="name">
                            </div>
                            <div class="col-sm">
                                <label class="label">Email hoặc số điện thoại</label>
                                <input class="form-control" id="email_phone" name="email_phone">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm">
                                <label class="label">Tiêu đề</label>
                                <input class="form-control" id="title" name="title">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm">
                                <label class="label">Nội dung</label>
                                <textarea rows="2" type="text" class="form-control" id="content_info" name="content_info"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm">
                                <label class="label">Hình ảnh nếu có</label>
                                <input type="file" class="form-control" id="image_contact" name="image_contact">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm d-flex justify-content-end">

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container all-center w-75">
        <div class="row card">
            <div>
                <h1 class="text-center">FREE IMAGE</h1>
                <h2 class="text-center">ĐĂNG TẢI HÌNH ẢNH VIDEO FILE TRỰC TUYẾN</h2>
            </div>
            <div class="all-center card-header" style="display: none">
                <div class="h3 text-center" id="time"></div>
            </div>

{{--            <div class="card-body all-center" hidden>--}}
{{--                <span id="info_bank"></span>--}}
{{--                <img class="ms-1" id="qr_zalo" src="{{asset('image/qr_zalo.jpg')}}" height="20%" width="20%">--}}
{{--            </div>--}}

            <div class="card-body all-center bg-black">
                <img src="{{asset('image/tet3.webp')}}" height="15%" width="15%">
                <img src="{{asset('image/tetnguyendan.webp')}}" height="30%" width="30%">
                <img src="{{asset('image/tet3.webp')}}" height="15%" width="15%">
            </div>
        </div>

        <div class="row">
            @if(isset($data_contact))
                <div role="alert" id="label_update" class="col-12 h-100 alert alert-success text-center">{{$data_contact}}</div>
            @endif
        </div>

        <div class="row fixed-bottom p-5">
            <div class="col-sm-1"></div>

            <div class="col-sm-3">
{{--                <div class="row">--}}
                    {{--                <span>Trong ngày:<span class="text-end" id="total_request"></span></span>--}}
{{--                </div>--}}
                <div class="row">
                    <span>Trong ngày truy cập:<span class="text-end" id="total_date_now"></span></span>
                </div>
                <div class="row">
                    <span>Tổng lượt truy cập:<span class="text-end" id="total_all"></span></span>
                </div>
            </div>

            <div class="col-sm-1 his-border-left"></div>

            <div class="col-sm-3">
                <div class="row">
                    <a class="text-dark fw-bold" href="{{route('report')}}">Lịch sử upload</a>
                </div>
                <div class="row">
                    <span id="contact_link">Góp ý</span>
                </div>
            </div>

            <div class="col-sm-1 his-border-left"></div>

            <div class="col-sm-3">
                <div class="row">
                    <a class="text-dark" href="https://www.facebook.com/100018825939660/" target="_blank">Liên hệ: <img src="{{asset('/image/facebook.png')}}" width="16px" height="16px"></a>
                </div>
                <div class="row">
                    <a class="text-dark" href="https://zalo.me/0332691871" target="_blank">Liên hệ: <img src="{{asset('/image/zalo.png')}}" width="16px" height="16px"></a>
                </div>
            </div>
        </div>
    </div>

@endsection

<script>
    var chart_test = null;

    var countdownTimer = setInterval('StartCoutDown()', 1000);
    var upgradeTime = null;//864005
    var seconds = null;

    function APIGetFreeImage()
    {
        HisSpinner();

        axios.get('/api/countdown/')
            .then(function (response) {
                var payload = new Date(response.data.data[0].updated_at);

                var date_exper = new Date(payload.setDate(payload.getDate() + parseInt(response.data.data[0].discription)));

                var date_now = new Date();

                seconds = parseInt((date_exper.getTime()/1000)) - parseInt(date_now.getTime()/1000);

                HisSpinner(false);
            })
            .catch(function (error) {
                HisSpinner(false);
            });

        HisSpinner();

        axios.get('/api/visitor/report')
            .then(function (response) {
                var payload = response.data;

                BindInnerTextValue("total_date_now", " " + '<b>' + payload.date + '</b>');
                BindInnerTextValue("total_all", " " + '<b>' + payload.data + '</b>');
                // BindInnerTextValue("total_request", " " + '<b>' + payload.date + '</b>' + " " + " request");

                HisSpinner(false);
            })
            .catch(function (error) {

                HisSpinner(false);
            });

        HisSpinner();

    }

    function StartCoutDown() {
        var days        = Math.floor(seconds/24/60/60);
        var hoursLeft   = Math.floor((seconds) - (days*86400));
        var hours       = Math.floor(hoursLeft/3600);
        var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
        var minutes     = Math.floor(minutesLeft/60);
        var remainingSeconds = seconds % 60;
        function pad(n) {
            return (n < 10 ? "0" + n : n);
        }
        // "Phiên Bản " + '<span class="text-danger">' + "Demo" +'</span>'+
        // " Hết Hạn Sau " + '<span class="text-danger">' +
        document.getElementById('time').innerHTML =         '<h2 class="text-center">ĐĂNG TẢI HÌNH ẢNH VIDEO FILE TRỰC TUYẾN - POST FREE VIDEO FILE PHOTOS ONLINE</h2>' +'</br>'+
                                                            "Tết Nguyên Đán 2023 chỉ còn " + '<span class="text-danger">' +
                                                            pad(days) + " ngày " + '</span>' + pad(hours) + " giờ " + pad(minutes) + " phút " + pad(remainingSeconds) + " giây" + '</span>';

        // document.getElementById('info_bank').innerHTML =    "Liên hệ Facebook " +'<a href="https://www.facebook.com/100018825939660/" target="_blank">tại đây</a>' + '</br>' +
        //                                                     "Liên hệ Zalo "+'<a href="https://zalo.me/0332691871" target="_blank">tại đây </a>'+"hoặc quét mã QR sau " + '<i class="fa-solid fa-circle-right"></i>';
                                                            // "MBBANK - 199939397777" + '</br>' +
                                                            // "MOMO - 0332691871"+ '</br>' +
                                                            // "Nội dung: " + '<b>' + "freeimage donate" + '</b>';

        if (seconds == 0) {
            clearInterval(countdownTimer);
            document.getElementById('time').innerHTML = "Phiên Bản Hết Hạn Vui Lòng Nạp Vip Tiếp Tục Sử Dụng";
        } else {
            seconds--;
        }
    }

    function RegisterEvents()
    {
        $('#contact_link').click(() => {
            $("#modal_contact").modal('show');
        });
    }

    window.onload = function ()
    {
        APIGetFreeImage();
        RegisterEvents();
        // chart_test = new Chart(document.getElementById("chart_test"),config);
    }

    const config = {
        type: 'line',
        data: {
            labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6'],
            datasets: [
                {
                    label: 'Dataset',
                    data: [1,2,3,4,5,6],
                    borderColor: "#453453",
                    backgroundColor: "#122664",
                    pointStyle: 'circle',
                    pointRadius: 10,
                    pointHoverRadius: 15
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: (ctx) => 'Point Style: ' + ctx.chart.data.datasets[0].pointStyle,
                }
            }
        }
    };
</script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>--}}
