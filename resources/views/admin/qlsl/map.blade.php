@extends('layouts.link')
@section('title')
    Quản lý sạt lở
@endsection
@section('active4')
    active
@endsection
@section('body')    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/map.css') }}">
    <body>

        <div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:block;width:30%" id="mySidebar">
            <h3>DANH SÁCH CÁC ĐIỂM SẠT LỞ</h3>
            <div class="search">
                <input class="form-control form-control-sidebar" id="input" onkeyup="showTable()" type="search"
                    placeholder="Tìm kiếm" aria-label="Search">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>

            <form>
                <table id="list" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Địa danh</th>
                            <th>Dài</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody id="list-view">
                        @foreach ($poly as $key => $ddanh)
                            <tr id="list-non">
                                <td>{{ $key + 1 }}</td>
                                <td><a data-name="danh" data-type="text">{{ $ddanh->diemcanhbao }}</a></td>
                                <td><a data-name="dai" data-type="text">{{ $ddanh->dodai }}</a></td>
                                <td><a data-name="ghichu" data-type="text">{{ $ddanh->ghichu }}</a></td>
                                <td style="display: none"><a data-name="shape" data-type="text">{{ $ddanh->shape }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>

        <div id="main" style="margin-left:30%;">
            <div class="w3-container">


                <button id="back" class="w3-button w3-teal w3-xlarge"><i class="fa-solid fa-house fa-2xs"></i></button>
                <button id="closeNav" class="w3-button w3-teal w3-xlarge" onclick="w3_close()"><i
                        class="fa-solid fa-chevron-left"></i></button>
                <button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()" style="display: none;"><i
                        class="fa-solid fa-chevron-right"></i></button>

                <div class="leaflet-right-top">

                    <div class="logo">
                        <img id="logo" style="width: 80px; height: 80px;"
                            src="{{ asset('img/Logo_tỉnh_Tiền_Giang.png') }}" alt="">
                    </div>

                    <div class="show-checkbox">
                        <form action="" class="check-box-map">
                            <div>
                                <label for="">
                                    <input id="dienbien" type="checkbox" value=""> Diễn biến đường bờ biển
                                </label>
                            </div>

                            <div>
                                <label for="">
                                    <input id="polyline" type="checkbox" value=""> Sạt lở
                                </label>
                            </div>
                            <div>
                                <label for="">
                                    <input id="huyen" type="checkbox" value="" > Huyện
                                </label>
                            </div>
                            <div>
                                <label for="">
                                    <input id="xa" type="checkbox" value=""> Xã
                                </label>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="change-map">
                    <select name="basemaps" id="basemaps" onchange="changeBasemap(basemaps)">
                        <option value="Defaul">Bản đồ gốc</option>
                        <option value="Streets">Bản đồ đường</option>
                    </select>
                </div>

                <div id="year" class="info-year">
                    <img src="{{ asset('img/Shorelinechanges0_190304.png') }}" alt=""><span>1903-04</span>
                    <img src="{{ asset('img/Shorelinechanges0_L701419651989.png') }}" alt=""><span>1965-1989</span>
                    <img src="{{ asset('img/Shorelinechanges0_1988.png') }}" alt=""><span>1988</span>
                    <img src="{{ asset('img/Shorelinechanges0_1990.png') }}" alt=""><span>1990</span>
                    <img src="{{ asset('img/Shorelinechanges0_1999.png') }}" alt=""><span>1999</span>
                    <img src="{{ asset('img/Shorelinechanges0_2013.png') }}" alt=""><span>2013</span>
                    <img src="{{ asset('img/Shorelinechanges0_201415.png') }}" alt=""><span>2014-15</span>
                    <img src="{{ asset('img/Shorelinechanges0_2016.png') }}" alt=""><span>2016</span>
                </div>
                <div id="map">

                </div>
            </div>
        </div>
    </body>
    <script src="{{ asset('js/map.js') }}"></script>
    <script>
        var polylines = [];
        @foreach ($poly as $polyline)

            @php
                $hinhanh = DB::select("SELECT * FROM hinhanh WHERE madiadiem =".$polyline->madiadiem);
                $video = DB::select("SELECT * FROM video WHERE madiadiem =".$polyline->madiadiem);
                $hasImage = false;
                $hasVideo = false;

            @endphp
            @foreach($hinhanh as $hinh)
                @if($hinh->hinhanh)
                    @php
                    $hasImage = true; 
                    @endphp
                @endif
            @endforeach

            @foreach($video as $media)
            @if($media->video)
                @php
                $hasVideo = true; 
                @endphp
            @endif
            @endforeach

            var coordinates = {{ $polyline->shape }};

            $popupContent = '<div class="tab">'+
        
        ' <button class="tablinks active"  onclick="openCity(event, \'ttc\')">Thông tin chung</button>'+

            '@if($hasImage)'+
        '  <button class="tablinks" onclick="openCity(event, \'ha\')">Hình ảnh</button>'+
           '@endif'+
           

           '@if($hasVideo) '+
        ' <button class="tablinks" onclick="openCity(event, \'video\')">Video</button>'+
            '@endif'+

        ' <a href="{{url('/admin/qlsl/')}}/{{$polyline->madiadiem}}/editlocation"><button class="tablinks" ">Chỉnh Sửa</button></a>'+
        '</div>'+
       '<div id="ttc" style="display: block" class="tabcontent">'+
       '<table>'+
       '<tbody>'+
       
               '<tr>'+
                   '<th> Điểm cảnh báo </th>'+
                   '<td> {{ $polyline->diemcanhbao }} </td>'+
               '</tr>'+
               '<tr>'+
                   '<th> Ghi chú </th>'+
                   '<td> {{ $polyline->ghichu }} </td>'+
               '</tr>'+
               '<tr>'+
                   '<th> Mô tả </th>'+
                   '<td> {{ $polyline->mota }} </td>'+
               '</tr>'+
           
       '</tbody>'+
   '</table>'+'</div>'+
   '<div id="ha" class="tabcontent">'+
       '<table>'+
           '<tbody>'+
               
                   '<tr>'+
                       '<th> Địa điểm </th>'+
                       '<td> {{ $polyline->diemcanhbao }} </td>'+
                   '</tr>'+
                   '<tr>'+
                       '<th> Hình ảnh </th>'+
                       '<td>'+
                        '<div id="carousel-" class="carousel slide" data-ride="carousel">'+ 
            '<div class="carousel-inner">'+     
                '@foreach ($hinhanh as $item )'+ 
                '<div class="carousel-item {{ $loop->first ? "active" : "" }}">'+ 
                        '<img src="{{ url('storage/hinhqlsl/'.$item->hinhanh) }}" style="width: 294px;height: 150px">'+ 
                    '</div>'+ 
                '@endforeach'+ 
            '</div>'+ 
            '<a class="carousel-control-prev" href="#carousel-" role="button" data-slide="prev">'+ 
                '<span class="carousel-control-prev-icon" aria-hidden="true"></span>'+ 
                '<span class="sr-only">Previous</span>'+ 
            '</a>'+ 
            '<a class="carousel-control-next" href="#carousel-" role="button" data-slide="next">'+ 
                '<span class="carousel-control-next-icon" aria-hidden="true"></span>'+ 
                '<span class="sr-only">Next</span>'+ 
            '</a>'+ 
        '</div>'+ 
                        '</td>'+
                   '</tr>'+
                   '<tr>'+
                       '<th> Mô tả </th>'+
                       '<td> {{ $polyline->mota }} </td>'+
                   '</tr>'+
              
           '</tbody>'+
       '</table>'+
   '</div>'+
   '<div id="video" class="tabcontent">'+
       '<table>'+
           '<tbody>'+
              
                   '<tr>'+
                       '<th> Địa điểm </th>'+
                       '<td> {{ $polyline->diemcanhbao }} </td>'+
                   '</tr>'+
                   '<tr>'+
                       '<th> Video </th>'+
                       '@foreach($video as $item)'+
                       '<td> <iframe width="294px" height="auto" src="{{ $item->video}}" ></iframe> </td>'+
                       '@endforeach'+
                   '</tr>'+
                   '<tr>'+
                       '<th> Mô tả </th>'+
                       '<td> {{ $polyline->mota }} </td>'+
                   '</tr>'+
           '</tbody>'+
       '</table>'+
   '</div>'
'</div>';
            
            var _polyline = L.polyline(coordinates, {
                color: 'red'
            }).addTo(map).bindPopup($popupContent);

            polylines.push(_polyline);
           
        @endforeach

    </script>
@endsection
