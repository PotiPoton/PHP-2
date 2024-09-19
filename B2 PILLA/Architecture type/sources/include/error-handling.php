<?php 
    $class = (isset($errorMsg))? "error" : "success";
    if (isset($successMsg) || isset($errorMsg) || isset($disconnectedMsg)): ?>
    <div class="container">

        <p class="connect <?php echo $class ?>">
        <?php 
        if (isset($successMsg)) echo $successMsg;
        if (isset($errorMsg)) echo $errorMsg;
        if (isset($disconnectedMsg)) echo $disconnectedMsg;
        ?>
        </p>
    </div>
<?php endif; ?>