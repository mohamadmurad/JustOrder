@extends('layout.layout')



@section('content')

    @include('layout.title',[
   'url' => 'order.index',
   'urlTitle' => 'رجوع',
   'title'=>'    تعديل الطلب ' . $order->barcode
   ])





        @if ($errors->any())

        <div class="alert alert-danger">

            <strong>اوه!</strong> هناك مشكلة.<br><br>

        </div>

    @endif



    <form action="{{ route('order.update',$order->id) }}" id="orderForm" method="POST" enctype="multipart/form-data">

        @csrf

        @method('PUT')



        <div class="row">


            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>عدد الالوان في السيري :</strong>
                    <input type="number" id="siresColorQty" min="1" name="siresColorQty" class="form-control" placeholder="عدد الالوان في السيري"  value="{{$order->siresColorQty}}">
                    <ul class="errors">
                        @foreach ($errors->get('siresColorQty') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>عدد القياسات في السيري :</strong>
                    <input type="number" id="siresSizeQty"  min="1" name="siresSizeQty" class="form-control" placeholder="عدد القياسات في السيري" value="{{$order->siresSizeQty}}">
                    <ul class="errors">
                        @foreach ($errors->get('siresSizeQty') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>




            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>عدد السيريات :</strong>
                    <input type="number" id="siresQty" name="siresQty" class="form-control" placeholder="عدد السيريات" value="{{$order->siresQty}}">
                    <ul class="errors">
                        @foreach ($errors->get('siresQty') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 text-right">
                <p id="">عدد القطع في السيري : <span id="siresItemNumber">{{$order->siresItemNumber}}</span></p>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 text-right">
                <p id="">الكمية : <span id="quantity">{{$order->quantity}}</span></p>
            </div>



                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong style="color:red">تاريخ الطلب :</strong>
                                <input type="date" name="orderDate" class="form-control" placeholder="تاريخ الطلب" value="{{$order->orderDate->format('Y-m-d')}}">
                                <ul class="errors">
                                    @foreach ($errors->get('orderDate') as $message)
                                        <i>{{ $message }}</i>
                                    @endforeach
                                </ul>
                            </div>
                        </div>


            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>تاريخ تسليم القماش :</strong>
                    <input type="date" name="fabricDate" class="form-control" placeholder="تاريخ تسليم القماش" value="{{\Carbon\Carbon::create($order->fabricDate)->format('Y-m-d')}}">
                    <ul class="errors">
                        @foreach ($errors->get('fabricDate') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>ملاحظات :</strong>
                    <textarea form="orderForm" type="text" name="notes" class="form-control" rows="3" placeholder="ملاحظات">{{$order->notes}}</textarea>
                    <ul class="errors">
                        @foreach ($errors->get('notes') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>صورة1 :</strong>
                    <input type="file" name="image" class="form-control" placeholder="صورة"   accept="image/*">
                    <ul class="errors">
                        @foreach ($errors->get('image') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>




            <div class="col-xs-12 col-sm-12 col-md-12">
                <strong>القياسات :</strong><br>
                <ul class="errors">
                    @foreach ($errors->get('sizes') as $message)
                        <i>{{ $message }}</i>
                    @endforeach
                </ul>
                @foreach($sizes as $size)
                    <div class="form-check form-check-inline col-xs-2 col-sm-2 col-md-2">

                        <input class="form-check-input" type="checkbox" name="sizes[]" value="{{$size->id}}"
                            @if($order->sizes)
                                @if(in_array($size->id, $order->sizes->pluck('id')->toArray()))
                            checked
                            @endif
                             @endif
                           >
                        <label class="form-check-label" >
                            {{$size->name}}
                        </label>
                    </div>
                @endforeach

            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                <strong>الالوان :</strong><br>
                <ul class="errors">
                    @foreach ($errors->get('colors') as $message)
                        <i>{{ $message }}</i>
                    @endforeach
                </ul>
                @foreach($colors as $color)
                    <div class="form-check form-check-inline col-xs-2 col-sm-2 col-md-2">
                        <input class="form-check-input" type="checkbox" name="colors[]" value="{{$color->id}}"
                               @if($order->colors)
                               @if(in_array($color->id, $order->colors->pluck('id')->toArray()))
                               checked
                            @endif
                            @endif
                        >
                        <label class="form-check-label" >
                            {{$color->name}}
                        </label>
                    </div>
                @endforeach

            </div>





            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">تعديل</button>
            </div>
        </div>



    </form>



@endsection
