@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="max-height: 85%;height: 85%">
{{--        <img class="img-fluid border border-dark rounded shadow-lg" id="show_image" style="max-height: 100%">--}}

        <video id="show_video" width="800" height="600" controls>
        </video>

        <div class="row p-0 m-0">
            <h1 role="alert" id="label_update"></h1>
        </div>
    </div>
@endsection
<script>

    function GetFreeVideo()
    {
        HisSpinner();

        axios.get('/api{{$data}}')
            .then(function (response) {
                // handle success
                // console.log("aaaaaaaaaaa",response.data.message[0].id_ggdrive);

                CreateElementVideo(response.data.message[0].id_ggdrive, "show_video");

                HisSpinner(false);
            })
            .catch(function (error) {
                // handle error

                HiddenElement("show_video");
                show_result("label_update", "Video Đã Bị Xóa - The video has been deleted", "col-12 h-100 alert alert-danger text-center text-uppercase");

                HisSpinner(false);
            })
            .then(function () {
                // always executed
                HisSpinner(false);
            });
    }

    window.onload = function()
    {
        GetFreeVideo();

        var bg_color = document.querySelector('main');
        bg_color.style.backgroundColor = "#0b222c";
    };
</script>
