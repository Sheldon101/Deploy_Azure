<?php
  session_start();
  // Declare all variables the site will be using
  $postID = '';
  $response = '';
  $articledata = '';
  $title = 'Invalid Article';
  $subtitle = '';
  $content = '';
  $date = '';
  $thumbnail = '';

  //Try to connect to SQL server
  try
  {
    $connString = "mysql:host=localhost; dbname=csusmblog";
    $user = "root";
    $pass = "root";
    $pdo = new PDO($connString, $user, $pass); //$pdo is the main SQL accessor variable
  }
  catch(PDOException $e )
  {
    die($e->getMessage());
  }

  if(isset($_GET['articleID']))
	{
		$postID = $_GET['articleID'];
		// Check if values are entered
		if(strlen($postID) == 0)
			$response = "Invalid Article";
		else // Check if articleId is an actual number
			if(is_numeric($postID) == false)
				$response = "Invalid Article";
			else // Checks are done, now perform SQL grabs
			{
        $querystring = "SELECT * FROM Post WHERE postID = '" . $postID . "';";
        echo $querystring;
        $result = $pdo->query($querystring);
        $articledata = $result->fetch();
        if(is_bool($articledata) == false)  // We want articledata to NOT be a boolian
        {
          // Perform functions that read all the data into the variables
          $title = $articledata["title"];

          $subtitle = $articledata["subtitle"];

          $content = $articledata["content"];

          $date = $articledata["updatedAt"];

          $thumbnail = $articledata["thumbnail"];
        }
      }
	 }
?>
<!DOCTYPE html>
<html lang = "en">
  <head>
    <title> <?php echo $title ?> </title>
    <meta charset = "utf-8"/>
    <link rel= "stylesheet" type = "text/css" href="../styles/article-style.css"/>
  </head>
  <body>
    <!--beginning of banner-->
    <header class="header">
        <a href="../blog-home.php" class="logo"><span>CSUSM</span>Blog</a>
        <nav class="navbar">
            <a href="../blog-home.php">Home</a>
            <?php if (isset($_SESSION['username']) && isset($_SESSION['adminId'])): ?>
              <a href="../blog-create.php">Create Post</a>
              <a href="../user-logout.php">Logout</a>
            <?php else: ?>
              <a href="../loginForm.html">Login</a>
            <?php endif; ?>
        </nav>
    </header>
    <!--end of banner-->
    <br/> <br/>  <br/> <br/>   <br/> <br/>
    <!--Go back button-->
      <form action = "../blog-home.php" method = "GET">
      <input type = "submit" id = "goback" onclick = "returnToHome()" value = "&lt Go Back"> </input>
      <br></br>
    <!--Article contents here-->
    <section class = "container">
      <div class="post-container">
        <div class="post">
          <?php if (isset($thumbnail) && !empty($thumbnail)): ?> 
            <div class="image">
              <img src=<?php echo $thumbnail ?> alt="Error loading image.">
            </div>
          <?php endif; ?>
          <h1> <?php echo $title ?> </h1>
          <h4> <?php echo $subtitle ?> </h4>
          <p> <?php echo $content ?> </p>
          <div class="date">
              <i class="far fa-clock"></i>
              <span><?php echo $date ?></span>
          </div>
        </div>
      </div>
    </section>
    <!--End of article content-->

    <script src = "../scripts/WebpageUpdate.js?v=2">
    </script>
  </body>
</html>
