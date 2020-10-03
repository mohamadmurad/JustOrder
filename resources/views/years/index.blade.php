@extends('layout.layout')

@section('content')


    @include('layout.title',[
    'url' => 'years.create',
    'urlTitle' => 'انشاء سنة جديدة',
    'title'=>'إدارة سنة'
    ])



    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>الاسم</th>
            <th width="280px">خيارات</th>
        </tr>
        <?php $i = 0?>
        @foreach ($years as $year)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $year->name }}</td>

                <td>
                    <form action="{{ route('years.destroy',$year->id) }}" method="POST">

{{--                        <a class="btn btn-info" href="{{ route('color.show',$color->id) }}">Show</a>--}}

                        <a class="btn btn-primary" href="{{ route('years.edit',$year->id) }}">تعديل</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center">
    {!! $years->links() !!}
    </div>

@endsection
