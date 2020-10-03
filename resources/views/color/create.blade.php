@extends('layout.layout')

@section('content')


    @include('layout.title',[
    'url' => 'color.index',
    'urlTitle' => 'رجوع',
    'title'=>'انشاء لون جديد'
    ])

    @if ($errors->any())

        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
{{--            <ul>--}}
{{--                @foreach ($errors->all() as $error)--}}
{{--                    <li>{{ $error }}</li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
        </div>
    @endif

    <form action="{{ route('color.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>اللون:</strong>
                    <input type="text" name="name" class="form-control" placeholder="اللون">
                    <ul class="errors">
                    @foreach ($errors->get('name') as $message)
                        <i>{{ $message }}</i>
                    @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </div>

    </form>
@endsection
