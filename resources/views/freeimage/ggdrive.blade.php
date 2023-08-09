@extends('layouts.app')

@section('content')
<div id="main">
    <div class="card-header text-center">
        <h2>UPLOAD FREE VIDEO</h2>
    </div>

    <div class="row">
        <div class="col-sm-6 d-flex justify-content-center">
            <div class="card m-3 w-100">
                <div class="card-header text-center">
                    <h2 class="text-uppercase">Lưu ý Chỉ chấp nhận file <span class="text-danger">MP4</span></h2>
                    Nếu video định dạng .wmv vui lòng chuyển đổi .mp4 <a href="https://convertio.co/vn/wmv-mp4/" target="_blank">tại đây!</a>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="row mb-3">
                            <input type="file" class="form-control mb-3" id="file_upload" name="file_upload" accept="video/mp4,video/x-m4v,video/*">
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-9">
                                <a id="show_link" target="_blank"></a>
                            </div>
                            <div class="col-sm-3 d-flex justify-content-end">
                                <a class="btn btn-primary text-center" id="copy_link" onclick="copyToClipboard('#show_link', 'copy_link')">Copy Link</a>
                            </div>
                        </div>

                        <div class="row mb-3 p-0 m-0">
                            <div role="alert" id="label_update"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm d-flex justify-content-center">
{{--            <img src="https://drive.google.com/uc?id=1Tb9fAQgBAZkC-FI3mvxROBYfmhDRiSgA" class="m-3" id="show_image" width="95%">--}}

            <video class="m-3" width="90%" controls id="show_video">
            </video>
        </div>
    </div>
</div>

@endsection
<script>
    function PostFreeImage(img_paste)
    {
        HisSpinner();

        var changecolor = document.getElementById("copy_link");
        changecolor.setAttribute("class", "btn btn-primary");
        BindInnerTextValue("copy_link","Copy link");

        var formData = new FormData();
        var imagefile = document.querySelector('#file_upload');
        formData.append("file_upload", imagefile.files[0]);
        formData.append("file_upload", img_paste);

        axios.post('/api/upload_file',
            formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function (response) {
                // console.log("aaaaaa",response.data.data);
                link_img = response.data.data;

                var show_link = document.getElementById("show_link");
                show_link.setAttribute("href", "https://nghiacp.com/upload_file/" + response.data.data);
                BindInnerTextValue("show_link", "https://nghiacp.com/upload_file/" + response.data.data);

                CreateElementVideo(response.data.data, "show_video");

                show_result("label_update", response.data.message, "col-12 h-100 alert alert-success text-center");
                HisSpinner(false);
            })
            .catch(function (error) {
                console.log(error);
                show_result("label_update", error.response.message, "col-12 h-100 alert alert-danger text-center");
                HisSpinner(false);
            });
    }

    function RegisterEvents()
    {
        HisSpinner(false);

        $('#file_upload').on('change', function(event)
        {
            var check_mp4 = CheckMP4("file_upload", "label_update");
            if (check_mp4 == false)
            {
                return;
            }

            PostFreeImage();
        });
    }

    window.onload = function()
    {
        RegisterEvents();
    };
</script>
