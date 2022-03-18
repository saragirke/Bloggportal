<?php 
include("includes/header.php");
include_once("includes/config.php");
?>




<?php
$comments = new Comments ();

if (isset($_POST['message'])) {
    $message = $_POST['message'];
    $username = $_SESSION ['username'];
    $id = $_GET['id'];
  
    $success = true; // Allt som postats är okej 
    if(!$comments->setComment($message))  {
        $success = false;
      echo "<p> Kommentaren har inte lagrats </p>";
    }
    if($success) {
        //Lägg till kurs 
        if($comments->addComment($message, $username, $id)) {
            
        
            //Default värden på input, så input raderas efter att kursen har lagrats
    
        } else {
            echo "<p> Fel vid lagring </p>";
}
    }
}
?>
<?php

//TA BORT inlägg i lista. 
if(isset($_GET['deleteid'])) {
    //Variabel från deleteid i länk längre ner i table-koden
    $deleteid = intval($_GET['deleteid']);

    if($comments->deleteComment($deleteid)) {
       echo "<p> Inlägget är raderat </p";
    }else {
        echo "<p> Det gick inte att ta bort inlägget, något gick fel :( </p";
    }
}


//Kontrollera om ett id har skickats, om så är fallet anropar funktioner 
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    //$count = intval($_GET['count']);

    $post = new Post();
    $details = $post->countPost($id);
    $details = $post->getPostById($id);

} else {
header("Location: index.php");
}

?>
<br>
<div class="result">
<div class="result2">
<h3><?= $details['title']; ?> </h3>


     <?= $details ['content'] ?><br><br>
    <p class="published">Publicerat: <?= $details ['postdate'] ?> </p>




    <form method="post" action="#">

<label for="message" id= "message">Kommentera:</label><br>
<textarea name="message" id="message" rows="10"></textarea>

<input type="submit" value="Lägg till kommentar">

</form>

<br>
<br>
<br>
<br>

<h3> Kommentarer </h3>
<?php
$comments = new Comments();
$comment_list = $comments->getCommentByPost();
$username = $_SESSION['username'];

foreach($comment_list as $c) {
    //Om inloggad användare är samma som användare för enskild kommentar visas en delete-knapp, annars utan knapp
    if ($_SESSION['username'] == $c['username']) {
    ?>
    <div class="result">

    <tr>
        <td><?= $c['message']; ?></td><br><p class="published"> Publicerat:  <?=$c['postdate'];?> Av: <?=$c['username'];?> </p>
        <td><a class="change" href="details.php?deleteid=<?= $c['comment_nr']; ?>"> Radera</a></td>
</tr>
</div>
    <?php //Nästa php tagg innan slut-måsvingen
} else {
?>
<div class="result">

<td><?= $c['message']; ?></td><br><p class="published"> Publicerat:  <?=$c['postdate'];?> Av: <?=$c['username'];?> </p>
</div>
    <?php //Nästa php tagg innan slut-måsvingen
}
}
?>

</div>
<a style="font-size:18px" href="index.php">Tillbaka</a>
</section>
</div>
<?php 

include("includes/footer.php");
?>

