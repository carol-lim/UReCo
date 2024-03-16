<!DOCTYPE html>
<?php
		include("config.php");
		if(isset($_POST['submit'])){
			$name = $_POST['name'];
			$ic = $_POST['ic'];
			$reason = $_POST['reason'];
			$sql = mysqli_query($conn, "INSERT INTO visitor(name, ic, reason) VALUES('$name', '$ic', '$reason')");
			if(!$sql)
				echo "<script>alert('An error occured. Please try again later.')</script>";
			else
				echo "<script>alert('Data successfully saved.')</script>";
		}
?>
<html lang="en" dir="ltr">
<head>
   <title>Visitor Information | UReCo</title>
   <link rel="stylesheet" type="text/css" href="../css/login.css">
   <!-- favicon -->
   <link rel="shortcut icon" type="image/png" href="../asset/favicon-32x32.png">   
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body style="background-image: url(../asset/satriablurred.jpg);background-size:cover">
   <div class="container">
      <header>UReCo</header>
      <h2>Visitor Information</h2>
      <form name="submit" method="POST" action="visitor.php">
         <div class="input-field">
            <input type="text" name="name" required>
            <label>Name</label>
         </div>
         <div class="input-field">
            <input type="text" name="ic" required>
            <label>NRIC</label>
         </div>
         <div class="input-field">
            <input type="text" name="reason" required></input> 
            <label>Reason of visit</label>
         </div>
         <div class="button">
            <div class="inner"></div>
            <button type="submit" name="submit">Submit</button>
         </div>
      </form>
   </div>

   <script>
     /* var input = document.querySelector('.pswrd');
      var show = document.querySelector('.show');
      show.addEventListener('click', active);
      function active(){
        if(input.type === "password"){
          input.type = "text";
          show.style.color = "#1DA1F2";
          show.textContent = "HIDE";
        }else{
          input.type = "password";
          show.textContent = "SHOW";
          show.style.color = "#111";
        }
      }*/
   </script>
</body>
</html>