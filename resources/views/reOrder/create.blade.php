@extends('layout.layout')

@section('content')


    @include('layout.title',[
   'url' => 'home',
   'urlTitle' => 'رجوع',
   'title'=>'  إعادة طلب ' . $order->barcode
   ])


    @if ($errors->any())
        <div class="alert alert-danger">
            هناك مشكلة في الحقول

        </div>
    @endif

    <form action="{{ route('reOrder.store') }}" method="POST" id="orderForm"  enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="order_id" value="{{$order->id}}">
        <div class="row">




            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>عدد الالوان في السيري :</strong>
                    <input type="number" id="siresColorQty" min="1" name="siresColorQty" class="form-control" placeholder="عدد الالوان في السيري"  value="{{old('siresColorQty')}}">
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
                    <input type="number" id="siresSizeQty" min="1" name="siresSizeQty" class="form-control" placeholder="عدد القياسات في السيري" value="{{old('siresSizeQty')}}">
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
                    <input type="number" id="siresQty" name="siresQty" class="form-control" placeholder="عدد السيريات">
                    <ul class="errors">
                        @foreach ($errors->get('siresQty') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 text-right">
                <p id="">عدد القطع في السيري : <span id="siresItemNumber"></span></p>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 text-right">
                <p id="">الكمية : <span id="quantity"></span></p>
            </div>




            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong style="color:red">تاريخ الطلب :</strong>
                    <input type="date" name="orderDate" class="form-control" placeholder="تاريخ الطلب">
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
                    <input type="date" name="fabricDate" class="form-control" placeholder="تاريخ تسليم القماش">
                    <ul class="errors">
                        @foreach ($errors->get('fabricDate') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

{{--            <div class="col-xs-12 col-sm-12 col-md-4">--}}
{{--                <div class="form-group">--}}
{{--                    <strong>كود القماش الجديد :</strong>--}}
{{--                    <input type="text" id="fabricCode" name="fabricCode" class="form-control" placeholder="كود القماش الجديد"  value="{{old('fabricCode')}}">--}}
{{--                    <ul class="errors">--}}
{{--                        @foreach ($errors->get('fabricCode') as $message)--}}
{{--                            <i>{{ $message }}</i>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>ملاحظات :</strong>
                    <textarea form="orderForm" type="text" name="notes" class="form-control" rows="3" placeholder="ملاحظات">{{old('notes')}}</textarea>
                    <ul class="errors">
                        @foreach ($errors->get('notes') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 text-center">
                <div class="form-group">
                    <strong>صورة1 :</strong>

                    <input type="file" name="image" id="image1" class="form-control" placeholder="صورة"   accept="image/*" >
                    <ul class="errors">
                        @foreach ($errors->get('image') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
                <img id="img1" class="imgPreview">
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

                    <input class="form-check-input" type="checkbox" name="sizes[]" value="{{$size->id}}" id="defaultCheck1" {{ (is_array(old('sizes')) and in_array($size->id, old('sizes'))) ? ' checked' : '' }}>
                    <label class="form-check-label" for="defaultCheck1">
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
                        <input class="form-check-input" type="checkbox" name="colors[]" value="{{$color->id}}" id="defaultCheck1" {{ (is_array(old('colors')) and in_array($color->id, old('colors'))) ? ' checked' : '' }}>
                        <label class="form-check-label" for="defaultCheck1">
                            {{$color->name}}
                        </label>
                    </div>
                @endforeach

            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">إنشاء</button>
            </div>
        </div>

    </form>
    <div class="toast" id="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <img src="..." class="rounded mr-2" alt="...">
            <strong class="mr-auto">Bootstrap</strong>
            <small>11 mins ago</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            Hello, world! This is a toast message.
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="fabricModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة نوع قماش</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  id="addFabric">
                        @csrf

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>نوع القماش:</strong>
                                    <input type="text" name="name" id="fabricName" class="form-control" placeholder="نوع القماش">
                                    <ul class="errors">
                                        @foreach ($errors->get('name') as $message)
                                            <i>{{ $message }}</i>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>كود القماش:</strong>
                                    <input type="text" name="code" id="fabricCode" class="form-control" placeholder="كود القماش">
                                    <ul class="errors">
                                        @foreach ($errors->get('code') as $message)
                                            <i>{{ $message }}</i>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>

                </div>
            </div>
        </div>
    </div>


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
            url: "http://{{request()->getHttpHost()}}"+"/api/getFabrics/",
            success: function (data) {

                var data = data.data;

                $('#fabricSelect').html('');
                autocomplete = new SelectPure(".autocomplete-select", {
                    options:data,
                    //value: ["15"],
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
