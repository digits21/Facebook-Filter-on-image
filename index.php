<?php

  /*
   Author: Jean Ouedraogo
   Date: 04/14/2018
   Orgaisation:Opendarasa

    dossier des filtres que nous voulons ajouter a notre photos  
  */

  /*
   Get the filters directory and get all possible filters
    dossier des filtres que nous voulons ajouter a notre photos  
  */
  $dir='filters';
  $filters=scandir($dir);
  if ($_POST) {

   /*
    Get the upload filter and destination file from post
    Recuperer les des deux photos postees et diminuer a moitie la taille et l'eppaisseur du filtre   
  */

  	 $percent=0.5;
  	 $sourceImage='images/'.$_FILES['source']['name'];
  	 $filter='filters/'.$_POST['filter'];
  	 list($width, $height) = getimagesize($filter); // get filter sizes ,   
     $newwidth = $width * $percent;                 //width of filter*0.5
     $newheight = $height * $percent;               // heigh of filter*0.5 

  	 switch ($_FILES['source']['type']) {
  	 	case 'image/jpg':
  	 		$destination = imagecreatefromjpeg($sourceImage);
  	 		$thumb = imagecreatetruecolor($newwidth, $newheight);
  	 		$source = imagecreatefromjpeg($filter);
            imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);  // resize filter and copy to thumb

  	 		imagecopymerge($destination, $thumb, 0, 0, 0, 0, $newwidth,$newheight, 60); // merge filter to destination image
            header('Content-type: image/jpg');
            imagejpeg($destination);
            imagedestroy($destination);
            imagedestroy($source);
            imagedestroy($thumb);
            echo $destination;
            //header("Location:images/".$destination);  // see result 
  	 		break;
  	 	case 'image/png':
  	 		$destination = imagecreatefrompng($sourceImage);
  	 		$thumb = imagecreatetruecolor($newwidth, $newheight);
  	 		$source = imagecreatefrompng($filter);
  	 		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
  	 		imagecopymerge($destination, $thumb, 0, 0, 0, 0,$newwidth,$newheight, 60); // the two 0 are the coordinate , les deux 0 sont le coordonnes de la ou le filtre se posera
            header('Content-type: image/png');
            imagepng($destination);
            imagedestroy($destination);
            imagedestroy($source);
            imagedestroy($thumb);
            echo $destination;
            //header("Location:images/".$destination);
  	 		break;
  	 	case 'image/jpeg':
  	 		$destination = imagecreatefromjpeg($sourceImage);
  	 		$thumb = imagecreatetruecolor($newwidth, $newheight);
  	 		$source = imagecreatefromjpeg($filter);
  	 		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
  	 		imagecopymerge($destination, $thumb, 0, 0, 0, 0,$newwidth,$newheight, 60);
            header('Content-type: image/jpeg');
            imagejpeg($destination);
            imagedestroy($destination);
            imagedestroy($source);
            imagedestroy($thumb);
            echo $destination;
            //header("Location:images/".$destination);
  	 		break;
  	 	default:
  	 		echo '<script>alert("Wrong image type")</script>';
  	 		break;
  	 }
  	 
     
     
  }

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>copy image on image </title>
	<style type="text/css">
		.filter-image{
			width:20px;
			height:20px;
			float:left;
		}
		.filter-title{
			float:right;
		}
	</style>
</head>
<body>
    <form method="post" action="" enctype="multipart/form-data">
    	<label>Select file to add filter on</label>
    	<input type="file" name="source" accept=".png,.jpg,.jpeg">
    	<select name="filter">
    		<?php
              foreach ($filters as $filter) {
              	?>
              	<option value="<?php echo $filter; ?>">
              		
              		<span class="filter-title"><?php echo $filter; ?></span>
              	</option>
              	<?php 
              }

    		 ?>
    		
    	</select>
    	<input type="submit" name="submit" value="submit">
    </form>
</body>
</html>