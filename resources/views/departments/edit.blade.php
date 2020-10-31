@extends('layout.layout')



@section('content')


    @include('layout.title',[
    'url' => 'color.index',
    'urlTitle' => 'رجوع',
    'title'=>'تعديل لون'
    ])


        @if ($errors->any())

        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
        </div>

    @endif



    <form action="{{ route('color.update',$color->id) }}" method="POST">

        @csrf

        @method('PUT')



        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">

                    <strong>اللون:</strong>

                    <input type="text" name="name" value="{{ $color->name }}" class="form-control" placeholder="اللون">
                    <ul class="errors">
                        @foreach ($errors->get('name') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">

                <button type="submit" class="btn btn-primary">تحديث</button>

            </div>

        </div>



    </form>

@endsection
