<?php 
include("includes/config.php"); ?>

<?php
if (isset($_POST['username'])) {

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

//variabelr för siffror och Stor bokstav
$number = preg_match_all('@[0-9]@', $password);
$uppercase = preg_match_all('@[A-Z]@', $password);


$users = new Users();



$success = true;
if(!$users->setUsername($username)) {
    $success = false; 
    $message = "<p style='color:red;'>Ange användarnamn </p>";
}

if(!$users->setFname($fname)) {
    $success = false; 
    $message = "<p style='color:red;'>Ange Förnamn </p>";
}

if(!$users->setLname($lname)) {
    $success = false; 
    $message = "<p style='color:red;'>Ange Efternamn </p>";
}

if(!$users->setEmail($email)) {
    $success = false; 
    $message = "<p style='color:red;'>Ange email </p>";
}

if(!$users->setPassword($password)) {
    $success = false; 
    $message = "<p style='color:red;'>Ange lösenord </p>";
}


if($success) {

//Kontrollerar att lösenord består av minst 8 tecken, en siffra samt en stor bokstav
if ($_POST["password"] >=5 && $number && $uppercase) {
if ($_POST["password"] === $_POST["repeat_password"])  {




//Kontroll om användarnamnet är tillgängligt, anropar funktion
if($users->isUsernameTaken($username)) {
    $message = "<p style='color:red;'> Oj vilket bra användarnamn, men tyvärr hann någon annan före  :( </p>";
}


if (empty($_POST['accept'])){
$message = "<p style='color:red;'>Du måste acceptera villkor för lagring av uppgifter</p>";
}

else{
    //Kontrollerar att angiven e-mail är korrekt utformad
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $message = "<p style='color:red;'>Ange en korrekt e-mailadress </p>";
}


//Kontrollerar att e-mail inte redan är kopplat till ett konto
elseif ($users->emailCheck($email)) {
  $message = "<p style='color:red;'>E-postadressen är redan kopplad till ett konto.</p>";
}



else{
    //Skapar ny användare
    if ($users->registerUser($fname, $lname, $email, $username, $password)) {
        $message = "<p> Välkommen! Ny användare har skapats!! </p>";
       }else {
           $message ="<p style='color:red;'> ANVÄNDARE EJ SKAPAD </P>";
       
       }
       }
    }
}
    //Felmeddelande om något inte stämmer - > användare skapas inte
    else {
        $message ="<p style='color:red;'> Lösenordet matchar inte </P>";
    }
}else { $message ="<p style='color:red;'>Lösenordet måste bestå av minst 5 tecken,en siffra och en stor bokstav </P>";
} 
}
}

?>



<?php
include("includes/header.php")
?>



<br>
<?php
// Message syftar till message i admin-sidan rad 8
if(isset($_GET ['message'])) {
    echo "<p>" . $_GET['message'] . "</p>";
}




?>


<div class="result">
<h3>Skapa konto</h3>

        <?php
if(isset($message)) {
    echo "<p>" . $message . "</p>";
}
?>



<form method="post">
<label for="fname"> Förnamn</label>
<br>
<input type="text" name="fname" id="fname">
<br>
<label for="lname"> Efternamn</label>
<br>
<input type="text" name="lname" id="lname">
<br>
<label for="email"> Email</label>
<br>
<input type="text" name="email" id="email">
<br>
<label for="username"> Användarnamn</label>
<br>
<input type="text" name="username" id="username">
<br>
<label for="password"> Lösenord</label>
<br>
<input type="password" name="password" id="password">
<br>
<label for="repeat_password"> Upprepa lösenord</label>
<br>
<input type="password" name="repeat_password" id="repeat_password">
<br>
<input type="checkbox" onclick="showPasswords()"> Visa lösenord <br>
<input type="checkbox" id="accept" name="accept"><label for="repeat_password"> Jag godkänner att de uppgifter jag angett lagras</label>
<br>
<input type="submit" value="Skapa Konto">
<br>
</form>

<br><br>
<a href="index.php">Tillbaka till start</a>

</div>
</section>

<script>

function showPasswords() {
  var pass = document.getElementById("repeat_password");
  var pass_rep = document.getElementById("password");
  if (pass.type === "password") {
    pass.type = "text";
  } else {
    pass.type = "password";
  }  if (pass_rep.type === "password") {
    pass_rep.type = "text";
  } else {
    pass_rep.type = "password";
  }
} </script>
<?php include("includes/footer.php"); ?>