@extends('layouts.app')

@section('content')
    <div id="main">
        <div class="row">
            <div class="col-sm-6 all-center">
                <div class="card m-3 w-100">
                    <div class="card-header text-center">
                        <a class="btn btn-primary" id="add_image">Thêm File <i class="fa-solid fa-circle-plus"></i></a>
                    </div>
                    <div class="card-body">
                        <form action="{{route('post_free_file')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <div id="div_image">

                            </div>

                            <div class="row mb-3">
                                <div class="col-9">

                                </div>
                                <div class="col-3 d-flex justify-content-end">
                                    <input type="submit" class="btn btn-primary" value="Lưu">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-9">
                                    @if(isset($link))
                                    <a id="show_link" href="http://nghiacp.com/upload_file_multipart/{{$link}}" target="_blank">
                                        http://nghiacp.com/upload_file_multipart/{{$link}}
                                    </a>
                                    @endif
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

            <div class="col-sm-5 d-flex justify-content-center">
                <div class="h-100 w-100 m-3">
                    <table class="table align-middle table-hover table-position-sticky">
                        <thead class="hdm-table-header bg-primary">
                        <tr>
                            <th class="w-75">Tên file</th>
                            <th class="">Download</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(isset($data))
                                @for($item=0; $item< count($data->id_ggdrive); $item++)
                                    <tr>
                                        <td><a href="https://docs.google.com/uc?export=download&id={{$data->id_ggdrive[$item]}}">{{$data->name_file[$item]}}</a></td>
                                        <td><a href="https://docs.google.com/uc?export=download&id={{$data->id_ggdrive[$item]}}"><i class="fa-solid fa-circle-down"></i></a> </td>
                                    </tr>
                                @endfor
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    var count_div = null;

    function CreateDivFile(stt)
    {
        var div_parent = document.getElementById("div_image");

        var div_row = document.createElement("div");
        div_row.setAttribute("class", "row mb-3");

        var div_col_1 = document.createElement("div");
        div_col_1.setAttribute("class", "col-sm");

        var h3 = document.createElement("h3");
        h3.innerText = "File " + stt;

        var file_up = document.createElement("input");
        file_up.setAttribute("type","file");
        file_up.setAttribute("class","form-control mb-3");
        file_up.setAttribute("id","file_" + stt);
        file_up.setAttribute("name","file_" + stt);

        div_parent.append(div_row);
        div_row.append(div_col_1);
        div_col_1.append(h3);
        div_col_1.append(file_up);

        return div_parent;
    }

    function PostFreeFileMultipart()
    {
        var changecolor = document.getElementById("copy_link");
        changecolor.setAttribute("class", "btn btn-primary");
        BindInnerTextValue("copy_link","Copy link");

        var form = document.querySelector("form");

        form.addEventListener("submit", (e) => {
            e.preventDefault();

            HisSpinner();

            var formData = new FormData(form);

            axios.post('/api/upload_file_multipart/',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function (response) {
                    console.log( response.data.link);

                    var show_link = document.getElementById("show_link");
                    show_link.setAttribute("href", "https://nghiacp.com/upload_file_multipart/" + response.data.link._id);

                    BindInnerTextValue("show_link", "https://nghiacp.com/upload_file_multipart/" + response.data.link._id);
                    show_result("label_update", response.data.message, "col-12 h-100 alert alert-success text-center");
                    HisSpinner(false);
                })
                .catch(function (error) {
                    // console.log(error);
                    show_result("label_update", error.response.message, "col-12 h-100 alert alert-danger text-center");
                    HisSpinner(false);
                });
        });
    }

    function RegisterEvents()
    {
        $('#add_image').click( () => {
            count_div+=1;
            CreateDivFile(count_div);
        });
    }

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

    window.onload = function()
    {
        // PostFreeFileMultipart();
        RegisterEvents();
        HisSpinner(false);


    };
</script>
