<!DOCTYPE html>
<html>
<head>
    @include('head')
    <title>Spec G | Home</title>
</head>
<body class="vh-100 webpage">
    @include('navbar')
    <div class="col-md-10 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3 ms-4">
                <li class="breadcrumb-item active" aria-current="page">Home</a></li>
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
        <h3 class="text-center">Project List</h3>
        <div class="w-100 clearfix my-3">
            <a href="add-project" role="button" class="btn text-light bg-primary btn-sm rounded-pill float-end me-2 px-5 btnMain">
                <i class="bi-plus-circle me-1"></i>
                New Project
            </a>
        </div>
        <div class="tableList bg-light">
            <table id="list" class="table table-light table-striped table-sm table-hover">
                <thead class="bg-white" style="position: sticky; top: 0">
                    <tr>
                        <th scope="col" style="width: 5%">#</th>
                        <th scope="col" style="width: 5%">ID</th>
                        <th scope="col" style="width: 15%">Project Name</th>
                        <th scope="col" style="width: 15%">Client</th>
                        <th scope="col" style="width: 15%">Location</th>
                        <th scope="col" style="width: 15%">Completion Date</th>
                        <th scope="col" style="width: 10%">Status</th>
                        <th scope="col" style="width: 20%">Phase</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1 @endphp
                    @foreach ($projects as $project)
                        <tr onclick="window.location.href='/view-project/{{$project->id}}'" onmouseover="showIcon(this)" onmouseleave="hideIcon(this)">
                            <td>{{$i++}}</td>
                            <td>{{$project->id}}</td>
                            <td>{{$project->name}}</td>
                            <td>{{$project->lastname}}, {{$project->firstname}}</td>
                            <td>{{$project->location}}</td>
                            <td>{{$project->completiondate}}</td>
                            <td>{{$project->status}}</td>
                            <td class="clearfix">
                                {{$project->phase}}
                                <i class="bi bi-caret-right-fill float-end" style="display:none"></i>
                            </td>
                        </tr>
                    @endforeach
                </tbody>     
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#list').DataTable();
            $('.dataTables_length').addClass('bs-select');
            //for nav active
            $('#nav-home').addClass('active');
            $('#nav-home').prop('aria-current','page');
            $('#nav-home').removeAttr('href');
            //end for nav active
        });

        function showIcon(element) {
            var icon = element.querySelector('.bi-caret-right-fill');
            icon.style.display = (icon.style.display === 'none') ? 'inline-block' : 'none';
        }

        function hideIcon(element) {
            var icon = element.querySelector('.bi-caret-right-fill');
            icon.style.display = (icon.style.display === 'inline-block') ? 'none' : 'inline-block';
        }
    </script>
    
</body>
</html>