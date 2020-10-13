@extends('layout.layout')

@section('content')

    @include('layout.title',[
   'url' => 'group.create',
   'urlTitle' => 'انشاء مجموعة جديدة',
   'title'=>'إدارة المجموعات'
   ])

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>

            <th>المجموعة</th>
            <th>الصنف</th>
            <th width="280px">خيارات</th>
        </tr>
        <?php $i = 0?>
        @foreach ($groups as $group)
            <tr>
                <td>{{ ++$i }}</td>

                <td>{{ $group->name }}</td>

                @if($group->type )
                    <td>{{ $group->type->name }}</td>
                @else
                    <td>-</td>
                @endif



                <td>
                    <form action="{{ route('group.destroy',$group->id) }}" method="POST">

{{--                        <a class="btn btn-info" href="{{ route('color.show',$color->id) }}">Show</a>--}}

                        <a class="btn btn-primary" href="{{ route('group.edit',$group->id) }}">تعديل</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center">
    {!! $groups->links() !!}
    </div>
@endsection
