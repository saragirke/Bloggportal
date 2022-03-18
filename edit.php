<?php
include("includes/config.php");
 ?>



<?php

// Kontroll om användare är inloggad
//if NOT set pga !
// skickas till inloggningssidan om ej inloggad
if(!isset($_SESSION['username']))
header("Location: login.php?message=Du måste vara inloggad!");
$post = new Post ();


//Check if id is sent, skicka annars tillbaka till admin sidan
if(isset($_GET['id'])) {
    $id=intval($_GET['id']);

//FRONTEND

// Check if form is submitted 
if(isset($_POST['title'])) {

    //Lagra värdena i variabler 
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    
    
    $success = true; // Allt som postats är okej 

    if(!$post->setTitle($title))  {
        $success = false;
      echo "<p> Inlägget måste ha en titel </p>";
    }
    
    //Fellmeddelande för innehåll
    if(!$post->setContent($content))  {
        $success = false;
      echo "<p> Inlägget måste ha ett innehåll</p>";
    }
    
    
    if($success) {
   //Uppdatera inlägget
    if($post->updatePost($id, $title, $content)) {
        $message= "<p> Inlägget har ändrats </p>";

    } else {
        echo "<p> Fel vid uppdatering </p>";
    }
    } else {
       echo "<p> Ändringen har inte sparats, kontrollera värdena </p>";
    }
    }

    $details = $post->getPostById($id);
} else {
    header("Location:admin.php");
}


    ?>

<?php
include("includes/header.php")
?>

<div class="result">

<h2> Administration </h2>

<h3> Ändra Inlägget: <br> "<?= $details ['title']; ?>" </h3>


<?php
//SKriver ut felmeddelande
if(isset($message)) {
    echo $message;
}



?>


<form method="post" action="edit.php?id=<?= $id ?>"> <!-- SKicka med id vid skick av form -->

<label for="title"> Titel:</label><br>
<input type="text" name="title" id="title" value="<?= $details['title']; ?>"> <br> <!-- Läser ut från $details i fälten så användaren ej behöver fylla i allt igen -->


<label for="content"> Innehåll:</label><br>
<textarea id="content" name="content"><?=$details['content'];?></textarea><br><br>

<input type="submit" value="Uppdatera inlägg">

</form>





<br>
<br>
<br>
<p><a href="admin.php">Tillbaka till föregående sida</a></p>
<a href="logout.php">Logga ut </a>

</div>

<?php include("includes/footer.php"); ?>