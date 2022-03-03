<?php
    if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email'])) {
        
        //Database fields and information to grab from html
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];

        //Database connection information variables
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "mysqlift402";
        $dbName = "test";

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM newsletter WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO newsletter(fname, lname, email) values(?, ?, ?)";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("sss",$fname, $lname, $email);
                if ($stmt->execute()) {
                    echo "Success!";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone has already registered with this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
?>