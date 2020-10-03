@extends('layout.layout')



@section('content')


    @include('layout.title',[
    'url' => 'subgroup.index',
    'urlTitle' => 'رجوع',
    'title'=>'تعديل مجموعة فرعية'
    ])





        @if ($errors->any())

        <div class="alert alert-danger">

            <strong>Whoops!</strong> There were some problems with your input.<br><br>

        </div>

    @endif


    <form action="{{ route('subgroup.update',$subgroup->id) }}" method="POST">

        @csrf

        @method('PUT')



        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">

                    <strong>المجموعة الفرعية:</strong>

                    <input type="text" name="name" value="{{ $subgroup->name }}" class="form-control" placeholder="المجموعة الفرعية">
                    <ul class="errors">
                        @foreach ($errors->get('name') as $message)
                            <i>{{ $message }}</i>
                        @endforeach
                    </ul>
                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">

                    <strong>المجموعة:</strong>
                    <select  class="form-control"  name="group_id">
                        <option selected value="{{ null }}">non</option>
                        @foreach($groups as $group)
                            @if($subgroup->group)
                                @if($subgroup->group->id == $group->id)
                                    <option selected value="{{ $group->id }}">{{$group->name}}</option>
                                @else
                                    <option value="{{ $group->id }}">{{$group->name}}</option>
                                @endif
                            @else
                                <option value="{{ $group->id }}">{{$group->name}}</option>
                            @endif

                        @endforeach
                    </select>

                    <ul class="errors">
                        @foreach ($errors->get('group_id') as $message)
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
