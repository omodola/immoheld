<!DOCTYPE html>
<html>
<title>Immoheld real estate listings </title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="icon" href="https://immoheld.eu/blog/wp-content/uploads/2018/10/Immoheld-Logo_1.png">

<link  rel="stylesheet" type="text/css" href="<?= base_url('assets/style.css');?>">

<body>

<!-- page content -->
<div class="w3-main w3-content w3-padding"  id="details_page_content">

  <div class="w3-hide-large"  id="details_page_content_mobile"></div>

  <div class="w3-container" >
          <div class="w3-container">
              <h1><a href="/listings"><img src="https://immoheld.eu/blog/wp-content/uploads/2018/10/Immoheld-Logo_1.png" alt="immoheld"></a></h1>
          </div>

      <div class="w3-container w3-padding-32 w3-center">
          <img src="<?php echo $listings['url']; ?>" alt="Me" class="w3-image" id="details_page_content_image" >
      </div>
      <hr>

  </div>


  <div class="w3-container w3-content" id="details">
    <h4><strong>Basic information</strong></h4>
    <div class="w3-row w3-large">
      <div class="w3-col s6">
		<p>Address: <?php echo $listings['address']; ?></p>
        <p>Year: <?php echo $listings['year']; ?></p>
        <p>Rooms: <?php echo $listings['rooms']; ?></p>
        <p>Rooms: <?php echo ucfirst($listings['type']); ?></p>
      </div>
    </div>
  </div>

</div>
</body>
</html>
