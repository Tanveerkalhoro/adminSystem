<?php 
include('header.php');
// echo "<br><br><br><br><br> user_id".$_SESSION['user_id'];
if(!isset($_SESSION['user_name'])){
    header("Location: login.php");
    ob_end_clean(); // Clean the buffer before redirect
}
$user_id = $_SESSION['user_id']; 
extract($_REQUEST);
if(isset($mode) && $mode=="delete" && isset($id)){
    $sql4     = "DELETE  FROM users WHERE id='$id' ";
    $result4  =mysqli_query($conn,$sql4);
    if($result4 > 0) {
      echo"This record has been deleted successfully!";
    }

}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>

        <?php include("css.php"); ?>
        <title>News & Posts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        h1 {
            color: #333;
            text-align: center;
        }
        
        .post {
            background: #fff;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .post-title {
            color: #333;
            margin-top: 0;
        }
        
        .post-meta {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 15px;
        }
        
        .post-content {
            color: #444;
        }
        
        .read-more {
            display: inline-block;
            color: #fff;
            background: #333;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
            margin-top: 10px;
        }
        
        .read-more:hover {
            background: #555;
        }
    </style>

    </head>
    <body>
        <?php include("sidebar.php"); ?>
        <div class="container">
        <h1>Latest News & Posts</h1>
        
        <!-- Post 1 -->
        <div class="post">
            <h2 class="post-title">Breaking News: Important Announcement</h2>
            <div class="post-meta">Posted on January 15, 2023 by Admin</div>
            <div class="post-content">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor.</p>
                <a href="#" class="read-more">Read More</a>
            </div>
        </div>
        
        <!-- Post 2 -->
        <div class="post">
            <h2 class="post-title">Monthly Newsletter: January Edition</h2>
            <div class="post-meta">Posted on January 5, 2023 by Editor</div>
            <div class="post-content">
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                <a href="#" class="read-more">Read More</a>
            </div>
        </div>
        
        <!-- Post 3 -->
        <div class="post">
            <h2 class="post-title">Tech Update: New Features Released</h2>
            <div class="post-meta">Posted on December 28, 2022 by Tech Team</div>
            <div class="post-content">
                <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                <a href="#" class="read-more">Read More</a>
            </div>
        </div>
    </div>
    </body>
</html>