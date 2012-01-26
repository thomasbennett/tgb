<?php define('IMAGES', 'http://www.thomasgbennett.com/images') ?>

<script>
    $('.back').click(function(){
        $.ajax({
            type: 'POST',
            url: 'work-include.php',
            success: function(data){
                $('#work-container').html(data);
            }
        });
    });
</script>
