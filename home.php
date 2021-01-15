<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=phone_book', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
session_start();
$idkey= $_SESSION['idkey'];
if (!is_dir('images')){
    mkdir('images');
}
if(!$idkey){
    header("location: index.php");
}
$statement = $pdo->prepare('SELECT*FROM users WHERE idkey = :idkey');
$statement->bindValue(':idkey', $idkey);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

$statement = $pdo->prepare('SELECT*FROM contact_list WHERE idkey = :idkey');
$statement->bindValue(':idkey', $idkey);
$statement->execute();
$contacts = $statement->fetchAll(PDO::FETCH_NUM);
$total = count($contacts);

//to refresh pags
// echo "<meta http-equiv='refresh' content='0'>";

require_once "header.php";
?>

<div class="container5">
    <div class="cardContainer5">
        <div class="card5">
            <div class="container8">
                <div class="cardContainer8">
                    <div class="card8 card">
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
            <?php if($idkey==='admin1'): ?>
            <div class="container9">
                <div class="cardContainer9">
                    <div class="card9 card">
                        <a href="users.php">View Users</a>
                    </div>
                </div>
            </div>
            <?php endif ?>
            <div>
            <?php  if(!empty($user['image'])): ?>
                <img src="<?php echo $user['image'] ?>" class="img1">
                <?php  endif ?>
            <span id="uploaded_image"></span>
            </div>
                <label>
                <img src="icon/camera.svg" class="img2"><p>Add image</p>
                <input type="file" name="file" id="file" />
                </label>
            
            <div class="box1">
            <h3>Name - <?php echo $user['firstname'].' '.$user['surname']; ?></h3>
            <h3>Email - <?php echo $user['email'];?></h3>
            <h3>Phone no. - <?php echo $user['phone'];?></h3>
            </div>
            <div class="box2">
            <h3>Total contacts - <?php if($total<10){echo '0'.$total;}else{echo $total;} ?></h3>
            <a href="AddContact.php" class="text-dark"><h3>Add a contact</h3></a>
            <a href="contactList.php" class="text-dark"><h3>Open contact list</h3></a>            
                        
            </div>
        </div>
    </div>
</div>
<?php require_once "footer.php"; ?>