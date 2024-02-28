<!DOCTYPE html>
<html>
<head>
    @include('head')
    <title>Spec G | Project Files</title>
</head>
<body class="vh-100 webpage">
    @include('navbar')
    <div class="col-md-10 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3 ms-4">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item"><a href="/view-project/{{$project->id}}">View/Update Project</a></li>
                <li class="breadcrumb-item active" aria-current="page">Project Files</li>
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
        <div class="col-md-8 mx-auto">
            <h3 class="w-100 clearfix mt-3">
                Project Files
                <button role="button" class="btn text-light bg-primary btn-sm rounded-pill float-end me-2 px-5 btnMain" data-bs-toggle="modal" data-bs-target="#addFileModal">
                    <i class="bi-plus-circle me-1"></i>
                    New File
                </button>
            </h3>
            <i class="fs-6">Project: {{$project->id}} - {{$project->name}}</i>
            <div class="tableList bg-light mt-2">
                <table id="list" class="table table-light table-striped table-sm table-hover">
                    <thead class="bg-white" style="position: sticky; top: 0">
                        <tr>
                            <th scope="col" style="width: 10%">#</th>
                            <th scope="col" style="width: 65%">File</th>
                            <th scope="col" style="width: 25%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1 @endphp
                        @foreach ($files as $file)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$file->filename}}</td>
                                <td>
                                    <a href="#" class="btn btn-link p-0 m-0" onclick="window.open('{{asset('files/'.$file->filename)}}','_blank'); return false;">View</a>&nbsp;|&nbsp;
                                    <button type="button" class="btn btn-link p-0 m-0" onclick="editFile({{$file->id}})" data-bs-toggle="modal" data-bs-target="#editFileModal{{$file->id}}">Edit</button>&nbsp;|&nbsp;
                                    <button type="button" class="btn btn-link p-0 m-0" data-bs-toggle="modal" data-bs-target="#deleteFileModal{{$file->id}}">Delete</button>
                                </td>
                            </tr>
                             <!--delete file modal-->
                             <div class="modal fade modalSpecG" id="deleteFileModal{{$file->id}}" tabindex="-1" aria-labelledby="deleteFileModalLabel{{$file->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteFileModalLabel{{$file->id}}">Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body w-75 mx-auto">
                                            Are you sure you want to delete file? You cannot undo this action.
                                        </div>
                                        <div class="modal-footer">
                                            <a href="/delete-file/{{$file->id}}" role="button" class="btn btn-primary btnMain px-5 rounded-pill btn-sm">Delete</a>
                                            <button type="button" class="btn btn-secondary btnMain px-5 rounded-pill btn-sm" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--edit file modal-->
                            <div class="modal fade modalSpecG" id="editFileModal{{$file->id}}" tabindex="-1" aria-labelledby="editFileModalLabel{{$file->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editFileModalLabel{{$file->id}}">Edit File</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action = "/edit-file" method = "post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body w-75 mx-auto">
                                                <i>Reminder: <br />
                                                    1. Selecting a different project will associate the file to that project <br />
                                                    2. Inputting a different filename will rename the file<br />
                                                    3. Selecing a new file will overwrite the previous file. Do not select a file if you wish to retain previous file.<br />
                                                </i>

                                                <!-- File input -->
                                                <label class="col-12 form-label" for="fileid" hidden>File</label>
                                                <div class="col-12 input-group mb-3" hidden>
                                                    <input type="text" id="fileid" name="fileid" class="form-control w-100 mb-1" value="{{$file->id}}"/>
                                                </div>

                                                <!-- Project ID input -->
                                                <label class="col-12 form-label mt-3" for="project">Project</label>
                                                <div class="col-12 input-group mb-3">
                                                    <select id="projSelect{{$file->id}}" name="project" class="select2 mb-1" style="width: 100%">
                                                        <option disabled>Select Project</option>
                                                        @foreach ($projs as $proj)
                                                            @if ($proj->id == $file->projID)
                                                                <option selected value="{{$proj->id}}" {{old('project') == $proj->id ? 'selected' : 'Select Project' }}>{{$proj->id}} - {{$proj->name}}</option>
                                                            @else
                                                                <option value="{{$proj->id}}" {{old('project') == $proj->id ? 'selected' : 'Select Project' }}>{{$proj->id}} - {{$proj->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <div class = "text-danger small mt-1"> @error('project') {{$message}} @enderror </div>
                                                </div>

                                                <!-- File Name input -->
                                                <label class="form-label" for="filename">File Name</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" id="filename" name = "filename" class="form-control w-100 mb-1" placeholder="Enter File Name" value="{{$file->filename}}"/>
                                                    <div class = "text-danger small"> @error('filename') {{$message}} @enderror </div>
                                                </div>

                                                <!-- File input -->
                                                <label class="col-12 form-label" for="file">
                                                    File
                                                </label>
                                                <div class="col-12 input-group mb-3">
                                                    <input type="file" id="file" name="file" class="form-control w-100 mb-1"/>
                                                    <span class = "text-danger"> @error('file') {{$message}} @enderror </span>
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
                        @endforeach
                    </tbody>     
                </table>
            </div>
        </div>
    </div>
     <!--add task modal-->
    <div class="modal fade modalSpecG" id="addFileModal" tabindex="-1" aria-labelledby="addFileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFileModalLabel">Add New File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action = "/add-file" method = "post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body w-75 mx-auto">

                        <!-- Project ID input -->
                        <label class="col-12 form-label" for="project" hidden>Project</label>
                        <div class="col-12 input-group mb-3" hidden>
                            <input type="text" id="project" name="project" class="form-control w-100 mb-1" value="{{$project->id}}"/>
                        </div>

                        <!-- File input -->
                        <label class="col-12 form-label" for="file">File</label>
                        <div class="col-12 input-group mb-3">
                            <input type="file" id="file" name="file" class="form-control w-100 mb-1" />
                            <span class = "text-danger"> @error('file') {{$message}} @enderror </span>
                        </div>

                        <!-- File Name input -->
                        <label class="form-label" for="filename">File Name</label>
                        <div class="input-group mb-3">
                            <input type="text" id="filename" name = "filename" class="form-control w-100 mb-1" placeholder="Enter File Name" value="{{old('filename')}}"/>
                            <div class = "text-danger small"> @error('filename') {{$message}} @enderror </div>
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
            $('.select2').select2();
            @if ($errors->has('filename') ||  $errors->has('file'))
                $('#addFileModal').modal('show'); // Show the modal if there are errors
            @endif
            $("#projSelect").select2({
                dropdownParent: $("#addFileModal")
            });
        });
        function editFile(fileId) {
            $("#projSelect"+fileId).select2({
                dropdownParent: $("#editFileModal"+fileId)
            });
        }  

    </script>
    
</body>
</html>