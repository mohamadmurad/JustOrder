@extends('layout.layout')

@section('content')


    @include('layout.title',[
    'url' => 'color.create',
    'urlTitle' => 'انشاء لون جديد',
    'title'=>'إدارة الالوان'
    ])

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>اللون</th>
            @if (Auth::user()->isAdmin == 1)
                <th width="280px">خيارات</th>
                @endif

        </tr>
        <?php $i = 0?>
        @foreach ($colors as $color)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $color->name }}</td>
                @if (Auth::user()->isAdmin == 1)
                    <td>
                        <form action="{{ route('color.destroy',$color->id) }}" method="POST">

                            {{--                        <a class="btn btn-info" href="{{ route('color.show',$color->id) }}">Show</a>--}}

                            <a class="btn btn-primary" href="{{ route('color.edit',$color->id) }}">تعديل</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                    </td>
                    @endif

            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center">
    {!! $colors->links() !!}
    </div>

@endsection
