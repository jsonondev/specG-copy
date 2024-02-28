@if ($tasks->isEmpty())
<div class="ps-5">
    <i class="fs-3">No tasks</i>
</div>
@else
@foreach ($tasks as $task)
    <div class="card taskCard mb-2 w-100">
        <div class="card-body d-flex flex-column p-0">
            @if ($task->status == "Done")
                <div class="card-header text-end mb-1 pe-3 py-0">
                    <small style="color:green" class="me-1"><b>{{$task->status}}</b></small>
                    <i class="bi-check-circle-fill" style="color:green"> </i>
                </div>
            @else
                <div class="card-header text-end py-0 clear-fix">
                    <button type="button" class="btn btn-link float-start btn-sm p-0" data-bs-toggle="modal" data-bs-target="#deleteTaskModal{{$task->id}}">
                        <i class="bi-trash3-fill" style="color:blue"> </i>
                    </button>
                    <small style="color:red" class="me-1"><b>{{$task->status}}</b></small>
                    <i class="bi-exclamation-circle-fill" style="color:red"> </i>   
                    </div>
            @endif
            <b class="card-title px-3 mb-0">{{$task->taskname}}</b>
            <a href="/view-project/{{$task->projectid}}"class="my-0 px-3 projectLink" hidden><small>{{$task->name}}</small></a>
            <small class="py-1">
                <p class="card-subtitle px-3 text-muted">
                    Assigned to: {{$task->alastname}}, {{$task->afirstname}} 
                </p>
                <p class="card-text px-3 mb-2">
                    Notes: 
                    @if (is_null($task->notes)) 
                        <i class="text-muted">no notes</i>
                    @else
                        {{$task->notes}}
                    @endif
                    <br />
                    @if (!is_null($task->reply)) 
                        Reply: {{$task->reply}}
                    @endif
                </p>
            </small>    
            <div class="card-footer mt-auto text-muted clearfix">
                <small>
                    <p class="mb-0">Created by: {{$task->clastname}}, {{$task->cfirstname}}</p>
                    <p class="mb-0">
                        Created on: {{$task->created_at}}
                        @if ($task->status == "Open" && $user->id == $task->assigneeid)
                            <button type="button" class="btn btn-link btn-sm align-self-end float-end p-0" onclick="closeTask('{{$task->id}}')" data-bs-toggle="modal" data-bs-target="#closeTaskModal{{$task->id}}">Mark as Done</button>
                        @endif
                    </p>
                </small>
            </div>
        </div>
    </div>
    <!--close task modal-->
    <div class="modal fade modalSpecG" id="closeTaskModal{{$task->id}}" tabindex="-1" aria-labelledby="closeTaskModalLabel{{$task->id}}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="closeTaskModalLabel{{$task->id}}">Mark as "Done"</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action = "/close-task" method = "post">
                    @csrf
                    <div class="modal-body w-75 mx-auto">
                        <!-- Task ID input -->
                        <label class="form-label" for="taskid" hidden>Task ID</label>
                        <div class="input-group mb-3" hidden>
                            <input type="text" id="taskid" name = "taskid" class="form-control w-100 mb-1" value="{{$task->id}}"/>
                        </div>

                        <!-- Project ID input -->
                        <label class="form-label" for="projectid" hidden>Project ID</label>
                        <div class="input-group mb-3" hidden>
                            <input type="text" id="projectid" name = "projectid" class="form-control w-100 mb-1" value="{{$task->projectid}}"/>
                        </div>
                        
                        <div class="mb-3">
                            Task Name: {{$task->taskname}}<br />
                            Assigned to: {{$task->alastname}}, {{$task->afirstname}}<br />
                            Created by: {{$task->clastname}}, {{$task->cfirstname}}<br />
                            Created on: {{$task->created_at}}<br /><br />
                            Notes: 
                                @if (is_null($task->notes))
                                    <i>none</i>
                                @else
                                    {{$task->notes}}
                                @endif
                                    
                        </div> 
                        
                        <!-- Reply -->
                        <label class="form-label" for="reply">Reply</label>
                        <div class="input-group mb-3">
                            <textarea type="text" id="reply" name = "reply" class="reply form-control w-100 mb-1" placeholder="(optional)">                            
                            </textarea>
                        </div>

                        <i class="bi-exclamation-triangle-fill me-1" style="color: rgb(246,190,0)"></i>
                        <i>Warning: You cannot undo this action.</i>
                        <i class="bi-exclamation-triangle-fill me-1" style="color: rgb(246,190,0)"></i>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btnMain rounded-pill px-5 btn-sm">Save</button>
                        <button type="button" class="btn btn-secondary rounded-pill px-5 btn-sm" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
     <!--delete task modal-->
     <div class="modal fade modalSpecG" id="deleteTaskModal{{$task->id}}" tabindex="-1" aria-labelledby="deleteTaskModalLabel{{$task->id}}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteTaskModalLabel{{$task->id}}">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action = "/delete-task" method = "post">
                    @csrf
                    <div class="modal-body w-75 mx-auto">
                        <!-- Task ID input -->
                        <label class="form-label" for="deletetaskid" hidden>Task ID</label>
                        <div class="input-group mb-3" hidden>
                            <input type="text" id="deletetaskid" name = "deletetaskid" class="form-control w-100 mb-1" value="{{$task->id}}"/>
                        </div>

                        <div class="mb-3">
                            <b>Are you sure you want to delete this task?</b><br />
                            <br />
                            Task Name: {{$task->taskname}}<br />
                            Assigned to: {{$task->alastname}}, {{$task->afirstname}}<br />
                            Created by: {{$task->clastname}}, {{$task->cfirstname}}<br />
                            Created on: {{$task->created_at}}<br /><br />
                            Notes: 
                                @if (is_null($task->notes))
                                    <i>none</i>
                                @else
                                    {{$task->notes}}
                                @endif
                                    
                        </div> 

                        <i class="bi-exclamation-triangle-fill me-1" style="color: rgb(246,190,0)"></i>
                        <i>Warning: You cannot undo this action.</i>
                        <i class="bi-exclamation-triangle-fill me-1" style="color: rgb(246,190,0)"></i>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btnMain rounded-pill px-5 btn-sm">Yes</button>
                        <button type="button" class="btn btn-secondary rounded-pill px-5 btn-sm" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endif


