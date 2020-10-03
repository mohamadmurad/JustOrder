@extends('layout.layout')



@section('content')

    @include('layout.title',[
    'url' => 'years.index',
    'urlTitle' => 'رجوع',
    'title'=>'تعديل سنة'
    ])




        @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Whoops!</strong> There were some problems with your input.<br><br>

        </div>

    @endif



    <form action="{{ route('years.update',$year->id) }}" method="POST">

        @csrf

        @method('PUT')



        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">

                    <strong>السنة:</strong>

                    <input type="text" name="name" value="{{ $year->name }}" class="form-control" placeholder="Year">
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
