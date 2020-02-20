@extends('larapoll::layouts.app')
@section('title')
Polls- Listing
@endsection
@section('style')
    <!--Regular Datatables CSS-->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <!--Responsive Extension Datatables CSS-->
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">


    <style>

        /*Overrides for Tailwind CSS */

        /*Form fields*/
        .dataTables_wrapper select,
        .dataTables_wrapper .dataTables_filter input {
            color: #4a5568; 			/*text-gray-700*/
            padding-left: 1rem; 		/*pl-4*/
            padding-right: 1rem; 		/*pl-4*/
            padding-top: .5rem; 		/*pl-2*/
            padding-bottom: .5rem; 		/*pl-2*/
            line-height: 1.25; 			/*leading-tight*/
            border-width: 2px; 			/*border-2*/
            border-radius: .25rem;
            border-color: #edf2f7; 		/*border-gray-200*/
            background-color: #edf2f7; 	/*bg-gray-200*/
        }

        /*Row Hover*/
        table.dataTable.hover tbody tr:hover, table.dataTable.display tbody tr:hover {
            background-color: #ebf4ff;	/*bg-indigo-100*/
        }

        /*Pagination Buttons*/
        .dataTables_wrapper .dataTables_paginate .paginate_button		{
            font-weight: 700;				/*font-bold*/
            border-radius: .25rem;			/*rounded*/
            border: 1px solid transparent;	/*border border-transparent*/
        }

        /*Pagination Buttons - Current selected */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current	{
            color: #fff !important;				/*text-white*/
            box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06); 	/*shadow*/
            font-weight: 700;					/*font-bold*/
            border-radius: .25rem;				/*rounded*/
            background: #667eea !important;		/*bg-indigo-500*/
            border: 1px solid transparent;		/*border border-transparent*/
        }

        /*Pagination Buttons - Hover */
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover		{
            color: #fff !important;				/*text-white*/
            box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);	 /*shadow*/
            font-weight: 700;					/*font-bold*/
            border-radius: .25rem;				/*rounded*/
            background: #667eea !important;		/*bg-indigo-500*/
            border: 1px solid transparent;		/*border border-transparent*/
        }

        /*Add padding to bottom border */
        table.dataTable.no-footer {
            border-bottom: 1px solid #e2e8f0;	/*border-b-1 border-gray-300*/
            margin-top: 0.75em;
            margin-bottom: 0.75em;
        }

        /*Change colour of responsive icon*/
        table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
            background-color: #667eea !important; /*bg-indigo-500*/
        }

    </style>
@endsection
@section('content')
<div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2">
    <section class="p-10 px-0">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('poll.home') }}">Home</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-500" aria-current="page">Polls</a>
            </li>
        </ol>
    </section>
    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
        @if($polls->count() >= 1)
            <table  id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead>
                <tr>
                    <th data-priority="1">#</th>
                    <th data-priority="2">Question</th>
                    <th data-priority="3">Options</th>
                    <th data-priority="4">Visitors allowed</th>
                    <th data-priority="5">Votes</th>
                    <th data-priority="6">State</th>
                    <th data-priority="7">Edit</th>
                    <th data-priority="8">Add Options</th>
                    <th data-priority="9">Remove Options</th>
                    <th data-priority="10">Remove</th>
                    <th data-priority="11">Lock/Unlock</th>
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
    </div>
</div>
@endsection

@section('js')
    <!--Datatables -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {

            var table = $('#example').DataTable( {
                responsive: true
            } )
                .columns.adjust()
                .responsive.recalc();
        } );
        // Delete Confirmation
        $(".delete").on("submit", function() {
            return confirm("Delete the poll?");
        });

        // Lock Confirmation
        $(".lock").on("submit", function() {
            return confirm("Lock/Unlock the poll?");
        });
    </script>
@endsection
