<?php 
    
    session_start();

    // require ('connect.php');
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

    echo "Connected successfully";

    if(isset($_POST["submit"])){

    
        function val($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        
        
            
        $_SESSION["firstname"] = $_POST["firstname"];
        $fname = val($_SESSION["firstname"]);
        
        $_SESSION["lastname"] = $_POST["lastname"];
        $lname = val($_SESSION["lastname"]);
        
        $_SESSION["email"] = $_POST["email"];
        $email = val($_SESSION["email"]);
        
        $_SESSION["mobile_number"] = $_POST["mobile_number"];
        $phone = val($_SESSION["mobile_number"]);

        // $sql = "INSERT INTO visitor (firstname, lastname, email, phone) 
        //         VALUES ('$fname', '$lname', '$email', '$phone')";

        $stmt = $conn->prepare("INSERT INTO visitor (firstname, lastname, email, phone) VALUES (?, ?, ?, ?)"); //create prepare statement
        $stmt->bind_param("ssss", $fname, $lname, $email, $phone);  //bind prepare statement
        $stmt->execute();

        $sql = "SELECT email, phone FROM host";
        // mysql_select_db('test_db');
        $result = $conn->query($sql);   

        if(! $result ) {
            die('Could not get data: ' . mysql_error());
        }
        while($row = $result->fetch_assoc()) {

            $hostemail = $row['email']; //get host mail id
            $hostphone = $row['phone']; // get host phone 
        }
        

        $sql1 = "SELECT checkintime FROM visitor WHERE email='$email'";
        $result = $conn->query($sql1);
        while($row = $result->fetch_assoc()){
            $checkintime = $row['checkintime'];
        }

        $subject = "Visitor CheckIn";
        $msg_to_host = "Name: $fname $lname Email: $email Phone: $phone Check In Time: $checkintime";
        mail($hostemail,$subject,$msg_to_host); // mail to the host about the visitor
        // $msg = " A new Visitor";
        // sms($hostphone, $msg);
        //sms can also be sent using api
        
    }
    $conn->close();
    session_destroy();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags -->
    <title>Visitor Check In Page</title>
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
            <h1>Visitor Check In Page</h1>
        </div>
        <div class="container">
            <div class="heading">
                <h2>Please Enter Your Details</h2>
                <p>Fill the application form below and submit.</p>
            </div>
            <div class="agile-form">
                <form action="visitor.php" method="post">
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
                        <li>
                            <label class="form-label"> Phone Number <span class="form-required"> * </span></label>
                            <div class="form-input">
                                <input type="text" name="mobile_number" placeholder="Phone Number" required>
                            </div>
                        </li>
                        <!-- <li>
                            <label class="form-label"> Gender <span class="form-required"> * </span></label>
                            <div class="form-input">
                                <select class="form-dropdown" name="gender" required>
                                    <option value="">Gender</option>
                                    <option value="Male"> Male </option>
                                    <option value="Female"> Female </option>
                                    <option value="Others"> Others </option>
                                </select>
                            </div>
                        </li> -->
                        <div class="submit_btn">
                            <input type="submit" value="Check In" name="submit">
                        </div>
                </form>
            </div>
        </div>
</body>

</html>