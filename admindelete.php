<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=phone_book', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$data = explode(" ", $_POST['id']);
$id = $data[0] ?? null;
if(!$id){
    header('Loacation: contactList.php');
    exit;
}
if($data[1]!=''){
unlink($data[1]);
}
$statement = $pdo->prepare('SELECT*FROM users WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);
$idkey=$user['idkey'];

$statement = $pdo->prepare('SELECT*FROM contact_list WHERE idkey = :idkey');
$statement->bindValue(':idkey', $idkey);
$statement->execute();
$contacts = $statement->fetchAll(PDO::FETCH_ASSOC);
$total = count($contacts);

foreach ($contacts as $contact){
unlink($contact['image']);
$statement = $pdo->prepare('DELETE FROM contact_list WHERE idkey = :idkey');
$statement->bindValue(':idkey', $idkey);
$statement->execute();
}
rmdir('images/'.$contact['idkey']);

$statement = $pdo->prepare('DELETE FROM users WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
header('Location: users.php');

?>