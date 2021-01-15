<?php header('Clear-Site-Data:"cache"');
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=phone_book', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
session_start();
$error=[
    '1'=>'',
    '2'=>'',
    '3'=>''
];
$value=[
    'firstname'=>'',
    'surname'=>'',
    'email'=>'',
    'phone'=>''
];
if($_SERVER["REQUEST_METHOD"] === "POST") {
    if(!empty($_POST['firstname']) && !empty($_POST['email'])  && !empty($_POST['password']))
    {
        $firstname=$_POST['firstname'];
        $surname=$_POST['surname'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $phone=$_POST['phone'];
        $rdate = date('Y-m-d H:i:s');
        $idkey= randomString(6);

if (!is_dir('images')){
    mkdir('images');
}

$statement = $pdo->prepare("INSERT INTO users (idkey, firstname, surname, email, password, phone, rdate)
                VALUES (:idkey, :firstname, :surname, :email, :password, :phone, :rdate)");
$statement->bindValue(':idkey', $idkey);
$statement->bindValue(':firstname', $firstname);
$statement->bindValue(':surname', $surname);
$statement->bindValue(':email', $email);
$statement->bindValue(':password', $password);
$statement->bindValue(':phone', $phone);
$statement->bindValue(':rdate', $rdate);
$statement->execute();

$_SESSION["idkey"] = $idkey;
header("location: home.php");
}
else{
    if(empty($_POST['firstname'])){
    $error['1'] = '*mandatory';
    }
    if(empty($_POST['email'])){
    $error['2'] = '*mandatory';
    }  
    if(empty($_POST['password'])){
    $error['3'] = '*mandatory';
    }    
}
if(!empty($_POST['firstname'])){
    $value['firstname']=$_POST['firstname'];
}
if(!empty($_POST['surname'])){
    $value['surname']=$_POST['surname'];
}
if(!empty($_POST['email'])){
    $value['email']=$_POST['email'];
}
if(!empty($_POST['phone'])){
    $value['phone']=$_POST['phone'];
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

<div class="container4">
    <div class="cardContainer4 ">
        <div class="card4 card">
        <form method="post">
            <label for="">First name</label>
            <input type="text" name="firstname" placeholder="<?php echo $error['1'];?>" value="<?php echo $value['firstname'];?>">
            <label for="">Surname</label>
            <input type="text" name="surname" value="<?php echo $value['surname'];?>">
            <label for="">Email</label>
            <input type="email" name="email" placeholder="<?php echo $error['2'];?>" value="<?php echo $value['email'];?>">
            <label for="">Phone number</label>
            <input type="number" name="phone" value="<?php echo $value['phone'];?>">
            <label for="">Password</label>
            <input type="password" name="password" placeholder="<?php echo $error['3'];?>" >
            <button type="submit" class="bg-primary">Register</button>
            </form>
        </div>
    </div>
</div>


<?php require_once "footer.php"; ?>