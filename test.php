<?php

  session_start();

  if (!$user_id = $_SESSION['user_id']) {
    
    header("Location:login.php");
  }


  $connection = mysqli_connect('localhost', 'root', '', 'foodstack');
    
  $search_query = "SELECT * FROM users WHERE user_id = '$user_id'";
    
  $result = mysqli_query($connection, $search_query);

  $row = mysqli_fetch_assoc($result);


  $name = $row['first_name'] . " " . $row['last_name'];
  $pro_pic = $row['pro_pic'];
  $city = $row['city'];


  //=============== Review Posting ======================

  // echo date("d M Y");

  if (isset($_POST['post'])) {

    $restaurant_name = $_POST['restaurant'];
    $menu_name = $_POST['menu'];
    $city = $_POST['city'];
    $rating = $_POST['rating'];
    $opinion = $_POST['opinion'];
    $date = date("d M Y");

    $restaurant_availability_checking_query = "SELECT * FROM restaurants WHERE restaurant_name = '$restaurant_name' AND city = '$city'";

    $available_restaurarant = mysqli_query($connection, $restaurant_availability_checking_query);

    if (mysqli_num_rows($available_restaurarant)) {

      $restaurant_info = mysqli_fetch_assoc($available_restaurarant);

      $this_restaurant_id = $restaurant_info['restaurant_id'];

      $menu_availability_checking_query = "SELECT * FROM menues WHERE menu_name = '$menu_name' AND restaurant_id = '$this_restaurant_id'";

      $available_menu = mysqli_query($connection, $menu_availability_checking_query);

      if (mysqli_num_rows($available_menu)) {

        $menu_info = mysqli_fetch_assoc($available_menu);

        $this_menu_id = $menu_info['menu_id'];
        $this_menu_rating = $menu_info['average_rating'];

        $final_rating = number_format((($this_menu_rating + $rating)/2), 2);

        $menu_rating_update_query = "UPDATE menues SET average_rating = '$final_rating' WHERE menu_id = '$this_menu_id'";

        mysqli_query($connection, $menu_rating_update_query);

        $post_insert_query = "INSERT INTO posts VALUES ('', '$user_id', '$this_restaurant_id', '$this_menu_id', '$date', '$rating', '$opinion', '', '', '')";

        mysqli_query($connection, $post_insert_query);

        $post_id_select_query = "SELECT * FROM posts WHERE (post_giver_id = '$user_id' AND restaurant_id = '$this_restaurant_id' AND menu_id = '$this_menu_id' AND date = '$date')";

        $selected_post = mysqli_query($connection, $post_id_select_query);

        $this_post = mysqli_fetch_assoc($selected_post);

        $this_post_id = $this_post['post_id'];


        // --------------- Uploading Image File to destination folder ------------

        $image_name = $_FILES['menu_pic']['name'];

        // ------------ Getting file extention -------------
        $extention = substr(strrchr(basename($image_name),'.'),1);
        // ------------ Getting file extention -------------

        $menu_pic_name = $this_post_id . "." . $extention ;
        $target = "images/posts/" . $menu_pic_name; // Renaming the image with post_id

        move_uploaded_file($_FILES['menu_pic']['tmp_name'], $target);

        $post_pic_update_query = "UPDATE posts SET post_pic = '$menu_pic_name' WHERE post_id = '$this_post_id'";

        mysqli_query($connection, $post_pic_update_query);

      } else {

        $menu_insert_query = "INSERT INTO menues VALUES ('', '$menu_name', '$rating', '$this_restaurant_id', '', '')";

        mysqli_query($connection, $menu_insert_query);

        $menu_id_select_query = "SELECT * FROM menues WHERE menu_name = '$menu_name' AND restaurant_id = '$this_restaurant_id'";

        $this_menu = mysqli_query($connection, $menu_id_select_query);

        $menu_info = mysqli_fetch_assoc($this_menu);

        $this_menu_id = $menu_info['menu_id'];


        $post_insert_query = "INSERT INTO posts VALUES ('', '$user_id', '$this_restaurant_id', '$this_menu_id', '$date', '$rating', '$opinion', '', '', '')";

        mysqli_query($connection, $post_insert_query);

        $post_id_select_query = "SELECT * FROM posts WHERE (post_giver_id = '$user_id' AND restaurant_id = '$this_restaurant_id' AND menu_id = '$this_menu_id' AND date = '$date')";

        $selected_post = mysqli_query($connection, $post_id_select_query);

        $this_post = mysqli_fetch_assoc($selected_post);

        $this_post_id = $this_post['post_id'];


        // --------------- Uploading Image File to destination folder ------------

        $image_name = $_FILES['menu_pic']['name'];

        // ------------ Getting file extention -------------
        $extention = substr(strrchr(basename($image_name),'.'),1);
        // ------------ Getting file extention -------------

        $post_pic_name = $this_post_id . "." . $extention ;
        $menu_pic_name = $this_menu_id . "." . $extention ;
        $post_target = "images/posts/" . $post_pic_name; // Renaming the image with post_id

        move_uploaded_file($_FILES['menu_pic']['tmp_name'], $post_target);

        // ====== Copy post pic to menu pic ==========
        $post_pic = "images/posts/" . $post_pic_name;
        $menu_pic = "images/menues/" . $menu_pic_name;

        copy($post_pic, $menu_pic);


        $post_pic_update_query = "UPDATE posts SET post_pic = '$post_pic_name' WHERE post_id = '$this_post_id'";

        mysqli_query($connection, $post_pic_update_query);

        $menu_pic_update_query = "UPDATE menues SET menu_pic = '$menu_pic_name' WHERE menu_id = '$this_menu_id'";

        mysqli_query($connection, $menu_pic_update_query);
      }

    } else {

      $new_restaurant_insert_query = "INSERT INTO restaurants VALUES ('', '$restaurant_name', '$city', 'unknown.jpg')";

      mysqli_query($connection, $new_restaurant_insert_query);

      $select_new_restaurant_id_query = "SELECT * FROM restaurants WHERE restaurant_name = '$restaurant_name' AND city = '$city'";

      $selection_result = mysqli_query($connection, $select_new_restaurant_id_query);

      $restaurant_info = mysqli_fetch_assoc($selection_result);

      $this_restaurant_id = $restaurant_info['restaurant_id'];

      $menu_insert_query = "INSERT INTO menues VALUES ('', '$menu_name', '$rating', '$this_restaurant_id', '', '')";

      mysqli_query($connection, $menu_insert_query);


      $menu_id_select_query = "SELECT * FROM menues WHERE menu_name = '$menu_name' AND restaurant_id = '$this_restaurant_id'";

      $this_menu = mysqli_query($connection, $menu_id_select_query);

      $menu_info = mysqli_fetch_assoc($this_menu);

      $this_menu_id = $menu_info['menu_id'];


      $post_insert_query = "INSERT INTO posts VALUES ('', '$user_id', '$this_restaurant_id', '$this_menu_id', '$date', '$rating', '$opinion', '', '', '')";

      mysqli_query($connection, $post_insert_query);

      $post_id_select_query = "SELECT * FROM posts WHERE (post_giver_id = '$user_id' AND restaurant_id = '$this_restaurant_id' AND menu_id = '$this_menu_id' AND date = '$date')";

      $selected_post = mysqli_query($connection, $post_id_select_query);

      $this_post = mysqli_fetch_assoc($selected_post);

      $this_post_id = $this_post['post_id'];


      // --------------- Uploading Image File to destination folder ------------

      $image_name = $_FILES['menu_pic']['name'];

      // ------------ Getting file extention -------------
      $extention = substr(strrchr(basename($image_name),'.'),1);
      // ------------ Getting file extention -------------

      $post_pic_name = $this_post_id . "." . $extention ;
      $menu_pic_name = $this_menu_id . "." . $extention ;
      $post_target = "images/posts/" . $post_pic_name; // Renaming the image with post_id

      move_uploaded_file($_FILES['menu_pic']['tmp_name'], $post_target);

      // ====== Copy post pic to menu pic ==========
      $post_pic = "images/posts/" . $post_pic_name;
      $menu_pic = "images/menues/" . $menu_pic_name;

      copy($post_pic, $menu_pic);


      $post_pic_update_query = "UPDATE posts SET post_pic = '$post_pic_name' WHERE post_id = '$this_post_id'";

      mysqli_query($connection, $post_pic_update_query);

      $menu_pic_update_query = "UPDATE menues SET menu_pic = '$menu_pic_name' WHERE menu_id = '$this_menu_id'";

      mysqli_query($connection, $menu_pic_update_query);


    }

  }


  //=============== Review Posting ======================



  // ================= Changing Password ====================

  if (isset($_POST['change_password'])) {

    $new_password = $_POST['newPassword'];
    $new_password = md5($new_password);
    $new_password = sha1($new_password);

    $password_update_query = "UPDATE users SET password = '$new_password' WHERE user_id = '$user_id'";

    mysqli_query($connection, $password_update_query);
  }



  // ================= Changing info ====================

  if (isset($_POST['change_info'])) {

    $new_first_name = $_POST['f_name'];
    $new_last_name = $_POST['l_name'];
    $new_city = $_POST['city'];
    $new_birth_date = $_POST['birth_date'];

    $info_update_query = "UPDATE users SET first_name = '$new_first_name', last_name = '$new_last_name', city = '$new_city', birth_date = '$new_birth_date' WHERE user_id = '$user_id'";

    mysqli_query($connection, $info_update_query);

    header("location:index.php");
  }





