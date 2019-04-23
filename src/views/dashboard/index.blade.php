@extends('larapoll::layouts.app')
@section('title')
Polls- Listing
@endsection
@section('style')
<style>
    .table td,
    .table th {
        text-align: center;
    }
</style>
@endsection
@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li><a href="{{ route('poll.home') }}">Home</a></li>
        <li class="active">Polls</li>
    </ol>

    @if(Session::has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if($polls->count() >= 1)
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Question</th>
                <th>Options</th>
                <th>Visitors allowed</th>
                <th>Votes</th>
                <th>State</th>
                <th>Edit</th>
                <th>Add Options</th>
                <th>Remove Options</th>
                <th>Remove</th>
                <th>Lock/Unlock</th>
            </tr>
        </thead>
        <tbody>
            @forelse($polls as $poll)
            <tr>
                <th scope="row">{{ $poll->id }}</th>
                <td>{{ $poll->question }}</td>
                <td>{{ $poll->options_count }}</td>
                <td>{{ $poll->canVisitorsVote ? 'Yes' : 'No' }}</td>
                <td>{{ $poll->votes_count }}</td>
                <td>
                    @if($poll->isLocked())
                    <span class="label label-danger">Closed</span>
                    @elseif($poll->isComingSoon())
                    <span class="label label-info">Soon</span>
                    @elseif($poll->isRunning())
                    <span class="label label-success">Started</span>
                    @endif
                </td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('poll.edit', $poll->id) }}">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                </td>
                <td>
                    <a class="btn btn-success btn-sm" href="{{ route('poll.options.push', $poll->id) }}">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </a>
                </td>
                <td>
                    <a class="btn btn-warning btn-sm" href="{{ route('poll.options.remove', $poll->id) }}">
                        <i class="fa fa-minus-circle" aria-hidden="true"></i>
                    </a>
                </td>
                <td>
                    <form class="delete" action="{{ route('poll.remove', $poll->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </form>
                </td>
                <td>
                    @php $route = $poll->isLocked()? 'poll.unlock': 'poll.lock' @endphp
                    @php $fa = $poll->isLocked()? 'fa fa-unlock': 'fa fa-lock' @endphp
                    <form class="lock" action="{{ route($route, $poll->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <button type="submit" class="btn btn-sm">
                            <i class="{{ $fa }}" aria-hidden="true"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <smal>No poll has been found. Try to add one <a href="{{ route('poll.create') }}">Now</a></smal>
    @endif
    {{ $polls->links() }}
</div>
@endsection

@section('js')
<!-- Delete Confirmation -->
<script>
    $(".delete").on("submit", function() {
        return confirm("Delete the poll?");
    });
</script>

<!-- Lock Confirmation -->
<script>
    $(".lock").on("submit", function() {
        return confirm("Lock/Unlock the poll?");
    });
</script>
@endsection