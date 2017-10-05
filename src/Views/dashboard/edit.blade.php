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
                <!-- Question Input -->
                <div class="form-group">
                    <label>{{ $poll->question }}</label>
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