<?php
session_start();
require ("connect.php");
$conn = CreateHandle();
$error = 0;

if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST'){
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $name = isset($_POST['name']) ? $_POST['name'] : "";
    $upass = isset($_POST['upass']) ? $_POST['upass'] : "";
    $upass2 = isset($_POST['upass2']) ? $_POST['upass2'] : "";
    
    $email = $conn->real_escape_string($email);
    $name = $conn->real_escape_string($name);
    $upass = $conn->real_escape_string($upass);
    $upass2 = $conn->real_escape_string($upass2);
    
    if($upass == $upass2){
        
        $sqlquery = "INSERT INTO users (email, name, password) VALUES ('$email', '$name', '$upass')";        
        $sqlquery2 = "SELECT email FROM users WHERE email = '$email'";
        
        $result = $conn ->query($sqlquery2);
        //$data = $result->fetch_array(MYSQLI_NUM);
        //if(!isset($data))
        //mysqli_num_rows($result) == 0
        
        
            if(mysqli_num_rows($result) == 0){
                
                    if (isset($conn)){
                        $result = $conn->query($sqlquery);
                        $conn->close();
                        $_SESSION['name'] = $name;
                        $_SESSION['email'] = $email;
                        header('location: index.php?registered=1');
                    }
                
            }else{                
                $error = 2;
            }
        
        
    }else{
        $error = 1;
    }
    
}
    

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
     <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
    
    <title>PK Weather Register</title>
</head>
    
<body>

    <div class="container">
        <div class="wrapper">
            <form class="form-signin" id="loginDetails" name="loginDetails" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                <br>
                <h1 class="text-center">Register!</h1>
                <br>
                <input class="form-control" type="email" id="email" name="email" required="true" autofocus="true" placeholder="Email" value="" />
                <br>
                <input class="form-control" type="name" id="name" name="name" required="true" autofocus="true" placeholder="Name" value="" />
                <br>
                <input class="form-control" type="password" id="upass" name="upass" required="true" placeholder="Password" />
                <br>
                <input class="form-control" type="password" id="upass2" name="upass2" required="true" placeholder="Password Again" />
                
                <?php
                    if($error == 1){
                        echo "<br>
                            <div class=\"alert alert-danger\" role=\"alert\">
                            Passwords do not match!
                            </div>
                            ";
                    }
                  if($error == 2){
                        echo "<br>
                        <div class=\"alert alert-danger\" role=\"alert\">
                        User already exists!
                        </div>";
                    }
                ?>
                <br>
                <button class="btn btn-lg btn-primary btn-block" type="submit" id="cmdSubmit" name="cmdSubmit" value="sign in">Register</button>
                <br>
                <a class="btn btn-lg btn-danger btn-block" href="login.php">Login?</a>
            </form>
                        
        </div>

    </div> <!-- /container -->







    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>