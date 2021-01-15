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
$statement = $pdo->prepare('SELECT*FROM contact_list WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$contact = $statement->fetch(PDO::FETCH_ASSOC);

if($_SERVER["REQUEST_METHOD"] === "POST") {

    $firstname=$_POST['firstname'];
    $surname=$_POST['surname'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    $image=$_FILES['image'];

    if(!empty($_FILES['image']['tmp_name'])){
        unlink($contact['image']);
        $imagePath = 'images/'.$idkey.'/'.randomString(6).$image['name'];
        if (!is_dir($imagePath)){
            mkdir(dirname($imagePath));
        }
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }else{$imagePath=$contact['image'];}

$statement = $pdo->prepare("UPDATE contact_list SET  firstname=:firstname, surname=:surname, phone=:phone, email=:email, image=:image WHERE id=:id");
$statement->bindValue(':firstname', $firstname);
$statement->bindValue(':surname', $surname);
$statement->bindValue(':phone', $phone);
$statement->bindValue(':email', $email);
$statement->bindValue(':image', $imagePath);
$statement->bindValue(':id', $id);
$statement->execute();

header("location: contactList.php");
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
            <input type="text" name="firstname" value="<?php echo $contact['firstname'];?>">
            <label for="">Surname</label>
            <input type="text" name="surname" value="<?php echo $contact['surname'];?>">
            <label for="">Phone number</label>
            <input type="number" name="phone"  value="<?php echo $contact['phone'];?>">
            <label for="">Email</label>
            <input type="email" name="email" value="<?php echo $contact['email'];?>">
            <label for="">Change image</label>
            <input type="file" name="image" value="<?php echo $contact['image'];?>">
            <button type="submit" class="btn btn-sm btn-outline-primary"><h3>Change</h3></button>
            <a href="contactList.php" class="btn btn-sm btn-outline-secondary"><h3>Back</h3></a>
        </div></form>
    </div>
</div>
<?php require_once "footer.php"; ?> 