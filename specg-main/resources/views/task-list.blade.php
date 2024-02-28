<!DOCTYPE html>
<html>
<head>
    @include('head')
    <style>
        .hidden {
            display: none;
        }
    </style>
    <title>Spec G | Tasks</title>
</head>
<body class="vh-100 webpage">
    @include('navbar')
    <div class="col-md-10 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3 ms-4">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tasks</li>
            </ol>
        </nav>
        @if(Session::has('success'))
            <div class="alert alert-success clearfix">
                <button type="button" class="btn-close btn-sm float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                <span>{{Session::get('success')}}</span>
            </div>
        @endif
        @if(Session::has('fail'))
            <div class="alert alert-danger clearfix">
                <button type="button" class="btn-close btn-sm float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                <span>{{Session::get('fail')}}</span>
            </div>
        @endif
        <h3 class="clearfix">
            Task Cards
            <button type="button" onclick="notes()" class="btn btn-primary btn-sm rounded-pill px-5 float-end mb-3" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                <i class="bi-plus-circle me-1"></i>        
                New Task
            </button>
        </h3>
        <div class="d-flex col-md-4 mx-auto mb-3">
            <button class="btn btn-sm btn-outline-dark border-0" disabled>Search</button>
            <input class="form-control form-control-sm" id="task-search-bar" onkeyup="searchCards()"  type="text" placeholder="Enter Details" aria-label="Search">
        </div>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3">
                @include('task')
            </div>
        </div>
    </div>
    <!--add task modal-->
    <div class="modal fade modalSpecG" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action = "/add-task" method = "post">
                    @csrf
                    <div class="modal-body w-75 mx-auto">

                        <!-- Creator ID input -->
                        <label class="form-label" for="creatorid" hidden>Creator ID</label>
                        <div class="input-group mb-3" hidden>
                            <input type="text" id="creatorid" name = "creatorid" class="form-control w-100 mb-1" value="{{$user->id}}"/>
                        </div>

                        <div class="mb-3">
                            <p class="mb-0">Created by: {{$user->lastname}}, {{$user->firstname}}</p>
                        </div>

                        <label class="col-12 form-label" for="project">Project</label>
                        <div class="col-12 input-group mb-3">
                            <select id="projSelect" name="project" class="select2 mb-1" style="width: 100%">
                                <option disabled selected>Select Project</option>
                                @foreach ($projects as $project)
                                <option value="{{$project->id}}" {{old('project') == $project->id ? 'selected' : 'Select Project' }}>{{$project->name}}</option>
                                @endforeach
                            </select>
                            <div class = "text-danger small mt-1"> @error('project') {{$message}} @enderror </div>
                        </div>

                        <!-- Task Name input -->
                        <label class="form-label" for="title">Task Name</label>
                        <div class="input-group mb-3">
                            <input type="text" id="task_name" name = "task_name" class="form-control w-100 mb-1" placeholder="Enter Task Name" value="{{old('task_name')}}"/>
                            <div class = "text-danger small"> @error('task_name') {{$message}} @enderror </div>
                        </div>

                        <!-- Notes input -->
                        <label class="form-label" for="notes">Notes</label>
                        <div class="input-group mb-3">
                            <textarea type="text" id="notes" name = "notes" class="form-control w-100 mb-1" placeholder="(optional)">                            
                            </textarea>
                        </div>

                        <!-- Assignee ID input -->
                        <label class="col-12 form-label" for="assignee">Assign To</label>
                        <div class="col-12 input-group mb-3">
                            <select id="empSelect" name="assignee" class="select2 mb-1" style="width: 100%">
                                <option disabled selected>Select Assignee</option>
                                @foreach ($emps as $emp)
                                <option value="{{$emp->id}}" {{old('assignee') == $emp->id ? 'selected' : 'Select Assignee' }}>{{$emp->lastname}}, {{$emp->firstname}}</option>
                                @endforeach
                            </select>
                            <div class = "text-danger small mt-1"> @error('assignee') {{$message}} @enderror </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btnMain px-5 rounded-pill btn-sm">Save</button>
                        <button type="button" class="btn btn-secondary btnMain px-5 rounded-pill btn-sm" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#list').DataTable();
            $('.dataTables_length').addClass('bs-select');
            //for nav active
            $('#nav-task').addClass('active');
            $('#nav-task').prop('aria-current','page');
            $('#nav-task').removeAttr('href');
            //end for nav active
            $('.taskCard').removeClass('w-100').addClass('col p-0')
            $('.projectLink').removeAttr('hidden');
            $('.select2').select2();
            @if ($errors->has('project') ||  $errors->has('task_name') || $errors->has('assignee'))
                $('#addTaskModal').modal('show'); // Show the modal if there are errors
            @endif
            $("#projSelect").select2({
                dropdownParent: $("#addTaskModal")
            });
            $("#empSelect").select2({
                dropdownParent: $("#addTaskModal")
            });
        });

        $('#addTaskModal').on('shown.bs.modal', function () {
            var notes = document.getElementById("notes");
            var value = notes.value;
            value = value.replace(/^\s+/, '');
            notes.value = value;
            notes.value.trim();
        });

        function closeTask(id) {
            var replies = document.getElementsByClassName("reply");
            for (var i = 0; i < replies.length; i++) {
            var reply = replies[i];
            var value = reply.value.trim();
            reply.value = value;
            }
        };

        function searchCards() {
            var input, filter, cards, card, cardContent, i, j, found;
            input = document.getElementById("task-search-bar");
            filter = input.value.toUpperCase();
            cards = document.getElementsByClassName("taskCard");

            for (i = 0; i < cards.length; i++) {
                card = cards[i];
                cardContent = card.getElementsByClassName("card-body")[0].innerText.toUpperCase();
                found = false;

                // Check if the filter value is present in any information within the card
                if (cardContent.indexOf(filter) > -1) {
                    found = true;
                } 
                else {
                    var cardSubtitles = card.getElementsByClassName("card-subtitle");
                    for (j = 0; j < cardSubtitles.length; j++) {
                        var subtitleContent = cardSubtitles[j].innerText.toUpperCase();
                        if (subtitleContent.indexOf(filter) > -1) {
                        found = true;
                        break;
                        }
                    }
                }

                if (found) {
                    card.classList.remove("hidden");
                } else {
                    card.classList.add("hidden");
                }
            }
        }
    </script>
</body>
</html>
