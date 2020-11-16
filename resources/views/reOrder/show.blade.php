@extends('layout.layout')

@section('content')


    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-left">
                <h2> Re Order {{$reOrder->order->barcode}} Number {{ $reOrder->re_order_number }}</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('reOrder.index') }}"> رجوع</a>
{{--                <a class="btn btn-primary" href="{{ route('order.edit',$reOrder->id) }}">تعديل</a>--}}
            </div>
        </div>

        <div class="row col-lg-12" id="imageContainer">
            @if($reOrder->order->image)
                <div class="col-lg-4 " >
                    <div class="text-center orderImg">

                        @if(Storage::disk('img')->exists($reOrder->image))
                            <img src="data:image/jpeg;base64,{{ base64_encode(Storage::disk('img')->get($reOrder->image)) }}"
                                 class="rounded orderImage" alt="{{$reOrder->barcode}}">
                        @elseif(Storage::disk('img')->exists($reOrder->order->image))
                            <img src="data:image/jpeg;base64,{{ base64_encode(Storage::disk('img')->get($reOrder->order->image)) }}"
                                 class="rounded orderImage" alt="{{$reOrder->order->barcode}}">
                        @endif

{{--                        <img src="{{asset(config('app.ORDER_FILES_PATH', 'files/Orders/')) . '/' . $reOrder->order->image}}"--}}
{{--                             class="rounded orderImage" alt="{{$reOrder->order->barcode}}">--}}
                    </div>
                </div>
            @endif
                @if(Storage::disk('img')->exists($reOrder->image2))
                    <img src="data:image/jpeg;base64,{{ base64_encode(Storage::disk('img')->get($reOrder->image2)) }}"
                         class="rounded orderImage" alt="{{$reOrder->barcode}}">
                @elseif(Storage::disk('img')->exists($reOrder->order->image2))
                    <img src="data:image/jpeg;base64,{{ base64_encode(Storage::disk('img')->get($reOrder->order->image2)) }}"
                         class="rounded orderImage" alt="{{$reOrder->order->barcode}}">
                @endif

                @if(Storage::disk('img')->exists($reOrder->image3))
                    <img src="data:image/jpeg;base64,{{ base64_encode(Storage::disk('img')->get($reOrder->image3)) }}"
                         class="rounded orderImage" alt="{{$reOrder->barcode}}">
                @elseif(Storage::disk('img')->exists($reOrder->order->image3))
                    <img src="data:image/jpeg;base64,{{ base64_encode(Storage::disk('img')->get($reOrder->order->image3)) }}"
                         class="rounded orderImage" alt="{{$reOrder->order->barcode}}">
                @endif
        </div>

        <div class="col-lg-12 margin-tb">
            <div class="float-right">
                <h2>العدد الكلي : {{ $reOrder->siresQty }}</h2>
            </div>
            <div class="float-left">
                <h2> حالة الاستلام :
                    @if($reOrder->done ===1)
                        تم الاستلام
                    @elseif($reOrder->receivedQty ==0)
                        لم يتم الاستلام

                @else
                    {{'تم استلام'. $reOrder->receivedQty .' من اصل ' . $reOrder->quantity}}

                @endif

            </div>
        </div>


        <div class="col-lg-12 margin-tb">


            <div class="float-left">
                <button class="btn btn-info mt-2 mb-2" id="print" onclick="$('#imageContainer').toggleClass('row'); window.print(); "><i class="fa fa-print"></i>
                    طباعة
                </button>
                @if($reOrder->done === 0)
                    <form action="{{ route('reOrderDone') }}" method="POST" id="receivedForm">

                        @csrf
                        <input type="hidden" value="{{$reOrder->id}}" name="order">
                        <input type="number" class="form-control col-md-6" name="receivedQty" style="min-width: auto;"  min="1"
{{--                               max="{{($reOrder->quantity - $reOrder->receivedQty)}}"--}}
                               placeholder="الكمية المستلمة">
                        <button type="submit" class="btn btn-primary" id="recive">استلام</button>
                        @foreach ($errors->get('receivedQty') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </form>

                @endif


            </div>


            <div class="float-right">
                <h2>تاريخ الطلب : {{ $reOrder->orderDate->format('Y-m-d') }}</h2>
                <h2 style="float: right;">تاريخ الاستلام
                    : {{  $reOrder->reservedDate != null ? $reOrder->reservedDate->format('Y-m-d') : 'ليس بعد' }}</h2>
            </div>
        </div>

    </div>



    <table id="webTable" class="table table-bordered mt-2" style="text-align: right;">
        <tr>
            <td>باركود</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->barcode }}</td>
        </tr>

        <tr>
            <td>ماركة</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->brand->name }}</td>
        </tr>


        <tr>
            <td>السنة</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->year->name }}</td>
        </tr>

        <tr>
            <td>الفصل</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->season->name }}</td>
        </tr>

        <tr>
            <td>النوع</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->type->name }}</td>
        </tr>

        <tr>
            <td>المجموعة</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->group->name }}</td>
        </tr>

        <tr>
            <td>المجموعة الفرعية</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->subgroup->name }}</td>
        </tr>


        <tr>
            <td>المورد</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->supplier->name }}</td>
        </tr>

        <tr>
            <td>مصدر القماش</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->fabricSource->name }}</td>
        </tr>




        <tr>
            <td >نوع القماش</td>
            @foreach($reOrder->order->fabrics as $fab)
                <td>
                    {{ $fab->name }}
                </td>
            @endforeach
        </tr>

        <tr>
            <td>رمز القماش</td>
            @foreach($reOrder->order->fabrics as $fab)
                <td>
                    {{ $fab->code }}
                </td>
            @endforeach
        </tr>

        <tr>
            <td>تركيبة القماش</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->fabricFormula }}</td>
        </tr>
        <tr>
            <td>عدد الالوان في السيري</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->siresColorQty }}</td>
        </tr>

        <tr>
            <td>عدد القياسات في السيري</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->siresSizeQty }}</td>
        </tr>

        <tr>
            <td>عدد القطع في السيري </td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->siresItemNumber }}</td>
        </tr>

        <tr>
            <td>عدد السيريات</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->siresQty }}</td>
        </tr>

        <tr>
            <td>الكمية</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->quantity }}</td>
        </tr>



        <tr>
            <td>الكمية المستلمة</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->receivedQty }}</td>
        </tr>


        <tr>
            <td>اسم الموديل</td>
            <td colspan="{{count($reOrder->order->fabrics)}}"> {{ $reOrder->order->modelName }}</td>
        </tr>


        <tr>
            <td>مواصفات الموديل</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->modelDesc }}</td>
        </tr>




        <tr>
            <td>تاريخ تسليم القماش</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{  \Carbon\Carbon::create($reOrder->fabricDate)->format('Y-m-d') }}</td>
        </tr>



        <tr>
            <td>القياسات</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">
                @foreach($reOrder->sizes as $size)
                    {{ $size->name . ' | ' }}
                @endforeach
            </td>
        </tr>


        <tr>
            <td>الالوان</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">
                @foreach($reOrder->colors as $color)
                    {{ $color->name . ' | ' }}
                @endforeach

            </td>
        </tr>


    </table>

    <div class="col-lg-6 float-right" id="printTable">
        <table  class="table table-bordered mt-2 col-lg-6" style="text-align: right;">
            <tr>
                <td>باركود</td>
                <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->barcode }}</td>
            </tr>

            <tr>
                <td>ماركة</td>
                <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->brand->name }}</td>
            </tr>


            <tr>
                <td>السنة</td>
                <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->year->name }}</td>
            </tr>

            <tr>
                <td>الفصل</td>
                <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->season->name }}</td>
            </tr>

            <tr>
                <td>النوع</td>
                <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->type->name }}</td>
            </tr>

            <tr>
                <td>المجموعة</td>
                <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->group->name }}</td>
            </tr>

            <tr>
                <td>المجموعة الفرعية</td>
                <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->subgroup->name }}</td>
            </tr>


            <tr>
                <td>المورد</td>
                <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->supplier->name }}</td>
            </tr>

            <tr>
                <td>مصدر القماش</td>
                <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->fabricSource->name }}</td>
            </tr>




            <tr>
                <td >نوع القماش</td>
                @foreach($reOrder->order->fabrics as $fab)
                    <td>
                        {{ $fab->name }}
                    </td>
                @endforeach
            </tr>

            <tr>
                <td>رمز القماش</td>
                @foreach($reOrder->order->fabrics as $fab)
                    <td>
                        {{ $fab->code }}
                    </td>
                @endforeach
            </tr>

            <tr>
                <td>تركيبة القماش</td>
                <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->fabricFormula }}</td>
            </tr>

        </table>

    </div>

    <div class="col-lg-6 float-left" id="printTable2">
    <table  class="table table-bordered mt-2 col-lg-6" style="text-align: right;">

        <tr>
            <td>عدد الالوان في السيري</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->siresColorQty }}</td>
        </tr>

        <tr>
            <td>عدد القياسات في السيري</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->siresSizeQty }}</td>
        </tr>

        <tr>
            <td>عدد القطع في السيري </td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->siresItemNumber }}</td>
        </tr>

        <tr>
            <td>عدد السيريات</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->siresQty }}</td>
        </tr>

        <tr>
            <td>الكمية</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->quantity }}</td>
        </tr>



        <tr>
            <td>الكمية المستلمة</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->receivedQty }}</td>
        </tr>


        <tr>
            <td>اسم الموديل</td>
            <td colspan="{{count($reOrder->order->fabrics)}}"> {{ $reOrder->order->modelName }}</td>
        </tr>


        <tr>
            <td>مواصفات الموديل</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{ $reOrder->order->modelDesc }}</td>
        </tr>




        <tr>
            <td>تاريخ تسليم القماش</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">{{  \Carbon\Carbon::create($reOrder->fabricDate)->format('Y-m-d') }}</td>
        </tr>



        <tr>
            <td>القياسات</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">
                @foreach($reOrder->sizes as $size)
                    {{ $size->name . ' | ' }}
                @endforeach
            </td>
        </tr>


        <tr>
            <td>الالوان</td>
            <td colspan="{{count($reOrder->order->fabrics)}}">
                @foreach($reOrder->colors as $color)
                    {{ $color->name . ' | ' }}
                @endforeach

            </td>
        </tr>

    </table>

    </div>

    <div class="col-lg-12 float-right text-right border-t note_div" >
        <h4>ملاحظات</h4>
        <p>{!! nl2br(str_replace(" ", " &nbsp;",$reOrder->notes)) !!}</p>
    </div>

@endsection
