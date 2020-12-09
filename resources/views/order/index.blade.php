@extends('layout.layout')

@section('content')

    @if ($message = Session::get('search'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-right">
                <h2>إدارة الطلبات</h2>
            </div>
            <div class="float-left">
                <a class="btn btn-success" href="{{ route('order.create') }}">طلب جديد</a>
            </div>
        </div>
    </div>


    <form action="{{ route('searchOrder') }}" method="POST">
        @csrf
        <div class="form-row align-items-center">
            <div class="col-auto">
                <label class="sr-only" for="inlineFormInput">d</label>
                <input type="search" name="barcode"  class="form-control mb-2" id="inlineFormInput" placeholder="Barcode">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-2">بحث</button>
            </div>
        </div>
    </form>



    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <div class="d-flex justify-content-center">
        عدد الكميات المطلوبة لكل الطلبات {!! $totalOrderQty !!}
    </div>

    <div class="d-flex justify-content-center">
        عدد الكميات المستلمة لكل الطلبات {!! $totalOrderreceivedQty !!}
    </div>
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Barcode</th>
{{--            @if(\Illuminate\Support\Facades\Auth::user()->isAdmin)--}}
                <th>user</th>
{{--            @endif--}}

            <th width="280px">خيارات</th>
        </tr>
        <?php $i = 0?>
        @foreach ($orders as $order)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $order->barcode }}</td>
{{--                @if(\Illuminate\Support\Facades\Auth::user()->isAdmin)--}}
                    <td>{{ $order->user->name }}</td>
{{--                @endif--}}


                <td>
                    <form action="{{ route('order.destroy',$order->id) }}" method="POST" style="display: inline;">

                        <a class="btn btn-info" href="{{ route('order.show',$order->id) }}">عرض</a>

                        <a class="btn btn-primary" href="{{ route('order.edit',$order->id) }}">تعديل</a>


                        <a class="btn btn-info" href="{{ route('reOrder.create',[
                        'order' => $order->id,
]) }}">اعادة طلب</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                    @if($order->receivedQty === 0)
                    <form action="{{ route('orderDone') }}" method="POST" id="receivedForm" >

                        @csrf
                        <input type="hidden" value="{{$order->id}}" name="order">
                        <input type="number" class="form-control col-md-6" name="receivedQty" style="min-width:  auto;" min="1"
{{--                               max="{{($order->quantity - $order->receivedQty)}}" --}}
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
    <div class="d-flex justify-content-center">
    {!! $orders->links() !!}

    </div>
    <div class="d-flex justify-content-center">
        العدد الكلي {!! $orders->total() !!}
    </div>




@endsection
