@extends('layout.layout')



@section('content')





    @include('layout.title',[
    'url' => 'type.index',
    'urlTitle' => 'رجوع',
    'title'=>'تعديل صنف'
    ])


        @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Whoops!</strong> There were some problems with your input.<br><br>

        </div>

    @endif


    <form action="{{ route('type.update',$type->id) }}" method="POST">

        @csrf

        @method('PUT')



        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">

                    <strong>الصنف:</strong>

                    <input type="text" name="name" value="{{ $type->name }}" class="form-control" placeholder="Name">
                    <ul class="errors">
                        @foreach ($errors->get('name') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>

            </div>

{{--            <div class="col-xs-12 col-sm-12 col-md-12">--}}

{{--                <div class="form-group">--}}

{{--                    <strong>MGR:</strong>--}}

{{--                    <input type="text" name="MGR" value="{{ $type->MGR }}" class="form-control" placeholder="MGR">--}}
{{--                    <ul class="errors">--}}
{{--                        @foreach ($errors->get('MGR') as $message)--}}
{{--                            <i>{{ $message }}</i>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}

{{--            </div>--}}



            <div class="col-xs-12 col-sm-12 col-md-12 text-center">

                <button type="submit" class="btn btn-primary">تحديث</button>

            </div>

        </div>



    </form>

@endsection
