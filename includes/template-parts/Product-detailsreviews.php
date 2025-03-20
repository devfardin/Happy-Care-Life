<?php
wp_enqueue_style('happy_care_single_details_reviews')
  ?>
<div class="tab happy_single_product_tabs">
  <button class="tablinks" onclick="openCity(event, 'Description')" id="defaultOpen">Description</button>
  <button class="tablinks" onclick="openCity(event, 'Reviews')">Reviews</button>
</div>

<div id="Description" class="tabcontent">
  <?php global $product;
  $pid = $product->get_id(); ?>
  <p> <?php echo $product->get_description(); ?></p>

</div>

<div id="Reviews" class="tabcontent">
  <?php
  $args = array('post_type' => 'product');
  $comments = get_comments($args);
  wp_list_comments(array('callback' => 'woocommerce_comments'), $comments);
  ?>
</div>


<script>
  function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
  }

  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();
</script>