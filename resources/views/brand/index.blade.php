@extends('layout.layout')

@section('content')


    @include('layout.title',[
   'url' => 'brand.create',
   'urlTitle' => 'انشاء ماركة جديدة',
   'title'=>'إدارة الماركات'
   ])

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>الماركة</th>
            <th>كود</th>
            <th width="280px">الخيارات</th>
        </tr>
        <?php $i = 0?>
        @foreach ($brands as $brand)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $brand->name }}</td>
                <td>{{ $brand->code }}</td>

                <td>
                    <form action="{{ route('brand.destroy',$brand->id) }}" method="POST">

{{--                        <a class="btn btn-info" href="{{ route('color.show',$color->id) }}">Show</a>--}}

                        <a class="btn btn-primary" href="{{ route('brand.edit',$brand->id) }}">تعديل</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center">
    {!! $brands->links() !!}
    </div>

@endsection
