<?php
/* 
* Template name: Calculator
*/
?>
<?php get_header(); ?>

<div id="content" class="calc">
  <p>Calculator testing.</p>

  <form id="calculator">
    <input type="radio" value="50" name="rate" /><label>Design &amp; Basic Updates</label>  
    <input type="radio" value="90" name="rate" /><label>Design &amp; Functionality Updates</label>  
    <input type="text" name="hours" id="hours" />
    <button id="calculate" type="button">Calculate</button>
  </form>

  <div id="discount">Online discount: <span id="discount-rate"></span></div>
  <div id="estimate"></div>

  <div class="increment">
    <span id="add">+</span>
    <span id="subtract">-</span>
  </div>
  <script>
    jQuery(function($){
      $('#calculate').click(function(e){
        var rate = $('input[type="radio"]:checked').val(); 
        var hours = $('input#hours').val();
        var discount = '0.04';
        var total = (hours * rate);

        $('#estimate').html('$' + ((total * discount) - total) * (-1));
        $('#discount-rate').html('$' + (total * discount));

        e.preventDefault();
      });

      $('#add').click(function(){
        var rate = $('input[type="radio"]:checked').val(); 
        var newtotal = $('#estimate').val();
        var total = (newtotal * rate);
        alert(newtotal);
        $('#estimate').html(total + rate);
      });

      $('#subtract').click(function(){
        var rate = $('input[type="radio"]:checked').val(); 
        var newtotal = $('#estimate').val();
        var total = (newtotal * rate);
        $('#estimate').html(total - rate);
      });

    });
  </script>
</div>


<?php get_footer(); ?>
