@extends('layout.layout')

@section('content')



    @include('layout.title',[
   'url' => 'fabric.create',
   'urlTitle' => 'انشاء قماش جديد',
   'title'=>'إدارة الاقمشة'
   ])

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>القماش</th>
            <th>الكود</th>
            <th width="280px">خيارات</th>
        </tr>
        <?php $i = 0?>
        @foreach ($fabrics as $fabric)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $fabric->name }}</td>
                <td>{{ $fabric->code }}</td>

                <td>
                    <form action="{{ route('fabric.destroy',$fabric->id) }}" method="POST">

{{--                        <a class="btn btn-info" href="{{ route('color.show',$color->id) }}">Show</a>--}}

                        <a class="btn btn-primary" href="{{ route('fabric.edit',$fabric->id) }}">تعديل</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger delete_btn">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center">
    {!! $fabrics->links() !!}
    </div>

@endsection
