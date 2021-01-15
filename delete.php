<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=phone_book', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$data = explode(" ", $_POST['id']);
$id = $data[0] ?? null;
if(!$id){
    header('Loacation: contactList.php');
    exit;
}
if($data[1]){
unlink($data[1]);
}
$statement = $pdo->prepare('DELETE FROM contact_list WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();

header('Location: contactList.php');

?>