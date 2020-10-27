@extends('layout.layout')

@section('content')


    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-left">
                <h2>Order {{$order->barcode}}</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('order.index') }}"> رجوع</a>
                <a class="btn btn-primary" href="{{ route('order.edit',$order->id) }}">تعديل</a>
            </div>
        </div>

        <div class="row col-lg-12">
            @if($order->image)
                <div class="col-lg-4 margin-tb">
                    <div class="text-center">
                        <img src="{{asset(config('app.ORDER_FILES_PATH', 'files/Orders/')) . '/' . $order->image}}"
                             class="rounded orderImage" alt="{{$order->barcode}}">
                    </div>
                </div>
            @endif
            @if($order->image2)
                <div class="col-lg-4 margin-tb-3">
                    <div class="text-center">
                        <img src="{{asset(config('app.ORDER_FILES_PATH', 'files/Orders/')) . '/' . $order->image2}}"
                             class="rounded orderImage" alt="{{$order->barcode}}">
                    </div>
                </div>

                @endif
                @if($order->image3)
                <div class="col-lg-4 margin-tb">
                    <div class="text-center">
                        <img src="{{asset(config('app.ORDER_FILES_PATH', 'files/Orders/')) . '/' . $order->image3}}"
                             class="rounded orderImage" alt="{{$order->barcode}}">
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-12 margin-tb">
{{--            <div class="float-right">--}}
{{--                <h2>العدد الكلي : {{ $order->siresQty }}</h2>--}}
{{--            </div>--}}
            <div class="float-left">
                <h2> حالة الاستلام :
                    @if($order->done ===1)
                        تم الاستلام
                    @elseif($order->receivedQty ==0)
                        لم يتم الاستلام

                @else
                    {{'تم استلام'. $order->receivedQty .' من اصل ' . $order->quantity}}

                @endif

            </div>
        </div>


        <div class="col-lg-12 margin-tb">


            <div class="float-left">
                <button class="btn btn-info mt-2 mb-2" id="print" onclick="window.print();"><i class="fa fa-print"></i>
                    طباعة
                </button>
                @if($order->done === 0)
                    <form action="{{ route('orderDone') }}" method="POST" id="receivedForm">

                        @csrf
                        <input type="hidden" value="{{$order->id}}" name="order">
                        <input type="number" class="form-control col-md-6" name="receivedQty" style="min-width: auto;"
                               min="1" max="{{($order->quantity - $order->receivedQty)}}"
                               placeholder="الكمية المستلمة">
                        <button type="submit" class="btn btn-primary" id="recive">استلام</button>
                        @foreach ($errors->get('receivedQty') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </form>

                @endif


            </div>


            <div class="float-right">
                <h2>تاريخ الطلب : {{ $order->orderDate->format('Y-m-d') }}</h2>
                <h2 style="float: right;">تاريخ الاستلام
                    : {{  $order->reservedDate != null ? $order->reservedDate->format('Y-m-d') : 'ليس بعد' }}</h2>
            </div>
        </div>

    </div>



    <table id="webTable" class="table table-bordered mt-2" style="text-align: right;">
        <tr>
            <td>باركود</td>
            <td>{{ $order->barcode }}</td>
        </tr>

        <tr>
            <td>ماركة</td>
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
            <td>المورد</td>
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
            <td>عدد القطع في السيري </td>
            <td>{{ $order->siresItemNumber }}</td>
        </tr>

        <tr>
            <td>عدد السيريات</td>
            <td>{{ $order->siresQty }}</td>
        </tr>

        <tr>
            <td>الكمية</td>
            <td>{{ $order->quantity }}</td>
        </tr>




        <tr>
            <td>الكمية المطلوبة</td>
            <td>{{ $order->reservedQuantity }}</td>
        </tr>


        <tr>
            <td>الكمية المستلمة</td>
            <td>{{ $order->receivedQty }}</td>
        </tr>


        <tr>
            <td>اسم الموديل</td>
            <td>{{ $order->modelName }}</td>
        </tr>


        <tr>
            <td>مواصفات الموديل</td>
            <td>{{ $order->modelDesc }}</td>
        </tr>





{{--                <tr>--}}
{{--                    <td>رقم العنصر </td>--}}
{{--                    <td>{{ $order->itemsNumber }}</td>--}}
{{--                </tr>--}}


        <tr>
            <td>تاريخ تسليم القماش</td>
            <td>{{ $order->fabricDate }}</td>
        </tr>

        <tr>
            <td>ملاحظات</td>
            <td>{{ $order->notes }}</td>
        </tr>


        <tr>
            <td>القياسات</td>
            <td>
                @foreach($order->sizes as $size)
                    {{ $size->name . ' | ' }}
                @endforeach
            </td>
        </tr>


        <tr>
            <td>الالوان</td>
            <td>
                @foreach($order->colors as $color)
                    {{ $color->name . ' | ' }}
                @endforeach

            </td>
        </tr>


    </table>

    <div class="col-lg-6 float-right" id="printTable">
        <table  class="table table-bordered mt-2 col-lg-6" style="text-align: right;">
            <tr>
                <td>باركود</td>
                <td>{{ $order->barcode }}</td>
            </tr>

            <tr>
                <td>ماركة</td>
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
                <td>المورد</td>
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
                <td>الالوان</td>
                <td>
                    @foreach($order->colors as $color)
                        {{ $color->name . ' | ' }}
                    @endforeach

                </td>
            </tr>


        </table>

    </div>
    <div class="col-lg-6 float-left" id="printTable2">
    <table  class="table table-bordered mt-2 col-lg-6" style="text-align: right;">

        <tr>
            <td>عدد الالوان في السيري</td>
            <td>{{ $order->siresColorQty }}</td>
        </tr>

        <tr>
            <td>عدد القياسات في السيري</td>
            <td>{{ $order->siresSizeQty }}</td>
        </tr>

        <tr>
            <td>عدد القطع في السيري </td>
            <td>{{ $order->siresItemNumber }}</td>
        </tr>

        <tr>
            <td>عدد السيريات</td>
            <td>{{ $order->siresQty }}</td>
        </tr>

        <tr>
            <td>الكمية</td>
            <td>{{ $order->quantity }}</td>
        </tr>

        <tr>
            <td>الكمية المطلوبة</td>
            <td>{{ $order->reservedQuantity }}</td>
        </tr>


        <tr>
            <td>الكمية المستلمة</td>
            <td>{{ $order->receivedQty }}</td>
        </tr>


        <tr>
            <td>اسم الموديل</td>
            <td>{{ $order->modelName }}</td>
        </tr>


        <tr>
            <td>مواصفات الموديل</td>
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
            <td>تاريخ تسليم القماش</td>
            <td>{{ $order->fabricDate }}</td>
        </tr>

        <tr>
            <td>ملاحظات</td>
            <td>{{ $order->notes }}</td>
        </tr>


        <tr>
            <td>القياسات</td>
            <td>
                @foreach($order->sizes as $size)
                    {{ $size->name . ' | ' }}
                @endforeach
            </td>
        </tr>




    </table>
    </div>

@endsection