?>














<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Foodstack - A world of food lovers </title>
  <link rel="shortcut icon" href="images/favicon.ico" type=image/x-icon>
  <link rel="stylesheet" href="css/material.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/web-fonts-with-css/css/fontawesome-all.min.css">

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <style type="text/css">
    
    #background-div {
      width: 100%;
      height: 90vh;
      background-image: url('images/login_screen.jpg');
      background-position: center center;
      background-size: cover;
      background-repeat: no-repeat; 
      display: flex;
    }

    #reg-form-container {
      width: 70%;
      height: 13vh;
      background-color: #fff;
      margin: auto;
      border-radius: 5px;
    }

    .small-holder {
      width: 17%;  
      height: inherit;
      background-color: #579; 
      display: inline-block;
      text-align: center;  
      vertical-align: top;   
    }

    .large-holder {
      height: inherit;
      width: 33%;
      background-color: #1ff;
      display: inline-block;
    }

    .light-font {
      font-size: 1.5vw;
      color: #252525;
      display: block;
      padding-top: 3vh;
    }

    .bold-font {
      font-weight: 600;
      font-size: 2vw;
      color: #252525;
      display: block;
      padding-top: 2vh;
    }

  </style>

</head>

<body id="index-body">

    <div id="background-div">

        <div id="reg-form-container">

          <div class="small-holder">
            <span class="light-font">Select Your</span> 
            <span class="bold-font">LOCATION</span>
          </div><!-- 
           --><div class="large-holder"></div><!-- 
           --><div class="large-holder"></div><!-- 
           --><div class="small-holder"></div>
          
        </div>
      
    </div>

  
  
