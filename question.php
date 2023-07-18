<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question</title>
    <link rel="stylesheet" href="./css/nav.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/body.css">
    <link rel="stylesheet" href="./css/sighnup.css">

</head>

<body>
    <?php include "dbconnect.php"; ?>
    <?php include "nav.php"; ?>
    <?php
    $id = $_GET['subid'];
    $sql = "SELECT * FROM `subject` WHERE sub_id=$id";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result)){
     $subname = $row['sub_name']; 
     $subdes = $row['sub_description']; 
    }
    ?>

    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Insert into thread db:
        $user_name = $_SESSION['name']; // Assuming you have the name stored in the session
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];

        $th_title = str_replace("<", "&lt;", $th_title);
        $th_title = str_replace(">", "&gt;", $th_title);

        $th_desc = str_replace("<", "&lt;", $th_desc);
        $th_desc = str_replace(">", "&gt;", $th_desc);

            $select_name_sql = "SELECT name FROM f_user WHERE name = '$user_name'";
            $name_result = mysqli_query($conn, $select_name_sql);
            $row3 = mysqli_fetch_assoc($name_result);
            $ques_user_name = $row3['name'];

        $sql = "INSERT INTO `ques` (`ques_title`,`ques_desc`,`ques_sub_id`,`ques_user_name`) VALUES ('$th_title','$th_desc','$id','$ques_user_name')";
        $result = mysqli_query($conn,$sql);
    
        $showAlert = true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your thread has been added! Please wait for community to respond.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
     }
    ?>

    <div class="container8">
        <div class="inside">
            <h1 class="display-4">Welcome to <?php echo $subname; ?> forums</h1>
            <p class="lead"><?php echo $subdes; ?></p><br>
            <hr>
            <p><b class="text3">NOTE :-</b><br>This is peer to peer forum for sharing knowledge with each
                other. Keep it friendly.
                Be courteous and respectful. Appreciate that others may have an opinion different from yours.Do not
                post copyright-infringing material.Stay on topic....Share your knowledge....Refrain from demeaning,
                discriminatory, or harassing behaviour and speech.
                No Spam,No Advertising.Do not post "Offensive Post".Remain Respectfull. <br> <b>-iDiscuss Team</b>
            </p>
        </div>
    </div>

    <div class="container5">
        <h2>Start Discussion:
            <hr>
        </h2>

        <?php
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        echo '<form action="' . $_SERVER["REQUEST_URI"] . '" method="post">
            <div class="form-group1">
                <label for="exampleInputEmail1" class="form-label">Problem Title:</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">*Keep your title as short and crisp as possible</div>
            </div> <br> <br>
                <div class="form-group1">
                <label for="exampleFormControlTextarea1">Eleborate your concern</label>
                <textarea class="form-control3" id="desc" name="desc" rows="3"></textarea>
            </div> <br>
            <div class="form-group1">
            <button type="submit" class="btn btn-primary">Submit</button></div>
        </form>';}
    else{
     echo '<div class="form-group1">
        <p class="form-text"><b>*You are not logged in.Kindly login to Post your Problem*</b></p>
        </div>';
    }
    ?>
    </div>


    <div class="container3">
        <h1>Browse Questions:<hr></h1>

        <?php
            $id = $_GET['subid'];
            $sql = "SELECT * FROM `ques` WHERE ques_sub_id=$id";
            $result = mysqli_query($conn,$sql);
            $noResult = true;
            while($row = mysqli_fetch_assoc($result)){
            $noResult = false;
            $id = $row['ques_id']; 
            $title = $row['ques_title']; 
            $desc = $row['ques_desc']; 
            $name2 = $row['ques_user_name']; 
            $timestamp = $row['time_stamp'];
            $date = new DateTime($timestamp);
            $new_date_format = $date->format('j-F-Y | g:i a');
                
            echo '<div class="d-flex">
                <span class="flex-shrink">
                <img src="./img/user.png" width="30px" alt="user"></span>
                <div class="flex-grow"><p class="medium">Asked by: <span class="pname">' .$name2. '</span> at <span class="pname">' .$new_date_format. '</span></p><a href="answer.php?quesid=' .$id. '"><span class="pname">Ques: </span>' .$title. '</a></h5><br><span class="pname">Desc: </span>' .$desc. '</div></div><br>';
                }
            if($noResult){
            echo '<b><div class="container5">
                <h2>No Threads Found</h2>
                <p class="form-control"> Be the first Person to ask a Question</p>
                </div> </b>';
            } 
        ?>
    </div>




    <?php include 'footer.php'; ?>

</body>

<script src="jsforforum.js"></script>

</html>