@extends('layout.layout')



@section('content')


    @include('layout.title',[
       'url' => 'supplier.index',
       'urlTitle' => 'رجوع',
       'title'=>'تعديل مورد'
       ])

        @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Whoops!</strong> There were some problems with your input.<br><br>

        </div>

    @endif



    <form action="{{ route('supplier.update',$supplier->id) }}" method="POST">

        @csrf

        @method('PUT')



        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">

                    <strong>اسم المورد:</strong>

                    <input type="text" name="name" value="{{ $supplier->name }}" class="form-control" placeholder="اسم المورد">
                    <ul class="errors">
                        @foreach ($errors->get('name') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>

                </div>

                <div class="form-group">

                    <strong>كود المورد:</strong>

                    <input type="text" name="code" value="{{ $supplier->code }}" class="form-control" placeholder="كود المورد">
                    <ul class="errors">
                        @foreach ($errors->get('code') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>


                <div class="form-group">

                    <strong>عنوان المورد:</strong>

                    <input type="text" name="address" value="{{ $supplier->address }}" class="form-control" placeholder="عنوان المورد">
                    <ul class="errors">
                        @foreach ($errors->get('address') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>

                <div class="form-group">

                    <strong>هاتف المورد:</strong>

                    <input type="text" name="phone" value="{{ $supplier->phone }}" class="form-control" placeholder="هاتف المورد">
                    <ul class="errors">
                        @foreach ($errors->get('phone') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>

                <div class="form-group">

                    <strong>ملاحفظات:</strong>

                    <input type="text" name="notes" value="{{ $supplier->notes }}" class="form-control" placeholder="ملاحفظات">
                    <ul class="errors">
                        @foreach ($errors->get('notes') as $message)
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
