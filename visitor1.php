<?php 
   
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "entry-management-system";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    if(isset($_POST["submit"])){

        function val($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        
        // $fname = val($_POST["firstname"]);
        // $lname = val($_POST["lastname"]);
        $_SESSION["email"] = $_POST["email"];
        $email = val($_SESSION["email"]);

        $sql = "UPDATE visitor 
                SET checkouttime = NOW()
                where email = '$email' ";

        $conn->query($sql);
            
        $sql = "SELECT firstname, lastname, email, phone FROM host";
        // mysql_select_db('test_db');
        $result = $conn->query($sql);
        if(! $result ) {
            die('Could not get data: ' . mysql_error());
        }
        while($row = $result->fetch_assoc()) {

            $hostfname = $row['firstname'];
            $hostlname = $row['lastname'];
            $hostemail = $row['email'];
            $hostphone = $row['phone'];
            
        }
    
        $sql1 = "SELECT firstname, lastname, checkintime, checkouttime FROM visitor WHERE email='$email'";
        $result = $conn->query($sql1);
        while($row = $result->fetch_assoc()){
            $fname = $row['firstname'];
            $lname = $row['lastname'];
            $checkintime = $row['checkintime'];
            $checkouttime = $row['checkouttime'];
        }
        
        $subject_to_host = "Visitor CheckOut";
        $msg_to_host = "Name: $fname $lname 
                        Email: $email 
                        Phone: $phone 
                        Check In Time: $checkintime 
                        Check Out Time: $checkouttime";
        mail($hostemail,$subject_to_host,$msg_to_host); // mail sent to the host informing him about the visitor's checkin and checkout time
        
        $subject_to_visitor = "Thank You For Visiting Our Office";
        $msg_to_visitor =  "Name: $fname $lname 
                            Phone: $phone 
                            Check In Time: $checkintime 
                            Check Out Time: $checkouttime 
                            Host Name: $hostfname ";
        mail($email,$subject_to_visitor,$msg_to_visitor); // mail sent to the visitor about his successfull checkout and the host name
    }
    
    $conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags -->
    <title>Visitor Check Out Page</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- stylesheets -->
    <link rel="stylesheet" href="host.css" type="text/css" media="all">

    <!-- google fonts  -->
    <link href="//fonts.googleapis.com/css?family=Alegreya+Sans:100,100i,300,300i,400,400i,500,500i,700,700i,800,800i,900,900i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#touc").click(function() {
                $("#tyu").hide();
            });
            $("#tou").click(function() {
                $("#tyu").show();
            });
        });
    </script>
</head>

<body background="pro-cr-form-bg.jpg">
    <div class="w3ls-banner">
        <div class="heading">
            <h1>Visitor Check Out Page</h1>
        </div>
        <div class="container">
            <div class="heading">
                <h2>Please Enter Your Details</h2>
                <p>Fill the application form below and submit.</p>
            </div>
            <div class="agile-form">
                <form action="visitor1.php" method="post">
                    <ul class="field-list">
                        <li class="name">
                            <label class="form-label"> Name <span class="form-required"> * </span></label>
                            <div class="form-input add">
                                <span class="form-sub-label">
                                    <input type="text" name="firstname" placeholder="First Name" required>
                                </span>
                                <span class="form-sub-label">
                                    <input type="text" name="lastname" placeholder="Last Name" required>
                                </span>
                            </div>
                        </li>
                        <li>
                            <label class="form-label"> E-Mail Address <span class="form-required"> * </span></label>
                            <div class="form-input">
                                <input type="email" name="email" placeholder="Mail@example.com" required>
                            </div>
                        </li>
                        <div class="submit_btn">
                            <input type="submit" value="Check Out" name = submit>
                        </div>
                </form>
            </div>
        </div>
</body>

</html>