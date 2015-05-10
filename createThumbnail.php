<?php
 if (isset($_POST['create'])) {
 require_once('/app/Classes/Thumbnail.php');
 try {
 $thumb = new Thumbnail($_POST['pix']);
 $thumb->setDestination('C:/WebHost/htdocs/skolaverkefni/Verkefni5/uploads/thumbnails/');
 $thumb->setMaxSize(100);
 $thumb->setSuffix('small'); 
 $thumb->create(); 
 $messages = $thumb->getMessages();
 $thumb->test();
 } catch (Exception $e) {
 echo $e->getMessage();
 }
 }
 ?> 
 <?php
 if (isset($messages) && !empty($messages)) { 
 	echo '<ul>';
 foreach ($messages as $message) {
 echo "<li>$message</li>";
 }
 echo '</ul>';
 }
 ?> 


<form id="form1" name="form1" method="post" action="">
 <p>
 <select name="pix" id="pix">
 <option value="">Select an image</option>
 <?php
 $files = new DirectoryIterator('../uploads');
 $images = new RegexIterator($files, '/\.(?:jpg|png|gif)$/i');
 foreach ($images as $image) {
 ?>
 <option value="../uploads/<?php echo $image; ?>">
 <?php echo $image; ?></option>
 <?php } ?>
 </select>
 </p>
 <p>
 <input type="submit" name="create" id="create" value="Create Thumbnail">
 </p>
</form> 