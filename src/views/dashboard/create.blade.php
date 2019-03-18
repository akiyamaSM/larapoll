@extends('larapoll::layouts.app')
@section('title')
    Polls- Creation
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
                <input type="text" id="question" name="question" class="form-control" value="{{ old('question') }}"/>
            </div>
            <ul class="options">
                <li>
                    <input id="option_1" type="text" name="options[0]" class="form-control" value="{{ old('options.0') }}" />
                    <input id="option_2" type="text" name="options[1]" class="form-control" value="{{ old('options.1') }}" />
                </li>
            </ul>

            <div class="radio">
                <label>
                    <input type="checkbox" name="canVisitorsVote" value="1" > Allow to guests
                </label>
            </div>

            <div class="dates">
                <div class="form-group">
                    <label for="starts_at">Starts at:</label>
                    <input type="datetime-local" id="starts_at" name="starts_at" class="form-control" value="{{ old('starts_at') }}"/>
                </div>

                <div class="form-group">
                    <label for="starts_at">Ends at:</label>
                    <input type="datetime-local" id="ends_at" name="ends_at" class="form-control" value="{{ old('ends_at') }}"/>
                </div>
            </div>
            <!-- Create Form Submit -->
            <div class="form-group">
                <input name="create" type="submit" value="Create" class="btn btn-primary form-control"/>
            </div>
        </form>
    </div>
</div>
@endsection
