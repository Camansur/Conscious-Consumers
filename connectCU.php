<?php
if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']))
{

    //Database fields and information to grab from html
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $feedback = $_POST['feedback'];

    //Boolean to determine whether to open the success page or error page.
    $success = False;

    //Database connection information variables
    $host = "conscious-db.clx2jdgotjoe.us-east-1.rds.amazonaws.com";
    $dbUsername = "root";
    $dbPassword = "mysqlift402";
    $dbName = "consciousdb";

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error)
    {
        die('Could not connect to the database.');
    }
    else
    {
        $Select = "SELECT email FROM contact WHERE email = ? LIMIT 1";
        $Insert = "INSERT INTO contact(fname, lname, email, feedback) values(?, ?, ?, ?)";
        $stmt = $conn->prepare($Select);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($resultEmail);
        $stmt->store_result();
        $stmt->fetch();
        $rnum = $stmt->num_rows;
        if ($rnum == 0)
        {
            $stmt->close();
            $stmt = $conn->prepare($Insert);
            $stmt->bind_param("ssss", $fname, $lname, $email, $feedback);
            if ($stmt->execute())
            {
                echo "Success!";
                $success = True;
            }
            else
            {
                echo $stmt->error;
            }
        }
        else
        {
            echo "A feedback was left recently using this email. Please wait 48 hours before sending another one.";
        }
        $stmt->close();
        $conn->close();

        if($success == TRUE){
            header("location: feedback.html");
        }else{
            header("location: error.html");
        }
        
        die();
    }
}
else
{
    echo "All field are required.";
    die();
}
?>