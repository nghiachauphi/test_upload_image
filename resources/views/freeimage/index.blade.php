@extends('layouts.app')

@section('content')
    <div id="main">
        <div class="card-header text-center">
            <h2>UPLOAD FREE IMAGE</h2>
        </div>

        <div class="row">
            <div class="col-sm-4 d-flex justify-content-center">
                <div class="card m-3 w-100">
                    <div class="card-header">Chọn hình ảnh hoặc dán hình ảnh vào bên dưới</div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <div class="row mb-3">
                                <input type="file" class="form-control mb-3" id="image_base64" name="image_base64">
                                <textarea class="form-control" id="pasteArea" placeholder="Paste Image Here (Ctrl + V)"></textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <a id="show_link" target="_blank"></a>
                                </div>
                                <div class="col-sm-2 d-flex justify-content-end">
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
                <img class="m-3" id="show_image" width="95%">
            </div>
        </div>
    </div>

@endsection

<script>
    var link_img = null

    function copyToClipboard(element, id_copy)
    {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();

        var changecolor = document.getElementById(id_copy);
        changecolor.setAttribute("class", "btn btn-dark");
        BindInnerTextValue(id_copy,"Đã copy");
    }

    function PasteImage()
    {
        HisSpinner();

        document.getElementById('pasteArea').onpaste = function (event) {
            // use event.originalEvent.clipboard for newer chrome versions
            var items = (event.clipboardData  || event.originalEvent.clipboardData).items;
            console.log(JSON.stringify(items)); // will give you the mime types
            // find pasted image among pasted items
            var blob = null;
            for (var i = 0; i < items.length; i++) {
                if (items[i].type.indexOf("image") === 0) {
                    blob = items[i].getAsFile();
                }
            }

            // load image if there is a pasted image
            if (blob !== null) {
                // var reader = new FileReader();
                // reader.onload = function(event) {
                //     // console.log(event.target.result); // data url!
                //     document.getElementById("pastedImage").src = event.target.result;
                // };
                // reader.readAsDataURL(blob);

                // console.log(blob);
                PostFreeImage(blob);
            }
        }

        HisSpinner(false);
    }

    function PostFreeImage(img_paste)
    {
        HisSpinner();

        var changecolor = document.getElementById("copy_link");
        changecolor.setAttribute("class", "btn btn-primary");
        BindInnerTextValue("copy_link","Copy link");

        var formData = new FormData();
        var imagefile = document.querySelector('#image_base64');
        formData.append("image_base64", imagefile.files[0]);
        formData.append("image_base64", img_paste);

        axios.post('/api/free_image',
            formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function (response) {
                console.log(response);

                var show_link = document.getElementById("show_link");
                link_img = response.data.data;
                show_link.setAttribute("href", "https://nghiacp.com/free_image/" + link_img);
                BindInnerTextValue("show_link", "https://nghiacp.com/free_image/" + response.data.data);
                show_result("label_update", response.data.message, "col-12 h-100 alert alert-success text-center");
                HisSpinner(false);
                GetFreeImage();
            })
            .catch(function (error) {
                console.log(error);
                show_result("label_update", error.response.message, "col-12 h-100 alert alert-danger text-center");
            });
    }

    function GetFreeImage()
    {
        HisSpinner();

        axios.get('/api/free_image/' + link_img)
            .then(function (response) {
                // handle success
                // console.log("aaaaaa",response.data);
                document.getElementById("show_image").src = response.data.message[0].image_base64;
                HisSpinner(false);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
    }

    function RegisterEvents()
    {
        $('#image_base64').on('change', function(event)
        {
            PostFreeImage();
        });
    }

    window.onload = function()
    {
        PasteImage();
        RegisterEvents();
    };
</script>
