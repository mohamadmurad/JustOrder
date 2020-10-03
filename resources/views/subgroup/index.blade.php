@extends('layout.layout')

@section('content')

    @include('layout.title',[
   'url' => 'subgroup.create',
   'urlTitle' => 'انشاء مجموعة فرعية جديدة',
   'title'=>'إدارة المجموعات الفرعية'
   ])


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>المجموعة الفرعية</th>
            <th>المجموعة</th>
            <th width="280px">خيارات</th>
        </tr>
        <?php $i = 0?>
        @foreach ($subgroups as $subgroup)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $subgroup->name }}</td>

                @if($subgroup->group )
                    <td>{{ $subgroup->group->name }}</td>
                @else
                    <td>-</td>
                @endif



                <td>
                    <form action="{{ route('subgroup.destroy',$subgroup->id) }}" method="POST">

{{--                        <a class="btn btn-info" href="{{ route('color.show',$color->id) }}">Show</a>--}}

                        <a class="btn btn-primary" href="{{ route('subgroup.edit',$subgroup->id) }}">تعديل</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center">
    {!! $subgroups->links() !!}
    </div>
@endsection
