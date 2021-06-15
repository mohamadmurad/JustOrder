@extends('layout.layout')

@section('content')

    @auth






        <livewire:reports-orders/>


    @else

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button class="btn btn-primary"><a href="{{route('login')}}">تسجيل الدخول</a></button>
        </div>
    @endauth



@endsection
