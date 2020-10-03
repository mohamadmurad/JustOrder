@extends('layout.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">

                <div class="float-right">
                    <h2>إضافة طلب جديد :</h2>
                </div>
                <div class="float-left">
                    <a class="btn btn-primary" href="http://localhost:8000/order"> رجوع</a>
                </div>

        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>

        </div>
    @endif

    <form action="{{ route('order.store') }}" method="POST" id="orderForm"  enctype="multipart/form-data">
        @csrf

        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>ماركة :</strong>
                    <select  class="form-control"  name="brand_id">
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{$brand->name . " | " . $brand->code}}</option>
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
                            <option value="{{ $year->id }}">{{$year->name}}</option>
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
                            <option value="{{ $type->id }}">{{$type->name}}</option>
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
                    <select  class="form-control"  name="group_id">
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{$group->name}}</option>
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
                    <select  class="form-control"  name="subgroup_id">
                        @foreach($subgroups as $subgroup)
                            <option value="{{ $subgroup->id }}">{{$subgroup->name}}</option>
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
                            <option value="{{ $season->id }}">{{$season->name}}</option>
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
                            <option value="{{ $supplier->id }}">{{$supplier->name . ' | ' . $supplier->code}}</option>
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
                    <strong style="color:red">مصدر القماش :</strong>
                    <select  class="form-control"  name="fabricSource_id">
                        @foreach($fabricSources as $fabricSource)
                            <option value="{{ $fabricSource->id }}">{{$fabricSource->name}}</option>
                        @endforeach
                    </select>
                    <ul class="errors">
                        @foreach ($errors->get('fabricSource_id') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>

                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong >نوع القماش :</strong>
                    <select  class="form-control"  name="fabric_id">
                        @foreach($fabrics as $fabric)
                            <option value="{{ $fabric->id }}">{{$fabric->name . " | " . $fabric->code }}</option>
                        @endforeach
                    </select>
                    <ul class="errors">
                        @foreach ($errors->get('fabric_id') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>

                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>تركيبة القماش :</strong>
                    <input type="text" name="fabricFormula" class="form-control" placeholder="تركيبة القماش">
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
                    <input type="number" min="1" name="siresColorQty" class="form-control" placeholder="عدد الالوان في السيري">
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
                    <input type="number" min="1" name="siresSizeQty" class="form-control" placeholder="عدد القياسات في السيري">
                    <ul class="errors">
                        @foreach ($errors->get('siresSizeQty') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

{{--            <div class="col-xs-12 col-sm-12 col-md-4">--}}
{{--                <div class="form-group">--}}
{{--                    <strong>عدد كلي :</strong>--}}
{{--                    <input type="number" name="quantity" class="form-control" placeholder="عدد كلي">--}}
{{--                    <ul class="errors">--}}
{{--                        @foreach ($errors->get('quantity') as $message)--}}
{{--                            <i>{{ $message }}</i>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}



            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>الكمية المطلوبة :</strong>
                    <input type="number" min="1" name="reservedQuantity" class="form-control" placeholder="الكمية المطلوبة ">
                    <ul class="errors">
                        @foreach ($errors->get('reservedQuantity') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>الكمية المستلمة :</strong>
                    <input type="number" min="1" name="receivedQty" class="form-control" placeholder="الكمية المستلمة ">
                    <ul class="errors">
                        @foreach ($errors->get('receivedQty') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>اسم الموديل :</strong>
                    <input type="text" name="modelName" class="form-control" placeholder="اسم الموديل">
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
                    <input type="text" name="modelDesc" class="form-control" placeholder="مواصفات الموديل">
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


{{--            <div class="col-xs-12 col-sm-12 col-md-4">--}}
{{--                <div class="form-group">--}}
{{--                    <strong>تاريخ الطلب :</strong>--}}
{{--                    <input type="date" name="orderDate" class="form-control" placeholder="تاريخ الطلب">--}}
{{--                    <ul class="errors">--}}
{{--                        @foreach ($errors->get('orderDate') as $message)--}}
{{--                            <i>{{ $message }}</i>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}


            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>تاريخ الاستلام :</strong>
                    <input type="date" name="reservedDate" class="form-control" placeholder="تاريخ الاستلام">
                    <ul class="errors">
                        @foreach ($errors->get('reservedDate') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>صورة :</strong>
                    <input type="file" name="image" class="form-control" placeholder="صورة">
                    <ul class="errors">
                        @foreach ($errors->get('image') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>ملاحظات :</strong>
                    <textarea form="orderForm" type="text" name="notes" class="form-control" rows="3" placeholder="ملاحظات"></textarea>
                    <ul class="errors">
                        @foreach ($errors->get('notes') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-check">
{{--                    <strong>تم :</strong>--}}
                    <label class="form-check-label" for="defaultCheck1">
                       تم :
                    </label>
                    <input type="checkbox" name="done" class="form-check-input" placeholder="تم">
                    <ul class="errors">
                        @foreach ($errors->get('done') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                <strong>القياسات :</strong><br>
                @foreach($sizes as $size)
                <div class="form-check form-check-inline col-xs-2 col-sm-2 col-md-2">

                    <input class="form-check-input" type="checkbox" name="sizes[]" value="{{$size->id}}" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        {{$size->name}}
                    </label>
                </div>
                @endforeach
                <ul class="errors">
                    @foreach ($errors->get('done') as $message)
                        <i>{{ $message }}</i>
                    @endforeach
                </ul>
            </div>

{{--            <div class="col-xs-12 col-sm-12 col-md-12">--}}
{{--                <div class="inline field">--}}
{{--                    <strong>القياسات :</strong>--}}
{{--                    <select name="sizes[]" multiple="" class="form-control">--}}
{{--                        @foreach($sizes as $size)--}}
{{--                            <option value="{{ $size->id }}">{{$size->name}}</option>--}}

{{--                        @endforeach--}}
{{--                    </select>--}}

{{--                    <ul class="errors">--}}
{{--                        @foreach ($errors->get('sizes') as $message)--}}
{{--                            <i>{{ $message }}</i>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="col-xs-12 col-sm-12 col-md-12">
                <strong>الالوان :</strong><br>
                @foreach($colors as $color)
                    <div class="form-check form-check-inline col-xs-2 col-sm-2 col-md-2">
                        <input class="form-check-input" type="checkbox" name="colors[]" value="{{$color->id}}" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
                            {{$color->name}}
                        </label>
                    </div>
                @endforeach
                <ul class="errors">
                    @foreach ($errors->get('done') as $message)
                        <i>{{ $message }}</i>
                    @endforeach
                </ul>
            </div>


{{--            <div class="col-xs-12 col-sm-12 col-md-12">--}}
{{--                <div class="inline field">--}}
{{--                    <strong>الالوان :</strong>--}}
{{--                    <select name="colors[]" multiple="" class="form-control">--}}
{{--                        @foreach($colors as $color)--}}
{{--                            <option value="{{ $color->id }}">{{$color->name}}</option>--}}

{{--                        @endforeach--}}


{{--                    </select>--}}

{{--                    <ul class="errors">--}}
{{--                        @foreach ($errors->get('colors') as $message)--}}
{{--                            <i>{{ $message }}</i>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}





            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>

    </form>
@endsection