<!-- jQuery is required by Materialize to function -->
<script type="text/javascript" src="js/bin/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="js/bin/materialize.min.js"></script>
<script src="js/material.min.js"></script>
<script type="text/javascript" src="js/notification-box-byShowrin.js"></script>
<script type="text/javascript" src="js/friend-request-box-byShowrin.js"></script>
<script type="text/javascript" src="js/sticky-kit.min.js"></script>

<script type="text/javascript">
  
  $(".sidebar").stick_in_parent({
      offset_top: 70
  });

  $(document).ready(function(){
    $('.tooltipped').tooltip();
  });

   $(document).ready(function(){
    $('.modal').modal();
  });

</script>

<script type="text/javascript">
  
  
  $('#opinion').val('');
  M.textareaAutoResize($('#opinion'));

  $(document).ready(function(){
      $('select').formSelect();
    });
        


</script>


<!-- =============== Ajax function for sending friend request ================== -->
<script>
    
  function sendFriendRequest(person_id) {
    
    if (window.XMLHttpRequest) {
      xmlhttp=new XMLHttpRequest();
    } else {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById("add-btn-"+person_id).disabled = true;
          document.getElementById("add-btn-"+person_id).innerHTML=this.responseText;    
      }
    }

    xmlhttp.open("GET","friend_request_function.php?q="+person_id,true);

    xmlhttp.send();
  }

