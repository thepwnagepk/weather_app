<?php
function CreateHandle()
{
    //This would house proper credentials, but this was developed locally with XAMPP and so if you use it yourself, put in the credentials that work with your setup.
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "weatherapp";
    $mysqli = new mysqli($host, $user, $pass, $db);

    if (mysqli_connect_errno())
    {
        echo "<p>connection problem</p>";
        return false;
    }
    else
    {
        
        return $mysqli;
    }
} 
?>