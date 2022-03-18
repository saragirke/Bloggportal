<?php 
include("includes/header.php");
include_once("includes/config.php");
?>


<?php
//Kontrollera om ett id har skickats, om så är fallet anropas funktioner 
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
<?php


$comments = new Comments ();
if (isset($_SESSION['username']))  {
    echo  '<form method="post" action="#">
    <label for="message" id= "message">Kommentera:</label><br>
    <textarea name="message" id="message" rows="10"></textarea>
    <input type="submit" value="Lägg till kommentar">
    </form>';

} else {
    $echo= "<p> endast inloggade medlemmar kan kommentera inlägg</p>";
}

if (isset($_POST['message'])) {
    $message = $_POST['message'];
    $username = $_SESSION ['username'];
    $id = $_GET['id'];
  

    $success = true;
    if(!$comments->setComment($message))  {
        $success = false;
      echo "<p> Kommentaren har inte lagrats </p>";
    }
    if($success) {
        //Lägg till kommentar 
        if($comments->addComment($message, $username, $id)) {
    
        } else {
            echo "<p> Fel vid lagring </p>";
}
    }
} 

?>

<h3> Kommentarer </h3>
<?php

//TA BORT kommentar 
if(isset($_GET['deleteid'])) {
    //Variabel från deleteid i länk längre ner i table-koden
    $deleteid = intval($_GET['deleteid']);

    if($comments->deleteComment($deleteid)) {
       echo "<p> Kommentaren har raderats! </p";
    }else {
        echo "<p> Det gick inte att ta bort kommentaren, något gick fel :( </p";
    }
}
?>


<?php
if(isset($_GET ['msg'])) {
    echo "<p>" . $_GET['msg'] . "</p>";
}?>

<br>
<br>
<br>
<br>




<?php

$comments = new Comments();
$comment_list = $comments->getCommentByPost();


foreach($comment_list as $c) {
    //Kolla om någon är inloggad
    if (isset($_SESSION['username']))  {
    //Om inloggad användare är samma som användare för enskild kommentar visas en delete-knapp
    if ($_SESSION['username'] == $c['username']) {
?>
<div class="result">

<tr>
        <td><?= $c['message']; ?></td><br><p class="published"> Publicerat:  <?=$c['postdate'];?> Av: <?=$c['username'];?> </p>
        <td><a class="change" href="details.php?deleteid=<?= $c['comment_nr'];?>&&id=<?=$id?>"> Radera</a></td>
</tr>
</div>
    <?php //Nästa php tagg innan slut-måsvingen
} 

//Om ingen är inloggad visas följande
}else {
?>
<div class="result">

<td><?= $c['message']; ?></td><br><p class="published"> Publicerat:  <?=$c['postdate'];?> Av: <?=$c['username'];?> </p>
</div>
    <?php //Nästa php tagg innan slut-måsvingen
}
}
?>

</div>

</section>
</div>
<?php 

include("includes/footer.php");
?>

