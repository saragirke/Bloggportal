<?php 
include("includes/header.php");
include("includes/config.php");
?>
<br><br>
<div class="result">
<h2> Alla blogginlägg </h2>




<?php


$post = new Post();

$post_list = $post->getPosts();


foreach($post_list as $c) {
    ?>
     <div class="result2">

     <h4><?=$c['title'];  ?></h4> 
     

     <!-- Skriv ut 400 tecken per inlägg -->
      <?=substr($c['content'], 0, 400);  ?> 
      
       <a href="details.php?id=<?= $c['id']; ?>"><br><u><strong>...Läs mer</strong></u></a> <!-- skickar med id i länk -->

<br>
<br>
<p class="published"> Publicerat:  <?=$c['postdate'];  ?> </p>

    </div>

<?php
}

?>

</div>
</section>
<?php 

include("includes/footer.php");
?>

