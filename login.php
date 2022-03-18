<?php include("includes/config.php"); ?>
<?php
if (isset($_POST['username'])) {

$username = $_POST['username'];
$password = $_POST['password'];

$users = new Users();

if ($users->loginUser($username, $password)) {
    $_SESSION['username'] = $username;
    header("Location: admin.php");

} else {
    $message ="<p style='color:red;'> Felaktigt användarnamn eller lösenord </P>";

}
}
?>

<?php
include("includes/header.php")
?>


<br>

<?php





?>

<div class="result">
<h2> Logga in </h2>

<?php
if(isset($message)) {
    echo "<p>" . $message . "</p>";
}
?>



<form method="post" action="login.php">
<label for="username"> Användarnamn</label>
<br>
<input type="text" name="username" id="username">
<br>
<label for="password"> Lösenord</label>
<br>
<input type="password" name="password" id="password">
<br>
<br>
<input type="submit" value="Logga in"><br>
<br><br><br>
</form>


<u><a href="index.php">Tillbaka till start</a></u>
<br>
<br>
</div>

<?php include("includes/footer.php"); ?>