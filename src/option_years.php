<?php 
    $i = 2024;
    $year = (int)date('Y');
    for(;$i <= $year ; $i++){
        ?>
        <option value="<?php echo $i?>"> <?php echo (string)$i?></option>
        <?php
    }
?>