</script>


<!-- =============== Ajax function for accepting friend request ================== -->
<script>
    
  function acceptFriendRequest(person_id) {
    
    if (window.XMLHttpRequest) {
      xmlhttp=new XMLHttpRequest();
    } else {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById("friend-request-"+person_id).style.display = 'none';
          document.getElementById("friend-request-"+person_id).innerHTML=this.responseText;   
      }
    }

    xmlhttp.open("GET","friend_request_accept_function.php?q="+person_id,true);

    xmlhttp.send();
  }

</script>


<!-- =============== Ajax function for deleting friend request ================== -->
<script>
    
  function deleteFriendRequest(person_id) {
    
    if (window.XMLHttpRequest) {
      xmlhttp=new XMLHttpRequest();
    } else {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById("friend-request-"+person_id).style.display = 'none';
          document.getElementById("friend-request-"+person_id).innerHTML=this.responseText;   
      }
    }

    xmlhttp.open("GET","friend_request_delete_function.php?q="+person_id,true);

    xmlhttp.send();
  }

</script>


<!-- =============== Ajax function for deleting all friend request by one click ================== -->
<script>
    
  function deleteAllFriendRequest() {
    
    if (window.XMLHttpRequest) {
      xmlhttp=new XMLHttpRequest();
    } else {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {

        var requests = document.getElementsByClassName("friend-request");

        for(i=0; i<requests.length; i++) {
            requests[i].style.display = 'none';
        }
      }
    }

    xmlhttp.open("GET","all_friend_request_delete_function.php?",true);

    xmlhttp.send();
  }

</script>


<!-- =============== Ajax function for deleting all friend request by one click ================== -->
<script>
    
  function deleteAllNotifications() {
    
    if (window.XMLHttpRequest) {
      xmlhttp=new XMLHttpRequest();
    } else {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {

        var notifications = document.getElementsByClassName("notification");

        for(i=0; i<notifications.length; i++) {
            notifications[i].style.display = 'none';
        }
      }
    }

    xmlhttp.open("GET","all_notification_delete_function.php?",true);

    xmlhttp.send();
  }

</script>


<!-- ============== Code for autocomplete suggestion in search bar in top nav starts =================== -->
<?php 

  $people_search_suggestion_query = "SELECT * FROM users WHERE user_id!='$user_id'";

  $people_suggestion_result = mysqli_query($connection, $people_search_suggestion_query);

  $restaurant_search_suggestion_query = "SELECT * FROM restaurants WHERE 1";

  $restaurant_suggestion_result = mysqli_query($connection, $restaurant_search_suggestion_query);

  $menu_search_suggestion_query = "SELECT * FROM menues WHERE 1";

  $menu_suggestion_result = mysqli_query($connection, $menu_search_suggestion_query);

?>

<script type="text/javascript">

  $(document).ready(function(){
    $('input.autocomplete').autocomplete({

      limit: 8,
      data: {
        // "Apple": null,
        // "Microsoft": null,
        // "Google": 'https://placehold.it/250x250',
        // "Nafisa": 'images/dp/17.jpg'

        <?php

          while ($menu = mysqli_fetch_assoc($menu_suggestion_result)) {

            ?>

              "<?php echo $menu['menu_name']; ?>" : '<?php echo "images/menues/" . $menu['menu_pic']; ?>',

            <?php
          }

        ?>

        <?php

          while ($people = mysqli_fetch_assoc($people_suggestion_result)) {

            ?>

              "<?php echo $people['first_name']; ?>" : '<?php echo "images/dp/" . $people['pro_pic']; ?>',

            <?php
          }

        ?>

        <?php

          while ($restaurant = mysqli_fetch_assoc($restaurant_suggestion_result)) {

            ?>

              "<?php echo $restaurant['restaurant_name']; ?>" : '<?php echo "images/restaurants/" . $restaurant['restaurant_pic']; ?>',

            <?php
          }

        ?>
        
      },
    });
});

