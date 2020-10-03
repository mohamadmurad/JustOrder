@extends('layout.layout')

@section('content')


    @include('layout.title',[
   'url' => 'fabric.index',
   'urlTitle' => 'رجوع',
   'title'=>'انشاء قماش جديد'
   ])

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>

        </div>
    @endif

    <form action="{{ route('fabric.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>اسم القماش:</strong>
                    <input type="text" name="name" class="form-control" placeholder="اسم القماش">
                    <ul class="errors">
                        @foreach ($errors->get('name') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>كود القماش:</strong>
                    <input type="text" name="code" class="form-control" placeholder="كود القماش">
                    <ul class="errors">
                        @foreach ($errors->get('code') as $message)
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
