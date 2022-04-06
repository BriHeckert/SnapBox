<?php 
?>
<html lang="en">
	 <head>
	   <meta charset="utf-8">
	   <meta http-equiv="X-UA-Compatible" content="IE=edge">
	   <meta name="viewport" content="width=device-width, initial-scale=1">
	   <meta name="author" content="Brianna Heckert, Kane Aldrich">
	   <meta name="description" content="login page">
	   <meta name="keywords" content="ScrapBox, ScrapBox login">
	   <link rel="stylesheet" href="main.css">
	   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	   <link rel="stylesheet/less" type="text/css" href="styles.less" />
	   <title>Login</title>
	 </head>
	<body id="loginBody" style="text-align: center; font-family:FANGSONG;background-color: #3b3b3b;background-repeat:no-repeat; background-size:cover; color: black;">
		<section class="vh-100">
		  <div class="container py-5 h-100" style="padding-top: 1rem!important;">
		    <div class="row d-flex justify-content-center align-items-center h-100">
		      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
		        <div class="card bg-dark text-white" style="border-radius: 1rem;">
		          <div class="card-body p-5 text-center" style="background-color:black; border-radius:15px">

		            <div class="mb-md-5 mt-md-4 pb-5">
		            <form action="?command=login" method="post">
		              <h2 style="font-size: 55px;font-family: sans-serif;"class="fw-bold mb-2 text-uppercase">Scrapbox</h2>
		              <p class="text-white-50 mb-5" style="color:white !important">Please enter your login and password!</p>
					  <div class="form-outline form-white mb-4">
		                <input name="Name" type="text" id="typeEmailX" class="form-control form-control-lg" />
		                <label class="form-label" for="typeEmailX">Name</label>
		              </div>
		              <div class="form-outline form-white mb-4">
		                <input name="Email" type="email" id="typeEmailX" class="form-control form-control-lg" />
		                <label class="form-label" for="typeEmailX">Email</label>
		              </div>
		              <div class="form-outline form-white mb-4">
		                <input name = "Password" type="password" id="typePasswordX" class="form-control form-control-lg" />
		                <label class="form-label" for="typePasswordX">Password</label>
		              </div>
		              <button class="btn btn-outline-light btn-lg px-5" type="submit" value="Submit">Login</button>
		            </form>
		              <a href="?command=CreateAccount"><button style="margin-top:10px"class="btn btn-outline-light btn-lg px-5">Create Account</button></a>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>
		  </div>
		</section>
	</body>
</html>