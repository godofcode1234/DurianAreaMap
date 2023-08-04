@extends('layouts.link')
@section('body')
    <!-- Styles -->
<link rel="stylesheet" href="{{asset('css/map.css')}}">
    </head>

    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <div class="right-info">
                            <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}"
                                    onclick="event.preventDefault();
                                document.getElementById('info').submit();">
                                    {{ __('Thông Tin Cá Nhân') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('home') }}"
                                    onclick="event.preventDefault();
                                document.getElementById('home').submit();">
                                    {{ __('Quản lý sạt lở') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                                    {{ __('Đăng Xuất') }}
                                </a>
                                <form id="info" action="{{ route('profile') }}" method="GET" style="display: none;">
                                    @csrf
                                </form>
                                <form id="home" action="{{ route('home') }}" method="GET" style="display: none;">
                                    @csrf
                                </form>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}">Đăng Nhập</a>

                    @endauth
                </div>
            @endif
        </div>

        <div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:block;width:30%" id="mySidebar">
            <h3>DANH SÁCH CÁC ĐIỂM SẠT LỞ</h3>
            <div class="search">
                <input class="form-control form-control-sidebar" id="input" onkeyup="showTable()" type="search"
                    placeholder="Search" aria-label="Search">
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
                    <tbody>
                        @foreach ($diadanh as $key => $ddanh)
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

                <button id="closeNav" class="w3-button w3-teal w3-xlarge" onclick="w3_close()"><i
                        class="fa-solid fa-chevron-left"></i></button>
                <button id="openNav" class="w3-button w3-teal w3-xlarge" onclick="w3_open()" style="display: none;"><i
                        class="fa-solid fa-chevron-right"></i></button>

                <div class="leaflet-right-top">

                    <div class="logo">
                        <img id="logo" style="width: 80px; height: 80px; top:9.23%"
                            src="{{ asset('img/istockphoto-1251643808-1024x1024.jpg') }}" alt="">
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
                                    <input type="checkbox" value=""> Cảnh báo
                                </label>
                            </div>

                            <div>
                                <label for="">
                                    <input type="checkbox" value=""> Sạt lở
                                </label>
                            </div>

                            <div>
                                <label for="">
                                    <input id="huyen" type="checkbox" value=""> Huyện
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
    </body>
<script src="{{ asset('js/welcome.js')}}"></script>
<script>
    @foreach ($diadanh as $polyline)

        var coordinates = {{ $polyline->shape }};

        $popupContent = '<div class="tab">'+
    
    ' <button class="tablinks" onclick="openCity(event, \'ttc\')">Thông tin chung</button>'+
  
    '  <button class="tablinks" onclick="openCity(event, \'ha\')">Hình ảnh</button>'+
  
    '  <button class="tablinks" onclick="openCity(event, \'video\')">Video</button>'+
   
    '</div>'+
   '<div id="ttc" class="tabcontent">'+
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
                   '<td> gerjgb </td>'+
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
                   '<td> gerjgb </td>'+
               '</tr>'+
               '<tr>'+
                   '<th> Mô tả </th>'+
                   '<td> {{ $polyline->mota }} </td>'+
               '</tr>'+
       '</tbody>'+
   '</table>'+
'</div>'
'</div>';
        L.polyline(coordinates, {
            color: 'red'
        }).addTo(map).bindPopup($popupContent);
    @endforeach
</script>
@endsection
