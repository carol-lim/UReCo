<?php
    include("auth.php");
    include("../config.php");
    $status=$_GET['status'];
    $hdid = $_GET['hdid'];
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("head.html");?>
    <title>Trace Helpdesk | Maintenance Team | UReCo</title>

    <script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_hd').addClass('active');
           $('#nav_hd_current').addClass('active');
        });

    </script>
</head>
<body id="body-pd">
    <?php include("sidebar.html");?>
    <div class="py-4">

        <div class="d-flex flex-column " id="content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Maintenance Helpdesk</li>
                    <?php if ($status == "open"){?>
                    <li class="breadcrumb-item">Current Helpdesk</li>
                    <?php }else{?>
                    <li class="breadcrumb-item">Closed Helpdesk</li>
                    <?php }?>
                    <li class="breadcrumb-item">Helpdesk Detail</li>
                    <li class="breadcrumb-item active" aria-current="page">Trace Helpdesk</li>
                </ol>
            </nav>
            <div class="d-flex">
                <div class="p-2">
                    <h3 id="heading1">Trace Helpdesk #<?php echo htmlentities($hdid)?></h3>
                </div>
                <div class="p-2">
                    <button type="button" class="btn btn-primary" id="add-btn" onclick="location.href='helpdeskDetail.php?hdid=<?php echo $hdid?>&status=<?php echo $status?>'">Back</button>
                </div>
            </div>
                
            <div class="rounded p-4 mb-3 bg-color">
               <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="content">
                                <ul class="timeline">
                                    <?php  
                                    $query = mysqli_query($conn, "
                                        SELECT * FROM helpdesktracker WHERE hdID = '$hdid' ORDER BY creationDate DESC"); 
                                    if(mysqli_num_rows($query)>0){
                                        while($row = mysqli_fetch_array($query)){  
                                    ?>
                                    <li class="event" data-date="<?php echo htmlentities($row['creationDate'])?>">
                                        <h3><?php echo htmlentities($row['statusName']) ?></h3>
                                        <p><?php echo htmlentities($row['description']) ?></p>
                        <?php
                            $status_id=$row['hdtID'];
                            $sql_get_file=mysqli_query($conn, "
                                SELECT *
                                FROM fileuploaded 
                                WHERE hdtID='$status_id'");
                            while($result_get_file=mysqli_fetch_array($sql_get_file)){
                        ?>
                            <a href="<?php echo htmlentities($result_get_file['filePath']);?>/<?php echo htmlentities($result_get_file['fileName']);?>" target="_blank">
                                <img src="<?php echo htmlentities($result_get_file['filePath']);?>/<?php echo htmlentities($result_get_file['fileName']);?>" alt="<?php echo htmlentities($result_get_file['fileName']);?>" class="img-thumbnail" style="max-width: 5rem" >
                            </a><br>
                        <?php }?>

                                        <small>By: 
                                            <?php 
                                            echo htmlentities($row['createdBy']);
                                            $person_id=$row['createdBy'];
                                            $firstCharacter = $person_id[0];
                                            if ($firstCharacter == 'D' || $firstCharacter == 'B'){
                                                $sql = mysqli_query($conn, "SELECT studName FROM student WHERE matrixNo ='$person_id'"); 
                                                $roww = mysqli_fetch_assoc($sql); 
                                                echo htmlentities(" ".$roww['studName']);
                                            }
                                            else if ($firstCharacter == 'S'){
                                                $sql = mysqli_query($conn, "SELECT staffName FROM staff WHERE staffID ='$person_id'"); 
                                                $roww = mysqli_fetch_assoc($sql); 
                                                echo htmlentities(" ".$roww['staffName']);
                                            }
                                            else if ($firstCharacter == 'M'){
                                                $sql = mysqli_query($conn, "SELECT maintName FROM maintenance WHERE maintID ='$person_id'"); 
                                                $roww = mysqli_fetch_assoc($sql); 
                                                echo htmlentities(" ".$roww['maintName']);
                                            }
                                            else echo htmlentities(" Anonymous");
                                            ?>
                                        </small>
                                    </li>
                                    <?php
                                        }
                                    }else{
                                    ?>
                                    <h2>No action taken...</h2>
                                    <?php 
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
           
        </div>
    </div>

    <!--Container Main end-->
</body>
</html>