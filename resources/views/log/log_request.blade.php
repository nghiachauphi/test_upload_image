@extends('layouts.app')

@section('content')
<div id="main">
    <div class="card-header text-center" hidden>
        <h2>LOG REQUEST</h2>
    </div>

{{--    <div class="w-100">--}}
{{--        <div class="row">--}}
{{--            <div class="col d-flex justify-content-end align-items-end">--}}
{{--                <a href="" class="btn btn-primary m-3">Xuất Excel</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <table class="table align-middle table-hover">
        <tr>
            <th class="">STT</th>
            <th class="w-25">Path</th>
            <th class="w-50">User Agent</th>
            <th class="">IP</th>
            <th class="">Date request</th>
            <th class="text-center">Xóa</th>
        </tr>
        <tbody id="tbody">
        </tbody>
    </table>

    <ul class="pagination d-flex justify-content-end m-3" id="main_pagination">
        <li class="page-item" id="previous_click">
            <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        <span class="pagination" id="page_number">

            </span>

        <li class="page-item" id="next_click">
            <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
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

        var itemDate = document.createElement("td");
        if (data.hasOwnProperty("created_at")) {
            itemDate.innerText = FormatDate(data.created_at);
        }

        var itemIp = document.createElement("td");
        if(data.hasOwnProperty("ip")) {
            itemIp.innerText = data.ip;
        }

        var itemUserAgent = document.createElement("td");
        if (data.hasOwnProperty("user_agent")) {
            itemUserAgent.innerText = data.user_agent;
        }

        var itemPath = document.createElement("td");
        var itemPathA = document.createElement("a");
            itemPathA.setAttribute("class", "text-break");
        if (data.hasOwnProperty("path")) {
            if (data.path == "/") {
                itemPathA.innerText = "home";
                itemPathA.setAttribute("href", "https://nghiacp.com/");
            }
            else{
                itemPathA.innerText = data.path;
                itemPathA.setAttribute("href", "https://nghiacp.com/" + data.path);
            }
        }
        itemPath.append(itemPathA);

        var itemDelete = document.createElement("td");
        itemDelete.setAttribute("class", "text-center");
        itemDelete.onclick = () => {
            AlertDelete_Category(data);
            code_delete = data._id;
        }

        var iDelete = document.createElement("i");
        iDelete.setAttribute('class',"fa-solid fa-circle-minus");
        itemDelete.append(iDelete);

        itemTr.append(arrStt);
        itemTr.append(itemPath);
        itemTr.append(itemUserAgent);
        itemTr.append(itemIp);
        itemTr.append(itemDate);
        itemTr.append(itemDelete);

        tbody.append(itemTr);
        return;
    }

    function LoadPaginate(data, item_paginate)
    {
        Paginator(data, APIGetCategory);
        HighlightPaginate(item_paginate);
    }

    function APIGetCategory(item_paginate)
    {
        HisSpinner();

        if (paginate_now == null)
            paginate_now = item_paginate;

        if (item_paginate == null)
            item_paginate = 1; //nếu null load page 1

        axios.get('/api/visitor/log/',{ params: {
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

    window.onload = function ()
    {
        // document.getElementById("main").append(GenerateAlertModal());
        // document.getElementById("main").append(GenerateConfirmModal(const_delete_category));

        HisSpinner(false);
        APIGetCategory();
    }
</script>