</script>
<!-- ============== Code for autocomplete suggestion in search bar in top nav ends =================== -->



<!-- ============== Code for Love react giving starts =================== -->
<script type="text/javascript">
  

  function loveFunction(post_id) {
    
    // $("#love"+post_id).attr('src', 'images/post-icons/loved.svg');

    if (window.XMLHttpRequest) {
      xmlhttp=new XMLHttpRequest();
    } else {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {

        if (this.responseText == "0") {

          document.getElementById("love"+post_id).src='images/post-icons/love.svg';
          document.getElementById("modal-love"+post_id).src='images/post-icons/love.svg';

          loveAmount(post_id);

        } else {

          document.getElementById("love"+post_id).src='images/post-icons/loved.svg';
          document.getElementById("modal-love"+post_id).src='images/post-icons/loved.svg';

          loveAmount(post_id);

        }
      }
    }

    xmlhttp.open("GET","love_counting_function.php?q="+post_id,true);

    xmlhttp.send();
  }


  function loveAmount(post_id) {

    if (window.XMLHttpRequest) {
      xmlhttp=new XMLHttpRequest();
    } else {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {

        document.getElementById("love-count"+post_id).innerHTML = this.responseText;
        document.getElementById("modal-love-count"+post_id).innerHTML = this.responseText;
      }
    }

    xmlhttp.open("GET","love_amount_fetch_function.php?q="+post_id,true);

    xmlhttp.send();

  }

</script>
<!-- ============== Code for Love react giving ends =================== -->


<!-- ============== Code for Reort giving starts =================== -->
<script type="text/javascript">
  

  function reportFunction(post_id) {
    
    // $("#love"+post_id).attr('src', 'images/post-icons/loved.svg');

    if (window.XMLHttpRequest) {
      xmlhttp=new XMLHttpRequest();
    } else {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {

        if (this.responseText == "0") {

          document.getElementById("report"+post_id).src='images/post-icons/report.svg';

          document.getElementById("modal-report"+post_id).src='images/post-icons/report.svg';

        } else {

          document.getElementById("report"+post_id).src='images/post-icons/reported.svg';
          document.getElementById("modal-report"+post_id).src='images/post-icons/reported.svg';


        }
      }
    }

    xmlhttp.open("GET","reporting_function.php?q="+post_id,true);

    xmlhttp.send();
  }

</script>
<!-- ============== Code for Report giving ends =================== -->


<!-- ============== Code for Saving starts =================== -->
<script type="text/javascript">
  

  function saveFunction(post_id) {
    
    // $("#love"+post_id).attr('src', 'images/post-icons/loved.svg');

    if (window.XMLHttpRequest) {
      xmlhttp=new XMLHttpRequest();
    } else {
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {

        if (this.responseText == "0") {

          document.getElementById("save"+post_id).src='images/post-icons/bookmark.svg';
          document.getElementById("modal-save"+post_id).src='images/post-icons/bookmark.svg';

        } else {

          document.getElementById("save"+post_id).src='images/post-icons/saved.svg';
          document.getElementById("modal-save"+post_id).src='images/post-icons/saved.svg';

        }
      }
    }

    xmlhttp.open("GET","saving_function.php?q="+post_id,true);

    xmlhttp.send();
  }

</script>
<!-- ============== Code for Saving ends =================== -->


