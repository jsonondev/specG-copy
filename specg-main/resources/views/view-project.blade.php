<!DOCTYPE html>
<html>
<head>
    @include ('head')
    <title>Spec G | View/Update Project</title>
</head>
<body class="vh-100 webpage">
    @include('navbar')
    <div class="col-md-10 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3 ms-4">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">View/Update Project</li>
            </ol>
        </nav>
        <div class="container">
            <div class="row mb-5">
                <h3>View/Update Project</h3>
                @if(Session::has('success'))
                    <div class="col-12 alert alert-success clearfix mb-2">
                        <button type="button" class="btn-close btn-sm float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                        <span>{{Session::get('success')}}</span>
                    </div>        
                @endif
                @if(Session::has('fail'))
                    <div class="col-12 alert alert-danger clearfix mb-2">
                        <button type="button" class="btn-close btn-sm float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                        <span>{{Session::get('fail')}}</span>
                    </div>        
                @endif
                <div class = "col-lg-6 bg-light mb-3">
                    <form action = "/edit-project" method = "post" class="p-4 mb-3">
                        <div class="row">
                            @csrf
                            <!-- Project id -->
                            <div class="col-md-6">
                                <label class="form-label" for="id">Project ID</label>
                                <input type="text" class="w-100 mb-1" style="20px" value="{{$project->id}}" disabled readonly/>
                                <div class="input-group">
                                    <input type="text" id="id" name = "id" class="w-100 mb-1" style="display: none" value="{{$project->id}}"/>
                                </div>
                            </div>
                
                            <!-- Status input -->
                            <div class="col-md-6">
                                <label class="form-label" for="status">Status</label>
                                <div class="input-group mb-1">
                                    <select id="status" name="status" class="select2" style="width: 100%">
                                        <option value ="Not Started">Not Started</option>
                                        <option value ="Active">Active</option>
                                        <option value ="Cancelled">Cancelled</option>
                                        <option value ="On Hold">On Hold</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Name input -->
                            <label class="col-12 form-label" for="name">Project Name</label>
                            <div class="col-12 input-group mb-1">
                                <input type="text" id="name" name = "name" class="form-control w-100 mb-1" placeholder="Enter Project Name" value="{{$project->name}}"/>
                                <div class = "text-danger small"> @error('name') {{$message}} @enderror </div>
                            </div>

                            <!--Display number of files uploaded for project-->
                            <div class="col-md-6">
                                <div class="form-label">Files</div>
                                <div class="ps-3 mb-3">
                                    No. of files:
                                    <i><a href="{{$project->id}}/files" class="ms-1">{{$count}} file/s</a></i>
                                </div>
                            </div>


                            <!-- Client Input -->
                            <div class="col-md-6">
                                <label class="form-label" for="client">Client</label>
                                <div class="input-group mb-1">
                                    <select id="clientSelect" name="client" class="select2" style="width: 100%">
                                        <option value="add-new-client">Add New Client</option>
                                        @foreach ($clients as $client)
                                            @if ($client->id == $project->clientid)
                                                <option selected value="{{$client->id}}" {{old('client') == $client->id ? 'selected' : 'Select Client' }}>{{$client->id}} - {{$client->lastname}}, {{$client->firstname}}</option>
                                            @else
                                                <option value="{{$client->id}}" {{old('client') == $client->id ? 'selected' : 'Select Client' }}>{{$client->id}} - {{$client->lastname}}, {{$client->firstname}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class = "text-danger small mb-1"> @error('client') {{$message}} @enderror </div>
                                </div>
                            </div>

                            <!-- Location input -->
                            <label class="col-12 form-label" for="location">Location</label>
                            <div class="col-12 input-group mb-1">
                                <input type="text" id="location" name = "location" class="form-control w-100 mb-1" placeholder="Enter Location" value="{{$project->location}}"/>
                                <div class = "text-danger small"> @error('location') {{$message}} @enderror </div>
                            </div>
                        
                        
                                <!-- Contract Price input --> 
                                <div class="col-md-6">
                                    <label class="form-label" for="contract_price">Contract Price</label>
                                    <div class="input-group mb-1">
                                        <input type="text" id="contract_price" name = "contract_price" class="form-control w-100 mb-1" placeholder="Enter Contract Price" value = "{{$project->contractprice}}"/> 
                                        <div class = "text-danger small"> @error('contract_price') {{$message}} @enderror </div>
                                    </div>
                                </div>

                                <!-- Completion Date input --> 
                                <div class="col-md-6">
                                    <label class="form-label" for="completion_date">Completion Date</label>
                                    <div class="input-group mb-1">
                                        <input type="date" id="completion_date" name = "completion_date" class="form-control w-100 mb-1" value = "{{$project->completiondate}}"/> 
                                        <div class = "text-danger small"> @error('completion_date') {{$message}} @enderror </div>
                                    </div>
                                </div>
                    
                                
                            <!-- Phase input -->
                            <label class="col-12 form-label" for="phase">Phase</label>
                            <div class="col-12 input-group mb-3">
                                <select id="phase" name="phase" class="select2" style="width: 100%">
                                    <option value ="X - NOT STARTED">X - NOT STARTED</option>
                                    <option value ="A - GENERAL REQUIREMENTS AND SPECIAL CONDITIONS">A - GENERAL REQUIREMENTS AND SPECIAL CONDITIONS</option>
                                    <option value ="B - STAGING, FORMWORKS, SCAFFOLDING, and BUNKHOUSE">B - STAGING, FORMWORKS, SCAFFOLDING, and BUNKHOUSE</option>
                                    <option value ="C - SITE WORKS">C - SITE WORKS</option>
                                    <option value ="D - CONCRETE STRUCTURAL WORKS (Class A 1:2:4)">D - CONCRETE STRUCTURAL WORKS (Class A 1:2:4)</option>
                                    <option value ="E - MASONRY WORKS (Class B 1:3)">E - MASONRY WORKS (Class B 1:3)</option>
                                    <option value ="F - CARPENTRY WORKS">F - CARPENTRY WORKS</option>
                                    <option value ="G - PAINTING WORKS">G - PAINTING WORKS</option>
                                    <option value ="H - ELECTRICAL WORKS">H - ELECTRICAL WORKS</option>
                                    <option value ="I - PLUMBING WORKS">I - PLUMBING WORKS</option>
                                    <option value ="J - SPECIALTY ITEMS">J - SPECIALTY ITEMS</option>
                                    <option value ="K - OTHERS">K - OTHERS</option>
                                </select>
                            </div>

                            <!-- Submit button -->
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btnMain px-5 rounded-pill mb-3 btn-sm">Save Changes</button>
                                <button type="button" class="btn btn-secondary btnMain px-5 rounded-pill mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class = "col-lg-6 mx-auto clearfix mb-3">
                    <div class="py-3 px-5 bg-light">
                        <h4>
                            Tasks
                            <button type="button" onclick="notes()" class="btn btn-primary btn-sm rounded-pill px-5 float-end mb-3" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                                <i class="bi-plus-circle me-1"></i>        
                                New Task
                            </button>
                        </h4>
                        @include ('task')
                    </div>
                </div>
            </div>
            <!--add client modal-->
            <div class="modal fade modalSpecG" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addClientModalLabel">Add New Client</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="cancelAddClient()" aria-label="Close"></button>
                        </div>
                        <form action = "/add-client" method = "post">
                        @csrf
                            <div class="modal-body w-75 mx-auto">
                                <!-- First Name input -->
                                <label class="form-label" for="firstName">First Name</label>
                                <div class="input-group mb-1">
                                    <input type="text" id="firstName" name = "firstName" class="form-control w-100 mb-1" placeholder="Enter First Name" value="{{old('firstName')}}"/>
                                    <div class = "text-danger small"> @error('firstName') {{$message}} @enderror </div>
                                </div>

                                <!-- Last Name input -->
                                <label class="form-label" for="lastName">Last Name</label>
                                <div class="input-group mb-1">
                                    <input type="text" id="lastName" name = "lastName" class="form-control w-100 mb-1" placeholder="Enter Last Name" value="{{old('lastName')}}"/>
                                    <div class = "text-danger small"> @error('lastName') {{$message}} @enderror </div>
                                </div>

                                <!-- Phone input -->
                                <label class="form-label" for="phone">Contact No.</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="phone" name = "phone" class="form-control w-100 mb-1" placeholder="Enter Contact No." value="{{old('phone')}}"/>
                                    <div class = "text-danger small"> @error('phone') {{$message}} @enderror </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btnMain rounded-pill px-5 btn-sm">Save</button>
                                <button type="button" class="btn btn-secondary btnMain rounded-pill px-5 btn-sm" onclick="cancelAddClient()" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--cancel modal-->
            <div class="modal fade modalSpecG" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelModalLabel">Cancel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    
                        <div class="modal-body w-75 mx-auto">
                            Are you sure you want to cancel? Any changes made will be lost.
                        </div>
                        <div class="modal-footer">
                            <a href="/home" class="btn btnMain rounded-pill px-5 btn-primary btn-sm">Yes</a>
                            <button type="button" class="btn btn-secondary btnMain rounded-pill px-5 btn-sm" data-bs-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
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

                        <!-- Assigner ID input -->
                        <label class="form-label" for="creatorid" hidden>Creator ID</label>
                        <div class="input-group mb-3" hidden>
                            <input type="text" id="creatorid" name = "creatorid" class="form-control w-100 mb-1" value="{{$user->id}}"/>
                        </div>

                        <!-- Project ID input -->
                        <label class="form-label" for="project" hidden>Project ID</label>
                        <div class="input-group mb-3" hidden>
                            <input type="text" id="project" name = "project" class="form-control w-100 mb-1" value="{{$project->id}}"/>
                        </div>

                        <div class="mb-3">
                            <p class="mb-0">Created by: {{$user->lastname}}, {{$user->firstname}}</p>
                            <p>For project: <b>{{$project->id}} - {{$project->name}}</b></p>
                        </div>

                        <!-- Task Name input -->
                        <label class="form-label" for="task_name">Task Name</label>
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
            $('#clientSelect').on('change', function () {
                if ($(this).val() === 'add-new-client') {
                    $('#addClientModal').modal('show');
                }
            });
            $('#status').val("{{$project->status}}");
            $('#phase').val("{{$project->phase}}");
            $('.select2').select2();
            @if ($errors->has('task_name') || $errors->has('assignee'))
                $('#addTaskModal').modal('show'); // Show the modal if there are errors
            @endif
            @if ($errors->has('firstName') ||  $errors->has('lastName') || $errors->has('phone'))
                $('#addClientModal').modal('show'); // Show the modal if there are errors
            @endif
            @if (session('clientid'))
                var clientid = '{{ session('clientid') }}';
                $('#clientSelect').val(clientid).trigger('change');
                unset($_SESSION['clientid']);
            @endif
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
        
        function cancelAddClient() {
            $('#clientSelect').val("{{$project->clientid}}").trigger('change');
        };
    </script>

</body>
</html>