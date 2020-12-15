@extends('layout.layout')

@section('content')

    @auth
    <form action="{{ route('orderReport') }}" method="POST" id="reportForm">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>ماركة :</strong>
                    <select  class="form-control"  name="brand_id" id="reportBrand">
                        <option value="0">الكل</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{$brand->name . " | " . $brand->code}}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>السنة:</strong>
                    <select  class="form-control"  name="year_id" id="reportYear">
                        <option value="0">الكل</option>
                        @foreach($years as $year)
                            <option value="{{ $year->id }}">{{$year->name}}</option>
                        @endforeach
                    </select>


                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>النوع:</strong>
                    <select  class="form-control"  name="type_id" id="reportType">
                        <option value="0">الكل</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{$type->name}}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>المجموعة:</strong>
                    <select  class="form-control"  name="group_id" id="group"  id="reportGroup">
                        <option value="0">الكل</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{$group->name}}</option>
                        @endforeach
                    </select>


                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>المجموعة الفرعية:</strong>
                    <select  class="form-control"  name="subgroup_id" id="subgroup" id="reportSuGroup">
                        <option value="0">الكل</option>

                        @foreach($subgroups as $subgroup)
                            <option value="{{ $subgroup->id }}">{{$subgroup->name}}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>الفصل:</strong>
                    <select  class="form-control"  name="season_id" id="reportSeason">
                        <option value="0">الكل</option>
                        @foreach($seasons as $season)
                            <option value="{{ $season->id }}">{{$season->name}}</option>
                        @endforeach
                    </select>


                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>المورد :</strong>
                    <select  class="form-control"  name="supplier_id" id="reportSubblier">
                        <option value="0">الكل</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{$supplier->name . ' | ' . $supplier->code}}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong style="color:red">مصدر القماش :</strong>
                    <select  class="form-control"  name="fabricSource_id" id="reportFabricSource">
                        <option value="0">الكل</option>
                        @foreach($fabricSources as $fabricSource)
                            <option value="{{ $fabricSource->id }}">{{$fabricSource->name}}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong >نوع القماش :</strong>
                    <select  class="form-control"  name="fabric_id" id="reportFabric">
                        <option value="0">الكل</option>
                        @foreach($fabrics as $fabric)
                            <option value="{{ $fabric->id }}">{{$fabric->name . " | " . $fabric->code }}</option>
                        @endforeach
                    </select>


                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="exampleRadios1" name="done" value="all" checked>
                    <label class="form-check-label" for="exampleRadios1">
                        الكل
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="exampleRadios2" name="done" value="0">
                    <label class="form-check-label" for="exampleRadios2">
                        غير مستلمة
                    </label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="exampleRadios3" name="done" value="1">
                    <label class="form-check-label" for="exampleRadios3">
                        مستلمة
                    </label>
                </div>
            </div>

            <input type="hidden" value="{{Auth::id()}}" name="Auth_id">


            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> بحث</button>
            </div>
        </div>
     </form>
    <br>
    <button id="export">Export to excel</button>
<div id="reportResult">
    <table class="table table-bordered" id="datatable" data-excel-name="A very important table">
        <tr>
            <th>#</th>
            <th>باركود</th>
            <th>نوع الطلب</th>
            <th>حالة الاستلام</th>

                            <th width="280px" class="noExport">خيارات</th>
        </tr>
        <tbody id="reportBody">

        </tbody>

    </table>
</div>
    @if(isset($report))
        <br>
        <button id="export">Export to excel</button>

        <table class="table table-bordered" id="datatable" data-excel-name="A very important table">
            <tr>
                <th>#</th>
                <th>باركود</th>
                <th>حالة الاستلام</th>
                <th width="280px" class="noExport">خيارات</th>
            </tr>
            <?php $i = 0?>
            @foreach ($orders as $order)
                <tr>
                    <td class="noExport">{{ ++$i }}</td>
                    <td>{{ $order->barcode }}</td>
                    @if($order->done == 0)
                        <td>لم يتم الاستلام</td>
                        @else
                        <td>تم الاستلام</td>
                        @endif

                    <td class="noExport">
                        <form action="{{ route('order.destroy',$order->id) }}" method="POST">

                            <a class="btn btn-info" href="{{ route('order.show',$order->id) }}">عرض</a>

                            <a class="btn btn-primary" href="{{ route('order.edit',$order->id) }}">تعديل</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                        @if($order->done === 0)
                            <form action="{{ route('orderDone') }}" method="POST" id="receivedForm" >

                                @csrf
                                <input type="hidden" value="{{$order->id}}" name="order">
                                <input type="number" class="form-control col-md-6" name="receivedQty"  style="min-width: auto;" min="1" max="{{$order->reservedQuantity}}" placeholder="الكمية المستلمة">
                                <button type="submit" class="btn btn-primary" id="recive">استلام</button>
                                @foreach ($errors->get('receivedQty') as $message)
                                    <i>{{ $message }}</i>
                                @endforeach
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="d-flex justify-content-center">
{{--        {!! $orders->links() !!}--}}
        </div>
    @endif
    @else

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button class="btn btn-primary"><a href="{{route('login')}}">تسجيل الدخول</a></button>
        </div>
    @endauth



@endsection
