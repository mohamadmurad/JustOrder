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

        <div class="row col-lg-12" id="imageContainer">
            @if($order->image)
                <div class="col-lg-4 " >
                    <div class="text-center orderImg">
                        @if(Storage::disk('img')->exists($order->image))
                            <img src="data:image/jpeg;base64,{{ base64_encode(Storage::disk('img')->get($order->image)) }}"
                                 class="rounded orderImage" alt="{{$order->barcode}}">
                        @endif


{{--                        <img src="{{asset(config('app.ORDER_FILES_PATH', 'files/Orders/')) . '/' . $order->image}}"--}}
{{--                             class="rounded orderImage" alt="{{$order->barcode}}">--}}
                    </div>
                </div>
            @endif
            @if($order->image2)
                <div class="col-lg-4 " >
                    <div class="text-center orderImg">
                        @if(Storage::disk('img')->exists($order->image2))
                            <img src="data:image/jpeg;base64,{{ base64_encode(Storage::disk('img')->get($order->image2)) }}"
                                 class="rounded orderImage" alt="{{$order->barcode}}">
                        @endif

{{--                        <img src="{{asset(config('app.ORDER_FILES_PATH', 'files/Orders/')) . '/' . $order->image2}}"--}}
{{--                             class="rounded orderImage" alt="{{$order->barcode}}">--}}
                    </div>
                </div>

                @endif
                @if($order->image3)
                <div class="col-lg-4">
                    <div class="text-center orderImg" >
                        @if(Storage::disk('img')->exists($order->image3))
                            <img src="data:image/jpeg;base64,{{ base64_encode(Storage::disk('img')->get($order->image3)) }}"
                                 class="rounded orderImage" alt="{{$order->barcode}}">
                        @endif

