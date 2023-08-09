@extends('layouts.app')

@section('content')
    <div class="row d-flex justify-content-center">

        <div class="col-sm-7 scroll-width-one">
            <div class="h-100">
                <h2 class="text-center text-info">Lịch sử upload nhiều ảnh hoặc video, file</h2>
                <table class="table align-middle table-hover table-position-sticky">
                    <thead class="hdm-table-header bg-info">
                    <tr>
                        <th class="">STT</th>
                        <th class="">Ngày tạo</th>
                        <th class="w-50">Link</th>
                        <th class="w-25">Video/File</th>
                    </tr>
                    </thead>
                    <tbody id="tbody_v2">
                    </tbody>
                </table>
                <ul class="pagination d-flex justify-content-end m-3" id="main_pagination_v2">
                    <li class="page-item" id="previous_click_v2">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    <span class="pagination" id="page_number_v2"></span>

                    <li class="page-item" id="next_click_v2">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="col-sm-5 scroll-width-one">
            <div class="h-100">
                <h2 class="text-center text-info">Lịch sử upload 1 hình ảnh</h2>
                <table class="table align-middle table-hover table-position-sticky">
                    <thead class="hdm-table-header bg-info">
                    <tr>
                        <th class="">STT</th>
                        <th class="">Ngày tạo</th>
                        <th class="w-50">Link</th>
                        <th class="w-25">Hình ảnh</th>
                    </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                </table>
                <ul class="pagination d-flex justify-content-end m-3" id="main_pagination">
                    <li class="page-item" id="previous_click">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    <span class="pagination" id="page_number"></span>

                    <li class="page-item" id="next_click">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
<script>
    function CreateRowItem(data, stt)
    {
        var tbody = document.getElementById("tbody");

        var itemTr = document.createElement("tr");

        var arrStt = document.createElement("td");
        arrStt.setAttribute("class", "text-center");
        arrStt.innerText = stt + 1;

        var date = document.createElement("td");
        date.setAttribute("class", "text-start");
        date.innerText = FormatDate(data.created_at);

        var td_link = document.createElement("td");
        var link = document.createElement("a");
        link.setAttribute("class", "text-center text-break");

        if (data.hasOwnProperty("link") && data.link != "")
        {
            link.innerText = "https://nghiacp.com/free_image/" + data.link;
            link.setAttribute("href", "https://nghiacp.com/free_image/" + data.link);
        }
        else
        {
            link.innerText = "https://nghiacp.com/free_image/" + data._id;
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

        itemTr.append(arrStt);
        itemTr.append(date);
        itemTr.append(td_link);
        itemTr.append(td_img);

        tbody.append(itemTr);
        return;
    }

    function CreateRowItem_V2(data, stt)
    {
        var tbody = document.getElementById("tbody_v2");

        var itemTr = document.createElement("tr");

        var arrStt = document.createElement("td");
        arrStt.setAttribute("class", "text-center");
        arrStt.innerText = stt + 1;

        var date = document.createElement("td");
        date.setAttribute("class", "text-start");
        date.innerText = FormatDate(data.created_at);

        var td_link = document.createElement("td");
        var li_link = document.createElement("a");

        var td_type = document.createElement("td");
        var type = document.createElement("div");
            td_type.append(type);

        if (data.hasOwnProperty("id_ggdrive") && data.id_ggdrive != "" && Array.isArray(data.id_ggdrive) == false)
        {
            li_link.innerText = "https://nghiacp.com/upload_file/" + data.id_ggdrive;
            li_link.setAttribute("href", "https://nghiacp.com/upload_file/" + data.id_ggdrive);

            type.innerText = "Video";
        }else
        {
            for (let i=0;i<data.name_file.length;i++)
            {
                var link = document.createElement("a");
                    link.setAttribute("href", "https://docs.google.com/uc?export=download&id=" + data.id_ggdrive.at(i));
                    link.innerHTML = data.name_file.at(i) + '</br></br>';
                    li_link.append(link);

                var down = document.createElement("a");
                    down.setAttribute("href", "https://docs.google.com/uc?export=download&id=" + data.id_ggdrive.at(i));
                    down.innerHTML = '<i class="fa-solid fa-circle-down"></i>' + '</br></br>';
                    type.append(down);
            }
        }
        td_link.append(li_link);

        itemTr.append(arrStt);
        itemTr.append(date);
        itemTr.append(td_link);
        itemTr.append(td_type);

        tbody.append(itemTr);
        return;
    }

    function LoadPaginate(data, item_paginate)
    {
        Paginator(data, GetApiHistoryUpload);
        HighlightPaginate(item_paginate);
    }

    function LoadPaginate_V2(data, item_paginate)
    {
        Paginator_V2(data, GetApiHistoryUpload_V2);
        HighlightPaginate_V2(item_paginate);
    }

    function GetApiHistoryUpload(item_paginate)
    {
        HisSpinner();

        if (paginate_now == null)
            paginate_now = item_paginate;

        if (item_paginate == null)
            item_paginate = 1; //nếu null load page 1

        axios.get('/api/user/image/',{ params: {
                page_number: item_paginate
            } })
            .then(function (response) {
                var payload = response.data.data;

                document.getElementById("tbody").innerText = "";
                document.getElementById("page_number").innerText = "";

                LoadPaginate(response.data,item_paginate);

                if (payload.length != 0)
                {
                    let stt = (item_paginate-1)*paginate_max;

                    for (let i = 0; i < payload.length; i++) {
                        CreateRowItem(payload[i], stt++ );
                    }
                }

                HisSpinner(false);
            })
            .catch(function (error) {
                console.log(error);
                HisSpinner(false);
            });
    }

    function GetApiHistoryUpload_V2(item_paginate)
    {
        HisSpinner();

        if (paginate_now == null)
            paginate_now = item_paginate;

        if (item_paginate == null)
            item_paginate = 1; //nếu null load page 1

        axios.get('/api/user/file/',{ params: {
                page_number: item_paginate
            } })
            .then(function (response) {
                var payload = response.data.data;
                console.log("aaaaa", payload);

                document.getElementById("tbody_v2").innerText = "";
                document.getElementById("page_number_v2").innerText = "";

                LoadPaginate_V2(response.data,item_paginate);

                if (payload.length != 0)
                {
                    let stt = (item_paginate-1)*paginate_max;

                    for (let i = 0; i < payload.length; i++) {
                        CreateRowItem_V2(payload[i], stt++ );
                    }
                }

                HisSpinner(false);
            })
            .catch(function (error) {
                console.log(error);
                HisSpinner(false);
            });
    }

    window.onload = function ()
    {
        GetApiHistoryUpload();
        GetApiHistoryUpload_V2();
    }
</script>
