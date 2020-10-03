@extends('layout.layout')



@section('content')
    @include('layout.title',[
        'url' => 'size.index',
        'urlTitle' => 'رجوع',
        'title'=>'تعديل قياس'
        ])


        @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Whoops!</strong> There were some problems with your input.<br><br>

        </div>

    @endif


    <form action="{{ route('size.update',$size->id) }}" method="POST">

        @csrf

        @method('PUT')



        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">

                    <strong>القياس:</strong>

                    <input type="text" name="name" value="{{ $size->name }}" class="form-control" placeholder="القياس">
                    <ul class="errors">
                        @foreach ($errors->get('name') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">

                    <strong>الكود:</strong>

                    <input type="text" name="code" value="{{ $size->code }}" class="form-control" placeholder="الكود">
                    <ul class="errors">
                        @foreach ($errors->get('code') as $message)
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
