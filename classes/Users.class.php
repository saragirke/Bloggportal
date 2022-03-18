<?php 
class Users {

    //Properties 
private $db;
private $fname;
private $lname; 
private $email; 
private $password; 
private $username; 
//private $postdate; 

// CONSTRUCTOR MED DB - ABSLUTNING
function __construct (){

$this->db = new mysqli('localhost', 'writebright', 'password', 'writebright');

//Fel-meddelande
if($this->db->connect_errno > 0){
    die('Fel vid anslutning [' . $db->connect_error . ']');
} 
}


//LOGGA IN
public function loginUser($username, $password) {
$username = $this->db->real_escape_string($username);
$password = $this->db->real_escape_string($password);

//finns användarnamnet i databasen
$sql= "SELECT * FROM users WHERE username='$username'";
$result = $this->db->query($sql);

// finns fler än 0 returneras det som true
if($result->num_rows > 0) {

$row = $result->fetch_assoc();
$stored_password = $row['password'];

if(password_verify($password, $stored_password)) {
    //Sessionsvariabel för att hålla koll på vilken användare som är inloggad. 
    $_SESSION['username'] = $username;
    return true;
}
 } else {
        return false;
    }
}


//REGISTRERA ANVÄNDARE
public function registerUser($fname, $lname, $email, $username,$password){
//motverka SQL-injections
$username= $this->db->real_escape_string($username);
$password= $this->db->real_escape_string($password);
$fname= $this->db->real_escape_string($fname);
$lname= $this->db->real_escape_string($lname);
$email= $this->db->real_escape_string($email);


//Hasha lösenordet 
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

//Hashade lösenordet som value 
    $sql = "INSERT INTO users (fname, lname, email, password, username)VALUES('$fname', '$lname' , '$email', '$hashed_password', '$username')";
    //return mysqli_query($this->db, $sql);

    // skcika frågan
    $result = $this->db->query($sql);
    return $result;

}




//KONTROLL AV ANVÄNDARNAMN
public function isUsernameTaken($username) {
$username= $this->db->real_escape_string($username);
$sql = "SELECT username from users WHERE username='$username'";

$result = $this->db->query($sql);

// finns fler än 0 av användarnamnet returneras det som true och därmed som upptaget
if($result->num_rows > 0) {
    return true;
 } else {
        return false;
    }
}





//KONTROLL AV EMAIL
public function emailCheck($email) {
    $email= $this->db->real_escape_string($email);
    $sql = "SELECT email from users WHERE email='$email'";
    $result = $this->db->query($sql);
    // finns fler än 0 av emailen returneras det som true och därmed som upptaget
if($result->num_rows > 0) {
    return true;
 } else {
        return false;
    }
}





//KONTROLLERA OM ANVÄNDARE ÄR INLOGGAD
//Om inte sessionsvariabeln inte finns så skcikas besökare tillbaka till inloggningssidan. 

public function secretPage() {
    if(!isset($_SESSION['username'])) {
        header("Location: login.php?message=<p class='error'>Du måste vara inloggad!");
        exit;
    }
}



//Kontrollera att fälten inte är tomma


public function setFname(string $fname) : bool {
    $fname = $_POST['fname'];
    if($fname != "") {
        $this ->fname = $fname;
        return true;
    } else {
        return false;
    }
}


public function setLname(string $lname) : bool {
    $lname = $_POST['lname'];
    if($lname != "") {
        return true;
    } else {
        return false;
    }
}

public function setEmail(string $email) : bool {
    $email = $_POST['email'];
    if($email != "") {
        $this ->email = $email;
        return true;
    } else {
        return false;
    }
}



public function setUsername(string $username) : bool {
    $username = $_POST['username'];
    if($username != "") {
        $this ->username = $username;
        return true;
    } else {
        return false;
    }
}

public function setPassword(string $password) : bool {
    $password = $_POST['password'];
    if($password != "") {
        $this ->password = $password;
        return true;
    } else {
        return false;
    }
}











// GET Users för att skriva ut till skärmen
public function getUsers() : array {
    //SQL frågor
    $sql = "SELECT *  FROM users;";
    $sql = "SELECT *FROM users ORDER BY signupdate DESC;";  //Nyaste inlägget först
    //Lagra i variabel 
    $result = mysqli_query($this->db, $sql);
    //Return som associativ array
    return mysqli_fetch_all($result, MYSQLI_ASSOC);

}


//Hämta användare och dess id
public function getUsersById(int $id) : array {
    //SQL fråga, väljs ut med hjälp av id
    $id =intval($id); //id variabel 
    $sql = "SELECT * FROM users WHERE id=$id;";
    $result = mysqli_query($this->db, $sql);
    // läs ut 
   return $result->fetch_assoc();


}

}