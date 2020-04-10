<?php
session_start();

require ("connect.php");
$conn = CreateHandle();
$error = 0;

$locationname;
$lat;
$long;

if (isset($_GET['locationname'])){ //add lat and long check
    $_SESSION['locationname'] = $_GET['locationname'];
    $_SESSION['lat'] = $_GET['lat'];
    $_SESSION['long'] = $_GET['long'];
    $locationname = $_GET['locationname'];
    $lat = $_GET['lat'];
    $long = $_GET['long'];

     //if locationname is set, then its not on the index php

        $sqlquery2 = "SELECT * FROM location WHERE locationname = '$locationname'";        
        $result = $conn ->query($sqlquery2);

        if(mysqli_num_rows($result) == 0){

            if (isset($conn)){
            $sqlquery = "INSERT INTO location (locationname, latitude, longitude) VALUES ('$locationname', '$lat', '$long')";
            $result = $conn ->query($sqlquery);
            }
        }else{
        $error = 2;// already a location with the name
        }
    

}

if (isset($_POST['savebutton'])){

    if(isset($_SESSION['locationname'])){
        if(isset($_SESSION['lat'])){
            if(isset($_SESSION['long'])){
        //making sure the session variables are set if they exist
    $locationname = $conn->real_escape_string($_SESSION['locationname']);
    $lat = $conn->real_escape_string($_SESSION['lat']);
    $long = $conn->real_escape_string($_SESSION['long']);   
                
    }
    }
    }
    
    if(isset($locationname)){ //if locationname is set, then its not on the index php
    
    $sqlquery2 = "SELECT * FROM location WHERE locationname = '$locationname'";        
    $result = $conn ->query($sqlquery2);
    
    if(mysqli_num_rows($result) == 0){

        if (isset($conn)){
        $sqlquery = "INSERT INTO location (locationname, latitude, longitude) VALUES ('$locationname', '$lat', '$long')";
        $result = $conn ->query($sqlquery);
        }
    }else{
    $error = 2;// already a location with the name
    }
    
    
    $sqlquery3 = "SELECT locationID FROM location WHERE location.locationname = '$locationname'";
    $result2 = $conn ->query($sqlquery3);
    $data = $result2->fetch_array(MYSQLI_NUM);
    $locationID = $data[0];
    $userID = $_SESSION['userID'];       
    //echo $locationID; //for debugging
    //echo $userID; //for debugging
    
    $sqlquery4 = "INSERT INTO favourites (locationID, userID) VALUES ('$locationID', '$userID')";
    $result3 = $conn ->query($sqlquery4);
    }
    
    

}




?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--<link href="/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">-->
    <link rel="stylesheet" href="style.css">

    <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">

    <title>PK Weather</title>

</head>

