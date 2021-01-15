<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=phone_book', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
session_start();
$idkey= $_SESSION["idkey"];
if(!$idkey){
    header("location: index.php");
}
$statement = $pdo->prepare('SELECT*FROM users WHERE idkey = :idkey');
$statement->bindValue(':idkey', $idkey);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['firstname']) && !empty($_POST['phone']))
    {
        $firstname=$_POST['firstname'];
        $surname=$_POST['surname'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $image=$_FILES['image'];

$imagePath='';
if(!empty($_FILES['image']['tmp_name'])){
    $imagePath = 'images/'.$idkey.'/'.randomString(6).$image['name'];
    if (!is_dir($imagePath)){
        mkdir(dirname($imagePath));
    }
    move_uploaded_file($image['tmp_name'], $imagePath);
}

$statement = $pdo->prepare("INSERT INTO contact_list (idkey, firstname, surname, email, phone, image)
                VALUES (:idkey, :firstname, :surname, :email, :phone, :image)");
$statement->bindValue(':idkey', $idkey);
$statement->bindValue(':firstname', $firstname);
$statement->bindValue(':surname', $surname);
$statement->bindValue(':email', $email);
$statement->bindValue(':phone', $phone);
$statement->bindValue(':image', $imagePath);
$statement->execute();

header("location: contactList.php");

    }
}
function randomString($n){
    $chareacters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for($i = 0; $i < $n; $i++){
        $index = rand(0, strlen($chareacters)-1);
        $str .= $chareacters[$index];
    }
    return $str;
}
require_once "header.php";
?>
<div class="container7">
    <div class="cardContainer7">
    <form method="post" enctype="multipart/form-data">
        <div class="card7">
            <label for="">First name</label>
            <input type="text" name="firstname" placeholder="*mandatory">
            <label for="">Surname</label>
            <input type="text" name="surname">
            <label for="">Phone number</label>
            <input type="number" name="phone"  placeholder="*mandatory">
            <label for="">Email</label>
            <input type="email" name="email" >
            <label for="">Add image</label>
            <input type="file" name="image">
            <button type="submit" class = "btn btn-sm btn-outline-primary"><h3>Add</h3></button>
            <a href="home.php" class = "btn btn-sm btn-outline-secondary"><h3>Back</h3></a>
        </div></form>
    </div>
</div>
<?php require_once "footer.php"; ?>