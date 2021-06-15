@extends('layout.layout')

@section('content')

    @auth



        <div class="row">

            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body text-right">
                        <div class="d-flex justify-content-between align-items-center ">
                            <div class="me-3">
                                <div class="text-white-75 small">الكميات المطلوبة لكل الطلبات</div>
                                <div class="text-lg fw-bold">{{$totalOrderQty}}</div>
                            </div>
                            <i class="fas fa-sort-amount-down text-white-50" data-feather="calendar"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="text-white stretched-link" href="{{route('order.index')}}">عرض الطلبات</a>
                        <div class="text-white"><i class="fa fa-copy"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body text-right">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">الكميات المستلمة لكل الطلبات</div>
                                <div class="text-lg fw-bold">{{$totalOrderreceivedQty}}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="dollar-sign"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="text-white stretched-link" href="{{route('order.index')}}">عرض الطلبات</a>
                        <div class="text-white"><i class="fa fa-copy"></i></div>
                    </div>
                </div>
            </div>


            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-success text-white h-100">
                    <div class="card-body text-right">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">الطلبات المعادة</div>
                                <div class="text-lg fw-bold">{{$reOrderCount}}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="check-square"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="text-white stretched-link" href="{{route('reOrder.index')}}">عرض الطلبات المعادة</a>
                        <div class="text-white"><i class="fa fa-copy"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-danger text-white h-100">
                    <div class="card-body text-right">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">الطلبات الغير مستلمة</div>
                                <div class="text-lg fw-bold">{{$notReceivedOrderQty}}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="message-circle"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="text-white stretched-link" href="{{route('order.index')}}">عرض الطلبات</a>
                        <div class="text-white"><i class="fa fa-copy"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-xl-12 mb-4 ">
                <div class="card mb-4 text-right">
                    <div class="card-header">آخر الطلبات التي قمت بإضافاتها</div>
                    <div class="card-body">
                        <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">

                            <div class="dataTable-container">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>No</th>
                                        <th>Barcode</th>
                                        {{--            @if(\Illuminate\Support\Facades\Auth::user()->isAdmin)--}}
                                        <th>user</th>
                                        {{--            @endif--}}

                                        <th width="280px">خيارات</th>
                                    </tr>
                                    <?php $i = 0?>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $order->barcode }}</td>
                                            {{--                @if(\Illuminate\Support\Facades\Auth::user()->isAdmin)--}}
                                            <td>{{ $order->user->name }}</td>
                                            {{--                @endif--}}


                                            <td>


                                                <a class="btn btn-info" href="{{ route('order.show',$order->id) }}">عرض</a>

                                                <a class="btn btn-primary" href="{{ route('order.edit',$order->id) }}">تعديل</a>


                                                <a class="btn btn-info" href="{{ route('reOrder.create',[
                        'order' => $order->id,
]) }}">اعادة طلب</a>


                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>



{{--        <livewire:reports-orders/>--}}

        {{--    <button id="export">Export to excel</button>--}}
        {{--<div id="reportResult">--}}
        {{--    <table class="table table-bordered" id="datatable" data-excel-name="A very important table">--}}
        {{--        <tr>--}}
        {{--            <th>#</th>--}}
        {{--            <th>باركود</th>--}}
        {{--            <th>النوع</th>--}}
        {{--            <th>المجموعة</th>--}}
        {{--            <th>المجموعة الفرعية</th>--}}
        {{--            <th>نوع الطلب</th>--}}
        {{--            <th>حالة الاستلام</th>--}}
        {{--            <th>الكمية المطلوبة</th>--}}
        {{--            <th>الكمية المستلمة</th>--}}

        {{--                            <th width="280px" class="noExport">خيارات</th>--}}
        {{--        </tr>--}}
        {{--        <tbody id="reportBody">--}}

        {{--        </tbody>--}}

        {{--    </table>--}}
        {{--</div>--}}
        {{--    @if(isset($report))--}}
        {{--        <br>--}}
        {{--        <button id="export">Export to excel</button>--}}

        {{--        <table class="table table-bordered" id="datatable" data-excel-name="A very important table">--}}
        {{--            <tr>--}}
        {{--                <th>#</th>--}}
        {{--                <th>باركود</th>--}}
        {{--                <th>حالة الاستلام</th>--}}
        {{--                <th width="280px" class="noExport">خيارات</th>--}}
        {{--            </tr>--}}
        {{--            <?php $i = 0?>--}}
        {{--            @foreach ($orders as $order)--}}
        {{--                <tr>--}}
        {{--                    <td class="noExport">{{ ++$i }}</td>--}}
        {{--                    <td>{{ $order->barcode }}</td>--}}
        {{--                    @if($order->done == 0)--}}
        {{--                        <td>لم يتم الاستلام</td>--}}
        {{--                        @else--}}
        {{--                        <td>تم الاستلام</td>--}}
        {{--                        @endif--}}

        {{--                    <td class="noExport">--}}
        {{--                        <form action="{{ route('order.destroy',$order->id) }}" method="POST">--}}

        {{--                            <a class="btn btn-info" href="{{ route('order.show',$order->id) }}">عرض</a>--}}

        {{--                            <a class="btn btn-primary" href="{{ route('order.edit',$order->id) }}">تعديل</a>--}}

        {{--                            @csrf--}}
        {{--                            @method('DELETE')--}}

        {{--                            <button type="submit" class="btn btn-danger">حذف</button>--}}
        {{--                        </form>--}}
        {{--                        @if($order->done === 0)--}}
        {{--                            <form action="{{ route('orderDone') }}" method="POST" id="receivedForm" >--}}

        {{--                                @csrf--}}
        {{--                                <input type="hidden" value="{{$order->id}}" name="order">--}}
        {{--                                <input type="number" class="form-control col-md-6" name="receivedQty"  style="min-width: auto;" min="1" max="{{$order->reservedQuantity}}" placeholder="الكمية المستلمة">--}}
        {{--                                <button type="submit" class="btn btn-primary" id="recive">استلام</button>--}}
        {{--                                @foreach ($errors->get('receivedQty') as $message)--}}
        {{--                                    <i>{{ $message }}</i>--}}
        {{--                                @endforeach--}}
        {{--                            </form>--}}
        {{--                        @endif--}}
        {{--                    </td>--}}
        {{--                </tr>--}}
        {{--            @endforeach--}}
        {{--        </table>--}}
        {{--        <div class="d-flex justify-content-center">--}}
        {{--        {!! $orders->links() !!}--}}
        {{--        </div>--}}
        {{--    @endif--}}
    @else

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button class="btn btn-primary"><a href="{{route('login')}}">تسجيل الدخول</a></button>
        </div>
    @endauth



@endsection
