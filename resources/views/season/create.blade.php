@extends('layout.layout')

@section('content')

    @include('layout.title',[
   'url' => 'season.index',
   'urlTitle' => 'رجوع',
   'title'=>'انشاء فصل جديد'
   ])


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>

        </div>
    @endif

    <form action="{{ route('season.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>الفصل:</strong>
                    <input type="text" name="name" class="form-control" placeholder="الفصل">
                    <ul class="errors">
                        @foreach ($errors->get('name') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>
            </div>

{{--            <div class="col-xs-12 col-sm-12 col-md-12">--}}
{{--                <div class="form-group">--}}
{{--                    <strong>البداية:</strong>--}}
{{--                    <input type="date" name="start" class="form-control" placeholder="البداية">--}}
{{--                    <ul class="errors">--}}
{{--                        @foreach ($errors->get('start') as $message)--}}
{{--                            <i>{{ $message }}</i>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-xs-12 col-sm-12 col-md-12">--}}
{{--                <div class="form-group">--}}
{{--                    <strong>النهاية:</strong>--}}
{{--                    <input type="date" name="end" class="form-control" placeholder="النهاية">--}}
{{--                    <ul class="errors">--}}
{{--                        @foreach ($errors->get('end') as $message)--}}
{{--                            <i>{{ $message }}</i>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-xs-12 col-sm-12 col-md-12">--}}
{{--                <div class="form-group">--}}
{{--                    <strong>السنة:</strong>--}}
{{--                    <select  class="form-control"  name="year_id">--}}
{{--                        @foreach($years as $year)--}}
{{--                            <option value="{{ $year->id }}">{{$year->name}}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                    <ul class="errors">--}}
{{--                        @foreach ($errors->get('year_id') as $message)--}}
{{--                            <i>{{ $message }}</i>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}

{{--                </div>--}}
{{--            </div>--}}

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </div>

    </form>
@endsection
