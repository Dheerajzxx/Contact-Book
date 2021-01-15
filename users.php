<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=phone_book', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
session_start();
$idkey= $_SESSION['idkey'];
if($idkey!='admin1'){
    header("location: logout.php");
}

$search = $_GET['search'] ?? '';
if($search){
  $statement = $pdo->prepare('SELECT*FROM users WHERE idkey LIKE :idkey AND firstname LIKE :search OR surname LIKE :search OR phone LIKE :search OR email LIKE :search OR password LIKE :search ORDER BY firstname ASC');  
  $statement->bindValue(':search', "%$search%");
  $statement->bindValue(':idkey', $idkey);
}
else{
$statement = $pdo->prepare('SELECT*FROM users ORDER BY firstname ASC');
}
$statement->execute();
$users = $statement->fetchAll(PDO::FETCH_ASSOC);

require_once "header.php";

?>

<div class="tableBody">
<form method="get">
<div class="input-group mb-3">
<input type="text" class="form-control" placeholder="Search for product" name="search" value="<?php echo $search ?>">
<button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
</div>
</form>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Firstname</th>
      <th scope="col">Surname</th>
      <th scope="col">Email</th>
      <th scope="col">Password</th>
      <th scope="col">Phone</th>
      <th scope="col"><a href="home.php" style="height:35px; width:105px" class = "btn btn-sm btn-outline-secondary">Back</a></th>
    </tr>
  </thead>
  <tbody>
  <?php  foreach ($users as $i => $user):?>
    <tr>
      <th scope="row"><?php echo $i+1 ?></th>
      <td>
            <?php if(!empty($user['image'])): ?>
            <img class="contactimg" src="<?php echo $user['image'] ?>">
            <?php endif; ?>
      </td>
      <td><?php echo $user['firstname'] ?></td>
      <td><?php echo $user['surname'] ?></td>
      <td><?php echo $user['email'] ?></td>
      <td><?php echo $user['password'] ?></td>
      <td><?php echo $user['phone'] ?></td>
      <td>
        <form style="display:inline-block" method="get" action="adminedit.php">
        <input type="hidden" name="id" value="<?php echo $user['id'] ?>">
        <button type="submit" class = "btn btn-sm btn-outline-primary">Edit</button>
        </form>
        <form style="display:inline-block" method="post" action="admindelete.php">
        <input type="hidden" name="id" value="<?php echo $user['id'].' '; echo $user['image']; ?>">                
        <button type="submit" class = "btn btn-sm btn-outline-danger" >Delete</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php require_once "footer.php"; ?>
