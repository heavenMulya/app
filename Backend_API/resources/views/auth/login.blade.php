<!doctype html>
<html lang="en">
  <head>
  	<title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="{{ asset('css/style.css')}}">

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Login</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
					<div class="wrap">
						<div class="img" style="background-image: url(images/bg-1.jpg);"></div>
						<div class="login-wrap p-4 p-md-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">log In</h3>
			      		</div>
								<div class="w-100">
									<p class="social-media d-flex justify-content-end">
										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
									</p>
								</div>
			      	</div>
							<form  class="signin-form" id="login-form">
			      		<div class="form-group mt-3">
			      			<input type="email" class="form-control" id="email" required>
			      			<label class="form-control-placeholder" for="Email" >Email</label>
			      		</div>
		            <div class="form-group">
		              <input  type="password" class="form-control" id="password" required>
		              <label class="form-control-placeholder" for="password">Password</label>
		              <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
		            </div>
		            <div class="form-group">
		            	<button type="submit" class="form-control btn btn-primary rounded submit px-3" id="login-btn">Log In</button>
		            </div>
		            <div class="form-group d-md-flex">
		            	<div class="w-50 text-left">
			            	<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
										</label>
									</div>
									<div class="w-50 text-md-right">
										<a href="#">Forgot Password</a>
									</div>
		            </div>
		          </form>
		          <p class="text-center">Not a member? <a data-toggle="tab" href="#signup">Sign Up</a></p>
		        </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="{{ asset('js/jquery.min.js')}}"></script>
  <script src="{{ asset('js/popper.js')}}"></script>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/main.js')}}"></script>
  <script src="{{asset('js/script.js')}}"></script>


  <script crossorigin="anonymous">
    $(document).ready(function() {
        $('#login-btn').on('click', function(e) {
            e.preventDefault(); // Prevent default form submission

            const email = $('#email').val();
            const password = $('#password').val();
            const remember = $('#remember_me').is(':checked');
            //console.log(email);

            $.ajax({
                url: 'http://127.0.0.1:8000/api/login', 
                type: 'POST',
                data: {
                    email: email,
                    password: password,
                   //remember: remember,
                   // _token: '{{ csrf_token() }}' 
                },
                success: function(response) {
                    const token=response.token;
                    localStorage.setItem('authToken',token);
                    const tok=localStorage.getItem('authToken')
                    if(!tok){
                      console.log('ooh');
                    }
                    else{
                        $.ajax({
            url: "{{route('get')}}", 
            type: 'get',
            headers:{
                'Authorization': 'Bearer '+ token
            },
            success: function(response) {
                //const token=response.token;
                //localStorage.setItem('authToken',token);
               window.location.href="/"
                console.log('token');     
            },
            error: function(error) {
                console.log("error1")
                
            }
        });
                     
                    }
                    //var dashboard="{{route('get')}}"
                     //get_token();
                    //window.location.href="/"
                    
                    // Handle successful login
                   // alert(response.message); // Display success message
                    //var token=localStorage.setItem('token', response.token);
                   // localStorage.setItem('token_type', response['token-type']);
                
                },
                error: function(error) {
                    console.log("error2")
                    
                }
            });
        });
    });
</script>




	</body>
</html>

