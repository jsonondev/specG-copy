<!DOCTYPE html>
<html>
    <head>
        @include ('head')
        <title>Spec G | Clients</title>
    </head>
    <body class="vh-100 webpage">
        @include ('navbar')
        <div class="col-md-10 mx-auto">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-3 ms-4">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Clients</li>
                </ol>
            </nav>
            <div class="container">
                <div class="row">
                    @if(Session::has('success'))
                        <div class="alert alert-success mb-2 clearfix">
                            <button type="button" class="btn-close btn-sm float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                            <span>{{Session::get('success')}}</span>
                        </div>
                    @endif
                    @if(Session::has('fail'))
                        <div class="alert alert-danger mb-2 clearfix">
                            <button type="button" class="btn-close btn-sm float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                            <span>{{Session::get('fail')}}</span>
                        </div>
                    @endif
                    <div class="col-md-8">
                        <h3>Client List</h3>
                        <div class="tableList bg-light">
                            <table id="list" class="table table-striped table-sm table-hover mx-auto">
                                <thead class="bg-white" style="position: sticky; top: 0">
                                    <th scope="col" style="width: 10%">#</th>
                                    <th scope="col" style="width: 10%">ID</th>
                                    <th scope="col" style="width: 30%">First Name</th>
                                    <th scope="col" style="width: 30%">Last Name</th>
                                    <th scope="col" style="width: 20%">Contact No</th>
                                </thead>
                                <tbody>
                                    @php $i = 1 @endphp
                                    @foreach ($clients as $client)
                                    <tr onclick="showDetails('{{$client->id}}','{{$client->firstname}}','{{$client->lastname}}','{{$client->phone}}')" onmouseover="showIcon(this)" onmouseleave="hideIcon(this)">
                                        <td>{{$i++}}</td>
                                        <td>{{$client->id}}</td>
                                        <td>{{$client->firstname}}</td>
                                        <td>{{$client->lastname}}</td>
                                        <td>
                                            {{$client->phone}}
                                            <i class="bi bi-caret-right-fill float-end" style="display:none"></i>
                                        </td> 
                                    </tr>
                                    @endforeach
                                </tbody>     
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <form id = "clientForm" action = "add-client" method = "post" class="w-75 mx-auto mt-5 bg-light p-3">
                            <h4 class="text-center">Client Details</h4> 
                            @csrf
                            <!-- ID  -->
                            <label class="form-label" for="id" hidden>Client ID</label>
                            <div class="input-group mb-1" hidden>
                                <input type="text" id="id" name = "id" class="form-control w-100 mb-1"/>
                            </div>
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
                            <label class="form-label" for="phone">
                                Phone
                                <sup>
                                    <i style="color: blue">"0-9" , "()"", and "-" only</i>
                                </sup>  
                            </label>
                            <div class="input-group mb-3">
                                <input type="text" id="phone" name = "phone" class="form-control w-100 mb-1" placeholder="Enter Contact No." value="{{old('phone')}}"/>
                                <div class = "text-danger small"> @error('phone') {{$message}} @enderror </div>
                            </div>

                            <!-- Submit button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btnMain rounded-pill btn-sm mb-2" id="btnEdit">Save Changes</button>          
                                <button type="submit" class="btn btn-primary btnMain rounded-pill btn-sm mb-2" id="btnAdd">Save</button>
                                <button type="button" class="btn btn-secondary btnMain rounded-pill btn-sm mb-3" onclick="clearDetails()">Clear</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var clientid = document.getElementById('id');
            var firstName = document.getElementById('firstName');
            var lastName = document.getElementById('lastName');
            var phone = document.getElementById('phone');
            var btnEdit = document.getElementById('btnEdit');
            var btnAdd = document.getElementById('btnAdd');

            window.addEventListener('load', function() {
                btnAdd.style.display = "block";
                btnEdit.style.display = "none";
                $('#list').DataTable();
                $('.dataTables_length').addClass('bs-select');
               //for nav active
                $('#nav-client').addClass('active');
                $('#nav-client').prop('aria-current','page');
                $('#nav-client').removeAttr('href');
                //end for nav active
            });
          
            function showDetails(client_id, first_name, last_name, phone_no) {
                clientid.value = client_id;
                firstName.value = first_name;
                lastName.value = last_name;
                phone.value = phone_no;
                btnEdit.style.display = 'block';
                btnAdd.style.display = 'none';
                clientForm.action = "edit-client" ;
            }

            function clearDetails() {
                clientid.value = '';
                firstName.value = '';
                lastName.value = '';
                phone.value = '';
                btnAdd.style.display = 'block';
                btnEdit.style.display = 'none';
                clientForm.action = "add-client" ;
            }

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
