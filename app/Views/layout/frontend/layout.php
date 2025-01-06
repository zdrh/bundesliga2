<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bundesliga</title>
    <?= $this->include('layout/frontend/assets'); ?>
</head>

<body>
    <?= $this->include('layout/frontend/navbar'); ?>
    <?php
    if(!is_null($subMenu)) {
        echo $this->include('layout/frontend/'.$frontendNavbar);
    }
     ?>
    <div class="container">
    <?= $this->include('layout/backend/alert'); ?>
        <?= $this->renderSection('content'); ?>
    </div>
</body>

</html>