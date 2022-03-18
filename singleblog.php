<?php 
include("includes/header.php");
include("includes/config.php");
?>
<br><br>
<div class="result">

<?php
$username = $_GET['username'];

echo "<h2> Välkommen till bloggen:</h2>";
echo "<h2> $username</h2>";


$post = new Post();
$blog_list = $post->getPostByUserId();

foreach($blog_list as $c) {
    ?>
    <!-- Medvetet avbrott i PHP för at tknna skriva ut html -->
    <div class="result2">

     <h4><?=$c['title'];  ?></h4> <br> <br>
    <?= $c['content'];?> 

    <p class="published"> Publicerat:  <?=$c['postdate'];?> <br>  Av: <?=$c['username'];?>   </p>
    <a href="details.php?id=<?= $c['id']; ?>"><br><u>Kommentera</u></a></p>
    </div>
    <?php //Nästa php tagg innan slut-måsvingen
}



?>



</section>
<?php 

include("includes/footer.php");
?>

