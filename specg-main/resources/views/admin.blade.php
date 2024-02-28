<!DOCTYPE html>
<html>
<head>
    @include('head')
    <title>Spec G | Admin</title>
</head>
<body class="vh-100 webpage">
    @include('navbar')
    <div class="col-md-10 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3 ms-4">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Admin</li>
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
        <div class="col-md-10 mx-auto">
            <h3 class="w-100 mt-3">
                User Accounts
            </h3>
            <div class="tableList bg-light">
                <table id="list" class="table table-light table-striped table-sm table-hover">
                    <thead class="bg-white" style="position: sticky; top: 0">
                        <tr>
                            <th scope="col" style="width: 5%">#</th>
                            <th scope="col" style="width: 15%">Last Name</th>
                            <th scope="col" style="width: 15%">First Name</th>
                            <th scope="col" style="width: 20%">Email</th>
                            <th scope="col" style="width: 15%">Phone</th>
                            <th scope="col" style="width: 15%">Status</th>
                            <th scope="col" style="width: 15%">Actions</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1 @endphp
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$user->lastname}}</td>
                                <td>{{$user->firstname}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->status}}</td>
                                <td class="text-center">
                                    @if ($user->status == 'approved')
                                        <button type ="button" class="btn btn-primary btn-sm btnMain rounded-pill m-0" disabled>Approve</button>
                                    @else
                                        <a href="/approve-user/{{$user->id}}" class="btn btn-primary btn-sm btnMain rounded-pill m-0">Approve</a>
                                    @endif
                                    <button type="button" class="btn btn-danger btn-sm btnMain rounded-pill m-0" data-bs-toggle="modal" data-bs-target="#deleteModal{{$user->id}}">Remove</button>
                                </td>
                            </tr>
                            <!--delete modal-->
                            <div class="modal fade modalSpecG" id="deleteModal{{$user->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$user->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{$user->id}}">Remove</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body w-75 mx-auto">
                                            @if ($user->status == 'approved')
                                                Are you sure you want to remove approved user account? You cannot undo this action.
                                            @else
                                                Are you sure you want to remove sign up request? You cannot undo this action.
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <a href="/remove-user/{{$user->id}}" role="button" class="btn btn-primary btnMain px-5 rounded-pill btn-sm">Yes</a>
                                            <button type="button" class="btn btn-secondary btnMain px-5 rounded-pill btn-sm" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                    </tbody>     
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#list').DataTable();
            $('.dataTables_length').addClass('bs-select');
            //for nav active
            $('#nav-admin').addClass('active');
            $('#nav-admin').prop('aria-current','page');
            $('#nav-admin').removeAttr('href');
            //end for nav active
        });  
    </script>    
</body>
</html>