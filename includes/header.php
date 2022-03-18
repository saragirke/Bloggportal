<?php include("includes/config.php"); ?>
<!DOCTYPE html>
<html lang="se">
<head>
    <title>Write Bright</title>
    <link rel="icon" type="image/x-icon" href="favoicon.ico">
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Questrial&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Hubballi&family=Prata&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
<script src="script.js"></script>
    <link rel="stylesheet" type="text/css" href="css/styles.css?t=<?= time();?>">
    <!-- <script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
</head>
<body>


<div class="hero-image">
  <div class="hero-text">
    <h1>Write Bright</h1>

<form style="display: inline" action="index.php" method="get">
  <button>Hem</button>
</form>

<!--<form style="display: inline" action="blog.php" method="get">
  <button>Blogginlägg</button>
</form>-->


<?php
if (!isset($_SESSION['username'])) {
    echo '<form style="display: inline" action="signup.php" method="get">
    <button>Börja blogga</button>
  </form>';
}
?>


<?php
if (!isset($_SESSION['username'])) {
    echo '<form style="display: inline" action="login.php" method="get">
    <button>Logga in</button>
  </form>';
}
?>

<?php
if (isset($_SESSION['username'])) {
    echo '<form style="display: inline" action="newpost.php" method="get">
    <button>Nytt inlägg</button>
  </form>';
}
?>

<?php
if (isset($_SESSION['username'])) {
    echo '<form style="display: inline" action="admin.php" method="get">
    <button>Hantera inlägg</button>
  </form>';
}
?>



<form style="display: inline" action="bloggers.php" method="get">
    <button>Bloggar</button>
  </form>



<!-- Om en navändare är inloggad visas användarnamnet samt en knapp för att logga ut-->
<?php
if (isset($_SESSION['username'])) {
    echo "<p> Inloggad som: " . $_SESSION['username'] . "</p>";

    echo '<form style="display: inline" action="logout.php" method="get">
    <button>Logga ut</button>
  </form>';
}
?>

</div>
</div>




        <section id="maincontent">