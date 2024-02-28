<!DOCTYPE html>
<html>
    <head>
        @include ('head')
        <style>
            #button {
                border: 0px;
                background-color: transparent;
            }
            #tooltip {
                background: white;
                color: black;
                padding: 4px 8px;
                font-size: 13px;
                border: 1px solid skyblue;
                border-radius: 4px;
                display: none;
                z-index: 1000;  
            }

            #tooltip[data-show] {
                display: block;
            }

            #arrow,
            #arrow::before {
                position: absolute;
                width: 8px;
                height: 8px;
                background: inherit;
            }

            #arrow {
                visibility: hidden;
            }

            #arrow::before {
                visibility: visible;
                content: '';
                transform: rotate(45deg);
            }

            #tooltip[data-popper-placement^='top'] > #arrow {
                bottom: -4px;
            }

            #tooltip[data-popper-placement^='bottom'] > #arrow {
                top: -4px;
            }

            #tooltip[data-popper-placement^='left'] > #arrow {
                right: -4px;
            }

            #tooltip[data-popper-placement^='right'] > #arrow {
                left: -4px;
            }
        </style>
        <title>Spec G | Reset Password</title>
    </head>
    <body class="landing">
        <div class="registerContent p-0">
            <div class="card px-0 col-md-6 mx-auto">        
                <img src="../images/specg.jpg" alt="Form header image" />
                <div class="card-body px-5">
                    <h3 class="mb-3">Reset Password</h3>
                    <form action = "/reset-password" method = "post">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <!-- Email input -->
                        <label class="form-label" for="email">Email</label>
                        <div class="input-group mb-3">
                            <input type="email" id="email" name = "email" class="form-control w-100 mb-1" placeholder="Enter Email" value="{{old('email')}}"/>
                            <div class = "text-danger small"> @error('email') {{$message}} @enderror </div>
                        </div>

                        <!-- Password input -->                                   
                        <label class="form-label float-start" for="password">
                            Password
                            <sup>
                                <span id ="button" class="p-0 btn-sm" aria-describedby="tooltip">
                                    <i class="bi-info-circle" style="color: blue; font-size: small"></i>
                                </span>
                            </sup>
                            <div id="tooltip" role="tooltip">
                                Minimum of 8 characters<br />
                                At least one lowercase letter<br />
                                At least one uppercase letter<br />
                                At least one digit<br />
                                At least one special character<br />
                                <div id="arrow" data-popper-arrow></div>
                            </div>
                        </label>
                        <div class="input-group mb-3">
                            <input type="password" id="password" name = "password" class="form-control" placeholder="Enter Password" value="{{old('password')}}"/>                                         
                            <button type="button" class="input-group-text fa-2x" onclick="showPw()">
                                <i class="bi-eye-fill" id="imgPw"></i>
                            </button>
                            <div class="w-100 mb-1"></div>    
                            <div class = "text-danger small"> @error('password'){{$message}} @enderror </div>
                        </div>
                        
                        <!-- Confirm Password input --> 
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <div class="input-group mb-4">
                            <input type="password" id="password_confirmation" name = "password_confirmation" class="form-control" placeholder="Reenter Password" value = ""/> 
                            <button type="button" class="input-group-text fa-2x" onclick="showCpw()">
                                <i class="bi-eye-fill" id="imgCpw"></i>
                            </button>
                        </div>

                        <!-- Submit button -->
                        <div class="d-grid col-md-5 mx-auto">
                            <button type="submit" class="btn btn-primary mb-3">Reset Password</button>
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
            function showCpw() {
                var cpw = document.getElementById("password_confirmation");
                var imgCpw = document.getElementById("imgCpw");

                if (cpw.type === "password") {
                    cpw.type = "text";
                    imgCpw.setAttribute("class", "bi-eye-slash-fill");
                } else {
                    cpw.type = "password";
                    imgCpw.setAttribute("class", "bi-eye-fill");
                }
            }
        </script>
        <script>
            const button = document.querySelector('#button');
            const tooltip = document.querySelector('#tooltip');
            const popperInstance = Popper.createPopper(button, tooltip, {
                placement: 'right',
                modifiers: [
                    {
                    name: 'offset',
                    options: {
                        offset: [0, 8],
                    },
                    },
                ],
            });

            function show() {
                tooltip.setAttribute('data-show', '');

                // Enable the event listeners
                popperInstance.setOptions((options) => ({
                    ...options,
                    modifiers: [
                        ...options.modifiers,
                        { name: 'eventListeners', enabled: true },
                    ],
                }));
                // We need to tell Popper to update the tooltip position
                // after we show the tooltip, otherwise it will be incorrect
                popperInstance.update();
            }

            function hide() {
                tooltip.removeAttribute('data-show');

                // Disable the event listeners
                popperInstance.setOptions((options) => ({
                    ...options,
                    modifiers: [
                        ...options.modifiers,
                        { name: 'eventListeners', enabled: false },
                    ],
                }));
            }

            const showEvents = ['mouseenter', 'focus'];
            const hideEvents = ['mouseleave', 'blur'];

            showEvents.forEach((event) => {
                button.addEventListener(event, show);
            });

            hideEvents.forEach((event) => {
                button.addEventListener(event, hide);
            });
        </script>
    </body>
</html>
