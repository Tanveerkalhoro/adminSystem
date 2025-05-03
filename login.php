<?php 
include('header.php');

if(isset($_SESSION['user_name'])){
    header("Location: index.php");
    ob_end_clean(); 
}
extract($_POST);
if(isset($is_submit) && $is_submit == "Y"){
    $error = '';
    
    if($user_name == ""){
        $error = "Please Insert User Name";
    }
    if($pasword == ""){
        $error .= (empty($error) ? "" : "<br>") . "Please Insert password";
    }
    
    if(empty($error)) {
        $sql3 = "SELECT * FROM users WHERE user_name='".$user_name."' AND pasword='".$pasword."' ";
        $result3 = mysqli_query($conn, $sql3);
        $count3 = mysqli_num_rows($result3);
        
        if($count3 > 0) {
            $data = mysqli_fetch_assoc($result3);
            $user_id                 = $data['id'];
            $user_type               = $data['user_type'];
            $_SESSION['user_type']   = $user_type;
            $_SESSION['user_id']     = $user_id;
            $_SESSION['user_name']   = $user_name;
           header("Location: index.php");
           ob_end_clean(); 
        } else {
            $error = "Invalid username or password!";
        }
    }
}



?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sidebar with Spacing</title>
  
        <?php include("css.php"); ?>

    </head>
    <body>
        <?php include("sidebar.php"); 
        ?>

        <div class="content">

            <div class="content">
                <h2 class="form-title">Login Form</h2>
                
                <?php if(isset($error) && !empty($error)) { ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php } ?>
                
                <form action="" method="POST">
                    <input type="hidden" name="is_submit" value="Y">
                    <div class="form-group">
                        <label for="user_name">User Name</label>
                        <input type="text" id="user_name" name="user_name" value="<?php echo isset($user_name) ? htmlspecialchars($user_name) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="pasword">Password</label>
                        <input type="password" id="pasword" name="pasword">
                    </div>
                    
                    <div class="form-group">
                        <input type="submit" value="Login">
                    </div>
                </form>
            </div>

            <?php 
            include("footer.php");
            ?>
        </div> 
    </body>
</html>