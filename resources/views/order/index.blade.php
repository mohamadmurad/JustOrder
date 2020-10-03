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

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Barcode</th>
            <th width="280px">خيارات</th>
        </tr>
        <?php $i = 0?>
        @foreach ($orders as $order)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $order->barcode }}</td>

                <td>
                    <form action="{{ route('order.destroy',$order->id) }}" method="POST">

                        <a class="btn btn-info" href="{{ route('order.show',$order->id) }}">عرض</a>

{{--                        <a class="btn btn-primary" href="{{ route('order.edit',$order->id) }}">تعديل</a>--}}

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center">
    {!! $orders->links() !!}
    </div>

@endsection
