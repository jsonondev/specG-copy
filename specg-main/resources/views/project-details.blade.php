<!DOCTYPE html>
<html>
<head>
    @include('head')
    <title>Spec G | Add New Project</title>
</head>
<body class="vh-100 webpage">
    @include('navbar')
    <div class="col-md-10 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3 ms-4">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add New Project</li>
            </ol>
        </nav>
        <div class="container">
            <div class="row">
                <div class = "col-md-3"></div>
                <form action = "save-project" method = "post" class="bg-light col-md-6 py-3 px-5">
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
                    <h3>Add New Project</h3>    
                    <div class="my-3">
                        <i>Note: Select client for new project first</i>
                    </div>
                    @csrf
                   
                    <!-- Client Input -->
                    <label class="form-label" for="client">Client</label>
                    <div class="input-group mb-1">
                        <select id="clientSelect" name="client" class="select2 form-control mb-1" style="width: 100%">
                            <option disabled selected>Select Client</option>
                            <option value="add-new-client">Add New Client</option>
                            @foreach ($clients as $client)
                                <option value="{{$client->id}}" {{old('client') == $client->id ? 'selected' : 'Select Client' }}>{{$client->id}} - {{$client->lastname}}, {{$client->firstname}}</option>
                            @endforeach
                        </select>
                        <div class = "text-danger small mt-1"> @error('client') {{$message}} @enderror </div>
                    </div>

                    <!-- Name input -->
                    <label class="form-label" for="name">Project Name</label>
                    <div class="input-group mb-1">
                        <input type="text" id="name" name = "name" class="form-control w-100 mb-1" placeholder="Enter Project Name" value="{{old('name')}}" disabled/>
                        <div class = "text-danger small"> @error('name') {{$message}} @enderror </div>
                    </div>

                    <!-- Location input -->
                    <label class="form-label" for="location">Location</label>
                    <div class="input-group mb-1">
                        <input type="text" id="location" name = "location" class="form-control w-100 mb-1" placeholder="Enter Location" value="{{old('location')}}" disabled/>
                        <div class = "text-danger small"> @error('location') {{$message}} @enderror </div>
                    </div>
                
                    <div class="row">
                        <!-- Contract Price input --> 
                        <div class="col-md-6">
                            <label class="form-label" for="contract_price">Contract Price</label>
                            <div class="input-group mb-1">
                                <input type="text" id="contract_price" name = "contract_price" class="form-control w-100 mb-1" placeholder="Enter Contract Price" value = "{{old('contract_price')}}" disabled/> 
                                <div class = "text-danger small"> @error('contract_price') {{$message}} @enderror </div>
                            </div>
                        </div>

                        <!-- Completion Date input --> 
                        <div class="col-md-6">
                            <label class="form-label" for="completion_date">Completion Date</label>
                            <div class="input-group mb-3">
                                <input type="date" id="completion_date" name = "completion_date" class="form-control w-100 mb-1" value = "{{old('completion_date')}}" disabled/> 
                                <div class = "text-danger small"> @error('completion_date') {{$message}} @enderror </div>
                            </div>
                        </div>
                    </div>
                        
                    <!-- Submit button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btnMain px-5 rounded-pill mb-3 btn-sm">Save</button>
                        <button type="button" class="btn btn-secondary  btnMain px-5 rounded-pill mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancel</button>
                    </div>
                </form>
                <div class = "col-md-3"></div>
            </div>
        </div>
        <!--add client modal-->
        <div class="modal fade modalSpecG" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addClientModalLabel">Save</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="cancelAddClient()" aria-label="Close"></button>
                    </div>
                    <form action = "add-client" method = "post">
                        @csrf
                        <div class="modal-body">
                            <div class="w-75 mx-auto">
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
                                <div class="input-group mb-1">
                                    <input type="text" id="phone" name = "phone" class="form-control w-100 mb-1" placeholder="Enter Contact No." value="{{old('phone')}}"/>
                                    <div class = "text-danger small"> @error('phone') {{$message}} @enderror </div>
                                </div>
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
                        <a href="/home" class="btn btn-primary btnMain rounded-pill px-5 btn-sm">Yes</a>
                        <button type="button" class="btn btn-secondary  btnMain rounded-pill px-5 btn-sm" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            if ($('#clientSelect')[0].selectedIndex === 0) {
                $('#name').prop('disabled', true);
                $('#location').prop('disabled', true);
                $('#contract_price').prop('disabled', true);
                $('#completion_date').prop('disabled', true);
            }
            else {
                $('#name').prop('disabled', false);
                $('#location').prop('disabled', false);
                $('#contract_price').prop('disabled', false);
                $('#completion_date').prop('disabled', false);
            }

            $('#clientSelect').on('change', function () {
                if ($(this).val() === 'add-new-client') {
                    $('#addClientModal').modal('show');
                }
                else {
                    $('#name').prop('disabled', false);
                    $('#location').prop('disabled', false);
                    $('#contract_price').prop('disabled', false);
                    $('#completion_date').prop('disabled', false);
                }
            });
            $('.select2').select2();
            
            @if ($errors->has('firstName') ||  $errors->has('lastName') || $errors->has('phone'))
                $('#addClientModal').modal('show'); // Show the modal if there are errors
            @endif
            @if (session('clientid'))
                var clientid = '{{ session('clientid') }}';
                $('#clientSelect').val(clientid).trigger('change');
            @endif
        });

        function cancelAddClient() {
            document.getElementById('clientSelect').selectedIndex = 0;
            $('.select2').trigger('change');
            $('#name').prop('disabled', true);
            $('#location').prop('disabled', true);
            $('#contract_price').prop('disabled', true);
            $('#completion_date').prop('disabled', true);
        };
        
    </script>
</body>
</html>