<?php
$userid=$_POST['userid'];

$File = 'prediction.csv';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "monetgurgaon";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection 


$arrResult  = array();
$handle     = fopen($File, "r");
if(empty($handle) === false) {
    while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
        $arrResult[] = $data;
    }
    fclose($handle);
}
$rows = count($arrResult)-1 ;
$cols = count($arrResult[0])-1;
$dat = $arrResult;
$result = array();
$user = array();
for ($i=0; $i < $rows ; $i++) { 
 for ($k=1; $k < $cols; $k++) { 
  $dat[$i+1][$k] = floatval($dat[$i+1][$k] );
  if($dat[$i+1][$k] ==0){
   $dat[$i+1][$k] = -2;
  }
 }
 arsort($dat[$i+1]);
 $user[$i] = $arrResult[$i+1][0];
 $keys = array_keys($dat[$i+1]);
 ini_set('memory_limit', '-1');
 for ($j=1; $j < 11; $j++) { 
  $result[$i][$j-1][0] = $dat[0][$keys[$j]];
  $result[$i][$j-1][0]= str_replace("[", "", $result[$i][$j-1][0]);
  $result[$i][$j-1][0]= str_replace("]", "", $result[$i][$j-1][0]);
  $result[$i][$j-1][1] = $dat[$i+1][$keys[$j]];
  $sql = 'SELECT c_thumb_url, c_title , c_url FROM `content` WHERE c_id = "'.$result[$i][$j-1][0].'"';
  $t = mysqli_fetch_row($conn->query($sql));
  $result[$i][$j-1][2] = $t[0];
  $result[$i][$j-1][3] = $t[1];
  $result[$i][$j-1][4] = $t[2];

  // print_r($result[$i][$j-1][2]);
  // echo '"'.$result[$i][$j-1][0].'"';
 }

}
$conn->close();
//$userid ='17';
$index = -1;
for ($i=0; $i < $rows; $i++) { 
 $user[$i]= str_replace("[", "", $user[$i]);
 $user[$i]= str_replace("]", "", $user[$i]);
 //echo $user[$i], $userid;
 //echo "     ";
 if($user[$i]==$userid){
  $index = $i;
 }
}

//print_r($dat[1]);
//die();

$video1= $result[$index][0][2];$avg1=$result[$index][0][1];$id1=$result[$index][0][0];$url1=$result[$index][0][4];$d1=$result[$index][0][3];
$video2= $result[$index][1][2];$avg2=$result[$index][1][1];$id2=$result[$index][1][0];$url2=$result[$index][1][4];$d2=$result[$index][1][3];
$video3= $result[$index][2][2];$avg3=$result[$index][2][1];$id3=$result[$index][2][0];$url3=$result[$index][2][4];$d3=$result[$index][2][3];
$video4= $result[$index][3][2];$avg4=$result[$index][3][1];$id4=$result[$index][3][0];$url4=$result[$index][3][4];$d4=$result[$index][3][3];
$video5= $result[$index][4][2];$avg5=$result[$index][4][1];$id5=$result[$index][4][0];$url5=$result[$index][4][4];$d5=$result[$index][4][3];
$video6= $result[$index][5][2];$avg6=$result[$index][4][1];$id6=$result[$index][5][0];$url6=$result[$index][5][4];$d6=$result[$index][5][3];
$video7= $result[$index][6][2];$avg7=$result[$index][6][1];$id7=$result[$index][6][0];$url7=$result[$index][6][4];$d7=$result[$index][6][3];
$video8= $result[$index][7][2];$avg8=$result[$index][7][1];$id8=$result[$index][7][0];$url8=$result[$index][7][4];$d8=$result[$index][7][3];


// echo gettype($user[0]);
// echo gettype($userid)
// $username=$userid;
// $video1="1.jpg";$avg1=13;
// $video2="2.jpg";$avg2=23;
// $video3="3.jpg";$avg3=23;
// $video4="4.jpg";$avg4=24;
// $video5="";$avg5="";
// $video6="";$avg6="";
// $video7="";$avg7="";
// $video8="";$avg8="";
// $video9=;$avg9=;
// $video10=;$avg10=;
// $video11=;$avg11=;
// $video12=;$avg12=;
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link href="1.css" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript">
        $(document).ready(function() {
    $('#myCarousel').carousel({
    interval: 10000
    })
    
    $('#myCarousel').on('slid.bs.carousel', function() {
        //alert("slid");
    });
    
    
});


    </script>
  
</head>
<body>

