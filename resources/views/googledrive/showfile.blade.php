@extends('layouts.app')

@section('content')
    <div>
        <div class="row d-flex justify-content-center" style="height: 80%">
            <div class="col-sm-10 scroll-width-one">
                <div class="h-100">
                    <table class="table align-middle table-hover table-position-sticky ">
                        <thead class="hdm-table-header bg-info">
                        <tr>
                            <th class="w-50">Tên file</th>
                            <th class="text-center w-25">Tải xuống</th>
                            <th class="text-center">Xem</th>
                        </tr>
                        </thead>

                        <tbody class="" id="col_one">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <h1 role="alert" id="label_update"></h1>
        </div>
    </div>
@endsection
<script>

    function CreateRowItem(data,name_file)
    {
        var tbody = document.getElementById("col_one");

        var itemTr = document.createElement("tr");

        var td_name = document.createElement("td");
        var name = document.createElement("a");
        name.setAttribute("href",  "https://docs.google.com/uc?export=download&id="+data);
        name.innerText = name_file;
        name.style.fontSize = "24px";
        td_name.append(name);

        var td_img = document.createElement("td");
        var img = document.createElement("a");
        img.innerHTML = '<i class="fa-solid fa-circle-down"></i>';
        img.setAttribute("href", "https://docs.google.com/uc?export=download&id="+data);
        img.setAttribute("class", "d-flex justify-content-center");
        td_img.append(img);

        var td_show = document.createElement("td");
        var a_show = document.createElement("iframe");
            a_show.setAttribute("src", "https://drive.google.com/file/d/" + data +"/preview");
        td_show.append(a_show);

        itemTr.append(td_name);
        itemTr.append(td_img);
        itemTr.append(td_show);

        tbody.append(itemTr);
        return;
    }

    function GetFileGGDrive()
    {
        HisSpinner();

        axios.get('/api{{$data}}')
            .then(function (response) {
                // handle success
                // console.log(response.data.message[0]);

                var link = response.data.message[0].id_ggdrive;
                var name = response.data.message[0].name_file;
                var length_pay = response.data.message[0].id_ggdrive.length;

                for (let i = 0; i < length_pay; i++) {
                    CreateRowItem(link[i],name[i]);
                }

                HisSpinner(false);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
                HisSpinner(false);

                show_result("label_update", "File Đã Bị Xóa - The file has been deleted", "col-12 h-100 alert alert-danger text-center text-uppercase");
            })
            .then(function () {
                // always executed
                HisSpinner(false);
            });
    }

    window.onload = function()
    {
        GetFileGGDrive();
    };
</script>
