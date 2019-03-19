@extends('larapoll::layouts.app')
@section('title')
    Polls- Creation
@endsection
@section('style')
    <style>
        .clearfix{
            clear: both;
        }
        .create-btn{
            display: block;
            width: 16%;
            float: right;
        }
        .old_options, #options, .button-add {
            list-style-type: none;
        }

        .add-input {
            width: 80%;
            display: inline-block;
            margin-right: 10px;
            margin-bottom: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('poll.home') }}">Home</a></li>
            <li><a href="{{ route('poll.index') }}">Polls</a></li>
            <li class="active">Create Poll</li>
        </ol>
    <div class="well col-md-8 col-md-offset-2">
            @if($errors->any())
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        <form method="POST" action=" {{ route('poll.store') }}">
            {{ csrf_field() }}
            <!-- Question Input -->
            <div class="form-group">
                <label for="question">Question:</label>
                <textarea id="question" name="question"  cols="30" rows="2" class="form-control" placeholder="Ex: Who is the best player in the world?">{{ old('question') }}</textarea>
            </div>
            <div class="form-group">
                <label>Options</label>
                <ul id="options">
                    <li>
                        <input id="option_1" type="text" name="options[0]" class="form-control add-input" value="{{ old('options.0') }}" placeholder="Ex: Cristiano Ronaldo"/>
                    </li>
                    <li>
                        <input id="option_2" type="text" name="options[1]" class="form-control add-input" value="{{ old('options.1') }}" placeholder="Ex: Lionel Messi" />
                    </li>
                </ul>

                <ul>
                    <li class="button-add">
                        <div class="form-group">
                            <a class="btn btn-primary" id="add">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="form-group clearfix">
                <label>Options</label>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="starts_at">Starts at:</label>
                        <input type="datetime-local" id="starts_at" name="starts_at" class="form-control" value="{{ old('starts_at') }}"/>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="starts_at">Ends at:</label>
                        <input type="datetime-local" id="ends_at" name="ends_at" class="form-control" value="{{ old('ends_at') }}"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="canVisitorsVote" value="1" {{ old('canVisitorsVote')  == 1 ? 'checked' : ''  }} > Allow to guests
                </label>
            </div>
            <!-- Create Form Submit -->
            <div class="form-group">
                <input name="create" type="submit" value="Create" class="btn btn-primary create-btn"/>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
    <script type="text/javascript">
        function remove(current){
            current.parentNode.remove()
        }
        document.getElementById("add").onclick = function() {
            var e = document.createElement('li');
            e.innerHTML = "<input type='text' name='options[]' class='form-control add-input' placeholder='Insert your option' /> <a class='btn btn-danger' href='#' onclick='remove(this)'><i class='fa fa-minus-circle' aria-hidden='true'></i></a>";
            document.getElementById("options").appendChild(e);
        }
    </script>
@endsection
