@extends('layout.layout')



@section('content')


    @include('layout.title',[
    'url' => 'group.index',
    'urlTitle' => 'رجوع',
    'title'=>'تعديل مجموعة'
    ])




        @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Whoops!</strong> There were some problems with your input.<br><br>

        </div>

    @endif


    <form action="{{ route('group.update',$group->id) }}" method="POST">

        @csrf

        @method('PUT')



        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">

                    <strong>المجموعة:</strong>

                    <input type="text" name="name" value="{{ $group->name }}" class="form-control" placeholder="المجموعة">
                    <ul class="errors">
                        @foreach ($errors->get('name') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">

                    <strong>الصنف:</strong>
                    <select  class="form-control"  name="type_id">
                        <option selected value="{{ null }}">non</option>
                        @foreach($types as $type)
                            @if($group->type)
                                @if($group->type->id == $type->id)
                                    <option selected value="{{ $type->id }}">{{$type->name}}</option>
                                @else
                                    <option value="{{ $type->id }}">{{$type->name}}</option>
                                @endif
                            @else
                                <option value="{{ $type->id }}">{{$type->name}}</option>
                            @endif

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

                <button type="submit" class="btn btn-primary">Update</button>

            </div>

        </div>



    </form>

@endsection
