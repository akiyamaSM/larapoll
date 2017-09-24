<div class="container">
    {{ $poll->question }}
    @foreach($poll->options as $option)
        <h3>{{ $option->name }}</h3>
    @endforeach
</div>