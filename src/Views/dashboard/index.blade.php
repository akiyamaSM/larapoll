<div class="container">
    <h1>Dashboard</h1>
    @foreach($polls as $poll)
        <span>{{ $poll->id }}</span>
        <span>{{ $poll->question }}</span>
    @endforeach
</div>