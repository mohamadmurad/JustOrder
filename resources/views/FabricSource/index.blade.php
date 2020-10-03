@extends('layout.layout')

@section('content')


    @include('layout.title',[
   'url' => 'FabricSource.create',
   'urlTitle' => 'انشاء مصدر قماش',
   'title'=>'إدارة مصادر القماش'
   ])

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>المصدر</th>
            <th width="280px">خيارات</th>
        </tr>
        <?php $i = 0?>
        @foreach ($FabricSources as $FabricSource)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $FabricSource->name }}</td>

                <td>
                    <form action="{{ route('FabricSource.destroy',$FabricSource->id) }}" method="POST">

{{--                        <a class="btn btn-info" href="{{ route('color.show',$color->id) }}">Show</a>--}}

                        <a class="btn btn-primary" href="{{ route('FabricSource.edit',$FabricSource->id) }}">تعديل</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center">
    {!! $FabricSources->links() !!}
    </div>

@endsection
