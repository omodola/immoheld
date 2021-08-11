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


<body class="w3-white w3-content" style="max-width:1600px">

    <!-- Sidebar -->
    <nav class="w3-sidebar w3-collapse w3-light-grey"  id="listings_sidebar"><br>
      <div class="w3-container">
        <a href="#" onclick="w3_close()" class="w3-hide-large w3-right w3-large w3-padding w3-hover-grey" title="close menu">
          <i class="fa fa-remove"></i>
        </a>
      </div>

      <div class="w3-container">
          <form action="/listings" method="GET" enctype="multipart/form-data">
              <p><label>Price</label></p>
              <input class="w3-input w3-border" type="text" placeholder="min" name="minPrice" <?php if(isset($data['minPrice'])){ echo sprintf('value="%s"', $data['minPrice']); } ?> > <br>
              <input class="w3-input w3-border" type="text" placeholder="max" name="maxPrice" <?php if(isset($data['maxPrice'])){ echo sprintf('value="%s"', $data['maxPrice']); } ?> >

              <p><label>Size</label></p>
              <input class="w3-input w3-border" type="text" placeholder="min" name="min_size" <?php if(isset($data['minSize'])){ echo sprintf('value="%s"', $data['minSize']); } ?> ><br>
              <input class="w3-input w3-border" type="text" placeholder="max" name="max_size" <?php if(isset($data['maxSize'])){ echo sprintf('value="%s"', $data['maxSize']); } ?> >

              <input id="order" name="order" type="hidden" <?php if(isset($data['order'])){ echo sprintf('value="%s"', $data['order']); } ?> >

              <p><button class="w3-button w3-block w3-black w3-left-align" type="submit"><i class="fa fa-search w3-margin-right"></i> Search availability</button></p>
          </form>
      </div>
    </nav>

    <!-- siebar on small screens -->
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close" id="listings_overlay"></div>

    <!-- page content -->
    <div class=" w3-main"  id="page_listings">

      <!-- header -->
      <header id="page_listings_header">
        <span class="w3-button w3-hide-large w3-xxlarge w3-hover-text-grey" onclick="w3_open()"><i class="fa fa-bars"></i></span>
        <div class="w3-container">
            <h1><a href="/listings"><img src="https://immoheld.eu/blog/wp-content/uploads/2018/10/Immoheld-Logo_1.png" alt="immoheld"></a></h1>
        </div>
        <div class="w3-section w3-display-container "  id="dropdown_sort">
            <?php $data['order'] = $data['order'] ?? 'newest_first'; ?>
              <div class="w3-display-middle">
                  <form action="/listings" method="GET" enctype="multipart/form-data">
                      <select class="w3-select w3-border" name="order" onchange="this.form.submit()">
                          <option value="newest_first" selected <?php echo (($data['order'] == "newest_first")?"selected":"") ?> >Newest first</option>
                          <option value="cheapest_first" <?php echo (($data['order'] == "cheapest_first")?"selected":"") ?> >Cheapest first</option>
                          <option value="oldest_first" <?php echo (($data['order'] == "oldest_first")?"selected":"") ?> >Oldest first</option>
                          <option value="expensive_first" <?php echo (($data['order'] =="expensive_first")?"selected":"") ?> >Most expensive first</option>

                          <input id="min_price" name="minPrice" type="hidden" <?php if(isset($data['minPrice'])){ echo sprintf('value="%s"', $data['minPrice']); } ?> >
                          <input id="max_price" name="maxPrice" type="hidden" <?php if(isset($data['maxPrice'])){ echo sprintf('value="%s"', $data['maxPrice']); } ?>  >
                          <input id="min_size" name="min_size" type="hidden" <?php if(isset($data['minSize'])){ echo sprintf('value="%s"', $data['minSize']); } ?> >
                          <input id="max_size" name="max_size" type="hidden" <?php if(isset($data['maxSize'])){ echo sprintf('value="%s"', $data['maxSize']); } ?> >

                      </select>
                  </form>
              </div>
          </div>
      </header>

      <!-- listings -->

        <div class="w3-row-padding real_estate_listings">
            <?php foreach ($listings as $listing) :
                $address = explode(',',$listing['address'])?>
            <a href="/listings/<?php echo $listing['id'];?>">

                <div class="w3-col l3 m6 w3-container w3-margin-bottom">
                        <div class="w3-container w3-light-grey" >
                            <p> <span ><b><?php echo $address['0']; ?>,</b></span><br>
                            <span id="country"><?php echo $address['1']; ?></span></p>
                        </div>
                        <img src="<?php echo $listing['url']; ?>" alt="house1"  class="w3-hover-opacity">
                        <div class="w3-container w3-light-grey">
                            <p><span><b>$<?php echo $listing['price']; ?></b></span>
                            <span style="float:right"><?php echo $listing['size']; ?>m<sup>2</sup></span><br>
                            <span><?php echo $listing['rooms']; ?> rooms</span><br>
                            <span><?php echo ucfirst($listing['type']); ?>, <?php echo $listing['year']; ?>.</span><br></p>
                        </div>
                </div>
            </a>

            <?php endforeach; ?>
        </div>

    <!-- End page content -->
    </div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    var current_height = 0;
    var count = 0;

    $(window).on("scroll", function () {
        const scroll_position = Math.floor($(window).height() + $(window).scrollTop());
        const is_bottom_page = $(document).height() - 100 < scroll_position;

        if (is_bottom_page && current_height < $(document).height()) {
            var real_estate_listings = '<?php
                foreach ($listings as $listing){
                    $address = explode(',',$listing['address']);
                    echo '<a href="/listings/'.$listing['id'].'">';
                    echo '  <div class="w3-col l3 m6 w3-container w3-margin-bottom ">';
                    echo'     <div class="w3-container w3-light-grey" >';
                    echo '<p> <span ><b>' .$address['0'].',</b></span>';
                    echo    '<span id="country">' .$address['1'].',</span><br>';
                    echo'</p>';
                    echo '</div>';
                    echo '<img src='. $listing['url'].' alt="house1"  class="w3-hover-opacity">';
                    echo '<div class="w3-container w3-light-grey">';
                    echo '<p><span><b>$'. $listing['price'].'</b></span>';
                    echo '<span style="float:right">'. $listing['size'].'m<sup>2</sup></span><br>';
                    echo '<span>'. $listing['rooms'].' rooms</span><br>';
                    echo '<span>'.ucfirst($listing['type']).', '.$listing['year'].'.</span><br></p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</a>';

                }
                ?>';
            $(".real_estate_listings").append(real_estate_listings);
            currentscrollHeight = $(document).height();
        }
    });



    function w3_open() {
        document.getElementById("listings_sidebar").style.display = "block";
        document.getElementById("listings_overlay").style.display = "block";
    }

    function w3_close() {
        document.getElementById("listings_sidebar").style.display = "none";
        document.getElementById("listings_overlay").style.display = "none";
    }
</script>


</body>
</html>
