<?php
/**
 * Created by PhpStorm.
 * User: alic
 * Date: 15-7-20
 * Time: 上午11:56
 */
define("SCRIPT","plus_member_active");
require_once("include/common.php");
_isset_cookie();

if(isset($_GET["id"])){
   $_id = $_GET["id"];
}else{
   header("Location:active.php");
}
/*加入报名*/
if(isset($_POST["re_btn"])){
   $_clean = $_POST["register"];
//   print_r($_clean);
//   exit;
   $_length_cl = count($_clean);
   foreach(range(0,$_length_cl-1) as $i){
      _query("INSERT INTO joind (active_id,join_name,reg,dated)
             VALUES (
                     $_id,
                     '{$_clean[$i]}',
                     0,
                     NOW()
             )");
   }
      header("Location:plus_member_active.php?id=$_id");
}

/*取消报名*/
if(isset($_POST["un_plu_btn"])){
   $_clean = $_POST["un_plus"];
//   print_r($_clean);
//   exit;
   $_length_cl = count($_clean);
   foreach(range(0,$_length_cl-1) as $i){
      _query("DELETE FROM joind WHERE active_id=$_id AND join_name='{$_clean[$i]}'");
   }
   header("Location:plus_member_active.php?id=$_id");
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
   <?php require_once("include/header_script.php"); ?>
    <title>团队报名</title>
</head>
<body>
<?php require_once("include/header_div.php"); ?>
<div id="content">
   <?php require_once("include/hidden.php") ?>
   <?php
   $_action = _affect_array("SELECT * FROM actiion WHERE id=$_id");
   $_group = _affect_array("SELECT * FROM groupd WHERE id={$_action["ground"]}");
   $_content = $_group["member"];
//   echo $_content;
   $_member_array = explode("/",$_content);
//   print_r($_member_array);
   ?>
   <div id="plu">
      <form action="?id=<?php echo $_id;  ?>" method="post">
         <?php
         $_length = count($_member_array);
         foreach (range(0, $_length - 1) as $_i) {
            ?>
            <p>
               <?php
               $_member_re = _query("SELECT * FROM joind WHERE active_id=$_id AND join_name='{$_member_array[$_i]}'");
               if(_num_rows($_member_re) == 0){
                  ?>
                  <label for="<?php echo $_i ?>">
                     <input type="checkbox" id="<?php echo $_i ?>" name="register[]"
                            value="<?php echo $_member_array[$_i] ?>">
                     <?php echo $_member_array[$_i] ?>
                  </label>
                  <em>未报名</em>
               <?php }else{ ?>
                  <?php echo $_member_array[$_i] ?>
                  <em>已报名</em>
               <?php } ?>
            </p>
         <?php } ?>
         <p>
            <label for="re_btn">
               <input type="submit" name="re_btn" class="pl_btn" value="协助报名">
               <a class="toggle1">取消报名</a>
            </label>
         </p>
      </form>
   </div>
   <div id="un_plu">
      <form action="?id=<?php echo $_id;  ?>" method="post">
         <?php
         $_length = count($_member_array);
         foreach (range(0, $_length - 1) as $_i) {
            ?>
            <p>
               <?php
               $_member_re = _query("SELECT * FROM joind WHERE active_id=$_id AND join_name='{$_member_array[$_i]}'");

               if(_num_rows($_member_re) == 1){
                  ?>
                  <label>
                      <input type="checkbox" id="<?php echo $_i ?>" name="un_plus[]"
                         value="<?php echo $_member_array[$_i] ?>">
                  <?php echo $_member_array[$_i] ?>
                  </label>
                  <em>已报名</em>
               <?php }?>
            </p>
         <?php } ?>
         <p>
            <label for="re_btn">
               <input type="submit" name="un_plu_btn" class="pl_btn" value="取消报名">
               <a class="toggle2">协助报名</a>
            </label>
         </p>
      </form>
   </div>
</div>
</body>
</html>