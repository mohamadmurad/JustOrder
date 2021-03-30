@extends('layout.layout')

@section('content')

    @auth

        <livewire:reports-orders />

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
