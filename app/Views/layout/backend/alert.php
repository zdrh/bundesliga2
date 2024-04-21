<?php

foreach ($error as $row) {
    if ($row->real) {
?>
        <div class="mt-3 alert alert-<?= $row->class ?> alert-dismissible fade show" role="alert">
            <?= $row->message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

<?php
    }
}
?>