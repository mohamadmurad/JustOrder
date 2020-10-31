@extends('layout.layout')

@section('content')


    @include('layout.title',[
    'url' => 'departments.create',
    'urlTitle' => 'انشاء قسم جديد',
    'title'=>'إدارة الاقسام'
    ])

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>القسم</th>
            <th width="280px">خيارات</th>
        </tr>
        <?php $i = 0?>
        @foreach ($departments as $department)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $department->name }}</td>

                <td>
                    <form action="{{ route('departments.destroy',$department->id) }}" method="POST">

{{--                        <a class="btn btn-info" href="{{ route('color.show',$color->id) }}">Show</a>--}}

                        <a class="btn btn-primary" href="{{ route('departments.edit',$department->id) }}">تعديل</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center">
    {!! $departments->links() !!}
    </div>

@endsection
