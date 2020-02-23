

<aside id="slide-out" class="side-nav white fixed">
                <div class="side-nav-wrapper">
                    <div class="sidebar-profile">
                        <div class="sidebar-profile-image">
                            <?php
                            $eid = $_SESSION['eid'];
                            $sql = "SELECT FirstName,LastName,EmpId,emp_image FROM  tblemployees where id=:eid";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':eid',$eid,PDO::PARAM_STR);
                            $query->execute();
                            $row = $query->fetch(PDO::FETCH_ASSOC);

                            if ($row["emp_image"] == NULL){

                            echo  '<img src="assets/images/user.png" class="circle" alt="">';

                            }else{

                            echo  '<img src="assets/profile_photo/'.$row["emp_image"].'" class="circle" alt="">';
                              }?>
                        </div>
                        <div class="sidebar-profile-info">

                    <?php
                        if($query->rowCount() > 0)
                        {
                                  ?>
                                <p><?php echo htmlentities($row["FirstName"]. ' ' .$row["LastName"]);?></p>

                         <?php } ?>
                        </div>
                    </div>
              
                <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
                  
  <li class="no-padding"><a class="waves-effect waves-grey" href="myprofile.php"><i class="material-icons"></i>My Profile</a></li>
  <li class="no-padding"><a class="waves-effect waves-grey" href="emp-changepassword.php"><i class="material-icons"></i>Change Password</a></li>
                    <li class="no-padding">
                        <a class="collapsible-header waves-effect waves-grey"><i class="material-icons"></i>Leaves<i class="nav-drop-icon material-icons"></i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="apply-leave.php">Apply Leave</a></li>
                                <li><a href="leavehistory.php">Leave History</a></li>
                            </ul>
                        </div>
                    </li>
                
         
               
                  <li class="no-padding">
                                <a class="waves-effect waves-grey" href="logout.php"><i class="material-icons"></i>Sign Out</a>
                            </li>  
                 
                   
                </ul>
                <div class="footer">
                    <p class="copyright"><a href="/">Elms</a> © <?php echo date('Y'); ?></p>
                
                </div>
                </div> 
            </aside>