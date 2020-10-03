@extends('layout.layout')

@section('content')


    @include('layout.title',[
    'url' => 'users.create',
    'urlTitle' => 'انشاء مستخدم جديد',
    'title'=>'إدارة المستخدمين'
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
            <th>اسم المستخدم</th>
            <th>الصلاحيات</th>
            <th>ip</th>
            <th>اخر ظهور</th>
            <th width="280px">خيارات</th>
        </tr>
        <?php $i = 0?>
        @foreach ($users as $user)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->isAdmin == 0 ? 'مستخدم' : 'مدير' }}</td>
                    {{ $is = false }}
                    @foreach($sessions as $session)

                        @if($session->user_id === $user->id)
                            {{$is = true}}
                        <td>
                            {{$session->ip_address}}
                        </td>

                        <td>
                            {{\Carbon\Carbon::createFromTimestamp($session->last_activity)}}
                        </td>

                        @endif

                    @endforeach

                @if(!$is)

                    <td>
                        -
                    </td>

                    <td>
                        -
                    </td>
                @endif


                    <td>
                    <form action="{{ route('users.destroy',$user->id) }}" method="POST">

{{--                        <a class="btn btn-info" href="{{ route('color.show',$color->id) }}">Show</a>--}}

                        <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">تعديل</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-center">
    {!! $users->links() !!}
    </div>

@endsection
