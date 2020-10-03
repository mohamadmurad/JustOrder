@extends('layout.layout')

@section('content')

    @include('layout.title',[
    'url' => 'users.index',
    'urlTitle' => 'رجوع',
    'title'=>'انشاء مستخدم جديد'
    ])

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>

        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>الاسم:</strong>
                    <input type="text" name="name" class="form-control" placeholder="الاسم">
                    <ul class="errors">
                        @foreach ($errors->get('name') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>اسم المستخدم:</strong>
                    <input type="text" name="username" class="form-control" placeholder="اسم المستخدم">
                    <ul class="errors">
                        @foreach ($errors->get('username') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>كلمة المرور:</strong>
                    <input type="password" name="password" class="form-control" placeholder="كلمة المرور">
                    <ul class="errors">
                        @foreach ($errors->get('password') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>تأكيد كلمة المرور:</strong>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="تأكيد كلمة المرور">
                    <ul class="errors">
                        @foreach ($errors->get('password_confirm') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="exampleRadios1" name="isAdmin" value="0" checked>
                    <label class="form-check-label" for="exampleRadios1">
                        مستخدم
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="exampleRadios2" name="isAdmin" value="1">
                    <label class="form-check-label" for="exampleRadios2">
                        ادمن
                    </label>
                </div>

            </div>




            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </div>

    </form>
@endsection
