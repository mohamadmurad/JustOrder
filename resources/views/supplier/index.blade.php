@extends('layout.layout')

@section('content')


    @include('layout.title',[
   'url' => 'supplier.create',
   'urlTitle' => 'انشاء مورد جديد',
   'title'=>'إدارة الموردون'
   ])

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>اسم المورد</th>
            <th>كود المورد</th>
            <th>عنوان المورد</th>
            <th>هاتف المورد</th>
            <th>ملاحظات</th>
            @if (Auth::user()->isAdmin == 1)
                <th width="280px">خيارات</th>
            @endif

        </tr>
        <?php $i = 0?>
        @foreach ($suppliers as $supplier)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $supplier->name }}</td>
                <td>{{ $supplier->code }}</td>
                <td>{{ $supplier->address !== null ? $supplier->address : '-' }}</td>
                <td>{{ $supplier->phone != null ? $supplier->phone : '-' }}</td>
                <td>{{ $supplier->notes != null ? $supplier->notes : '-' }}</td>
                @if (Auth::user()->isAdmin == 1)
                    <td>
                        <form action="{{ route('supplier.destroy',$supplier->id) }}" method="POST">

                            {{--                        <a class="btn btn-info" href="{{ route('color.show',$color->id) }}">Show</a>--}}

                            <a class="btn btn-primary" href="{{ route('supplier.edit',$supplier->id) }}">تعديل</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                    </td>
                @endif

            </tr>
        @endforeach
    </table>

    {!! $suppliers->links() !!}

@endsection
