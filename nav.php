<nav>
    <div class="container">
        <div class="leftcont">
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="about.php">ABOUT</a></li>
                <li><input type="search" name="" id="" placeholder="Search"></li>
            </ul>
        </div>

        <?php
          session_start();
         echo '<div class="cont2">
           <div class="rightcont">
          <ul>';
          if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
            echo '<li><a href="logout.php">LOGOUT</a></li>

            <li>welcome!..'.$_SESSION['name'].'</li>';
          }else{ 
            echo'<li><a href="signup.php">SIGNUP</a></li>
              <li><a href="login.php">LOGIN</a></li>';
          }
        ?>
        <div class="button day-theme" onclick="setTheme('day')">Day</div>
        <div class="button night-theme" onclick="setTheme('night')">Night</div>
        </ul>
    </div>
    </div>
    </div>
</nav>