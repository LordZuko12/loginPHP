<html>
<head>
	<title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
  	<script src="js/bootstrap.min.js"></script>
</head>

<body class="container">
<br>
<a href="index.php"><span class="btn btn-primary">Home</span></a> <br />
<?php
include("config.php");
//connect to db here

/*filter_var($email, FILTER_VALIDATE_EMAIL)
		{
			
		}*/

	
	$idErr=$nameErr=$passErr=$rpassErr=$phoneErr=$emailErr=" ";
	$bId=$bFname=$bEmail=$bPhone=$bPass=false;
	
function clean($d)
	{
		$d=trim($d);
		$d=stripcslashes($d);
		$d=htmlspecialchars($d);
		return $d;
	}
	
function isValidUserID($aiubid){
    if(preg_match('/^[0-1]{1}[0-9]{1}(-)[0-9]{5}(-)[1-3]{1}$/', $aiubid)){
        return true;
    }
    else {
        return false;
    }
} 

function isValidName($fullname){
        if(preg_match('/^[A-Za-z]+(?:[ _-][A-Za-z]+)*$/', $fullname)){
            return true;
        }
        else{
            return false;
        }
    }

function isValidMobile($phone){
        str_replace(" ", "", $phone);
        str_replace("-", "", $phone);
        if(preg_match('/^(0088|\+88)?(01)[156789]{1}[0-9]{8}$/', $phone)){
            return true;
        }
        else {
            return false;
        }
    }

function isValidEmail($email){
        /*if(preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/',$email)){
            return true;
        }*/
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return true;
        }
        else{
            return false;
        }
		
    }
if($_SERVER['REQUEST_METHOD']=="POST")	
{

	$aiubid = $_POST['aiubid'];
	$fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass = $_POST['password'];
	$rpass = $_POST['rePassword'];
	

	if($pass == ""|| $aiubid == "" || $fullname == ""|| $email == "" || $phone == "" || $rpass == "") {
		
		$idErr="Invalid User ID";
		$nameErr = "Invalid Name";
		$phoneErr = "Invalid Mobile Number. Must contain 11 digits";
		$emailErr = "Invalid Email";
		$passErr = "Invalid Password";
		
	}else{
		
		$aiubid = clean($aiubid);
		$fullname = clean($fullname);
		$email = clean($email);
		$phone = clean($phone);
		$pass = clean($pass);
		$rpass = clean($rpass);
		
		if(isValidUserID($aiubid))
		{
			$bId = true;
		}else
		{
			$idErr="Invalid User ID";
		}
		
		if(isValidName($fullname))
		{
			$bFname = true;
		}else
		{
			$nameErr = "Only letters allowed";
		}
		
		if(isValidMobile($phone))
		{
			$bPhone = true;
		}else
		{
			$phoneErr = "Invalid Mobile Number. Must contain 11 digits";
		}
		
		if(isValidEmail($email))
		{
			$bEmail = true;
		}else
		{
			$emailErr = "Invalid Email";
		}
		
		if($pass==$rpass)
		{
			$bPass = true;
		}else
		{
			$passErr = "Password not matched";
		}
		
		if($bId == true and $bFname == true and $bEmail == true and $bPhone == true and $bPass == true)
		{
			$sql="SELECT * FROM user WHERE aiubid='$aiubid'";
			$result = mysqli_query($conn, $sql);
			$res=mysqli_fetch_array($result);
			$count=mysqli_num_rows($result);
			
			if($count==0)
			{
				mysqli_query($conn,"INSERT INTO user(aiubid,fullname,email,phone,password) VALUES('$aiubid','$fullname','$email','$phone', md5('$pass'))")
				or die("Could not execute the insert query.");
			
				echo "<hr><div class='alert alert-success'>Registration successfully done. Click Home for login Now</div>";
				echo "<br/><hr>";
				
			}else
			{
				echo "<hr><div class='alert alert-success'>User Exists. Click Home for login Now</div>";
				echo "<br/><hr>";
			}
			
		}
	}

}
?>

	<center><h2>New User Registration</h2><hr></center>
	<form name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<table class="table table-striped table-bordered table-condensed">
            <tr>
                <td>AIUB ID</td>
                <td><input type="text" name="aiubid" class="form-control" placeholder=""><span ><?php echo $idErr ?></span></td>
            </tr>
            <tr>
                <td>Full Name</td>
                <td><input type="text" name="fullname" class="form-control" placeholder=""><span ><?php echo $nameErr ?></span></td>
            </tr>
            <tr>
				<td>Email</td>
				<td><input type="text" name="email" class="form-control" placeholder=""><span ><?php echo $emailErr ?></span></td>
			</tr>
            <tr>
                <td>Phone Number</td>
                <td><input type="text" name="phone" class="form-control" placeholder=""><span ><?php echo $phoneErr ?></span></td>
            </tr>
			<tr> 
				<td>Password</td>
				<td><input type="password" name="password" class="form-control"><span ><?php echo $passErr ?></span></td>
			</tr>
			<tr> 
				<td>Re-Type Password</td>
				<td><input type="password" name="rePassword" class="form-control"></td>
			</tr>
			<tr>
            <td colspan="2"><br></td>
            </tr>
            <tr> 
				
				<td colspan="2"><input type="submit" class="btn btn-success btn-block btn-lg" name="submit" value="Register"></td>
			</tr>
		</table>
	</form>
<?php

//close the db connection here
?>
</body>
</html>
