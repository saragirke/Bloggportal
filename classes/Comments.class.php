<?php
class Comments {
//properties
private $db;
private $message;



// Comtructor with db-connections
function __construct (){

    $this->db = new mysqli('localhost', 'writebright', 'password', 'writebright');
    
    //Fel-meddelande
    if($this->db->connect_errno > 0){
        die('Fel vid anslutning [' . $db->connect_error . ']');
    } 
    }
    





//Lägg till ett inlägg , funktion som tar argument
public function addComment(string $message, string $username, int $id) {

//Motverka SQL-injections
$message= $this->db->real_escape_string($message);
//check with set-metoder . Returnerar false om det matas in felaktig information som vi inte vill ha i databasen
if(!$this->setComment($message)) return false;

//SQL Query 
$sql = "INSERT INTO comments (message, username, id)VALUES('" . $this->message . "', '$username' , '$id');";
// Skicka frågan till server som returnerar true eller false 
return mysqli_query($this->db, $sql);

}





//set-metoded
public function setComment(string $message) : bool {
    if($message != "") {
        $this ->message = $message;
        return true;
    } else {
        return false;
    }
}



//Hämta kommenterar från specifikt inlägg
public function getCommentByPost(): array {
    $id = $_GET['id'];
    $sql = "SELECT * FROM comments WHERE comments.id='$id' ORDER BY postdate DESC;";

       //Lagra i variabel 
       $result = $this->db->query($sql);
       //Return som associativ array
       return mysqli_fetch_all($result, MYSQLI_ASSOC);
   
}






public function countComments(): array {

$sql = "SELECT id, count(id) FROM comments GROUP BY id ORDER BY count(id) DESC;";
       //Lagra i variabel 
       $result = $this->db->query($sql);
       //Return som associativ array
       return mysqli_fetch_all($result, MYSQLI_ASSOC);

}



//Radera kommentar
public function deleteComment(int $comment_nr) : bool {
    $id = intval($comment_nr); // SKapar som heltal

    //SQL fråga
    $sql = "DELETE FROM comments WHERE comment_nr=$comment_nr;";

    //SKicka fråga
    return mysqli_query($this->db, $sql);
}




}

?>