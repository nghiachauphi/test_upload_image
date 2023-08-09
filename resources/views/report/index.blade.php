@extends('layouts.app')

@section('content')
    <h2 class="text-center">15 lịch sử gần nhất</h2>
    <div class="row d-flex justify-content-center" style="height: 80%">
        <div class="col-sm-5 scroll-width-one">
            <div class="h-100">
                <table class="table align-middle table-hover table-position-sticky ">
                    <thead class="hdm-table-header bg-primary">
                    <tr>
                        <th class="">Thời gian tạo</th>
                        <th class="w-50">Link</th>
                        <th class="w-25">Hình ảnh</th>
                    </tr>
                    </thead>

                    <tbody class="" id="col_one">
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-sm-5 scroll-width-one">
            <div class="h-100">
                <table class="table align-middle table-hover table-position-sticky ">
                    <thead class="hdm-table-header bg-primary">
                    <tr>
                        <th class="">Thời gian tạo</th>
                        <th class="w-50">Link</th>
                        <th class="w-25 text-center">Loại</th>
                    </tr>
                    </thead>
                    <tbody id="col_two">
                    </tbody>
                </table>
            </div>

        </div>

        <div class="col-sm-4 " style="display: none">
            <div class="m-3 h-100" >
                <table class="table align-middle table-hover">
                    <tr>
                        <th class="w-25">Thời gian tạo</th>
                        <th class="w-25">Link</th>
                        <th class="w-50">File</th>
                    </tr>
                    <tbody id="col_three">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
<script>
    function CreateRowItem_one(data)
    {
        var tbody = document.getElementById("col_one");

        var itemTr = document.createElement("tr");

        var date = document.createElement("td");
        date.setAttribute("class", "text-start");
        date.innerText = FormatDate(data.created_at);

        var td_link = document.createElement("td");
        var link = document.createElement("a");
        link.setAttribute("class", "text-center text-break");

        if (data.hasOwnProperty("link") && data.link != "")
        {
            link.innerText = ShortText(data.link);
            link.setAttribute("href", "https://nghiacp.com/free_image/" + data.link);
        }
        else
        {
            link.innerText = ShortText(data._id);
            link.setAttribute("href", "https://nghiacp.com/free_image/" + data._id);
        }

        td_link.append(link);

        var td_img = document.createElement("td");
        var img = document.createElement("img");
        img.setAttribute("class", "text-center");
        img.setAttribute("width", "32px");
        img.setAttribute("height", "32px");
        img.setAttribute("src", data.image_base64);
        td_img.append(img);

        itemTr.append(date);
        itemTr.append(td_link);
        itemTr.append(td_img);

        tbody.append(itemTr);
        return;
    }

    function CreateRowItem_two(data, stt)
    {
        var tbody = document.getElementById("col_two");

        var itemTr = document.createElement("tr");

        var date = document.createElement("td");
        date.setAttribute("class", "text-start");
        date.innerText = FormatDate(data.created_at);

        var td_link = document.createElement("td");
        var link = document.createElement("a");
        link.setAttribute("class", "text-center");

        var td_type = document.createElement("td");
        var type = document.createElement("div");
        type.setAttribute("class", "text-center");

        if (data.hasOwnProperty("id_ggdrive") && data.id_ggdrive != "" && Array.isArray(data.id_ggdrive) == false) //là video
        {
            link.innerText = ShortText(data.id_ggdrive);
            link.setAttribute("href", "https://nghiacp.com/upload_file/" + data.id_ggdrive);

            type.innerText = "Video";
        }else if(Array.isArray(data.id_ggdrive) == true)
        {
            if (data.hasOwnProperty("name_file")) //Là file
            {
                link.innerText = ShortText(data._id);
                link.setAttribute("href", "https://nghiacp.com/upload_file_multipart/" + data._id);

                type.innerText = "File";
            }else //Là nhiều hình
            {
                link.innerText = ShortText(data._id);
                link.setAttribute("href", "https://nghiacp.com/free_image_multipart/" + data._id);

                type.innerText = "Nhiều ảnh";
            }

        }else
        {
            link.innerText = "Đã bị xóa";
            link.style.color = "#0b222c";

            type.innerText = "...";
        }

        td_link.append(link);
        td_type.append(type);

        itemTr.append(date);
        itemTr.append(td_link);
        itemTr.append(td_type);

        tbody.append(itemTr);
        return;
    }

    function CreateRowItem_three(data, stt)
    {
        var tbody = document.getElementById("col_three");

        var itemTr = document.createElement("tr");

        var arrStt = document.createElement("td");
        arrStt.setAttribute("class", "text-center");
        arrStt.innerText = stt + 1;

        itemTr.append(itemDelete);

        tbody.append(itemTr);
        return;
    }

    function APIGetRePort()
    {
        HisSpinner();

        axios.get('/api/free_image/report')
            .then(function (response) {
                var payload = response.data.data;

                if (payload.length != 0)
                {
                    for (let i = 0; i < payload.length; i++) {
                        CreateRowItem_one(payload[i]);
                    }
                }

                HisSpinner(false);
            })
            .catch(function (error) {

                HisSpinner(false);
            });

        HisSpinner();

        axios.get('/api/upload_file/report')
            .then(function (response) {
                var payload = response.data.data;

                if (payload.length != 0)
                {
                    for (let i = 0; i < payload.length; i++) {
                        CreateRowItem_two(payload[i]);
                    }
                }

                HisSpinner(false);
            })
            .catch(function (error) {

                HisSpinner(false);
            });
    }

    window.onload = function ()
    {
        APIGetRePort();
    }
</script>