<!-- ========== Change Password Regex Validation ======== -->
  <script type="text/javascript">
    
    $(function() {

      var regex = {
        currentPassword: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/,
        newPassword: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/,
      };

      var currentPasswordError = 0;
      var newPasswordError = 0;
      var passwordMatched = 1;


      $.each($('#change-password input:not([type="submit"])'), function() {

        $(this).on('keyup', function(){
          if(!regex[$(this).attr('name')].test($(this).val())){
            
            if ($(this).val() != "") {

              if ($(this).attr('name') == "currentPassword") {
                $('#current-password-error').removeClass('error-hide');
                $('#current-password-error').addClass('error-show');
                currentPasswordError = 1;

                $('#password-matching').addClass('error-hide');
                $('#password-matching').removeClass('error-show');
                passwordMatched = 1;

              } else if ($(this).attr('name') == "newPassword") {
                $('#new-password-error').removeClass('error-hide');
                $('#new-password-error').addClass('error-show');
                newPasswordError = 1;
              }

            
            } else {
              if ($(this).attr('name') == "currentPassword") {
                $('#current-password-error').addClass('error-hide');
                $('#current-password-error').removeClass('error-show');
                currentPasswordError = 0;
              } else if ($(this).attr('name') == "newPassword") {
                $('#new-password-error').addClass('error-hide');
                $('#new-password-error').removeClass('error-show');
                newPasswordError = 0;
              }

            }


// ------------------- Disabling Submit Button to avoid wrong submission ------------------

            if (currentPasswordError == 0 && newPasswordError == 0 && passwordMatched == 1) {
              $('#change-password-btn').removeAttr('disabled');
            } else {
              $('#change-password-btn').attr('disabled', 'disabled');
            }
// ------------------- Disabling Submit Button to avoid wrong submission ------------------



          } else {
            if ($(this).attr('name') == "currentPassword") {
              $('#current-password-error').addClass('error-hide');
              $('#current-password-error').removeClass('error-show');
              currentPasswordError = 0;



// =================== Email id availability checking ======================

              if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
              } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
              }

              xmlhttp.onreadystatechange=function() {
                if (this.readyState==4 && this.status==200) {
                  
                  if (this.responseText == "") {

                    $('#password-matching').addClass('error-hide');
                    $('#password-matching').removeClass('error-show');
                    passwordMatched = 1;

                    } else {

                      $('#password-matching').removeClass('error-hide');
                    $('#password-matching').addClass('error-show');
                    passwordMatched = 0;

                      document.getElementById("password-matching-text").innerHTML=this.responseText;
                    } 
                }


// ------------------- Disabling Submit Button to avoid wrong submission ------------------
              if (currentPasswordError == 0 && newPasswordError == 0 && passwordMatched == 1) {
                $('#change-password-btn').removeAttr('disabled');
              } else {
                $('#change-password-btn').attr('disabled', 'disabled');
              }
// ------------------- Disabling Submit Button to avoid wrong submission ------------------               

              }

              

              xmlhttp.open("GET","current_password_checker.php?q="+$(this).val(),true);

              xmlhttp.send();

              
            

            } else if ($(this).attr('name') == "newPassword") {
              $('#new-password-error').addClass('error-hide');
              $('#new-password-error').removeClass('error-show');
              newPasswordError = 0;


// ------------------- Disabling Submit Button to avoid wrong submission ------------------
              if (currentPasswordError == 0 && newPasswordError == 0 && passwordMatched == 1) {
                $('#change-password-btn').removeAttr('disabled');
              } else {
                $('#change-password-btn').attr('disabled', 'disabled');
              }
// ------------------- Disabling Submit Button to avoid wrong submission ------------------             

            }

          }

                  
        });
        
      });
    
    });

  </script>


  <!-- jQuery for activating materialize.css plugins -->
  <script type="text/javascript">
    $(document).ready(function(){
        $('select').formSelect();
      });


    $(document).ready(function(){
        $('.datepicker').datepicker({
          format: 'yyyy-mm-dd',
          yearRange: 100,
          showMonthAfterYear: true,
          showDaysInNextAndPreviousMonths: true
        });
      });
  </script> 


</body>
</html>