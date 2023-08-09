@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="max-height: 85%;height: 85%;">
        <img class="img-fluid border border-dark rounded shadow-lg" id="show_image" style="max-height: 100%">

        <div class="row p-0 m-0">
            <h1 role="alert" id="label_update"></h1>
        </div>
    </div>
@endsection
<script>

    function GetFreeImage()
    {
        HisSpinner();

        axios.get('/api{{$data}}')
            .then(function (response) {
                // handle success
                console.log(response.data);
                document.getElementById("show_image").src = response.data.message[0].image_base64;
                HisSpinner(false);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
                HisSpinner(false);
                HiddenElement("show_image");
                show_result("label_update", "Hình Ảnh Đã Bị Xóa - The photo has been deleted", "col-12 h-100 alert alert-danger text-center text-uppercase");
            })
            .then(function () {
                // always executed
            });
    }

    window.onload = function()
    {
        HisSpinner(false);
        GetFreeImage();

        var bg_color = document.querySelector('main');
        bg_color.style.backgroundColor = "#0b222c";
    };
</script>
