
<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title></title>
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width">

	<link rel="stylesheet/less" href="less/style.less">
	<script src="js/libs/less-1.3.0.min.js"></script>
	
	<!-- Use SimpLESS (Win/Linux/Mac) or LESS.app (Mac) to compile your .less files
	to style.css, and replace the 2 lines above by this one:

	<link rel="stylesheet" href="less/style.css">
	 -->

	<script src="js/libs/modernizr-2.5.3-respond-1.1.0.min.js"></script>
</head>
<body>
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">debZN</a>
          <div class="nav-collapse">
            <ul class="nav">
              
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#tv">TV</a></li>
              <li><a href="#movies">Movies</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      
      <?php
	if(!isset($_GET['me']) || $_GET['me']==''){
	?>
	<div class="hero-unit">
        <h1>Hello, world!</h1>
        <p>it is not working just yet</p>
        <p><a class="btn btn-primary btn-large">Signup or login &raquo;</a></p>
      </div>
	<?php
	}
	else{

?>
      <div id="local-search" class="hero-unit">
      	<h1>Hello <?php echo $_GET['me'];?></h1>
      	<br/>
      	<p>Search local database</p>
	     <form class="form-search">		     		
	     	<input type="text" class="input-medium search-query" placeholder="Type something...">
		    <select name="category" class="input-small">
				<option value="tv">TV</option>
			    <option value="movie">Movies</option>
			</select>
			<button type="submit" class="btn btn-primary">Search</button>
		</form>
      </div>
      <div>
	  	<form class="well" method="get" action="add.php">
	  		<input type="hidden" name="cat" value="tv">
	  		<label>Title: </label>
	  		<input type="text" name="tv-title" class="input-large" placeholder=""/>
	  		<label>Genre: </label>
	  		<input type="text" name="tv-genre" class="input-large" placeholder="Separate multiple genres by |"/>
	  		<label>Classification: </label>
	  		<select name="tv-class" class="input-small">
	  			<option value="Scripted" selected="selected">Scripted</option>
	  			<option value="Reality">Reality</option>
	  			<option value="Documentary">Documentary</option>
	  		</select>
	  		<label>URL: </label>
	  		<input type="url" name="tv-url" class="input-xlarge" placeholder="" />
	  		<br/>
	  		<input type="submit" name="tv-sub" class="btn btn-inverse" value="Submit"/>
	  	</form>    
	  </div>
      <hr />
<?php
}
?>
      <footer>
        <p>&copy; debZN 2012</p>
      </footer>

    </div> <!-- /container -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.2.min.js"><\/script>')</script>

<script src="js/libs/bootstrap/bootstrap.min.js"></script>

<script src="js/script.js"></script>
</body>
</html>
