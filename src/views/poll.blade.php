@extends('larapoll::layouts.app')

@section('content')
<div class="container">
    <div class="flex-center position-ref full-height">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{ PollWriter::draw($poll->id) }}
    </div>
</div>
@endsection
