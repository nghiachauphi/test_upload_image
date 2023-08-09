@extends('layouts.app')

@section('content')
    <div id="main">
        <div class="card-header text-center" hidden>
            <h2>UPLOAD FREE IMAGE MULTIPART</h2>
        </div>

        <div class="row">
            <div class="col-sm-4 d-flex justify-content-center">
                <div class="card m-3 w-100">
                    <div class="card-header text-center">
                        <a class="btn btn-primary" id="add_image">Thêm Hình Ảnh <i class="fa-solid fa-circle-plus"></i></a>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" autocomplete="off" id="form_image_mutil">
                            @csrf
                            <div id="div_image">

                            </div>

                            <div class="row mb-3">
                                <div class="col-9">

                                </div>
                                <div class="col-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-9">
                                    <a id="show_link" target="_blank"></a>
                                </div>
                                <div class="col-sm-3 d-flex justify-content-end">
                                    <button class="btn btn-primary text-center" id="copy_link" onclick="copyToClipboard('#show_link', 'copy_link')">Copy Link</button>
                                </div>
                            </div>

                            <div class="row mb-3 p-0 m-0">
                                <div role="alert" id="label_update"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm d-flex justify-content-center" >
                <div class="row" id="see_image" style="height: 50%">
                </div>
            </div>
        </div>
    </div>

@endsection
<script>
    var count_div = null;
    var new_arr = new Array();
    var number_arr = new Array();
    var formData = null;

    function CreateDiv(stt)
    {
        var div_parent = document.getElementById("div_image");

        var div_row = document.createElement("div");
        div_row.setAttribute("class", "row mb-3");

        var div_col_1 = document.createElement("div");
        div_col_1.setAttribute("class", "col-sm");

        var h3 = document.createElement("h3");
        h3.innerText = "Hình" + stt;

        var file_up = document.createElement("input");
        file_up.setAttribute("type","file");
        file_up.setAttribute("class","form-control mb-3");
        file_up.setAttribute("id","image_" + stt);
        file_up.setAttribute("name","image_" + stt);
        file_up.onchange = function (){
            PreviewImage("image_" + stt, "show_pasted_" + stt);
            DisabledElement("pasted_" + stt, true);
            HiddenElement("pasted_" + stt, true);
        }

        var paste = document.createElement("textarea");
        paste.setAttribute("class", "form-control");
        paste.setAttribute("id", "pasted_" + count_div);
        paste.setAttribute("placeholder", "Dán hình tại đây (Ctrl + V)");

        div_parent.append(div_row);
        div_row.append(div_col_1);
        div_col_1.append(h3);
        div_col_1.append(file_up);
        div_col_1.append(paste);

        return div_parent;
    }

    function CreateSeeImage(stt)
    {
        if(count_div == 1)
        {
            document.getElementById("see_image").innerHTML = "";
            BindInnerTextValue("show_link", "");
            hide_result("label_update");
        }

        var see_image = document.getElementById('see_image');

        var div_col = document.createElement('div');
        div_col.setAttribute('class', 'col-sm-6');

        var img = document.createElement('img');
        img.setAttribute('class', 'm-3');
        img.setAttribute('width', '90%');
        img.setAttribute('height', '80%');
        img.setAttribute('id', "show_pasted_" + stt);

        div_col.append(img);
        see_image.append(div_col);

        return see_image;
    }

    function PasteImage(number)
    {
        HisSpinner();
        document.getElementById('pasted_' + number).onpaste = function (event)
        {
            DisabledElement("image_" + number, true);
            HiddenElement("image_" + number, true);

            var items = (event.clipboardData  || event.originalEvent.clipboardData).items;
            var blob = null;
            for (var i = 0; i < items.length; i++) {
                if (items[i].type.indexOf("image") === 0) {
                    blob = items[i].getAsFile();
                }
            }

            // load image if there is a pasted image
            if (blob !== null) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    // console.log(event.target.result); // data url!
                    document.getElementById("show_pasted_"+number).src = event.target.result;

                };
                reader.readAsDataURL(blob);

                new_arr.push(blob);
                number_arr.push(number);

                // console.log("bbbb",blob);
            }
        }

        HisSpinner(false);
    }

    function PostFreeImageMultipart()
    {
        var form = document.getElementById("form_image_mutil");
            form.addEventListener("submit", (e) => {
            e.preventDefault();

            HisSpinner();

            formData = new FormData(form);

            for(let i=0; i<new_arr.length; i++)
            {
                formData.append("image_" + number_arr[i], new_arr[i]);
            }

            for (const value of formData.values()) {
                console.log(value); //debug
            }

            axios.post('/api/free_image_multipart',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function (response) {
                    // console.log(response);

                    new_arr = [];
                    count_div = null;
                    document.getElementById("div_image").innerHTML = "";

                    var show_link = document.getElementById("show_link");
                    show_link.setAttribute("href", "https://nghiacp.com/free_image_multipart/" + response.data.link._id);

                    BindInnerTextValue("show_link", "https://nghiacp.com/free_image_multipart/" + response.data.link._id);
                    show_result("label_update", response.data.message, "col-12 h-100 alert alert-success text-center");

                    HisSpinner(false);
                })
                .catch(function (error) {
                    console.log(error.request);
                    HisSpinner(false);
                });
        });
    }

    function RegisterEvents()
    {
        $('#add_image').click( () => {
            count_div+=1;
            CreateDiv(count_div);
            CreateSeeImage(count_div);
            PasteImage(count_div);
        });
    }

    window.onload = function()
    {
        PostFreeImageMultipart();
        RegisterEvents();
        HisSpinner(false);
    };
</script>
