@extends('layouts.app')

@section('content')
    <div style="height: 85%">
        <!-- Modal Image -->
        <div id="modal_image" class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen" >
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                        <a class="btn" type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-circle-xmark fa-2xl"></i></a>
                    </div>
                    <div class="modal-body all-center" style="background-color: #0b222c;">
                        <img class="img-fluid rounded shadow-lg" id="show_modal_image" src="" style="max-height: 85%">
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="show_image">

        </div>

        <div class="row p-0 m-0">
            <h1 role="alert" id="label_update"></h1>
        </div>
    </div>

@endsection
<script>
    var data_image_multipart = new Array();

    function CreateRowItem(data)
    {
        var div_row = document.getElementById('show_image');

        var div_col = document.createElement('div');
            div_col.setAttribute("class", "col-sm-6 all-center");

        var img = document.createElement('img');
            img.setAttribute("class", "img-fluid border border-dark rounded shadow-lg");
            img.setAttribute("src", "https://drive.google.com/uc?export=view&id=" + data);
            img.style.maxHeight = "85%";
            img.style.cursor = "all-scroll";
            img.onclick = function ()
            {
                document.getElementById('show_modal_image').src = "https://drive.google.com/uc?export=view&id=" + data;
                $('#modal_image').modal('show');
            }

        div_col.append(img);
        div_row.append(div_col);

        return div_row;
    }

    function GetFreeImageMultipart()
    {
        HisSpinner();

        axios.get('/api{{str_replace('free_image_multipart', 'upload_file_multipart', $data)}}')
            .then(function (response) {
                // handle success
                console.log(response.data.message[0].id_ggdrive);
                data_image_multipart = response.data.message[0].id_ggdrive;

                for (let i = 0; i < data_image_multipart.length; i++) {
                    CreateRowItem(data_image_multipart[i]);
                }

                HisSpinner(false);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
                HiddenElement("show_image");
                show_result("label_update", "Hình Ảnh Đã Bị Xóa - The video has been deleted", "col-12 h-100 alert alert-danger text-center text-uppercase");

                HisSpinner(false);
            })
            .then(function () {
                // always executed
                HisSpinner(false);
            });
    }

    function RegisterEvents()
    {

    }

    window.onload = function()
    {
        GetFreeImageMultipart();
        RegisterEvents();

        var bg_color = document.querySelector('main');
        bg_color.style.backgroundColor = "#0b222c";
    };
</script>
