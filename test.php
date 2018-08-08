<?php

                  $connection = mysqli_connect('localhost', 'root', '', 'foodstack');

                  $restaurant_select_query = "SELECT * FROM restaurants WHERE city='$city'";

                  $selected_restaurant = mysqli_query($connection, $restaurant_select_query);

                  $count = 1;

                  while ($restaurant = mysqli_fetch_assoc($selected_restaurant)) {

                    $restaurant_id = $restaurant['restaurant_id'];

                    $menu_select_query = "SELECT * FROM menues WHERE restaurant_id='$restaurant_id'";

                    $selected_menu = mysqli_query($connection, $menu_select_query);

                    while ($menu = mysqli_fetch_assoc($selected_menu) {

                      ?>

                      <li class="collection-item avatar">
                          
                          <!-- === Menu-pic showing -->
                          <img src="images/menues/<?php echo $menu['menu_pic']; ?>" alt="" class="circle">
                        
                        <!-- === Menu and restaurant name showing with profilwe link ==== -->
                          <a href="profile.php?menu_id= <?php echo $menu['menu_id']; ?>">
                            
                            <p style="color: #ff7c1a"> <?php echo $menu['menu_name']; ?> </p>

                            <span class="title" style="color: #ff7c1a"> 
                              <?php echo $restaurant['restaurant_name']; ?> 
                          </span>

                          </a>

                        <!-- === Add Friend Button === -->
                          <span class="secondary-content">
                            <button id="add-btn-<?php echo $person_id; ?>" class="btn waves-effect waves-light add-btn" type="submit" onclick="sendFriendRequest(<?php echo $person_id; ?>)" >Add
                          </button>
                          </span>
                      </li>

                      <?php
                    }

                    $count++;

                    //---------- For controling the number of people to show -------------
                    if ($count>5) {
                      break;
                    }
                  }

                ?>
                
                </ul>
                        

                </div>
