@extends('layout.layout')

@section('content')


    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-left">
                <h2>Order {{$order->barcode}}</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('order.index') }}"> رجوع</a>
            </div>
        </div>
        @if($order->image)
        <div class="col-lg-12 margin-tb">
            <div class="text-center">
                <img src="{{asset(config('app.ORDER_FILES_PATH', 'files/Orders/')) . '/' . $order->image}}" class="rounded orderImage" alt="{{$order->barcode}}">
            </div>
        </div>
        @endif
        <div class="col-lg-12 margin-tb">
            <div class="float-right">
                <h2>العدد الكلي : {{ $order->siresQty }}</h2>
            </div>
            <div class="float-left">
                <h2> حالة الاستلام : {{  $order->done ===1 ? 'تم الاستلام' : 'لم يتم الاستلام' }}</h2>
            </div>
        </div>


        <div class="col-lg-12 margin-tb">
            @if($order->done === 0)
            <div class="float-left">
                @if($order->done === 0)
                    <form action="{{ route('orderDone') }}" method="POST" id="receivedForm" >

                        @csrf
                        <input type="hidden" value="{{$order->id}}" name="order">
                        <input type="number" class="form-control col-md-6" name="receivedQty" style="min-width: auto;" min="1" max="{{$order->reservedQuantity}}" placeholder="الكمية المستلمة">
                        <button type="submit" class="btn btn-primary" id="recive">استلام</button>
                    </form>
                @endif
            </div>
            @endif

            <div class="float-right">
                <h2>تاريخ الطلب : {{ $order->orderDate->format('Y-m-d') }}</h2>
                <h2 style="float: right;">تاريخ الاستلام : {{  $order->reservedDate != null ? $order->reservedDate->format('Y-m-d') : 'ليس بعد' }}</h2>
            </div>
        </div>

    </div>



    <table class="table table-bordered" style="text-align: right;">
        <tr>
            <td>باركود</td>
            <td>{{ $order->barcode }}</td>
        </tr>

        <tr>
            <td>ماركة </td>
            <td>{{ $order->brand->name }}</td>
        </tr>


        <tr>
            <td>السنة</td>
            <td>{{ $order->year->name }}</td>
        </tr>

        <tr>
            <td>الفصل</td>
            <td>{{ $order->season->name }}</td>
        </tr>

        <tr>
            <td>النوع</td>
            <td>{{ $order->type->name }}</td>
        </tr>

        <tr>
            <td>المجموعة</td>
            <td>{{ $order->group->name }}</td>
        </tr>

        <tr>
            <td>المجموعة الفرعية</td>
            <td>{{ $order->subgroup->name }}</td>
        </tr>



        <tr>
            <td>المورد </td>
            <td>{{ $order->supplier->name }}</td>
        </tr>

        <tr>
            <td>مصدر القماش</td>
            <td>{{ $order->fabricSource->name }}</td>
        </tr>

        <tr>
            <td>نوع القماش</td>
            <td>{{ $order->fabric->name }}</td>
        </tr>

        <tr>
            <td>تركيبة القماش</td>
            <td>{{ $order->fabricFormula }}</td>
        </tr>

        <tr>
            <td>عدد الالوان في السيري</td>
            <td>{{ $order->siresColorQty }}</td>
        </tr>

        <tr>
            <td>عدد القياسات في السيري</td>
            <td>{{ $order->siresSizeQty }}</td>
        </tr>


        <tr>
            <td>الكمية المطلوبة</td>
            <td>{{ $order->reservedQuantity }}</td>
        </tr>


        <tr>
            <td>الكمية المستلمة </td>
            <td>{{ $order->receivedQty }}</td>
        </tr>


        <tr>
            <td>اسم الموديل  </td>
            <td>{{ $order->modelName }}</td>
        </tr>


        <tr>
            <td>مواصفات الموديل </td>
            <td>{{ $order->modelDesc }}</td>
        </tr>


{{--        <tr>--}}
{{--            <td>رقم السيري </td>--}}
{{--            <td>{{ $order->siresNumber }}</td>--}}
{{--        </tr>--}}


{{--        <tr>--}}
{{--            <td>رقم العنصر </td>--}}
{{--            <td>{{ $order->itemsNumber }}</td>--}}
{{--        </tr>--}}


        <tr>
            <td>ملاحظات  </td>
            <td>{{ $order->notes }}</td>
        </tr>


        <tr>
            <td>القياسات   </td>
            <td>
                @foreach($order->sizes as $size)
                    {{ $size->name . ' | ' }}
                @endforeach
            </td>
        </tr>


        <tr>
            <td>الالوان </td>
            <td>
                @foreach($order->colors as $color)
                     {{ $color->name . ' | ' }}
                @endforeach

            </td>
        </tr>




    </table>


@endsection
