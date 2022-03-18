<?php 
include("includes/header.php");
include("includes/config.php");
?>
<br><br>




<div class="result">
<h2> Bloggare på Write Bright </h2>




<?php

$user = new Users();

$user_list = $user->getUsers();


foreach($user_list as $c) {
    ?>
     <div class="result2">

     <h3>-<?=$c['username'];  ?></h3> 

     <a href="singleblog.php?username=<?= $c['username']; ?>"><br><u><strong>Läs Bloggen</strong></u></a>

<br>
<br>


    </div>

<?php
}

?>

</div>
</section>

<?php 

include("includes/footer.php");
?>