<div class="" style="text-align:center;margin-top: 40px;">

<h1>Video Recomendation For Userid <?php echo $userid; ?></h1>

<a href="index.html">Go back</a>
</div>


 <div class="container" style="margin-top: 80px;">
    <div class="col-md-12">

        <div class="well">
            <div id="myCarousel" class="carousel slide">
                
                <!-- Carousel items -->
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="row">
                            <div class="col-sm-3"><a href="<?php echo $url1; ?>"><img src="<?php echo $video1; ?>" alt="Image" class="img-responsive"></a>
                            <div class="caption" style="text-align: left;margin-top: 20px;">
                                <p>Predicted Valence <?php echo $avg1; ?></p>
                            
                                <p><?php echo $id1;?> - <?php echo $d1;?></p>
                            </div>
                            </div>
                            <div class="col-sm-3"><a href="<?php echo $url2; ?>"><img src="<?php echo $video2; ?>" alt="Image" class="img-responsive"></a>
                            <div class="caption" style="text-align: left;margin-top: 20px;">
                                <p>Predicted Valence <?php echo $avg2; ?></p>
                                
                                <p><?php echo $id2;?> - <?php echo $d2;?></p>
                            </div>
                            </div>
                            <div class="col-sm-3"><a href="<?php echo $url3; ?>"><img src="<?php echo $video3; ?>" alt="Image" class="img-responsive"></a>
                            <div class="caption" style="text-align: left;margin-top: 20px;">
                                <p>Predicted Valence <?php echo $avg3; ?></p>
                                
                                <p><?php echo $id3;?> - <?php echo $d3;?></p>
                            </div>
                            </div>
                            <div class="col-sm-3"><a href="<?php echo $url4; ?>"><img src="<?php echo $video4; ?>" alt="Image" class="img-responsive"></a>
                            <div class="caption" style="text-align: left;margin-top: 20px;">
                                <p>Predicted Valence <?php echo $avg4; ?></p>
                                
                                <p><?php echo $id4;?> - <?php echo $d4;?></p>
                            </div>
                            </div>
                        </div>
                        <!--/row-->
                    </div>
                    <!--/item-->
                    <div class="item">
                        <div class="row">
                            <div class="col-sm-3"><a href="<?php echo $url5; ?>"><img src="<?php echo $video5; ?>" alt="Image" class="img-responsive"></a>
                            <div class="caption" style="text-align: left;margin-top: 20px;">
                                <p>Predicted Valence <?php echo $avg5; ?></p>
                                
                                <p><?php echo $id5;?> - <?php echo $d5;?></p>
                            </div>
                            </div>
                            <div class="col-sm-3"><a href="<?php echo $url6; ?>"><img src="<?php echo $video6; ?>" alt="Image" class="img-responsive"></a>
                            <div class="caption" style="text-align: left;margin-top: 20px;">
                                <p>Predicted Valence <?php echo $avg6; ?></p>
                                
                                <p><?php echo $id6;?> - <?php echo $d6;?></p>
                            </div>
                            </div>
                            <div class="col-sm-3"><a href="<?php echo $url7; ?>"><img src="<?php echo $video7; ?>" alt="Image" class="img-responsive"></a>
                            <div class="caption" style="text-align: left;margin-top: 20px;">
                                <p>Predicted Valence <?php echo $avg7; ?></p>
                                
                                <p><?php echo $id7;?> - <?php echo $d7;?></p>
                            </div>
                            </div>
                            <div class="col-sm-3"><a href="<?php echo $url8; ?>"><img src="<?php echo $video8; ?>" alt="Image" class="img-responsive"></a>
                            <div class="caption" style="text-align: left;margin-top: 20px;">
                                <p>Predicted Valence <?php echo $avg8; ?></p>
                                
                                <p><?php echo $id8;?> - <?php echo $d8;?></p>
                            </div>
                            </div>
                        </div>
                        <!--/row-->
                    </div>
                    <!--/item-->
                    <!-- <div class="item">
                        <div class="row">
                            <div class="col-sm-3"><a href="#x" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                            </div>
                            <div class="col-sm-3"><a href="#x" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                            </div>
                            <div class="col-sm-3"><a href="#x" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                            </div>
                            <div class="col-sm-3"><a href="#x" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                            </div>
                        </div>
                    
                    </div> -->
                    
                </div>
                <!--/carousel-inner--> 
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>

                <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
            </div>
            <!--/myCarousel-->
        </div>
        <!--/well-->
    </div>
</div>


</body>
</html>