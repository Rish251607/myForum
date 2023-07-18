<?php

include 'dbconnect.php';

$name = $email = $password = $confirm_password = "";
$name_err = $email_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if name is empty
if(empty(trim($_POST["name"]))){
    $name_err = '<span class="alert">*Name cannot be blank* <br></span>';
}else{
    $sql = "SELECT sno FROM f_user WHERE `name` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if($stmt)
    {
        mysqli_stmt_bind_param($stmt, "s", $param_name);

        // Set the value of param name
        $param_name = trim($_POST['name']);

        // Try to execute this statement
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1)
            {
                $name_err = '<span class="alert">*This name is already taken*<br></span>'; 
            }
            else{
                $name = trim($_POST['name']);
            }
        }
        else{
            echo '<span class="alert">*Something went wrong*</span>';
        }
    }
}



    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = '<span class="alert">*Email cannot be blank* <br></span>';
    }
    else{
        $sql = "SELECT sno FROM f_user WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set the value of param username
            $param_email = trim($_POST['email']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $email_err = '<span class="alert">*This Email is already taken*<br></span>'; 
                }
                else{
                    $email = trim($_POST['email']);
                }
            }
            else{
                echo '<span class="alert">*Something went wrong*</span>';
            }
        }
    }

    // mysqli_stmt_close($stmt);


// Check for password
if(empty(trim($_POST['password']))){
    $password_err = '<span class="alert">*Password cannot be blank* <br></span>';
}
elseif(strlen(trim($_POST['password'])) < 2){
    $password_err = '<span class="alert">*Password cannot be less than 2 characters* <br></span>';
}
else{
    $password = trim($_POST['password']);
}

// Check for confirm password field
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $confirm_password_err = '<span class="alert">*Passwords should match* <br></span>';
}


// If there were no errors, go ahead and insert into the database
if (empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err))
{
    $sql = "INSERT INTO `f_user` (`name`, `email`, `password`) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_email, $param_password);

        // Set these parameters
        $param_name = $name;
        $param_email = $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            session_start();
             $_SESSION["name"] = $name;
             $_SESSION["loggedin"] = true;

             //Redirect user to welcome page
             header("location: index.php?signupsuccess=true");
            exit(); // Add this line to stop further execution
        }
        else {
            echo "Error: " . mysqli_error($conn); // Display the specific error message
        }
    }
    mysqli_stmt_close($stmt);
}
 mysqli_close($conn);
}
?>




<!doctype html>
<html lang="en">

<head>
    <title>PHP signup system!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="./css/sighnup.css">
    <link rel="stylesheet" href="./css/nav.css">
  <link rel="stylesheet" href="./css/footer.css">
    
</head>

<body>
    <?php include 'nav.php'; ?>

    <div class="container5">
        <h2>Please Register Here:</h2>
        <hr> <br>
        <form action="signup.php" method="post">

        <div class="form-group1">
            <input type="text" class="form-control" name="name" id="inputname4" placeholder="Name"><br>
            <?php echo $name_err ?>  </div><br>

            <div class="form-group1">
            <input type="email" class="form-control" name="email" id="inputemail4" placeholder="email"><br>
            <?php echo $email_err ?> </div><br>

            <div class="form-group1">
            <input type="password" class="form-control" name="password" id="inputPassword4" placeholder="Password"> <br>
            <?php echo $password_err ?></div> <br>


            <div class="form-group1">
            <input type="password" class="form-control" name="confirm_password" id="inputPassword"
                placeholder="Confirm Password"> <br>
            <?php echo $confirm_password_err ?> </div><br>


            <div class="form-group1">
            <button type="submit" class="btn btn-primary">Sign in</button> </div>
            <p class="link">Already Having Account <a href="login.php" class="linka">Log in</a></p>
        </form>
    </div>
    <?php include 'footer.php';?>
</body>
<script src="jsforforum.js"></script>
</html>