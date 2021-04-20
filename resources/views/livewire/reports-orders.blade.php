<div>


    <form wire:submit.prevent="submit" method="post">

        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>ماركة :</strong>
                    <select class="form-control" name="brand_id" id="reportBrand" wire:model="sel_brand">
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
                    <select class="form-control" name="year_id" id="reportYear" wire:model="sel_year">
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
                    <select class="form-control" name="type_id" id="reportType" wire:model="sel_type">
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
                    <select class="form-control" name="group_id" id="reportGroup" wire:model="sel_group">
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
                    <select class="form-control" name="subgroup_id" id="subgroup" id="reportSuGroup"
                            wire:model="sel_subgroup">
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
                    <select class="form-control" name="season_id" id="reportSeason" wire:model="sel_season">
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
                    <select class="form-control" name="supplier_id" id="reportSubblier" wire:model="sel_supplier">
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
                    <select class="form-control" name="fabricSource_id" id="reportFabricSource"
                            wire:model="sel_fabricSource">
                        <option value="0">الكل</option>
                        @foreach($fabricSources as $fabricSource)
                            <option value="{{ $fabricSource->id }}">{{$fabricSource->name}}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>نوع القماش :</strong>
                    <select class="form-control" name="fabric_id" id="reportFabric" wire:model="sel_fabric">
                        <option value="0">الكل</option>
                        @foreach($fabrics as $fabric)
                            <option value="{{ $fabric->id }}">{{$fabric->name . " | " . $fabric->code }}</option>
                        @endforeach
                    </select>


                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="exampleRadios1" name="done" value="all" checked
                           wire:model="sel_done">
                    <label class="form-check-label" for="exampleRadios1">
                        الكل
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="exampleRadios2" name="done" value="0"
                           wire:model="sel_done">
                    <label class="form-check-label" for="exampleRadios2">
                        غير مستلمة
                    </label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="exampleRadios3" name="done" value="1"
                           wire:model="sel_done">
                    <label class="form-check-label" for="exampleRadios3">
                        مستلمة
                    </label>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> بحث</button>

                <button id="export" class="btn btn-success"  onclick="exportReportToExcel(this)" style="margin-bottom: 12px;">
                    <i class="far fa-file-excel"></i>
                    تصدير الى اكسل
                </button>
            </div>
        </div>
    </form>

    @if($orders && count($orders) > 0)
        <div class="row mt-5">
            <div class="col">
                <p class="text-center">الطلبات </p>
                <table class="table table-bordered" id="datatable" data-excel-name="A very important table">
                    <tr>
                        <th>#</th>
                        <th>باركود</th>
                        <th>النوع</th>
                        <th>المجموعة</th>
                        <th>المجموعة الفرعية</th>
                        <th>تركيبة القماش</th>
                        <th>حالة الاستلام</th>
                        <th>الكمية المطلوبة</th>
                        <th>الكمية المستلمة</th>
                        <th width="280px" class="noExport" data-exclude="true">خيارات</th>
                    </tr>
                    <?php $i = 0?>

                    @foreach ($orders as $order)
                        <tr>
                            <td class="noExport">{{ ++$i }}</td>
                            <td>{{ $order->barcode }}</td>
                            <td>{{ $order->type->name }}</td>
                            <td>{{ $order->group->name }}</td>
                            <td>{{ $order->subgroup->name }}</td>
                            <td>{{ $order->fabricFormula }}</td>

                            @if($order->done == 0)
                                <td>لم يتم الاستلام</td>
                            @else
                                <td>تم الاستلام</td>
                            @endif
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->receivedQty }}</td>
                            <td class="noExport" data-exclude="true">
                                <form action="{{ route('order.destroy',$order->id) }}" method="POST">

                                    <a class="btn btn-info" href="{{ route('order.show',$order->id) }}"><i
                                            class="fa fa-eye"></i></a>

                                    <a class="btn btn-primary" href="{{ route('order.edit',$order->id) }}"><i
                                            class="fa fa-edit"></i></a>


                                    <button type="submit" class="btn btn-danger" style="margin-bottom: 12px;">

                                        <i class="fa fa-trash"></i></button>
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @if($order->done === 0)
                                    <form action="{{ route('orderDone') }}" method="POST" id="receivedForm">

                                        @csrf
                                        <input type="hidden" value="{{$order->id}}" name="order">
                                        <input type="number" class="form-control col-md-6" name="receivedQty"
                                               style="min-width: auto;"
                                               placeholder="الكمية المستلمة">
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
            </div>
            <div class="col">
                <p class="text-center">الطلبات المعادة</p>
                <table class="table table-bordered" id="datatable2" data-excel-name="A very important table">
                    <tr>
                        <th>#</th>
                        <th>باركود</th>
                        <th>رقم الاعادة</th>
                        <th>النوع</th>
                        <th>المجموعة</th>
                        <th>المجموعة الفرعية</th>
                        <th>تركيبة القماش</th>
                        <th>حالة الاستلام</th>
                        <th>الكمية المطلوبة</th>
                        <th>الكمية المستلمة</th>
                        <th width="280px" class="noExport" data-exclude="true">خيارات</th>
                    </tr>
                    <?php $i = 0?>

                    @foreach ($reOrders as $order)
                        <tr>
                            <td class="noExport">{{ ++$i }}</td>
                            <td>{{ $order->order->barcode }}</td>
                            <td>{{ $order->re_order_number }} </td>
                            <td>{{ $order->order->type->name }}</td>
                            <td>{{ $order->order->group->name }}</td>
                            <td>{{ $order->order->subgroup->name }}</td>
                            <td>{{ $order->order->fabricFormula }}</td>
                            @if($order->done == 0)
                                <td>لم يتم الاستلام</td>
                            @else
                                <td>تم الاستلام</td>
                            @endif
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->receivedQty }}</td>
                            <td class="noExport" data-exclude="true">
                                <form action="{{ route('order.destroy',$order->id) }}" method="POST">

                                    <a class="btn btn-info" href="{{ route('reOrder.show',$order->id) }}"><i
                                            class="fa fa-eye"></i></a>

                                    <a class="btn btn-primary" href="{{ route('reOrder.edit',$order->id) }}"><i
                                            class="fa fa-edit"></i></a>


                                    <button type="submit" class="btn btn-danger" style="margin-bottom: 12px;">

                                        <i class="fa fa-trash"></i></button>
                                    @csrf
                                    @method('DELETE')


                                </form>
                                @if($order->done === 0)
                                    <form action="{{ route('reOrderDone') }}" method="POST" id="receivedForm">

                                        @csrf
                                        <input type="hidden" value="{{$order->id}}" name="order">
                                        <input type="number" class="form-control col-md-6" name="receivedQty"
                                               style="min-width: auto;"
                                               placeholder="الكمية المستلمة">
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
            </div>


        </div>


    @else
        <div class="text-center mt-5">

            <i class="fa fa-minus"></i>

            <h5>لا يوجد نتائج</h5>

        </div>
    @endif
</div>
