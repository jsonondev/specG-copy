<!DOCTYPE html>
<html>
    <head>
        @include ('head')
        <title>Spec G | Log In</title>
    </head>
    <body class="landing">
        <div class="loginContent container p-0">
            <div class="row p-0">
                <div class="col-sm-1">
                </div>
                <div class="card px-0 col-auto">        
                    <img src="../images/specg.jpg" alt="Form header image"/>
                    <div class="card-body px-5">
                        <h3 class="mb-3">Log In</h3>
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
                        <form action = "/authenticate" method = "post">
                            @csrf
                            <!-- Username input -->
                            <label class="form-label" for="email">Email</label>
                            <div class="input-group mb-3">
                                <input type="email" id="email" name = "email" class="form-control form-control" placeholder="Enter Email" value="{{old('email')}}"/>
                                <div class="w-100 mb-1"></div>  
                                <div class = "text-danger small"> @error('email') {{$message}} @enderror </div>
                            </div>
                            
                            <!-- Password input -->
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group">
                                <input type="password" id="password" name = "password" class="form-control" placeholder="Enter Password" value="{{old('password')}}"/>                                         
                                <button type="button" class="input-group-text fa-2x" onclick="showPw()">
                                    <i class="bi-eye-fill" id="imgPw"></i>
                                </button>
                                <div class="w-100 mb-1"></div>  
                                <div class = "text-danger small">@error('password') {{$message}} @enderror </div>
                            </div>
                            <div class=" mb-4">
                                <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#passwordModal">Forgot Password</button>
                            </div>
                            <!-- Submit button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block mb-3">Log in</button>
                            </div>
                            <div class="text-center">
                                <p>Don't have an account? <a href="/register">Register here</a></p>
                            </div>
                        </form>
                    </div> 
                </div>
                <div class="col-sm-8">
                </div>
            </div>
        </div>
        <!--password modal-->
        <div class="modal fade modalSpecG" id="passwordModal" tabindex="-1" aria-labelledby="passModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="passwordModalLabel">Forgot Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action = "/forgot-password" method = "post"> 
                            <div class="modal-body w-75 mx-auto">
                                @csrf
                                <!-- Email input -->
                                <label class="form-label" for="email">Email</label>
                                <div class="input-group mb-3">
                                    <input type="email" id="email" name = "email" class="form-control w-100 mb-1" placeholder="Enter Email" value="{{old('email')}}"/>
                                </div>    
                            </div> 
                            <div class="modal-footer">
                                <button type="submit" class="btn btnMain rounded-pill px-5 btn-primary btn-sm">Confirm</button>
                                <button type="button" class="btn btn-secondary btnMain rounded-pill px-5 btn-sm" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        <script>
            function showPw() {
                var pw = document.getElementById("password");
                var imgPw = document.getElementById("imgPw");
                if (pw.type === "password") {
                    pw.type = "text";
                    imgPw.setAttribute("class", "bi-eye-slash-fill");
                } else {
                    pw.type = "password";
                    imgPw.setAttribute("class", "bi-eye-fill");
                }
            }
        </script>
    </body>
</html>
