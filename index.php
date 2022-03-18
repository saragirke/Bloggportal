<?php include("includes/config.php"); ?>
<?php
include("includes/header.php")

?>
<br>






<div class="row">
  <div class="leftcolumn">



    <div class="block">
    <h2>Senaste inläggen</h2>

    <?php


$post = new Post();
$post_list = $post->getPosts();
foreach($post_list as $c) {

    ?>
<div class="result2">

     <h4><?=$c['title'];  ?></h4>
    
     <!-- Skriv ut 400 tecken per inlägg -->
      <?=substr($c['content'], 0, 300);  ?> 
      <p class="published"> Publicerat:  <?=$c['postdate'];?> Av: <a href="singleblog.php?username=<?= $c['username']; ?>"><?=$c['username'];?></a> </p>
       <p class="published"><a href="details.php?id=<?= $c['id']; ?>"><br><u>Läs mer/Kommentera</u></a></p> <!-- skickar med id i länk -->

<br>    
<br>

    

</div>  
<?php 
}  


?>


</div>
</div>



  <div class="rightcolumn">
    <div class="block">
      <h3>Alla bloggar</h3>
<?php

$user = new Users();

$user_list = $user->getUsers();


foreach($user_list as $c) {
    ?>

  <ul><li><a href="singleblog.php?username=<?= $c['username']; ?>"><?=$c['username'];  ?></a></li></ul>

<br>

<?php 
}

?>

    </div>


    <!-- Mest lästa inäggen -->

    <div class="block">
      <h3>Mest lästa inläggen</h3>
      <?php

$post = new Post();
//ANropar funktion
$post_list = $post->getCountedPosts();

//Loopar igenom
foreach($post_list as $c) {
    ?>
<!-- Skriver med med länkar till post sam enskild blogg-->
<ul><li><a href="details.php?id=<?= $c['id']; ?>"><?=$c['title'];?></a></li></ul>


<br>

<?php
}

?>
    </div>


    
    <div class="block">
      <h3>Om Write Bright</h3>
      <p>Bloggprotalen har skapats i kursen BLABLA. Syftet är att lära sig BLABLA
          Jag som skapat bloggen heter Sara
      </p>
    </div>
  </div>
</div>



</section>


<?php include("includes/footer.php"); ?>