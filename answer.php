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
    $id = $_GET['quesid'];
    $sql = "SELECT * FROM `ques` WHERE ques_id=$id";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result)){
     $quetitle = $row['ques_title']; 
     $quedes = $row['ques_desc']; 
    }
    ?>

    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Insert into thread db:
        $user_name = $_SESSION['name']; // Assuming you have the name stored in the session
        $answer = $_POST['answer'];
        

        $answer = str_replace("<", "&lt;", $answer);
        $answer = str_replace(">", "&gt;", $answer);

        $select_name_sql = "SELECT name FROM f_user WHERE name = '$user_name'";
        $name_result = mysqli_query($conn, $select_name_sql);
        $row3 = mysqli_fetch_assoc($name_result);
        $ans_by_user = $row3['name'];

        $sql = "INSERT INTO `answer` (`ans_content`,`ques_id`,`ans_by_user`,`time`) VALUES ('$answer','$id','$ans_by_user',current_timestamp())";
        $result = mysqli_query($conn,$sql);
    
        $showAlert = true;
        if($showAlert){
            echo '<div class="done">
            <strong>Success!</strong> Your Answer has been added!</div>';
        }
     }
    ?>

    <div class="container8">
        <div class="inside">
            <h1 class="display-4"><?php echo $quetitle; ?></h1>
            <p class="lead"><?php echo $quedes; ?></p><br>
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
        <label for="exampleFormControlTextarea1">Type your Answer</label>
        <textarea class="form-control" id="answer" name="answer" rows="3"></textarea>
         </div> <br>
            <div class="form-group1">
            <button type="submit" class="btn btn-primary">Post Answer</button></div>
        </form>';}
    else{
     echo '<div class="form-group1">
        <p class="form-text"><b>*You are not logged in.Kindly login to Post your Answer*</b></p>
        </div>';
    }
    ?>
    </div>


    <div class="container3">
        <h1>Discussions:<hr></h1>

        <?php
            $id = $_GET['quesid'];
            $sql = "SELECT * FROM `answer` WHERE ques_id=$id";
            $result = mysqli_query($conn,$sql);
            $noResult = true;
            while($row = mysqli_fetch_assoc($result)){
            $noResult = false;
            $id = $row['ans_id']; 
            $answer = $row['ans_content']; 
            $name2 = $row['ans_by_user']; 
            $timestamp = $row['time'];
            $date = new DateTime($timestamp);
            $new_date_format = $date->format('j-F-Y | g:i a');
                
            echo '<div class="d-flex">
                <span class="flex-shrink">
                <img src="./img/user.png" width="30px" alt="user"></span>
                <div class="flex-grow"><p class="medium">Answered by: <span class="pname">' .$name2. '</span> at <span class="pname">' .$new_date_format. '</span></p></h5><span class="pname">Ans: </span>' .$answer. '</div></div><br>';
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