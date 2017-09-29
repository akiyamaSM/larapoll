<div class="container">
    {{ session('success') }}
    <h1>Dashboard</h1>
    @foreach($polls as $poll)
        <span>{{ $poll->id }}</span>
        <span>{{ $poll->question }}</span>
        <span>{{ $poll->options_count }}</span>
    @endforeach
</div>