<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum website</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="./css/nav.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/body.css">

</head>

<body>
    <?php include "nav.php"; ?>
    <?php include "dbconnect.php"; ?>
    

    <div class="cont4">
        <div class="subblock">
            <?php 
                $sql = "SELECT * FROM `subject`";
                $result = mysqli_query($conn,$sql);
                while($row = mysqli_fetch_assoc($result)){
                $id = $row['sub_id']; 
                $sub = $row['sub_name']; 
                $desc = $row['sub_description']; 
                echo '<div class="card">
                    <img src="./img/card-'.$id.'.jpg" class="card-img-top" alt="logo">
                    <div class="card-body">
                        <h5 class="card-title"><a class="block" href = "question.php?subid=' .$id. '">' .$sub. '</a></h5>
                        <p class="card-text">' . substr($desc,0,30). '...</p>
                        <a href="question.php?subid=' .$id. '" class="btn btn-success">View questions</a>
                    </div>
                    </div>';
                }
            ?>
        </div>
    </div>


    <?php include 'footer.php'; ?>



</body>
<script src="jsforforum.js"></script>

</html>