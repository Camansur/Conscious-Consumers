<?php
if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']))
{

    //Database fields and information to grab from html
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];

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
        $Select = "SELECT email FROM newsletter WHERE email = ? LIMIT 1";
        $Insert = "INSERT INTO newsletter(fname, lname, email) values(?, ?, ?)";
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
            $stmt->bind_param("sss", $fname, $lname, $email);
            if ($stmt->execute())
            {
                $success = True;
                echo "Success!";
            }
            else
            {
                echo $stmt->error;
            }
        }
        else
        {
            echo "Someone is already registered with this email.";
        }
        $stmt->close();
        $conn->close();

        if($success == TRUE){
            header("location: joined.html");
        }else {
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