{{--                        <img src="{{asset(config('app.ORDER_FILES_PATH', 'files/Orders/')) . '/' . $order->image3}}"--}}
{{--                             class="rounded orderImage" alt="{{$order->barcode}}">--}}
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-12 margin-tb">
{{--            <div class="float-right">--}}
{{--                <h2>العدد الكلي : {{ $order->siresQty }}</h2>--}}
{{--            </div>--}}
            <div class="float-left">
                <h4> حالة الاستلام :
                    @if($order->done ===1)
                        تم الاستلام
                    @elseif($order->receivedQty ==0)
                        لم يتم الاستلام

                @else
                    {{'تم استلام'. $order->receivedQty .' من اصل ' . $order->quantity}}
                </h4>
                @endif

            </div>
        </div>


        <div class="col-lg-12 margin-tb">


            <div class="float-left">
                <button class="btn btn-info mt-2 mb-2" id="print" onclick="$('#imageContainer').toggleClass('row'); window.print(); "><i class="fa fa-print"></i>
                    طباعة
                </button>
                @if($order->receivedQty === 0)
                    <form action="{{ route('orderDone') }}" method="POST" id="receivedForm">

                        @csrf
                        <input type="hidden" value="{{$order->id}}" name="order">
                        <input type="number" class="form-control col-md-6" name="receivedQty" style="min-width: auto;"  min="1"
{{--                               max="{{($order->quantity - $order->receivedQty)}}"--}}
                               placeholder="الكمية المستلمة">
                        <button type="submit" class="btn btn-primary" id="recive">استلام</button>
                        @foreach ($errors->get('receivedQty') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </form>

                @endif


            </div>


            <div class="float-right">
                <h4>تاريخ الطلب : {{ $order->orderDate->format('Y-m-d') }}</h4>
                <h4 style="float: right;">تاريخ الاستلام
                    : {{  $order->receivedDate != null ? \Carbon\Carbon::create($order->receivedDate)->format('Y-m-d') : 'ليس بعد' }}</h4>
            </div>
        </div>

    </div>



    <table id="webTable" class="table table-bordered mt-2" style="text-align: right;">
        <tr>
            <td>باركود</td>
            <td colspan="{{count($order->fabrics)}}">{{ $order->barcode }}</td>
        </tr>

        <tr>
            <td>ماركة</td>
            <td colspan="{{count($order->fabrics)}}">{{ $order->brand->name }}</td>
        </tr>


        <tr>
            <td>السنة</td>
            <td colspan="{{count($order->fabrics)}}">{{ $order->year->name }}</td>
        </tr>

        <tr>
            <td>الفصل</td>
            <td colspan="{{count($order->fabrics)}}">{{ $order->season->name }}</td>
        </tr>

        <tr>
            <td>النوع</td>
            <td colspan="{{count($order->fabrics)}}">{{ $order->type->name }}</td>
        </tr>

        <tr>
            <td>المجموعة</td>
            <td colspan="{{count($order->fabrics)}}">{{ $order->group->name }}</td>
        </tr>

        <tr>
            <td>المجموعة الفرعية</td>
            <td colspan="{{count($order->fabrics)}}">{{ $order->subgroup->name }}</td>
        </tr>


        <tr>
            <td>المورد</td>
            <td colspan="{{count($order->fabrics)}}">{{ $order->supplier->name }}</td>
        </tr>

        <tr>
            <td>مصدر القماش</td>
            <td colspan="{{count($order->fabrics)}}">{{ $order->fabricSource->name }}</td>
        </tr>




        <tr>
            <td >نوع القماش</td>
            @foreach($order->fabrics as $fab)
                <td>
                    {{ $fab->name }}
                </td>
            @endforeach
        </tr>

        <tr>
            <td>رمز القماش</td>
            @foreach($order->fabrics as $fab)
                <td>
                    {{ $fab->code }}
                </td>
            @endforeach
        </tr>

        <tr>
            <td>تركيبة القماش</td>
            <td colspan="{{count($order->fabrics)}}">{{ $order->fabricFormula }}</td>
        </tr>
        <tr>
            <td>عدد الالوان في السيري</td>
            <td colspan="{{count($order->fabrics)}}">{{ $order->siresColorQty }}</td>
        </tr>

        <tr>
            <td>عدد القياسات في السيري</td>
            <td colspan="{{count($order->fabrics)}}">{{ $order->siresSizeQty }}</td>
        </tr>

        <tr>
            <td>عدد القطع في السيري </td>
            <td colspan="{{count($order->fabrics)}}">{{ $order->siresItemNumber }}</td>
        </tr>

        <tr>
            <td>عدد السيريات</td>
            <td colspan="{{count($order->fabrics)}}">{{ $order->siresQty }}</td>
        </tr>

        <tr>
            <td>الكمية</td>
            <td colspan="{{count($order->fabrics)}}">{{ $order->quantity }}</td>
        </tr>




{{--        <tr>--}}
{{--            <td>الكمية المطلوبة</td>--}}
{{--            <td>{{ $order->reservedQuantity }}</td>--}}
{{--        </tr>--}}


        <tr>
            <td>الكمية المستلمة</td>
            <td colspan="{{count($order->fabrics)}}">{{ $order->receivedQty }}</td>
        </tr>


        <tr>
            <td>اسم الموديل</td>
            <td colspan="{{count($order->fabrics)}}"> {{ $order->modelName }}</td>
        </tr>


        <tr>
            <td>مواصفات الموديل</td>
            <td colspan="{{count($order->fabrics)}}">{{ $order->modelDesc }}</td>
        </tr>





{{--                <tr>--}}
{{--                    <td>رقم العنصر </td>--}}
{{--                    <td>{{ $order->itemsNumber }}</td>--}}
{{--                </tr>--}}


        <tr>
            <td>تاريخ تسليم القماش</td>
            <td colspan="{{count($order->fabrics)}}">{{  \Carbon\Carbon::create($order->fabricDate)->format('Y-m-d') }}</td>
        </tr>

{{--        <tr>--}}
{{--            <td>ملاحظات</td>--}}
{{--            <td>{!! nl2br(str_replace(" ", " &nbsp;",$order->notes)) !!}</td>--}}
{{--        </tr>--}}


        <tr>
            <td>القياسات</td>
            <td colspan="{{count($order->fabrics)}}">
                @foreach($order->sizes as $size)
                    {{ $size->name . ' | ' }}
                @endforeach
            </td>
        </tr>


        <tr>
            <td>الالوان</td>
            <td colspan="{{count($order->fabrics)}}">
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
                <td colspan="{{count($order->fabrics)}}">{{ $order->barcode }}</td>
            </tr>

            <tr>
                <td>ماركة</td>
                <td colspan="{{count($order->fabrics)}}">{{ $order->brand->name }}</td>
            </tr>


            <tr>
                <td>السنة</td>
                <td colspan="{{count($order->fabrics)}}">{{ $order->year->name }}</td>
            </tr>

            <tr>
                <td>الفصل</td>
                <td colspan="{{count($order->fabrics)}}">{{ $order->season->name }}</td>
            </tr>

            <tr>
                <td>النوع</td>
                <td colspan="{{count($order->fabrics)}}">{{ $order->type->name }}</td>
            </tr>

            <tr>
                <td>المجموعة</td>
                <td colspan="{{count($order->fabrics)}}">{{ $order->group->name }}</td>
            </tr>

            <tr>
                <td>المجموعة الفرعية</td>
                <td colspan="{{count($order->fabrics)}}">{{ $order->subgroup->name }}</td>
            </tr>


            <tr>
                <td>المورد</td>
                <td colspan="{{count($order->fabrics)}}">{{ $order->supplier->name }}</td>
            </tr>

            <tr>
                <td>مصدر القماش</td>
                <td colspan="{{count($order->fabrics)}}">{{ $order->fabricSource->name }}</td>
            </tr>




            <tr>
                <td >نوع القماش</td>
                @foreach($order->fabrics as $fab)
                <td>
                    {{ $fab->name }}
                </td>
                @endforeach
            </tr>

            <tr>
                <td>رمز القماش</td>
                @foreach($order->fabrics as $fab)
                <td>
                        {{ $fab->code }}
                </td>
                @endforeach
            </tr>

            <tr>
                <td>تركيبة القماش</td>
                <td colspan="{{count($order->fabrics)}}">{{ $order->fabricFormula }}</td>
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

{{--        <tr>--}}
{{--            <td>الكمية المطلوبة</td>--}}
{{--            <td>{{ $order->reservedQuantity }}</td>--}}
{{--        </tr>--}}


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
            <td>{{ \Carbon\Carbon::create($order->fabricDate)->format('Y-m-d') }}</td>
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

    </div>

    <div class="clearfix"></div>
    <div class="col-lg-6 col-xs-6  col-sm-6 float-right text-right border-t note_div" >
        <h5>ملاحظات</h5>
        <p>{!! nl2br(str_replace(" ", " &nbsp;",$order->notes)) !!}</p>
    </div>

    <div class="col-lg-6 col-xs-6 col-sm-6 float-right text-right border-t note_div" >
        <h5>ملاحظات الطباعة</h5>
        <p>{!! nl2br(str_replace(" ", " &nbsp;",$order->PrintNotes)) !!}</p>
    </div>

@endsection
