<?php  
if(isset($_SESSION['user_id'])){
  $sql    ="SELECT DISTINCT  a.* FROM `menus` a WHERE a.enable = 1 AND a.is_display = 1 ORDER BY a.sort_order ";
  $result =mysqli_query($conn,$sql);
  $count  =mysqli_num_rows($result);?>
  <div class="horizontal-sidebar">
      <a href="index.php">Home</a>
      <?php 
      if($count > 0){
          while($data =mysqli_fetch_assoc($result)) {
            $site_bar_menu_id = $data['id'];
            $sql    ="SELECT a.* 
                      FROM users a 
                      INNER JOIN `role_per` b ON a.`role_id` = b.role_id
                      WHERE a.id = '".$_SESSION['user_id']."'
                      AND b.`menus_id` = '".$site_bar_menu_id."' ";
            $result2 =mysqli_query($conn,$sql);
            $count2  =mysqli_num_rows($result2);
            if($count2 > 0 ||  $_SESSION['user_type'] =="SuperAdmin"){ ?>
              <a href="<?php echo $data['menus_links']; ?>?menu_id=<?php echo $data['id']; ?>"><?php echo $data['menus_name']; ?></a>
            <?php }
          }
      }?>
      <a href="logout.php">Logout</a>
  </div>
<?php }?>
    
