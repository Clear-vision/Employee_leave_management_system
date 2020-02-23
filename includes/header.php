        <div class="loader-bg"></div>
        <div class="loader">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-spinner-teal lighten-1">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                    <div class="circle"></div>
                    </div><div class="circle-clipper right">
                    <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mn-content fixed-sidebar">
            <header class="mn-header navbar-fixed">
                <nav class="cyan darken-1">
                    <div class="nav-wrapper row">
                        <section class="material-design-hamburger navigation-toggle">
                            <a href="#" data-activates="slide-out" class="button-collapse show-on-large material-design-hamburger__icon">
                                <span class="material-design-hamburger__layer"></span>
                            </a>
                        </section>
                        <div class="header-title col s3">      
                            <span class="chapter-title">ELMS | Employee</span>
                        </div>

                        <ul class="right col s9 m3 nav-right-menu">

                            <li class="hide-on-small-and-down"><a href="javascript:void(0)" data-activates="dropdown1" class="dropdown-button dropdown-right show-on-large"><i class="material-icons"></i>
                                    <?php
                                    $isread = 1;
                                    $emp_read_status = 'unseen';

                                    $sql = "SELECT tblleaves.id AS lid
                                          FROM tblleaves JOIN tblemployees ON tblleaves.empid=tblemployees.id
                                           WHERE tblleaves.IsRead=:isread  
                                           AND tblleaves.emp_read_status = :emp_read_status
                                           AND tblemployees.id = '".$_SESSION["eid"]."'";
                                    $query = $dbh ->prepare($sql);
                                    $query->bindParam(':isread',$isread,PDO::PARAM_STR);
                                    $query->bindParam(':emp_read_status',$emp_read_status,PDO::PARAM_STR);

                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $readcount = $query->rowCount();?>


                                    <span class="badge"><?php echo htmlentities($readcount);?></span></a></li>
                            <li class="hide-on-med-and-up"><a href="javascript:void(0)" class="search-toggle"><i class="material-icons">search</i></a></li>
                        </ul>

                        <ul id="dropdown1" class="dropdown-content notifications-dropdown">
                            <li class="notificatoins-dropdown-container">
                                <ul>
                                    <li class="notification-drop-title">Notifications</li>
                                    <?php

                                    $isread = 1;
                                    $emp_read_status = 'unseen';
                                    $sql = "SELECT tblleaves.id AS lid,tblemployees.FirstName,
                                          tblemployees.LastName,tblemployees.EmpId,tblleaves.PostingDate,
                                          tblleaves.AdminRemarkDate 
                                          FROM tblleaves JOIN tblemployees ON tblleaves.empid=tblemployees.id
                                           WHERE tblleaves.IsRead=:isread 
                                           AND tblleaves.emp_read_status = :emp_read_status
                                           AND tblemployees.id = '".$_SESSION["eid"]."' ORDER BY lid DESC";

                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':isread',$isread,PDO::PARAM_STR);
                                    $query->bindParam(':emp_read_status',$emp_read_status,PDO::PARAM_STR);

                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    if($query->rowCount() > 0)
                                    {
                                        foreach($results as $result)
                                        {               ?>


                                            <li>
                                                <a href="leavehistory.php?leaveid=<?php echo htmlentities($result->lid);?>">
                                                    <div class="notification">
                                                        <div class="notification-icon circle cyan"><i class="material-icons">done</i></div>
                                                        <div class="notification-text"><p><b><?php echo htmlentities($result->FirstName." ".$result->LastName);?><br />(<?php echo htmlentities($result->EmpId);?>) </b> leave Remarked</p><span> at <?php echo htmlentities(date('F d, Y - h:i:s A',strtotime($result->AdminRemarkDate)));?></b</span></div>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php }} ?>


                                </ul>
                     
                
                    </div>
                </nav>
            </header>