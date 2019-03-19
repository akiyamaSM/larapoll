@extends('larapoll::layouts.app')
@section('title')
    Polls- Edit
@endsection
@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('poll.home') }}">Home</a></li>
            <li><a href="{{ route('poll.index') }}">Polls</a></li>
            <li class="active">Edit Poll</li>
        </ol>
        <div class="well col-md-8 col-md-offset-2">
            @if($errors->any())
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <form method="POST" action=" {{ route('poll.update', $poll->id) }}">
                {{ csrf_field() }}
                    @method('patch')
                <!-- Question Input -->
                <div class="row">
                    <div class="form-group">
                        <label>Question: </label>
                        <input type="text" class="form-control" name="question" value="{{ old('question', $poll->question) }}">
                    </div>
                </div>

                <ul class="options">
                    @foreach($poll->options as $option)
                        <li>{{ $option->name }}</li>
                    @endforeach
                </ul>

                @php
                    $maxCheck = $poll->maxCheck;
                    $count_options = $poll->optionsNumber()
                @endphp
                <select name="count_check" class="form-control">
                    @for($i =1; $i<= $count_options; $i++)
                        <option  {{ $i==$maxCheck? 'selected':'' }} >{{ $i }}</option>
                    @endfor
                </select>

                <div class="dates">
                    <div class="form-group">
                        <label for="starts_at">Starts at:</label>
                        <input type="datetime-local" id="starts_at" name="starts_at" class="form-control" value="{{ old('starts_at', \Carbon\Carbon::parse($poll->starts_at)->format('Y-m-d\TH:i')) }}"/>
                    </div>

                    <div class="form-group">
                        <label for="starts_at">Ends at:</label>
                        <input type="datetime-local" id="ends_at" name="ends_at" class="form-control" value="{{ old('ends_at', \Carbon\Carbon::parse($poll->ends_at)->format('Y-m-d\TH:i')) }}"/>
                    </div>
                </div>

                <div class="radio">
                    <label>
                        <input type="checkbox" name="close" {{ $poll->isLocked()? 'checked':'' }}> Close
                    </label>
                </div>

                <!-- Create Form Submit -->
                <div class="form-group">
                    <input name="update" type="submit" value="Update" class="btn btn-primary form-control"/>
                </div>
            </form>
        </div>
    </div>
@endsection