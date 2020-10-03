<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Order</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/printStyle.css') }}" media="print">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

</head>
<body dir="rtl">
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
                <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
                    @if (Route::has('login'))
                        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                            @auth
                                <p href="" style="display: inline;" class="text-sm text-gray-700 underline">{{ \Illuminate\Support\Facades\Auth::user()->username }} </p>

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
        </nav>

        <div class="container">

            @yield('content')


        </div>
    </div>
</div>



<!-- jQuery CDN - Slim version (=without AJAX) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<script>

    $(document).ready(function () {

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });


</script>
</body>
</html>
