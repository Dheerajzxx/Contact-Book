<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=phone_book', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
session_start();
$idkey= $_SESSION['idkey'];
if(!$idkey){
    header("location: index.php");
}
$id = $_GET['id'] ?? null;
if(!$id){
    header('Loacation: contactList.php');
    exit;
}
$statement = $pdo->prepare('SELECT*FROM users WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

if($_SERVER["REQUEST_METHOD"] === "POST") {

    $firstname=$_POST['firstname'];
    $surname=$_POST['surname'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $phone=$_POST['phone'];
    $image=$_FILES['image'];

    if(!empty($_FILES['image']['tmp_name'])){
         $test = explode('.', $_FILES['image']['tmp_name']);
         $ext = end($test);
         $imagePath = 'images/'.$user['idkey'].'.'. $ext;
         if(file_exists($imagePath)){
             unlink($imagePath);
         }
         move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }else{$imagePath=$user['image'];}

$statement = $pdo->prepare("UPDATE users SET  firstname=:firstname, surname=:surname, phone=:phone, email=:email, password=:password, image=:image WHERE id=:id");
$statement->bindValue(':firstname', $firstname);
$statement->bindValue(':surname', $surname);
$statement->bindValue(':email', $email);
$statement->bindValue(':password', $password);
$statement->bindValue(':phone', $phone);
$statement->bindValue(':image', $imagePath);
$statement->bindValue(':id', $id);
$statement->execute();

header("location: users.php");
}
require_once "header.php";
?>
<div class="container7">
    <div class="cardContainer7">
    <form method="post" enctype="multipart/form-data"> 
        <div class="card7">
            <label for="">First name</label>
            <input type="text" name="firstname" value="<?php echo $user['firstname'];?>">
            <label for="">Surname</label>
            <input type="text" name="surname" value="<?php echo $user['surname'];?>">
            <label for="">Email</label>
            <input type="email" name="email" value="<?php echo $user['email'];?>">
            <label for="">Password</label>
            <input type="number" name="password"  value="<?php echo $user['password'];?>">
            <label for="">Phone number</label>
            <input type="number" name="phone"  value="<?php echo $user['phone'];?>">
            <label for="">Change image</label>
            <input type="file" name="image">
            <button type="submit" class="btn btn-sm btn-outline-primary"><h3>Change</h3></button>
            <a href="users.php" class="btn btn-sm btn-outline-secondary"><h3>Back</h3></a>
        </div></form>
    </div>
</div>
<?php require_once "footer.php"; ?> 