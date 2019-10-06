@extends('Shared._Layout')
@section('head')
    <title>{{__('resources.ListContactTitle')}}</title>    
@endsection
@section('content')
    <div class="page-header text-center"><h1>{{__('resources.ListContactTitle')}}</h1></div>
    <b>{{__('resources.searching')}} : </b>
    <select id="SearchBy">
        <option value="fullName">{{__('resources.name')}}</option>
        <option value="phoneNumber">{{__('resources.phoneNumber')}}</option>
        <option value="address">{{__('resources.address')}}</option>
    </select><br /><br />
    <input type="text" id="Search"><input type="submit" id="SearchBtn" value="{{__('resources.search')}}" /><br><br>
    @include('Shared._messages')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>{{__('resources.name')}}</th>
                <th>{{__('resources.phoneNumber')}}</th>
                <th>{{__('resources.address')}}</th>
                <th>{{__('resources.birth_year')}}</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="dataTable">
            @if (count($contact) > 0)
                @foreach ($contact as $item)
                    <tr>
                        <td>{{$item->fullName}}</td>
                        <td>{{$item->phoneNumber}}</td>
                        <td>{{$item->address}}</td>
                        <td>{{$item->birth_year}}</td>
                        <td>
                            <a href="/Contacts/{{$item->id}}/edit" class="btn btn-warning mr-1" style="float:left;">{{__('resources.editing')}}</a> 
                            <button type="button" class="btn btn-primary mr-1" data-toggle="modal" data-target="#myModal" id="{{$item->id}}" style="float:left;">{{__('resources.details')}}</button>
                            {{Form::open(['action' => ['ContactsController@destroy', $item->id], 'method' => 'DELETE', 'style' => 'float:left;']) }}
                                {{Form::submit(__('resources.delete'), ['class' => 'btn btn-danger'])}}
                            {{Form::close()}}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align:center;font-size:12px;font-weight:bold;">© 2019 {{__('resources.allright')}}</td>
            </tr>
        </tfoot>
    </table>
    {{ $contact->links() }}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">{{__('resources.detailsPerson')}}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('resources.close')}}</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#SearchBtn").click(function(){
            var SearchBy = $("#SearchBy").val();
            var SearchValue = $("#Search").val();
            var SetData = $("#dataTable");
            SetData.html("");
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "post",
                url: "/Contacts/GetSearchingData/{SearchBy}/{SearchValue}",
                data:{_token: "{{ csrf_token() }}", SearchValue: SearchValue, SearchBy: SearchBy},
                success: function (result) {
                    result = JSON.parse(result);
                    if (result.length == 0) {
                        SetData.append('<tr style="color:red"><td colspan="4">{{__('resources.noMatched')}}</td></tr>')
                    }
                    else {
                        $.each(result, function (index, value) {
                            var Data = "<tr>" +
                                "<td>" + value.fullName + "</td>" +
                                "<td>" + value.phoneNumber + "</td>" +
                                "<td>" + value.address + "</td>" +
                                "<td>" + value.birth_year + "</td>" +
                                "<td> <a href='/Contacts/"+value.id+"/edit' class='btn btn-warning mr-1' style='float:left;'>{{__('resources.editing')}}</a>" +
                                "<button type='button' class='btn btn-primary mr-1' data-toggle='modal' data-target='#myModal' id='"+value.id+"' style='float:left;'>{{__('resources.details')}}</button>"+
                                '{{Form::open(['action' => ['ContactsController@destroy', 'value.id'], 'method' => 'DELETE', 'style' => 'float:left;']) }}'+
                                '{{Form::submit(__('resources.delete'), ['class' => 'btn btn-danger'])}}'+
                                '{{Form::close()}}'+
                                "</td></tr>";
                            SetData.append(Data);
                        });
                    }
                },
                error: function (xhr) {
                    alert(xhr.status);
                }
            });
        });
        $(".btn-primary").click(function(){
            var uid = $(this).attr("id");
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:'POST',
                url:'/Contacts/getDetails/{id}',
                data:{_token: "{{ csrf_token() }}", id: uid},
                success:function(data) {
                    var qwe = JSON.parse(data);
                    $(".modal-body").empty();
                    var a = "<table><tr><td><b>{{__('resources.name')}}</b></td><td>&nbsp; : &nbsp; "+qwe.fullName+"</td></tr>";
                    var b = "<tr><td><b>{{__('resources.phoneNumber')}}</b></td><td>&nbsp; : &nbsp; "+qwe.phoneNumber+"</td></tr>";
                    var c = "<tr><td><b>{{__('resources.address')}}</b></td><td>&nbsp; : &nbsp; "+qwe.address+"</td></tr>";
                    var d = "<tr><td><b>{{__('resources.note')}}</b></td><td>&nbsp; : &nbsp; "+qwe.note+"</td></tr>";
                    var e = "<tr><td><b>{{__('resources.birth_year')}}</b></td><td>&nbsp; : &nbsp; "+qwe.birth_year+"</td></tr>";
                    var f = "<tr><td><b>{{__('resources.dateAdd')}}</b></td><td>&nbsp; : &nbsp; "+qwe.created_at+"</td></tr>";
                    var g = "<tr><td><b>{{__('resources.dateUpdate')}}</b></td><td>&nbsp; : &nbsp; "+qwe.updated_at+"</td></tr></table>";
                    $(".modal-body").append(a+b+c+d+e+f+g);
                },
                error: function (xhr) {
                    alert(xhr.status);
                }
            });
        });
        /*$("#Search").keyup(function(){ // Text'e metin girerken arama yapar
            var SearchBy = $("#SearchBy").val();
            var SearchValue = $("#Search").val();
            var SetData = $("#dataTable");
            SetData.html("");
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "post",
                url: "/Contacts/GetSearchingData/{SearchBy}/{SearchValue}",
                data:{_token: "{{ csrf_token() }}", SearchValue: SearchValue, SearchBy: SearchBy},
                success: function (result) {
                    result = JSON.parse(result);
                    if (result.length == 0) {
                        SetData.append('<tr style="color:red"><td colspan="4">Eşleşen kayıt bulunamadı.</td></tr>')
                    }
                    else {
                        $.each(result, function (index, value) {
                            var Data = "<tr>" +
                                "<td>" + value.fullName + "</td>" +
                                "<td>" + value.phoneNumber + "</td>" +
                                "<td>" + value.address + "</td>" +
                                "<td> <a href='/Contacts/"+value.id+"/edit' class='btn btn-warning mr-1' style='float:left;'>Düzenle</a>" +
                                "<button type='button' class='btn btn-primary mr-1' data-toggle='modal' data-target='#myModal' id='"+value.id+"' style='float:left;'>Detay Göster</button>"+
                                '{!!Form::open(['action' => ['ContactsController@destroy', 'value.id'], 'method' => 'DELETE', 'style' => 'float:left;']) !!}'+
                                '{{Form::submit('Sil', ['class' => 'btn btn-danger'])}}'+
                                '{!!Form::close()!!}'+
                                "</td></tr>";
                            SetData.append(Data);
                        });
                    }
                },
                error: function (xhr) {
                    alert(xhr.status);
                }
            });
        });*/
        
    </script>
@endsection
