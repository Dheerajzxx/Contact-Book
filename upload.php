<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=phone_book', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
session_start();
$idkey= $_SESSION['idkey'];

if($_FILES["file"]["name"] != '')
{
 $test = explode('.', $_FILES["file"]["name"]);
 $ext = end($test);
 $location = 'images/'.$idkey.'.'. $ext;
 if(file_exists($location)){
     unlink($location);
 }
 move_uploaded_file($_FILES["file"]["tmp_name"], $location);
$statement = $pdo->prepare("UPDATE users SET  image=:image WHERE idkey=:idkey");
$statement->bindValue(':image', $location);
$statement->bindValue(':idkey', $idkey);
$statement->execute();
$statement = $pdo->prepare('SELECT*FROM users WHERE idkey = :idkey');
$statement->bindValue(':idkey', $idkey);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);
header('Clear-Site-Data:"cache"');
echo '<img src="'.$location.'" class="img1" />';

}
?>
