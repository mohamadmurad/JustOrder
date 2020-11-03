<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'JustOrder') }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.0/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ URL::asset('css/style.css?v=0.0000005') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-notifications.css?v=0.0000005') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/printStyle.css?v=0.0000004') }}" media="print">
    <link href="https://fonts.googleapis.com/css2?family=Amiri&display=swap" rel="stylesheet">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
            integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ"
            crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
            integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY"
            crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

</head>
<body dir="rtl" >
<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar" class="active">
        <div class="sidebar-header">
            <h3>Just Orders</h3>
            <strong>JO</strong>
        </div>

        <ul class="list-unstyled components">

            <li>
                <a href="{{ route('home') }}">
                    <i class="fas fa-home"></i>
                    الرئيسة
                </a>
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-copy"></i>
                    ادارة
                </a>
                <ul class="collapse list-unstyled" id="pageSubmenu">
                @auth
                    @if (Auth::user()->isAdmin !== 1)
                        <!-- The Current User Can Update The Post -->
                            <li>
                                <a href="{{ route('order.index') }}">الطلبات</a>
                            </li>

                            <li>
                                <a href="{{ route('fabric.index') }}">الأقمشة</a>
                            </li>

                        @else
                            <li>
                                <a href="{{ route('order.index') }}">الطلبات</a>
                            </li>
                            <li>
                                <a href="{{ route('years.index') }}">السنوات</a>
                            </li>


                            <li>
                                <a href="{{ route('type.index') }}">الاصناف</a>
                            </li>

                            <li>
                                <a href="{{ route('color.index') }}">الالوان</a>
                            </li>

                            <li>
                                <a href="{{ route('FabricSource.index') }}">مصادر القماش</a>
                            </li>

                            <li>
                                <a href="{{ route('fabric.index') }}">الأقمشة</a>
                            </li>

                            <li>
                                <a href="{{ route('supplier.index') }}">الموردون</a>
                            </li>

                            <li>
                                <a href="{{ route('brand.index') }}">الماركات</a>
                            </li>

                            <li>
                                <a href="{{ route('size.index') }}">القياسات</a>
                            </li>

                            <li>
                                <a href="{{ route('group.index') }}">المجموعات</a>
                            </li>


                            <li>
                                <a href="{{ route('subgroup.index') }}">المجموعات الفرعية</a>
                            </li>

                            <li>
                                <a href="{{ route('season.index') }}">الفصول</a>
                            </li>

                            <li>
                                <a href="{{ route('departments.index') }}">الاقسام</a>
                            </li>

                            <li>
                                <a href="{{ route('users.index') }}">المستخدمين</a>
                            </li>

                        @endif

                    @endauth
                </ul>
            </li>
        </ul>

    </nav>

    <!-- Page Content  -->
    <div id="content">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-align-left"></i>
                    <span>القائمة</span>
                </button>
                <div
                    class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
                    @if (Route::has('login'))
                        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                            @auth
                                <p href="" style="display: inline;"
                                   class="text-sm text-gray-700 underline">{{ \Illuminate\Support\Facades\Auth::user()->username }} </p>

                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf

                                    <x-jet-dropdown-link href="{{ route('logout') }}"
                                                         onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                        {{ __('تسجيل الخروج') }}
                                    </x-jet-dropdown-link>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">تسجيل الدخول</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                                @endif
                            @endif
                        </div>
                    @endif


                </div>
            </div>
            @if(isset($notification))
            <ul class="nav nav-pills mr-auto justify-content-end">
                <li class="nav-item dropdown" style="width: max-content">
                    <a class="nav-link "  href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-envelope fa-2x"></i>
                       @if(count($notification) >0)
                            <span class="counter ">{{count($notification)}}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-container dropdown-position-bottomright">

                        <div class="dropdown-toolbar">

                            <h3 class="dropdown-toolbar-title text-right">لديك  ({{count($notification)}}) طلبات لم يتم استلامها </h3>
                        </div><!-- /dropdown-toolbar -->

                        <ul class="vertical-scrollable" style="padding: 0;">

                                @foreach($notification as $n)
                                    <li class="notification ">
                                        <div class="media">
                                            <div class="media-left">
                                                <div class="media-object">
                                                    <img  class="img-circle" alt="50x50" src="
                                            @if($n->image !== null)
                                                    {{asset(config('app.ORDER_FILES_PATH', 'files/Orders/')) . '/' . $n->image}}
                                                    @else
                                                        data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2250%22%20height%3D%2250%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2050%2050%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1758d492281%20text%20%7B%20fill%3A%23919191%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1758d492281%22%3E%3Crect%20width%3D%2250%22%20height%3D%2250%22%20fill%3D%22%23cccccc%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%226.4609375%22%20y%3D%2229.5%22%3E50x50%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E
