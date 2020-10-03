@extends('layout.layout')

@section('content')

    @include('layout.title',[
   'url' => 'group.index',
   'urlTitle' => 'رجوع',
   'title'=>'انشاء مجموعة جديدة'
   ])



    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>

        </div>
    @endif

    <form action="{{ route('group.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>االمجموعة:</strong>
                    <input type="text" name="name" class="form-control" placeholder="االمجموعة">
                    <ul class="errors">
                        @foreach ($errors->get('name') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>صنف المجموعة:</strong>
                    <select  class="form-control"  name="type_id">
                        <option selected value="{{ null }}">non</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{$type->name}}</option>
                        @endforeach
                    </select>
                    <ul class="errors">
                        @foreach ($errors->get('type_id') as $message)
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
