<!DOCTYPE html>
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('/assets/') }}"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Login | EduStaff</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset("/assets/img/logo/smkn1cmi_logo.png")}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}" />
    <!-- Helpers -->
    <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>
    <script src="{{asset('assets/js/config.js')}}"></script>

    <style>
        /* Ensure body and html take full height */
        html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        }

        /* Background image and particles */
        #particles-js {
        position: absolute;
        width: 100%;
        height: 100%;
        background-image: url('{{asset("/assets/img/backgrounds/bg_web_administrasi_pegawai.jpg")}}');
        background-size: cover;
        background-position: center;
        z-index: -1;
        }

        /* Add overlay to darken the background */
        #particles-js::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Darkens the background */
        z-index: 1;
        }

        /* Form transparency */
        .transparent-card {
        position: relative;
        z-index: 2; /* Ensure it is above the overlay */
        background-color: rgba(255, 255, 255, 0.8); /* White with 80% opacity */
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Padding to center the form */
        .container-p-y {
        padding-top: 100px;
        }

        /* Make sure the body is scrollable only if content exceeds window size */
        body {
        overflow: hidden;
        }


    </style>
  </head>

  <body>
    <!-- Content -->

    <div>
        <div id="particles-js"></div>
        <div class="authentication-wrapper authentication-basic container-p-y px-2">
          <div>
            <!-- Register -->
            <div class="card transparent-card" style="max-width: 450px; min-width: 100%;">
                <div class="card-header text-center">{{ __('Reset Password') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input type="email" name="email" class="form-control" id="email" required autofocus>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('New Password') }}</label>
                            <div class="input-group input-group-merge">
                                <input type="password" name="password" class="form-control" id="password" required>
                                <span class="input-group-text cursor-pointer" onclick="togglePassword('password')"><i class="bx bx-hide" id="passwordEye"></i></span>
                            </div>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                            <div class="input-group input-group-merge">
                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                                <span class="input-group-text cursor-pointer" onclick="togglePassword('password_confirmation')"><i class="bx bx-hide" id="passwordConfirmationEye"></i></span>
                            </div>
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <script>
                            function togglePassword(id) {
                                const input = document.getElementById(id);
                                const eye = document.getElementById(id + 'Eye');

                                if (input.type === 'password') {
                                    input.type = 'text';
                                    eye.classList.remove('bx-hide');
                                    eye.classList.add('bx-show');
                                } else {
                                    input.type = 'password';
                                    eye.classList.remove('bx-show');
                                    eye.classList.add('bx-hide');
                                }
                            }
                        </script>

                        <button type="submit" class="btn btn-primary w-100" id="resetPasswordBtn" {{ (request()->input()) ? '' : 'disabled' }}><i class="bx bx-lock me-2"></i> {{ __('Reset Password') }}</button>
                        <span id="loading-icon" style="display: none;"><i class="bx bx-loader bx-spin me-2"></i> {{ __('Processing...') }}</span>
                        <script>
                            document.getElementById('resetPasswordBtn').addEventListener('click', function() {
                                document.getElementById('resetPasswordBtn').style.display = 'none';
                                document.getElementById('loading-icon').style.display = 'inline';
                            });

                            const inputs = document.querySelectorAll('input');
                            inputs.forEach(input => {
                                input.addEventListener('input', function() {
                                    if (inputs.every(input => input.value !== '')) {
                                        document.getElementById('resetPasswordBtn').removeAttribute('disabled');
                                    } else {
                                        document.getElementById('resetPasswordBtn').setAttribute('disabled', '');
                                    }
                                });
                            });
                        </script>
                    </form>
                </div>
              </div>
            </div>            
            <!-- /Register -->
          </div>
        </div>
      </div>      
    <!-- / Content -->
    
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

    <script src="{{asset('assets/vendor/js/menu.js')}}"></script>
    <!-- endbuild -->
    <!-- Vendors JS -->
    <!-- Main JS -->
    <script src="{{asset('assets/js/main.js')}}"></script>

    <!-- Page JS -->
    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script>
    particlesJS('particles-js', {
    "particles": {
        "number": {
        "value": 80,
        "density": {
            "enable": true,
            "value_area": 800
        }
        },
        "color": {
        "value": "#ffffff"
        },
        "shape": {
        "type": "circle",
        "stroke": {
            "width": 0,
            "color": "#000000"
        },
        "polygon": {
            "nb_sides": 5
        }
        },
        "opacity": {
        "value": 0.5,
        "random": false,
        "anim": {
            "enable": false,
            "speed": 1,
            "opacity_min": 0.1,
            "sync": false
        }
        },
        "size": {
        "value": 3,
        "random": true,
        "anim": {
            "enable": false,
            "speed": 40,
            "size_min": 0.1,
            "sync": false
        }
        },
        "line_linked": {
        "enable": true,
        "distance": 150,
        "color": "#ffffff",
        "opacity": 0.4,
        "width": 1
        },
        "move": {
        "enable": true,
        "speed": 6,
        "direction": "none",
        "random": false,
        "straight": false,
        "out_mode": "out",
        "attract": {
            "enable": false,
            "rotateX": 600,
            "rotateY": 1200
        }
        }
    },
    "interactivity": {
        "detect_on": "canvas",
        "events": {
        "onhover": {
            "enable": true,
            "mode": "repulse"
        },
        "onclick": {
            "enable": true,
            "mode": "push"
        },
        "resize": true
        },
        "modes": {
        "grab": {
            "distance": 400,
            "line_linked": {
            "opacity": 1
            }
        },
        "bubble": {
            "distance": 400,
            "size": 40,
            "duration": 2,
            "opacity": 8,
            "speed": 3
        },
        "repulse": {
            "distance": 200
        },
        "push": {
            "particles_nb": 4
        },
        "remove": {
            "particles_nb": 2
        }
        }
    },
    "retina_detect": true
    });
    </script>

  </body>
</html>
