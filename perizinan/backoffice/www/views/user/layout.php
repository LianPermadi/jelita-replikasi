<!DOCTYPE html>
<html>
<head>
 
        <?php echo $template['partials']['header']; ?>

</head>
    <body>
        <div id="main">
            <div class="container">
                <?php echo $template['partials']['title']; ?>
                <?php echo $template['partials']['navigation']; ?>
                <?php echo $template['body']; ?>
            </div>
            <?php echo $template['partials']['footer']; ?>
        </div>
    </body>
</html>