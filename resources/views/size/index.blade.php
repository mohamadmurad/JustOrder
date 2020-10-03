@extends('layout.layout')

@section('content')

    @include('layout.title',[
   'url' => 'size.create',
   'urlTitle' => 'انشاء قياس جديد',
   'title'=>'إدارة القياسات'
   ])


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>القياس</th>
            <th>الكود</th>
            <th width="280px">خيارات</th>
        </tr>
        <?php $i = 0?>
        @foreach ($sizes as $size)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $size->name }}</td>
                <td>{{ $size->code }}</td>

                <td>
                    <form action="{{ route('size.destroy',$size->id) }}" method="POST">

{{--                        <a class="btn btn-info" href="{{ route('color.show',$color->id) }}">Show</a>--}}

                        <a class="btn btn-primary" href="{{ route('size.edit',$size->id) }}">تعديل</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center">
    {!! $sizes->links() !!}
    </div>

@endsection
