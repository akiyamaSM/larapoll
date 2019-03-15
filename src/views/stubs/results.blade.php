@if(Session::has('errors'))
    <div class="alert alert-danger">
            {{ session('errors') }}
    </div>
@endif
@if(Session::has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<h5>Poll: {{ $question }}</h5>

@foreach($options as $option)
    <div class='result-option-id'>
        <strong>{{ $option->name }}</strong><span class='pull-right'>{{ $option->percent }}%</span>
        <div class='progress'>
            <div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='{{ $option->percent }}' aria-valuemin='0' aria-valuemax='100' style='width: {{ $option->percent }}%'>
                <span class='sr-only'>{{ $option->percent }}% Complete</span>
            </div>
        </div>
    </div>
@endforeach
