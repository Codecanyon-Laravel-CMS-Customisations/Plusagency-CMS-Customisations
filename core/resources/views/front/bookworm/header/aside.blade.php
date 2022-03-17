  <!-- Account Sidebar Navigation - Mobile -->
  <aside id="sidebarContent9" class="u-sidebar u-sidebar__lg" aria-labelledby="sidebarNavToggler9">
      <div class="u-sidebar__scroller">
          <div class="u-sidebar__container">
              <div class="u-header-sidebar__footer-offset">
                  <!-- Toggle Button -->
                  <div class="d-flex align-items-center position-absolute top-0 right-0 z-index-2 mt-5 mr-md-6 mr-4">
                      <button type="button" class="close ml-auto" aria-controls="sidebarContent9" aria-haspopup="true"
                          aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false"
                          data-unfold-target="#sidebarContent9" data-unfold-type="css-animation"
                          data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight"
                          data-unfold-duration="500">
                          <span aria-hidden="true">Close <i class="fas fa-times ml-2"></i></span>
                      </button>
                  </div>
                  <!-- End Toggle Button -->

                  <!-- Content -->
                  <div class="js-scrollbar u-sidebar__body">
                      <div class="u-sidebar__content u-header-sidebar__content">
                          <form class="" method="POST" action="{{ route('user.login') }}">
                              @csrf
                              <!-- Login -->
                              <div id="login1" data-target-group="idForm1">
                                  <!-- Title -->
                                  <header class="border-bottom px-4 px-md-6 py-4">
                                      <h2 class="font-size-3 mb-0 d-flex align-items-center"><i
                                              class="flaticon-user mr-3 font-size-5"></i>Account</h2>
                                  </header>
                                  <!-- End Title -->

                                  <div class="p-4 p-md-6">
                                      <!-- Form Group -->
                                      <div class="form-group mb-4">
                                          <div class="js-form-message js-focus-state">
                                              <label id="signinEmailLabel9" class="form-label"
                                                  for="signinEmail">Username or email *</label>
                                              <input type="email" class="form-control rounded-0 height-4 px-4"
                                                  name="email" id="signinEmail9"
                                                  placeholder="creativelayers088@gmail.com"
                                                  aria-label="creativelayers088@gmail.com"
                                                  aria-describedby="signinEmailLabel9" novalidate>
                                              @if (Session::has('err'))
                                                  <p class="text-danger mb-2 mt-2">{{ Session::get('err') }}</p>
                                              @endif
                                              @error('email')
                                                  <p class="text-danger mb-2 mt-2">{{ convertUtf8($message) }}</p>
                                              @enderror
                                          </div>
                                      </div>
                                      <!-- End Form Group -->

                                      <!-- Form Group -->
                                      <div class="form-group mb-4">
                                          <div class="js-form-message js-focus-state">
                                              <label id="signinPasswordLabel9" class="form-label"
                                                  for="signinPassword">Password *</label>
                                              <input type="password" class="form-control rounded-0 height-4 px-4"
                                                  name="password" id="signinPassword9" placeholder="" aria-label=""
                                                  aria-describedby="signinPasswordLabel9" novalidate>
                                              @error('password')
                                                  <p class="text-danger mb-2 mt-2">{{ convertUtf8($message) }}</p>
                                              @enderror
                                          </div>
                                      </div>
                                      <!-- End Form Group -->

                                      <div class="d-flex justify-content-between mb-5 align-items-center">
                                          <!-- Checkbox -->
                                          <div class="js-form-message">
                                              <div
                                                  class="custom-control custom-checkbox d-flex align-items-center text-muted">
                                                  <input type="checkbox" class="custom-control-input"
                                                      id="termsCheckbox1" name="remember">
                                                  <label class="custom-control-label" for="termsCheckbox1">
                                                      <span class="font-size-2 text-secondary-gray-700">
                                                          Remember me
                                                      </span>
                                                  </label>
                                              </div>
                                          </div>
                                          <!-- End Checkbox -->

                                          <a class="js-animation-link text-dark font-size-2 t-d-u link-muted font-weight-medium"
                                              href="javascript:;" data-target="#forgotPassword1"
                                              data-link-group="idForm1" data-animation-in="fadeIn">Forgot Password?</a>
                                      </div>

                                      @if ($bs->is_recaptcha == 1)
                                          <div class="d-block mb-4">
                                              {!! NoCaptcha::renderJs() !!}
                                              {!! NoCaptcha::display() !!}
                                              @if ($errors->has('g-recaptcha-response'))
                                                  @php
                                                      $errmsg = $errors->first('g-recaptcha-response');
                                                  @endphp
                                                  <p class="text-danger mb-0 mt-2">{{ __("$errmsg") }}</p>
                                              @endif
                                          </div>
                                      @endif

                                      <div class="mb-4d75">
                                          <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Sign
                                              In</button>
                                      </div>

                                      <div class="mb-2">
                                          <a href="javascript:;"
                                              class="js-animation-link btn btn-block py-3 rounded-0 btn-outline-dark font-weight-medium"
                                              data-target="#signup1" data-link-group="idForm1"
                                              data-animation-in="fadeIn">Create Account</a>
                                      </div>
                                  </div>
                              </div>
                              <!-- End Login -->
                          </form>
                          <form class="" method="POST" action="{{ route('user-register-submit') }}">
                              @csrf
                              <!-- Signup -->
                              <div id="signup1" style="display: none; opacity: 0;" data-target-group="idForm1">
                                  <!-- Title -->
                                  <header class="border-bottom px-4 px-md-6 py-4">
                                      <h2 class="font-size-3 mb-0 d-flex align-items-center"><i
                                              class="flaticon-resume mr-3 font-size-5"></i>Create Account</h2>
                                  </header>
                                  <!-- End Title -->

                                  <div class="p-4 p-md-6">
                                      <!-- Form Group -->
                                      <div class="form-group mb-4">
                                          <div class="js-form-message js-focus-state">
                                              <label id="usernameLabel1" class="form-label"
                                                  for="username2">{{ __('Username') }} *</label>
                                              <input type="text" class="form-control rounded-0 height-4 px-4"
                                                  name="username" id="username2"
                                                  value="{{ Request::old('username') }}">
                                              @if ($errors->has('username'))
                                                  <p class="text-danger mb-0 mt-2">{{ $errors->first('username') }}
                                                  </p>
                                              @endif
                                          </div>
                                      </div>
                                      <!-- End Form Group -->

                                      <!-- Form Group -->
                                      <div class="form-group mb-4">
                                          <div class="js-form-message js-focus-state">
                                              <label id="signinEmailLabel11" class="form-label"
                                                  for="signinEmail11">Email *</label>
                                              <input type="email" class="form-control rounded-0 height-4 px-4"
                                                  name="email" id="signinEmail11"
                                                  placeholder="creativelayers088@gmail.com"
                                                  aria-label="creativelayers088@gmail.com"
                                                  aria-describedby="signinEmailLabel11" novalidate
                                                  value="{{ Request::old('email') }}">
                                              @if ($errors->has('email'))
                                                  <p class="text-danger mb-0 mt-2">{{ $errors->first('email') }}</p>
                                              @endif
                                          </div>
                                      </div>
                                      <!-- End Form Group -->

                                      <!-- Form Group -->
                                      <div class="form-group mb-4">
                                          <div class="js-form-message js-focus-state">
                                              <label id="signinPasswordLabel11" class="form-label"
                                                  for="signinPassword11">Password *</label>
                                              <input type="password" class="form-control rounded-0 height-4 px-4"
                                                  name="password" id="signinPassword11" placeholder="" aria-label=""
                                                  aria-describedby="signinPasswordLabel11" novalidate
                                                  value="{{ Request::old('password') }}">
                                              @if ($errors->has('password'))
                                                  <p class="text-danger mb-0 mt-2">{{ $errors->first('password') }}
                                                  </p>
                                              @endif
                                          </div>
                                      </div>
                                      <!-- End Form Group -->

                                      <!-- Form Group -->
                                      <div class="form-group mb-4">
                                          <div class="js-form-message js-focus-state">
                                              <label id="signupConfirmPasswordLabel9" class="form-label"
                                                  for="signupConfirmPassword9">Confirm Password *</label>
                                              <input type="password" class="form-control rounded-0 height-4 px-4"
                                                  id="signupConfirmPassword9" placeholder="" aria-label=""
                                                  aria-describedby="signupConfirmPasswordLabel9" novalidate
                                                  name="password_confirmation"
                                                  value="{{ Request::old('password_confirmation') }}">
                                              @if ($errors->has('password_confirmation'))
                                                  <p class="text-danger mb-0 mt-2">
                                                      {{ $errors->first('password_confirmation') }}</p>
                                              @endif
                                          </div>
                                      </div>
                                      <!-- End Input -->

                                      @if ($bs->is_recaptcha == 1)
                                          <div class="d-block mb-4">
                                              {!! NoCaptcha::renderJs() !!}
                                              {!! NoCaptcha::display() !!}
                                              @if ($errors->has('g-recaptcha-response'))
                                                  @php
                                                      $errmsg = $errors->first('g-recaptcha-response');
                                                  @endphp
                                                  <p class="text-danger mb-0 mt-2">{{ __("$errmsg") }}</p>
                                              @endif
                                          </div>
                                      @endif

                                      <div class="mb-3">
                                          <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Create
                                              Account</button>
                                      </div>

                                      <div class="text-center mb-4">
                                          <span class="small text-muted">Already have an account?</span>
                                          <a class="js-animation-link small" href="javascript:;" data-target="#login1"
                                              data-link-group="idForm1" data-animation-in="fadeIn">Login
                                          </a>
                                      </div>
                                  </div>
                              </div>
                              <!-- End Signup -->
                          </form>
                          <form class="" method="POST" action="{{ route('user-forgot-submit') }}">
                              @csrf
                              <!-- Forgot Password -->
                              <div id="forgotPassword1" style="display: none; opacity: 0;" data-target-group="idForm1">
                                  <!-- Title -->
                                  <header class="border-bottom px-4 px-md-6 py-4">
                                      <h2 class="font-size-3 mb-0 d-flex align-items-center"><i
                                              class="flaticon-question mr-3 font-size-5"></i>Forgot Password?</h2>
                                  </header>
                                  <!-- End Title -->

                                  <div class="p-4 p-md-6">
                                      <!-- Form Group -->
                                      <div class="form-group mb-4">
                                          <div class="js-form-message js-focus-state">
                                              <label id="signinEmailLabel33" class="form-label"
                                                  for="signinEmail33">Email *</label>
                                              <input type="email" class="form-control rounded-0 height-4 px-4"
                                                  name="email" id="signinEmail33"
                                                  placeholder="creativelayers088@gmail.com"
                                                  aria-label="creativelayers088@gmail.com"
                                                  aria-describedby="signinEmailLabel33" novalidate
                                                  value="{{ Request::old('email') }}">
                                              @error('email')
                                                  <p class="text-danger mb-2 mt-2">{{ convertUtf8($message) }}</p>
                                              @enderror
                                              @if (Session::has('err'))
                                                  <p class="text-danger mb-2 mt-2">{{ Session::get('err') }}</p>
                                              @endif
                                          </div>
                                      </div>
                                      <!-- End Form Group -->

                                      @if ($bs->is_recaptcha == 1)
                                          <div class="d-block mb-4">
                                              {!! NoCaptcha::renderJs() !!}
                                              {!! NoCaptcha::display() !!}
                                              @if ($errors->has('g-recaptcha-response'))
                                                  @php
                                                      $errmsg = $errors->first('g-recaptcha-response');
                                                  @endphp
                                                  <p class="text-danger mb-0 mt-2">{{ __("$errmsg") }}</p>
                                              @endif
                                          </div>
                                      @endif

                                      <div class="mb-3">
                                          <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Recover
                                              Password</button>
                                      </div>

                                      <div class="text-center mb-4">
                                          <span class="small text-muted">Remember your password?</span>
                                          <a class="js-animation-link small" href="javascript:;" data-target="#login1"
                                              data-link-group="idForm1" data-animation-in="fadeIn">Login
                                          </a>
                                      </div>
                                  </div>
                              </div>
                              <!-- End Forgot Password -->
                          </form>
                      </div>
                  </div>
                  <!-- End Content -->
              </div>
          </div>
      </div>
  </aside>
  <!-- End Account Sidebar Navigation - Mobile -->

  <!-- Account Sidebar Navigation - Desktop -->
  <aside id="sidebarContent" class="u-sidebar u-sidebar__lg" aria-labelledby="sidebarNavToggler">
      <div class="u-sidebar__scroller">
          <div class="u-sidebar__container">
              <div class="u-header-sidebar__footer-offset">
                  <!-- Toggle Button -->
                  <div class="d-flex align-items-center position-absolute top-0 right-0 z-index-2 mt-5 mr-md-6 mr-4">
                      <button type="button" class="close ml-auto" aria-controls="sidebarContent" aria-haspopup="true"
                          aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false"
                          data-unfold-target="#sidebarContent" data-unfold-type="css-animation"
                          data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight"
                          data-unfold-duration="500">
                          <span aria-hidden="true">Close <i class="fas fa-times ml-2"></i></span>
                      </button>
                  </div>
                  <!-- End Toggle Button -->

                  <!-- Content -->
                  <div class="js-scrollbar u-sidebar__body">
                      <div class="u-sidebar__content u-header-sidebar__content">
                          <form class="" method="POST" action="{{ route('user.login') }}">
                              @csrf
                              <!-- Login -->
                              <div id="login" data-target-group="idForm">
                                  <!-- Title -->
                                  <header class="border-bottom px-4 px-md-6 py-4">
                                      <h2 class="font-size-3 mb-0 d-flex align-items-center"><i
                                              class="flaticon-user mr-3 font-size-5"></i>Account</h2>
                                  </header>
                                  <!-- End Title -->

                                  <div class="p-4 p-md-6">
                                      <!-- Form Group -->
                                      <div class="form-group mb-4">
                                          <div class="js-form-message js-focus-state">
                                              <label id="signinEmailLabel" class="form-label"
                                                  for="signinEmail">Username or email *</label>
                                              <input type="email" class="form-control rounded-0 height-4 px-4"
                                                  name="email" id="signinEmail"
                                                  placeholder="creativelayers088@gmail.com"
                                                  aria-label="creativelayers088@gmail.com"
                                                  aria-describedby="signinEmailLabel" novalidate>
                                              @if (Session::has('err'))
                                                  <p class="text-danger mb-2 mt-2">{{ Session::get('err') }}</p>
                                              @endif
                                              @error('email')
                                                  <p class="text-danger mb-2 mt-2">{{ convertUtf8($message) }}</p>
                                              @enderror
                                          </div>
                                      </div>
                                      <!-- End Form Group -->

                                      <!-- Form Group -->
                                      <div class="form-group mb-4">
                                          <div class="js-form-message js-focus-state">
                                              <label id="signinPasswordLabel" class="form-label"
                                                  for="signinPassword">Password *</label>
                                              <input type="password" class="form-control rounded-0 height-4 px-4"
                                                  name="password" id="signinPassword" placeholder="" aria-label=""
                                                  aria-describedby="signinPasswordLabel" novalidate>
                                              @error('password')
                                                  <p class="text-danger mb-2 mt-2">{{ convertUtf8($message) }}</p>
                                              @enderror
                                          </div>
                                      </div>
                                      <!-- End Form Group -->

                                      <div class="d-flex justify-content-between mb-5 align-items-center">
                                          <!-- Checkbox -->
                                          <div class="js-form-message">
                                              <div
                                                  class="custom-control custom-checkbox d-flex align-items-center text-muted">
                                                  <input type="checkbox" class="custom-control-input"
                                                      id="termsCheckbox" name="remember">
                                                  <label class="custom-control-label" for="termsCheckbox">
                                                      <span class="font-size-2 text-secondary-gray-700">
                                                          Remember me
                                                      </span>
                                                  </label>
                                              </div>
                                          </div>
                                          <!-- End Checkbox -->

                                          <a class="js-animation-link text-dark font-size-2 t-d-u link-muted font-weight-medium"
                                              href="javascript:;" data-target="#forgotPassword" data-link-group="idForm"
                                              data-animation-in="fadeIn">Forgot Password?</a>
                                      </div>

                                      @if ($bs->is_recaptcha == 1)
                                          <div class="d-block mb-4">
                                              {!! NoCaptcha::renderJs() !!}
                                              {!! NoCaptcha::display() !!}
                                              @if ($errors->has('g-recaptcha-response'))
                                                  @php
                                                      $errmsg = $errors->first('g-recaptcha-response');
                                                  @endphp
                                                  <p class="text-danger mb-0 mt-2">{{ __("$errmsg") }}</p>
                                              @endif
                                          </div>
                                      @endif

                                      <div class="mb-4d75">
                                          <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Sign
                                              In</button>
                                      </div>

                                      <div class="mb-2">
                                          <a href="javascript:;"
                                              class="js-animation-link btn btn-block py-3 rounded-0 btn-outline-dark font-weight-medium"
                                              data-target="#signup" data-link-group="idForm"
                                              data-animation-in="fadeIn">Create Account</a>
                                      </div>
                                  </div>
                              </div>
                              <!-- End Login -->
                          </form>
                          <form class="" method="POST" action="{{ route('user-register-submit') }}">
                              @csrf
                              <!-- Signup -->
                              <div id="signup" style="display: none; opacity: 0;" data-target-group="idForm">
                                  <!-- Title -->
                                  <header class="border-bottom px-4 px-md-6 py-4">
                                      <h2 class="font-size-3 mb-0 d-flex align-items-center"><i
                                              class="flaticon-resume mr-3 font-size-5"></i>Create Account</h2>
                                  </header>
                                  <!-- End Title -->

                                  <div class="p-4 p-md-6">
                                      <!-- Form Group -->
                                      <div class="form-group mb-4">
                                          <div class="js-form-message js-focus-state">
                                              <label id="usernameLabel1" class="form-label"
                                                  for="username1">{{ __('Username') }} *</label>
                                              <input type="text" class="form-control rounded-0 height-4 px-4"
                                                  name="username" id="username1"
                                                  value="{{ Request::old('username') }}">
                                              @if ($errors->has('username'))
                                                  <p class="text-danger mb-0 mt-2">{{ $errors->first('username') }}
                                                  </p>
                                              @endif
                                          </div>
                                      </div>
                                      <!-- End Form Group -->

                                      <!-- Form Group -->
                                      <div class="form-group mb-4">
                                          <div class="js-form-message js-focus-state">
                                              <label id="signinEmailLabel1" class="form-label"
                                                  for="signinEmail1">Email *</label>
                                              <input type="email" class="form-control rounded-0 height-4 px-4"
                                                  name="email" id="signinEmail1"
                                                  placeholder="creativelayers088@gmail.com"
                                                  aria-label="creativelayers088@gmail.com"
                                                  aria-describedby="signinEmailLabel1" novalidate
                                                  value="{{ Request::old('email') }}">
                                              @if ($errors->has('email'))
                                                  <p class="text-danger mb-0 mt-2">{{ $errors->first('email') }}</p>
                                              @endif
                                          </div>
                                      </div>
                                      <!-- End Form Group -->

                                      <!-- Form Group -->
                                      <div class="form-group mb-4">
                                          <div class="js-form-message js-focus-state">
                                              <label id="signinPasswordLabel1" class="form-label"
                                                  for="signinPassword1">Password *</label>
                                              <input type="password" class="form-control rounded-0 height-4 px-4"
                                                  name="password" id="signinPassword1" placeholder="" aria-label=""
                                                  aria-describedby="signinPasswordLabel1" novalidate
                                                  value="{{ Request::old('password') }}">
                                              @if ($errors->has('password'))
                                                  <p class="text-danger mb-0 mt-2">{{ $errors->first('password') }}
                                                  </p>
                                              @endif
                                          </div>
                                      </div>
                                      <!-- End Form Group -->

                                      <!-- Form Group -->
                                      <div class="form-group mb-4">
                                          <div class="js-form-message js-focus-state">
                                              <label id="signupConfirmPasswordLabel" class="form-label"
                                                  for="signupConfirmPassword">Confirm Password *</label>
                                              <input type="password" class="form-control rounded-0 height-4 px-4"
                                                  id="signupConfirmPassword" placeholder="" aria-label=""
                                                  aria-describedby="signupConfirmPasswordLabel" novalidate
                                                  name="password_confirmation"
                                                  value="{{ Request::old('password_confirmation') }}">
                                              @if ($errors->has('password_confirmation'))
                                                  <p class="text-danger mb-0 mt-2">
                                                      {{ $errors->first('password_confirmation') }}</p>
                                              @endif
                                          </div>
                                      </div>
                                      <!-- End Input -->

                                      @if ($bs->is_recaptcha == 1)
                                          <div class="d-block mb-4">
                                              {!! NoCaptcha::renderJs() !!}
                                              {!! NoCaptcha::display() !!}
                                              @if ($errors->has('g-recaptcha-response'))
                                                  @php
                                                      $errmsg = $errors->first('g-recaptcha-response');
                                                  @endphp
                                                  <p class="text-danger mb-0 mt-2">{{ __("$errmsg") }}</p>
                                              @endif
                                          </div>
                                      @endif

                                      <div class="mb-3">
                                          <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Create
                                              Account</button>
                                      </div>

                                      <div class="text-center mb-4">
                                          <span class="small text-muted">Already have an account?</span>
                                          <a class="js-animation-link small" href="javascript:;" data-target="#login"
                                              data-link-group="idForm" data-animation-in="fadeIn">Login
                                          </a>
                                      </div>
                                  </div>
                              </div>
                              <!-- End Signup -->
                          </form>
                          <form class="" method="POST" action="{{ route('user-forgot-submit') }}">
                              @csrf
                              <!-- Forgot Password -->
                              <div id="forgotPassword" style="display: none; opacity: 0;" data-target-group="idForm">
                                  <!-- Title -->
                                  <header class="border-bottom px-4 px-md-6 py-4">
                                      <h2 class="font-size-3 mb-0 d-flex align-items-center"><i
                                              class="flaticon-question mr-3 font-size-5"></i>Forgot Password?</h2>
                                  </header>
                                  <!-- End Title -->

                                  <div class="p-4 p-md-6">
                                      <!-- Form Group -->
                                      <div class="form-group mb-4">
                                          <div class="js-form-message js-focus-state">
                                              <label id="signinEmailLabel3" class="form-label"
                                                  for="signinEmail3">Email *</label>
                                              <input type="email" class="form-control rounded-0 height-4 px-4"
                                                  name="email" id="signinEmail3"
                                                  placeholder="creativelayers088@gmail.com"
                                                  aria-label="creativelayers088@gmail.com"
                                                  aria-describedby="signinEmailLabel3" novalidate
                                                  value="{{ Request::old('email') }}">
                                              @error('email')
                                                  <p class="text-danger mb-2 mt-2">{{ convertUtf8($message) }}</p>
                                              @enderror
                                              @if (Session::has('err'))
                                                  <p class="text-danger mb-2 mt-2">{{ Session::get('err') }}</p>
                                              @endif
                                          </div>
                                      </div>
                                      <!-- End Form Group -->

                                      @if ($bs->is_recaptcha == 1)
                                          <div class="d-block mb-4">
                                              {!! NoCaptcha::renderJs() !!}
                                              {!! NoCaptcha::display() !!}
                                              @if ($errors->has('g-recaptcha-response'))
                                                  @php
                                                      $errmsg = $errors->first('g-recaptcha-response');
                                                  @endphp
                                                  <p class="text-danger mb-0 mt-2">{{ __("$errmsg") }}</p>
                                              @endif
                                          </div>
                                      @endif

                                      <div class="mb-3">
                                          <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Recover
                                              Password</button>
                                      </div>

                                      <div class="text-center mb-4">
                                          <span class="small text-muted">Remember your password?</span>
                                          <a class="js-animation-link small" href="javascript:;" data-target="#login"
                                              data-link-group="idForm" data-animation-in="fadeIn">Login
                                          </a>
                                      </div>
                                  </div>
                              </div>
                              <!-- End Forgot Password -->
                          </form>
                      </div>
                  </div>
                  <!-- End Content -->
              </div>
          </div>
      </div>
  </aside>
  <!-- End Account Sidebar Navigation - Desktop -->

  @include('front.bookworm.header.cart')
  @include('front.bookworm.header.wishlist')
