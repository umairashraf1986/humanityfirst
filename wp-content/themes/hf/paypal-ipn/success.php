<html>
<head>
	<title>Humanity First - PayPal Payment Success</title>
</head>
<body>

	<style>
	    a.btn-open-app {
	        display: block;
	        background: linear-gradient(to bottom, #009bc1 0%,#6ba8c6 100%);
	        width: 200px;
	        text-align: center;
	        color: #fff;
	        text-decoration: none;
	        padding: 10px 0;
	        border-radius: 24px;
	    }
	    a.btn-open-app:focus, 
	    a.btn-open-app:active,
	    a.btn-open-app:hover {
	        background: #009bc1;
	        outline: none;
	    }
	    a.btn-open-app:hover {
	        color: #fff;
	        text-decoration: none;
	    }
	</style>
	<h2>Successfully charged $<?php echo $_REQUEST['payment_gross']; ?>!</h2>
	<a href='humanityFirstAppScheme://' class="btn-open-app">Back to App</a>
</body>
</html>