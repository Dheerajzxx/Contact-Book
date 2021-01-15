<?php header('Clear-Site-Data:"cache"');
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=phone_book', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST") {
$email=$_POST['email'];
$password=$_POST['password'];

$statement = $pdo->prepare('SELECT*FROM users WHERE email = :email');
$statement->bindValue(':email', $email);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

if($user['password']===$password){
    
    $_SESSION["idkey"] = $user['idkey'];
    header("location: home.php");
}
else{
    header("location: index.php");
}

    
}
require_once "header.php";
?>
    <div class="row">
        <div class="col-8">
            <div class="container1">
                <div class="cardContainer1">
                    <div class="card1 card">
                        <div class="image"><img src="icon/phone-book.svg" alt=""></div>
                        <div class="heading">
                            <h1>Phone-Book</h1>
                        </div>
                    </div>
                    <div class="cardContainer2">
                        <div class="card2 card">
                            <h2>Features :-</h2>
                            <hr>
                            <p>- Save your contact</p>
                            <p>- Edit your contact</p>
                            <p>- Delete your contact</p>
                            <p>- Unlimited space</p>
                            <p>- Add an image</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="container3">
                <div class="cardContainer3 ">
                    <div class="card3 card">
                    <form style="display:inline-block" method="post">
                        <div><input type="email" name="email" placeholder="Enter your email"></div>
                        <div><input type="password" name="password" placeholder="Enter your paasword"></div>
                        <button type="submit" class="bg-primary">Log In</butoon>
                    </form>
                        <a href="create.php" class="bg-success">Create New Account</a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

<?php require_once "footer.php"; ?>