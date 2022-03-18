<?php
include("includes/header.php");
include("includes/config.php");


 ?>


<?php

$users = new Users ();

$users->secretPage();

// Kontroll om användare är inloggad
//if NOT set pga !
// skickas till inloggningssidan om ej inloggad
/*if(!isset($_SESSION['username'])){
header("Location: login.php?message=<p class='error'>Du måste vara inloggad!");
 }*/
?>



<br>
<div class="result">

<h2> Nytt inlägg </h2>



<?php
$post = new Post ();


//TA BORT inlägg i lista. 
if(isset($_GET['deleteid'])) {
    //Variabel från deleteid i länk längre ner i table-koden
    $deleteid = intval($_GET['deleteid']);

    if($post->deletePost($deleteid)) {
       echo "<p> Inlägget är raderat </p";
    }else {
        echo "<p> Det gick inte att ta bort inlägget, något gick fel :( </p";
    }
}


//Default värden på input, sådet ej blir error pga sparade värden i formuläret
$title ="";
$content="";



// Check if form is submitted 
if(isset($_POST['title'])) {

//Lagra värdena i variabler 
$title = $_POST['title'];
$content = $_POST['content1'];
$username = $_SESSION ['username'];


$success = true; // Allt som postats är okej 
if(!$post->setTitle($title))  {
    $success = false;
  echo "<p> Inlägget måste ha en titel </p>";
}

//Fellmeddelande för kurskod
if(!$post->setContent($content))  {
    $success = false;
  echo "<p> Inlägget måste ha ett innehåll</p>";
}


if($success) {
//Lägg till kurs 
if($post->addPost($title, $content, $username)) {
    echo "<p> Blogginlägget har skapats! </p>";

    //Default värden på input, så input raderas efter att kursen har lagrats
    $title ="";
    $content="";

} else {
    echo "<p> Fel vid lagring </p>";
}
} else {
   echo "<p> Kontrollera värden och försök igen</p>";
}
}

?>



<form method="post" action="admin.php">

<label for="title"> Titel:</label><br>
<input type="text" name="title" id="title" value="<?= $title; ?>"> <br> <!-- Value gör att input ej raderas vid felmeddelande -->

<label for="content">Innehåll:</label><br>
<textarea name="content1" id="content1" rows="10"><?= $content; ?></textarea>

<input type="submit" value="Lägg till inlägg">

</form>






<h3> Befintliga inlägg </h3>

<table>
<thead>
    <tr>
<th> Titel </th>
<th> Innehåll</th>
<th>Ändra</th>
<th> Radera </th>
</tr>

<tbody>
<?php
$post = new Post();
$blog_list = $post->getPostByUser();

foreach($blog_list as $c) {
    ?>
    <!-- Medvetet avbrott i PHP för at tknna skriva ut html -->
    <tr>
        <td><?= $c['title']; ?></td>
        <td><?=substr($c['content'], 0, 50); ?> ... </td>
        <td ><a class="change" href="edit.php?id=<?= $c['id']; ?>">Ändra</a></td>
        <!-- En länk som skickar med inlägg-id för att radera -->
        <td><a class="change" href="admin.php?deleteid=<?= $c['id']; ?>"> Radera</a></td>

</tr>
    <?php //Nästa php tagg innan slut-måsvingen
}



?>


</tbody>
</table>

<br>
<br>
<br>




<button class="logout"><a href="logout.php">Logga ut </a></button>
<br>
<br>
<br>
</div>
<script>
 CKEDITOR.replace( 'content1', {
height:300,
filebrowserUploadUrl: '',
 });
</script>
<?php include("includes/footer.php"); ?>