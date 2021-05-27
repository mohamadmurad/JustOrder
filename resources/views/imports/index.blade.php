@extends('layout.layout')

@section('content')

    @include('layout.title',[
   'url' => 'order.index',
   'urlTitle' => 'رجوع',
   'title'=>'import data '
   ])



    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>

        </div>
    @endif

    <form action="{{ route('import.import') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>file :</strong>
                    <input type="file" name="excel" class="form-control" placeholder="االمجموعة">
                    <ul class="errors">
                        @foreach ($errors->get('excel') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">import </button>
            </div>
        </div>

    </form>
@endsection