<body>
    <!-- Main Top Navbar-->
    <nav id="mainnavbar" class="navbar navbar-expand-md">
        <a class="navbar-brand linkcolour" href="index.php">PK's Weather</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <img src="menu.svg" alt="menu" id="menu">
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <div id="searchbar" class="container">
                <a id="getmylocation" class="btn btn-outline-dark mt-1" role="button" href="index.php">Find my Location!</a>
                <form class="form-inline" action="index.php?modal=true" method="post">
                    <input class="form-control" type="search" id="search" name="search" placeholder="Search for your town/city here" aria-label="Search" required>
                    <button id="locationsearch" class="btn btn-outline-dark" type="submit">Search</button>
                </form>
            </div>
            <hr class="my-2">
            <!-- Welcome Text in dropdown - changed to logged in text-->
            <?php if (isset($_SESSION['name'])) { ?>
            <div class="alert-warning">
                <p class="nav-link text-center">Logged in as: <?php echo $_SESSION['name']?>
                </p>
            </div>
            <?php } ?>
            <!-- Login/Register/Logout Buttons-->
            <?php if (isset($_SESSION['name'])) { ?>
            <a class="btn btn-danger btn-block " href="logout.php">Logout</a>
            <?php }else{?>
            <div class="btn-group btn-block " role="group" aria-label="Basic example">
                <button class="btn btn-success" onclick="window.location.href='login.php';">Login</button>
                <button class="btn btn-warning" onclick="window.location.href='register.php';">Register</button>
            </div>
            <?php } ?>
            <hr class="my-2">
        </div>
    </nav>
    
    
    <!-- Welcome Text if user just looged in or registered-->
    <?php if (isset($_SESSION['name'])){ ?>
    <div class="alert-light">
        <p class="nav-link text-center">Welcome, <?php echo $_SESSION['name']?>
        </p>
    </div>
    <?php } ?>

    <!-- Favourite Menu Collapse-->
    <?php if (isset($_SESSION['name'])) { ?>
    <button class="btn btn-block btn-success" type="button" data-toggle="collapse" data-target="#favourites" aria-expanded="false" aria-controls="favourites"><?php echo $_SESSION['name']?>'s Favourites <img src="chevron-bottom.svg" alt="chevron-down" id="chevron-down"></button>
    <?php } ?>

    <div class="collapse border" id="favourites">

        <?php
            $userID = $_SESSION['userID'];
            $sqlquery3 = "SELECT * FROM location, favourites WHERE location.locationID = favourites.locationID AND favourites.userID = '$userID'";
            $result2 = $conn ->query($sqlquery3);
            if ($result2 -> num_rows > 0){
                while($row = $result2 -> fetch_assoc()){
                    $url1 = 'index.php?lat='.$row["latitude"].'&long='.$row["longitude"].'&locationname=' .$row["locationname"];
                    echo " <div class=\"card card-body\"><a class=\"linkcolour\" href=\" " .$url1. "\">" . $row["locationname"] . "<a></div><hr class=\"my-1\">";
                } 
            }
    ?>

    </div>

    <!-- Location Details-->
    
    <div class="location-section text-center mt-4 ">
        <!-- <p id="latlong"></p>
        <h1 class="timezone"> Timezone </h1> -->
        <h1 class="locationname"> Location </h1>
        <h4 class="locationsubtitle">
            </h1>
            <canvas class="icon" width="128" height="128"></canvas>
    </div>

    <!-- Temperature Details-->
    
    <div class="temperature-section text-center mb-4">
        <h1 class="temperature"></h1>
        <h2 class="temperature-description"></h2>
    </div>
    
    <?php
                    if($error == 1){
                        echo "<p>Email is wrong or account does not exist</p>";
                    }
                  if($error == 2){
                        echo "<div class=\"alert alert-primary mt-4\"><p class=\"text-center\">This location is already saved in the favourites tab</p></div>";
                    }
                  
    ?>
    <!-- Save Button-->
    <?php 
    if(!empty($_SERVER['QUERY_STRING'])){ 
        if($error != 2){
    ?>

    <form class="form-inline" name="form-save" id="form-save" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <button class="btn btn-dark btn-block"  id="savebutton" name="savebutton" type="submit">Save Current Location to Favourites</button>
    </form>
    <?php 
    }}
    ?>

   


    <!-- Search Responses
    <div class="search-responses">
        <h1 class="sr-title"> Search Results </h1>
        <ul id="search-responses" class="list-group">
        </ul>

    </div>-->



    <!-- Modal -->
    <div class="modal fade" id="searchResultsModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-center">Search Results</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <ol id="search-responses" class="list-group">
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-block btn-outline-primary" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="app.js"></script>
    <script src="skycons.js"></script>
    <script src="jquery-3.4.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    <script>
        var isSearch = '<?php echo isset($_POST['search'])?>';
        var search = '<?php echo isset($_POST['search']) ? $_POST['search'] : ""; ?>'; // is the php the user typed in    
        console.log(search);
        var search2 = search.replace(/ /g, "%20");
        console.log(search2);
//the url in this might be viewable by users which could be a problem since it has the unique key
        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "https://us1.locationiq.com/v1/search.php?key=30ed2a0f706ead&q=" + search2 + "&format=json", 
            "method": "GET"
        }

        $.ajax(settings).done(function(response) {
            console.log(response);

            test1 = document.querySelector(".search-response-1");

            for (i = 0; i < response.length; i++) {
                var locationchange = response[i].display_name.replace(/ /g, "%20");
                url1 = 'index.php?lat=' + response[i].lat + '&long=' + response[i].lon + '&locationname=' + locationchange + '&saved=true';
                document.getElementById('search-responses').innerHTML += '<a href=' + url1 + '><li>' + response[i].display_name + '</li></a><hr class="my-1">';
            }



        });

        if (isSearch) {
            $('#searchResultsModal').modal('show');
        }

    </script>
</body>

</html>
