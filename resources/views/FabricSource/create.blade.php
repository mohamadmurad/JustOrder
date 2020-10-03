@extends('layout.layout')

@section('content')


    @include('layout.title',[
   'url' => 'FabricSource.index',
   'urlTitle' => 'رجوع',
   'title'=>'انشاء مصدر قماش جديد'
   ])

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>

        </div>
    @endif

    <form action="{{ route('FabricSource.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>المصدر:</strong>
                    <input type="text" name="name" class="form-control" placeholder="المصدر">
                    <ul class="errors">
                        @foreach ($errors->get('name') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">انشاء</button>
            </div>
        </div>

    </form>
@endsection
