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
                    <strong>ماركة :</strong>
                    <select  class="form-control"  name="brand_id">
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ ($order->brand_id == $brand->id ? "selected":"") }}>{{$brand->name . " | " . $brand->code}}</option>
                        @endforeach
                    </select>
                    <ul class="errors">
                        @foreach ($errors->get('brand_id') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>السنة:</strong>
                    <select  class="form-control"  name="year_id">
                        @foreach($years as $year)
                            <option value="{{ $year->id }}" {{ ($order->year_id == $year->id ? "selected":"") }}>{{$year->name}}</option>
                        @endforeach
                    </select>
                    <ul class="errors">
                        @foreach ($errors->get('year_id') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>النوع:</strong>
                    <select  class="form-control"  name="type_id">
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ ($order->type_id == $type->id ? "selected":"") }}>{{$type->name}}</option>
                        @endforeach
                    </select>
                    <ul class="errors">
                        @foreach ($errors->get('type_id') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>المجموعة:</strong>
                    <select  class="form-control"  name="group_id" id="group">
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" {{ ($order->group_id == $group->id ? "selected":"") }}>{{$group->name}}</option>
                        @endforeach
                    </select>
                    <ul class="errors">
                        @foreach ($errors->get('group_id') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>

                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>المجموعة الفرعية:</strong>
                    <select  class="form-control"  name="subgroup_id" id="subgroup">
                        @foreach($subgroups as $subgroup)
                            <option value="{{ $subgroup->id }}" {{ ($order->subgroup_id == $subgroup->id ? "selected":"") }}>{{$subgroup->name}}</option>
                        @endforeach
                    </select>
                    <ul class="errors">
                        @foreach ($errors->get('subgroup_id') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>الفصل:</strong>
                    <select  class="form-control"  name="season_id">
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}" {{ ($order->season_id == $season->id ? "selected":"") }}>{{$season->name}}</option>
                        @endforeach
                    </select>
                    <ul class="errors">
                        @foreach ($errors->get('season_id') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>المورد :</strong>
                    <select  class="form-control"  name="supplier_id">
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ ($order->supplier_id == $supplier->id ? "selected":"") }}>{{$supplier->name . ' | ' . $supplier->code}}</option>
                        @endforeach
                    </select>
                    <ul class="errors">
                        @foreach ($errors->get('supplier_id') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>

                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong >مصدر القماش :</strong>
                    <select  class="form-control"  name="fabricSource_id">
                        @foreach($fabricSources as $fabricSource)
                            <option value="{{ $fabricSource->id }}" {{ ($order->fabricSource_id == $fabricSource->id ? "selected":"") }}>{{$fabricSource->name}}</option>
                        @endforeach
                    </select>
                    <ul class="errors">
                        @foreach ($errors->get('fabricSource_id') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>

                </div>
            </div>


{{--            <div class="col-xs-12 col-sm-12 col-md-6">--}}
{{--                <div class="form-group">--}}
{{--                    <strong >نوع القماش :</strong>--}}
{{--                    <select  class="form-control"  name="fabric_id">--}}
{{--                        @foreach($fabrics as $fabric)--}}
{{--                            <option value="{{ $fabric->id }}" {{ ($order->fabric_id == $fabric->id ? "selected":"") }}>{{$fabric->name . " | " . $fabric->code }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                    <ul class="errors">--}}
{{--                        @foreach ($errors->get('fabric_id') as $message)--}}
{{--                            <i>{{ $message }}</i>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}

{{--                </div>--}}
{{--            </div>--}}

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong >نوع القماش :</strong>
                    <span class="autocomplete-select "></span>
                    {{--                    <button onclick="resetAutocomplete()">Reset</button>--}}
                    <ul class="errors">
                        @foreach ($errors->get('fabric_id') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>

                </div>
            </div>

            <div id="ff" style="display: none;">

            </div>


            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>تركيبة القماش :</strong>
                    <input type="text" name="fabricFormula" class="form-control" placeholder="تركيبة القماش" value="{{$order->fabricFormula}}">
                    <ul class="errors">
                        @foreach ($errors->get('fabricFormula') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>




            {{--            <div class="col-xs-12 col-sm-12 col-md-4">--}}
            {{--                <div class="form-group">--}}
            {{--                    <strong>عدد القطع السيري:</strong>--}}
            {{--                    <input type="number" name="siresQty" class="form-control" placeholder="عدد القطع في السري">--}}
            {{--                    <ul class="errors">--}}
            {{--                        @foreach ($errors->get('siresQty') as $message)--}}
            {{--                            <i>{{ $message }}</i>--}}
            {{--                        @endforeach--}}
            {{--                    </ul>--}}
            {{--                </div>--}}
            {{--            </div>--}}

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

{{--            <div class="col-xs-12 col-sm-12 col-md-4">--}}
{{--                <div class="form-group">--}}
{{--                    <strong>عدد القطع في السيري :</strong>--}}
{{--                    <input type="number" name="quantity" min="1" class="form-control" placeholder="عدد القطع في السري" value="{{$order->quantity}}">--}}
{{--                    <ul class="errors">--}}
{{--                        @foreach ($errors->get('quantity') as $message)--}}
{{--                            <i>{{ $message }}</i>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}


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



{{--            <div class="col-xs-12 col-sm-12 col-md-4">--}}
{{--                <div class="form-group">--}}
{{--                    <strong>الكمية المطلوبة :</strong>--}}
{{--                    <input type="number" min="1" name="reservedQuantity" class="form-control" placeholder="الكمية المطلوبة " value="{{$order->reservedQuantity}}">--}}
{{--                    <ul class="errors">--}}
{{--                        @foreach ($errors->get('reservedQuantity') as $message)--}}
{{--                            <i>{{ $message }}</i>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}

            {{--            <div class="col-xs-12 col-sm-12 col-md-4">--}}
            {{--                <div class="form-group">--}}
            {{--                    <strong>الكمية المستلمة :</strong>--}}
            {{--                    <input type="number" min="1" name="receivedQty" class="form-control" placeholder="الكمية المستلمة ">--}}
            {{--                    <ul class="errors">--}}
            {{--                        @foreach ($errors->get('receivedQty') as $message)--}}
            {{--                            <i>{{ $message }}</i>--}}
            {{--                        @endforeach--}}
            {{--                    </ul>--}}
            {{--                </div>--}}
            {{--            </div>--}}


            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>اسم الموديل :</strong>
                    <input type="text" name="modelName" class="form-control" placeholder="اسم الموديل" value="{{$order->modelName}}">
                    <ul class="errors">
                        @foreach ($errors->get('modelName') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>مواصفات الموديل :</strong>
                    <input type="text" name="modelDesc" class="form-control" placeholder="مواصفات الموديل" value="{{$order->modelDesc}}">
                    <ul class="errors">
                        @foreach ($errors->get('modelDesc') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{--            <div class="col-xs-12 col-sm-12 col-md-4">--}}
            {{--                <div class="form-group">--}}
            {{--                    <strong>كود القماش :</strong>--}}
            {{--                    <input type="text" name="fabricCode" class="form-control" placeholder="كود القماش">--}}
            {{--                    <ul class="errors">--}}
            {{--                        @foreach ($errors->get('fabricCode') as $message)--}}
            {{--                            <i>{{ $message }}</i>--}}
            {{--                        @endforeach--}}
            {{--                    </ul>--}}
            {{--                </div>--}}
            {{--            </div>--}}


            {{--            <div class="col-xs-12 col-sm-12 col-md-4">--}}
            {{--                <div class="form-group">--}}
            {{--                    <strong>رقم السيري :</strong>--}}
            {{--                    <input type="text" name="siresNumber" class="form-control" placeholder="رقم السيري">--}}
            {{--                    <ul class="errors">--}}
            {{--                        @foreach ($errors->get('siresNumber') as $message)--}}
            {{--                            <i>{{ $message }}</i>--}}
            {{--                        @endforeach--}}
            {{--                    </ul>--}}
            {{--                </div>--}}
            {{--            </div>--}}

            {{--            <div class="col-xs-12 col-sm-12 col-md-4">--}}
            {{--                <div class="form-group">--}}
            {{--                    <strong>رقم العنصر :</strong>--}}
            {{--                    <input type="text" name="itemsNumber" class="form-control" placeholder="رقم العنصر">--}}
            {{--                    <ul class="errors">--}}
            {{--                        @foreach ($errors->get('itemsNumber') as $message)--}}
            {{--                            <i>{{ $message }}</i>--}}
            {{--                        @endforeach--}}
            {{--                    </ul>--}}
            {{--                </div>--}}
            {{--            </div>--}}


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

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>صورة1 :</strong>
                    <input type="file" name="image" id="image1" class="form-control" placeholder="صورة"   accept="image/*">
                    <ul class="errors">
                        @foreach ($errors->get('image') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
                @if($order->image)
                    <img id="img1" src="data:image/jpeg;base64,{{ base64_encode(Storage::disk('img')->get($order->image)) }}" class="imgPreview">
                @endif
            </div>




            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>صورة2 :</strong>
                    <input type="file" name="image2" id="image2" class="form-control" placeholder="صورة"   accept="image/*">
                    <ul class="errors">
                        @foreach ($errors->get('image2') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
                @if($order->image2)
                    <img id="img2" src="data:image/jpeg;base64,{{ base64_encode(Storage::disk('img')->get($order->image2)) }}" class="imgPreview">
                @endif
            </div>


            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>صورة3 :</strong>
                    <input type="file" name="image3" id="image3" class="form-control" placeholder="صورة"   accept="image/*">
                    <ul class="errors">
                        @foreach ($errors->get('image3') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
                @if($order->image3)
                    <img id="img3" src="data:image/jpeg;base64,{{ base64_encode(Storage::disk('img')->get($order->image3)) }}" class="imgPreview">
                @endif
            </div>




            <div class="col-xs-12 col-sm-6 col-md-6">
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


            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>ملاحظات الطباعة :</strong>
                    <textarea form="orderForm" type="text" name="PrintNotes" class="form-control" rows="3" placeholder="ملاحظات الطباعة">{{$order->PrintNotes}}</textarea>
                    <ul class="errors">
                        @foreach ($errors->get('PrintNotes') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>


            {{--            <div class="col-xs-12 col-sm-12 col-md-4">--}}
            {{--                <div class="form-check">--}}
            {{--                    <strong>تم :</strong>--}}
            {{--                    <label class="form-check-label" for="defaultCheck1">--}}
            {{--                       تم الاستلام :--}}
            {{--                    </label>--}}
            {{--                    <input type="checkbox" name="done" class="form-check-input" placeholder="تم">--}}
            {{--                    <ul class="errors">--}}
            {{--                        @foreach ($errors->get('done') as $message)--}}
            {{--                            <i>{{ $message }}</i>--}}
            {{--                        @endforeach--}}
            {{--                    </ul>--}}
            {{--                </div>--}}
            {{--            </div>--}}


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




    <script>

        jQuery("#status").fadeIn();
        jQuery("#preloader").delay(350).fadeIn("slow");
        jQuery("body").delay(350).css({ overflow: "visible" });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "get",
            url: "http://{{request()->getHttpHost()}}"+"/api/getFabrics/?order="+ {{$order->id}},
            success: function (data) {
                console.log(data.value);
                var dataa = data.data;


                $('#fabricSelect').html('');
                autocomplete = new SelectPure(".autocomplete-select", {
                    options:dataa,
                    value: data.value.join().split(','),
                    multiple: true,
                    autocomplete: true,
                    icon: "fa fa-times",
                    onChange: value => {
                        //var o = new Option("option text", value);
                        //$("#ff").append(o);
                        /*console.log(value);*/

                    },
                    classNames: {
                        select: "select-pure__select",
                        dropdownShown: "select-pure__select--opened",
                        multiselect: "select-pure__select--multiple",
                        label: "select-pure__label",
                        placeholder: "select-pure__placeholder",
                        dropdown: "select-pure__options",
                        option: "select-pure__option",
                        autocompleteInput: "select-pure__autocomplete",
                        selectedLabel: "select-pure__selected-label",
                        selectedOption: "select-pure__option--selected",
                        placeholderHidden: "select-pure__placeholder--hidden",
                        optionHidden: "select-pure__option--hidden",
                    }
                });
                // options = data;

                // $('#fabricModal').modal('toggle');
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


    </script>

@endsection
