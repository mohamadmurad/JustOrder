@extends('layout.layout')

@section('content')

    @include('layout.title',[
   'url' => 'season.create',
   'urlTitle' => 'انشاء فصل جديد',
   'title'=>'إدارة الفصول'
   ])



    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>الفصل</th>
{{--            <th>البداية</th>--}}
{{--            <th>النهاية</th>--}}
{{--            <th>السنة</th>--}}
            <th width="280px">خيارات</th>
        </tr>
        <?php $i = 0?>
        @foreach ($seasons as $season)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $season->name }}</td>
{{--                <td>{{ $season->start->format('Y-m-d') }}</td>--}}
{{--                <td>{{ $season->end->format('Y-m-d') }}</td>--}}

{{--                @if($season->year )--}}
{{--                    <td>{{ $season->year->name }}</td>--}}
{{--                @else--}}
{{--                    <td>-</td>--}}
{{--                @endif--}}



                <td>
                    <form action="{{ route('season.destroy',$season->id) }}" method="POST">

{{--                        <a class="btn btn-info" href="{{ route('color.show',$color->id) }}">Show</a>--}}

                        <a class="btn btn-primary" href="{{ route('season.edit',$season->id) }}">تعديل</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center">
    {!! $seasons->links() !!}
    </div>
@endsection
