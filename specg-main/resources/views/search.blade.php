<!DOCTYPE html>
<html>
<head>
    @include('head')
    <title>Spec G | Search</title>
</head>
<body class="vh-100 webpage">
    @include('navbar')
    <div class="col-md-10 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3 ms-4">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Search</li>
            </ol>
        </nav>
        @if(Session::has('success'))
            <div class="alert alert-success clearfix mb-2">
                <button type="button" class="btn-close btn-sm float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                <span>{{Session::get('success')}}</span>
            </div>
        @endif
        @if(Session::has('fail'))
            <div class="alert alert-danger clearfix mb-2">
                <button type="button" class="btn-close btn-sm float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                <span>{{Session::get('fail')}}</span>
            </div>
        @endif
        <div class="col-md-6 mx-auto">
            <h3 class="w-100 mt-3">
                Search Results:
            </h3>
            <div class="bg-light px-5 py-2">
                @if ($data ->isEmpty())
                    <h5 class="p-0 m-0">No results found.</h5>
                @else
                    @foreach($data as $record)
                    <div class="p-2">
                        @if($record->source == 'projects')
                            <h5 class="p-0 m-0">
                                <a href="/view-project/{{ $record->id }}" class="p-0 m-0">
                                    {{ $record->id }} - {{ $record->name }}
                                </a>
                            </h5>
                            <p class="text-muted p-0 m-0 small">
                                <i class="p-0 m-0">Project</i>
                            </p>
                        @elseif($record->source == 'clients')
                            <h5 class="p-0 m-0">
                                <a href="/client-list" class="p-0 m-0">
                                    {{ $record->id }} - {{ $record->name }}
                                </a>
                            </h5>
                            <p class="text-muted p-0 m-0 small">
                                <i class="p-0 m-0">Client</i>
                            </p>
                        @elseif($record->source == 'tasks')
                            <h5 class="p-0 m-0">
                                <a href="/view-project/{{ $record->id }}" class="p-0 m-0">
                                    {{ $record->name }}
                                </a>
                            </h5>
                            <p class="text-muted p-0 m-0 small">
                                <i class="p-0 m-0">Task</i>
                            </p>
                        @elseif($record->source == 'files')
                            <h5 class="p-0 m-0">
                                <a href="#" class="p-0 m-0" onclick="window.open('{{asset('files/'.$record->name)}}','_blank'); return false;">
                                    {{ $record->name }}
                                </a>
                            </h5>
                            <p class="text-muted p-0 m-0 small">
                                <i class="p-0 m-0">File</i>
                            </p>
                        @endif
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <script>
    </script>    
</body>
</html>