@endif
                                                        " data-holder-rendered="true" style="width: 50px; height: 50px;">
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <strong class="notification-title"><a style="background: none !important;" href="{{ route('order.show',$n->id) }}">{{$n->barcode}}</a> </strong>
                                                {{--                                        <p class="notification-desc">I totally don't wanna do it. Rimmer can do it.</p>--}}

                                                <div class="notification-meta">
                                                    <small class="timestamp">{{$n->orderDate}}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach




                        </ul>



                    </div>
                    <ul class="dropdown-menu">
                        @if(isset($notification))
                            <li class="head text-light bg-dark">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <span>Notifications {{count($notification)}}</span>

                                    </div>
                            </li>
                            @foreach($notification as $n)
                                <li class="notification-box">
                                    <a href="{{ route('order.show',$n->id) }}">
                                        <div class="row">
                                            <div class="col-lg-3 col-sm-3 col-3 text-center">
                                                <img src="{{asset(config('app.ORDER_FILES_PATH', 'files/Orders/')) . '/' . $n->image}}" class="w-50 rounded-circle">
                                            </div>
                                            <div class="col-lg-8 col-sm-8 col-8">
                                                <strong class="text-info">{{$n->barcode}}</strong>

                                                <small class="text-warning">{{$n->orderDate}}</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li class="head text-light bg-dark">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <span>Notifications 0</span>

                                    </div>
                            </li>

                                <li class="notification-box">

                                        <div class="row">

                                            <div class="col-lg-8 col-sm-8 col-8">
                                                <strong class="text-info">ليس هناك اشعارات</strong>


                                            </div>
                                        </div>
                                    </a>
                                </li>
                        @endif

                    </ul>
                </li>
            </ul>
            @endif
        </nav>

        <div class="container">

            @yield('content')


        </div>
    </div>
</div>


<div id="preloader">
    <div id="status">&nbsp;</div>
</div>


<!-- jQuery CDN - Slim version (=without AJAX) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"
       ></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.0/js/bootstrap.min.js"></script>
<script>

    $(document).ready(function () {
        jQuery("#status").fadeOut();
        jQuery("#preloader").delay(350).fadeOut("slow");
        jQuery("body").delay(350).css({ overflow: "visible" });
        $('#toast').toast('show')

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });


        $('.btn-danger').on('click', function () {

            var r = confirm("هل تريد الحذف؟");
            if (r == true) {
                return true;
            } else {
                return false;
            }
            return false;

        });

        $('#recive').on('click', function () {

            var r = confirm("هل تريد استلام هذا الطلب؟");
            if (r == true) {
                return true;
            } else {
                return false;
            }
            return false;

        });


        $('#image1').on('change',function (){
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function(){
                $("#img1").attr("src", reader.result);
            }

            reader.readAsDataURL(file);
        });
        $('#image2').on('change',function (){
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function(){
                $("#img2").attr("src", reader.result);
            }

            reader.readAsDataURL(file);
        });
        $('#image3').on('change',function (){
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function(){
                $("#img3").attr("src", reader.result);
            }

            reader.readAsDataURL(file);
        });


        $('#group').on('change',function(){
            var selectedCountry = $(this).children("option:selected").val();

            jQuery("#status").fadeIn();
            jQuery("#preloader").delay(350).fadeIn("slow");
            jQuery("body").delay(350).css({ overflow: "visible" });
            $.ajax({
                type: "GET",

                url: "http://{{request()->getHttpHost()}}"+"/api/getSubGroup/" + selectedCountry,
                success: function (data) {

                    console.log(data.data);
                    var data = data.data;
                    $('#subgroup').html('');
                    if (selectedCountry == 0){
                        $('#subgroup').append(new Option('الكل', 0))
                    }
                    for(var i =0 ; i< data.length; i++){
                        console.log(data[i].name);

                        $('#subgroup').append(new Option(data[i].name, data[i].id))
                    }
                    jQuery("#status").fadeOut();
                    jQuery("#preloader").fadeOut("slow");


                },
                error: function (data) {

                    console.log(data.responseText);
                    jQuery("#status").fadeOut();
                    jQuery("#preloader").fadeOut("slow");
                    alert('حدث خطأ');
                }
            });
            jQuery("#status").fadeOut();
            jQuery("#preloader").fadeOut("slow");


        });


        $('#siresColorQty').on('change',function (){
            var siresColorQty =  $("#siresColorQty").val();
            var siresSizeQty = $("#siresSizeQty").val();

            $("#siresItemNumber").html(siresColorQty * siresSizeQty);
        });


        $('#siresSizeQty').on('change',function (){
            var siresColorQty =  $("#siresColorQty").val();
            var siresSizeQty = $("#siresSizeQty").val();

            $("#siresItemNumber").html(siresColorQty * siresSizeQty);
        });

        $('#siresQty').on('change',function (){
            var siresColorQty =  $("#siresColorQty").val();
            var siresSizeQty = $("#siresSizeQty").val();
            var siresQty = $("#siresQty").val();

            $("#quantity").html(siresColorQty * siresSizeQty * siresQty);
        });


        $('#addFabric').on('submit',function (e) {

            jQuery("#status").fadeIn();
            jQuery("#preloader").delay(350).fadeIn("slow");
            jQuery("body").delay(350).css({ overflow: "visible" });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            var formData = {
                name: $('#fabricName').val(),
                code: $('#fabricCode').val(),
            };
            console.log('dsds');
            $.ajax({
                type: "get",
                data: formData,
                dataType: 'json',
                url: "http://{{request()->getHttpHost()}}"+"/api/AddFabric/",
                success: function (data) {
                    console.log(data);
                    var data = data.data;
                    $('#fabricSelect').html('');

                    for(var i =0 ; i< data.length; i++){
                        console.log(data[i].name);

                        $('#fabricSelect').append(new Option(data[i].name, data[i].id))
                    }
                    $('#fabricModal').modal('toggle');
                    jQuery("#status").fadeOut();
                    jQuery("#preloader").fadeOut("slow");
                },
                error: function (data) {
                    console.log(data.responseText);
                    jQuery("#status").fadeOut();
                    jQuery("#preloader").fadeOut("slow");
                    alert('حدث خطأ');
                }
            });


            return false;
        });
    });


    function previewFile(input,img){
        if (input.files && input.files[0]) {
            var file = input.files[0];
            var reader = new FileReader();
            reader.onload = function(){
                $("#" + img).attr("src", reader.result);
            }

            reader.readAsDataURL(file);
        }



    }







</script>
</body>
</html>
