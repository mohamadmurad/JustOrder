@extends('layout.layout')

@section('content')


    @include('layout.title',[
    'url' => 'type.create',
    'urlTitle' => 'انشاء صنف جديد',
    'title'=>'إدارة الاصناف'
    ])

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>الصنف</th>
{{--            <th>MGR</th>--}}
            <th width="280px">Action</th>
        </tr>
        <?php $i = 0?>
        @foreach ($types as $type)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $type->name }}</td>
{{--                <td>{{ $type->MGR }}</td>--}}

                <td>
                    <form action="{{ route('type.destroy',$type->id) }}" method="POST">

{{--                        <a class="btn btn-info" href="{{ route('color.show',$color->id) }}">Show</a>--}}

                        <a class="btn btn-primary" href="{{ route('type.edit',$type->id) }}">تعديل</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center">
    {!! $types->links() !!}
    </div>

@endsection
