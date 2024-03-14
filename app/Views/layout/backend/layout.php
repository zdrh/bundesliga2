<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bundesliga</title>
    <?= $this->include('layout/backend/assets'); ?>
</head>

<body>
    <?= $this->include('layout/backend/navbar'); ?>
    <div class="container">
        <?= $this->renderSection('content'); ?>
    </div>
</body>

</html>