<?php 
class Post {

    //Properties 
private $db;
private $title;
private $content;


// Kontruktor med db-anslutning
function __construct (){

$this->db = new mysqli('localhost', 'writebright', 'password', 'writebright');

//Fel-meddelande
if($this->db->connect_errno > 0){
    die('Fel vid anslutning [' . $db->connect_error . ']');
} 
}



//Lägg till ett inlägg , funktion som tar argument
public function addPost(string $title, string $content, string $username) {

    //Motverka SQL-injections
     $title= $this->db->real_escape_string($title);
     $content= $this->db->real_escape_string($content);

//check with set-metoder . Returnerar false om det matas in felaktig information som vi inte vill ha i databasen
if(!$this->setTitle($title)) return false;
if(!$this->setContent($content)) return false;


//SQL Query 
//ej $this-> på username efter den inte tillhör this
$sql = "INSERT INTO posts (title, content, username)VALUES('" . $this->title . "', '"  . $this->content . "' , '$username');";
// Skicka frågan till server som returnerar true eller false 
return mysqli_query($this->db, $sql);

}




//Uppdatera med hjälp av id/primärnyckeln
public function updatePost(int $id, string $title, string $content) : bool {

    //Motverka SQL-injections
    $title= $this->db->real_escape_string($title);
    $content= $this->db->real_escape_string($content);

//Kontroll med set-metoder . Returnerar false om det matas in felaktig information som vi inte vill ha i databasen
if(!$this->setTitle($title)) return false;
if(!$this->setContent($content)) return false;

// SQL fråga 
$sql = "UPDATE posts SET title= '" . $this->title . "',content= '"  . $this->content . "' WHERE id=$id;";
 return mysqli_query($this->db, $sql);
}




//Hämta inlägg med id
public function getPostById(int $id) : array {
    //SQL fråga, väljs ut med hjälp av id
    $id =intval($id); //id variabel 
  
    $sql = "SELECT * FROM posts WHERE id=$id;";
     
    $result = mysqli_query($this->db, $sql);
    // läs ut 
   return $result->fetch_assoc();


}


//Räkna antal besök på inlägg
public function countPost($id){
    $id =intval($id); 
    //Uppdatera count med 1 vid varje klick på id
$sql = "UPDATE posts SET count = (count+1) WHERE id='$id';";

$result = mysqli_query($this->db, $sql);
// läs ut 
return mysqli_query($this->db, $sql);

}


//Hämta mest lästa inläggen
public function getCountedPosts(): array {
    $sql = "SELECT *  FROM posts ORDER BY count DESC LIMIT 5;";

        //Lagra i variabel 
        $result = mysqli_query($this->db, $sql);
        //Return som associativ array
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
}



// Get för att hämta inlägg
public function getPosts() : array {
    //SQL frågor
    $sql = "SELECT *  FROM posts;";
    //Skriv ut endast 5 inlägg med LIMIT
    $sql = "SELECT *FROM posts ORDER BY postdate DESC LIMIT 5;";  //Nyaste inlägget först
   
    //Lagra i variabel 
    $result = mysqli_query($this->db, $sql);
    //Return som associativ array
    return mysqli_fetch_all($result, MYSQLI_ASSOC);

}


// Läs ut inlägg från INLOGGAD användare på admin-sidan

public function getPostByUser(): array {
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM posts WHERE posts.username='$username' ORDER BY postdate DESC;";

       //Lagra i variabel 
       $result = $this->db->query($sql);
       //Return som associativ array
       return mysqli_fetch_all($result, MYSQLI_ASSOC);
   
}


// läs ut alla inlägg från user med hjälp av id

public function getPostByUserId(): array {
    $username = $_GET['username'];
    $sql = "SELECT * FROM posts WHERE posts.username='$username' ORDER BY postdate DESC;";
    
       //Lagra i variabel 
       $result = $this->db->query($sql);
       //Return som associativ array
       return mysqli_fetch_all($result, MYSQLI_ASSOC);
}



// Delete inlägg med hjälp av primärnyckeln id

public function deletePost(int $id) : bool {
    $id = intval($id); // SKapar som heltal

    //Anropar funktion för att ta bort kommentarer på inlägget
    $this->deleteCommentById($id);
        //SQL fråga
    $sql = "DELETE FROM posts WHERE id=$id;";


    //SKicka fråga
    return mysqli_query($this->db, $sql);
}


//Radera kommentar med hjälp av id
public function deleteCommentById(int $id) : bool {
    $id = intval($id); // SKapar som heltal

    //SQL fråga
    $sql = "DELETE FROM comments WHERE id=$id;";

    //SKicka fråga
    return mysqli_query($this->db, $sql);
}







//set-metoder
public function setTitle(string $title) : bool {
    if($title != "") {
        $this ->title = $title;
       
        return true;
    } else {
        return false;
    }
}

// set-metod code + kontroll av längd 



    public function setContent(string $content) : bool {
        $content = strip_tags(html_entity_decode($content), '<p><li><ol><a><br><i><b><strong><em>');
        if($content != ""){
            $this->content = $content;
           
            return true;
        }else {
            return false;
        }
    }




//destructor 
function __destruct() {
    mysqli_close($this->db);
}

}