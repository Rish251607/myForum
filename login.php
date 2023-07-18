<?php

include "dbconnect.php";

$name = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['name'])) || empty(trim($_POST['password']))){
        $err = '<span class="alert">Please enter name + password</span>';
    }
    else{
        $name = trim($_POST['name']);
        $password = trim($_POST['password']);
    }


    if(empty($err))
    {
        $sql = "SELECT sno, name, password FROM `f_user` WHERE name = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_name);
        $param_name = $name;
        
        // Try to execute this statement
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_result($stmt, $id, $name, $hashed_password);
                if(mysqli_stmt_fetch($stmt)){
                    if(password_verify($password, $hashed_password)){
                        // This means the password is correct. Allow the user to log in.
                        session_start();
                        $_SESSION["name"] = $name;
                        $_SESSION["loggedin"] = true;

                        // Redirect user to welcome page
                        header("location: index.php");
                        exit();
                    }
                     else{
                         $err = '<span class="alert">*incorrect password</span>';
                     }
                }
            }
             else{
                 $err = '<span class="alert">Incorrect name</span>';
             }
        }
        else{
            $err = '<span class="alert">Something went wrong. Please try again later.</span>';
        }
    } 
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PHP login system!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="./css/sighnup.css">
    <link rel="stylesheet" href="./css/nav.css">
    <link rel="stylesheet" href="./css/footer.css">
</head>

<body>

    <?php include 'nav.php'; ?>

    <div class="container5 mt-4">
        <h2>Please Login Here:</h2>
        <hr>
        <form action="login.php" method="post">
            <?php echo $err ?> <br>

            <div class="form-group1">
                <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    placeholder="Enter name">
            </div><br>

            <div class="form-group1">
                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                    placeholder="Enter Password">
            </div> <br>

            <div class="form-group1">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <?php include 'footer.php';?>

</body>
<script src="jsforforum.js"></script>
</html>