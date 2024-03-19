<?= $this->extend('layout/frontend/layout'); ?>

<?= $this->section('content'); ?>
<h1 id="main">Přihlášení do administrace</h1>

<?= form_open('login-complete'); ?>

<div class="row">
    <div class="col-md-4">
        <div class="input-group mb-3 mt-3">
            <span class="input-group-text"><i class="fa-solid fa-circle-user"></i></span>
            <div class="form-floating">
                <input type="text" class="form-control" id="email" placeholder="Enter email" name="login">
                <label for="email">Uživatelské jméno</label>
            </div>
        </div>

        <div class="input-group mb-3 mt-3">
            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
            <div class="form-floating">
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
                <label for="pwd">Heslo</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Přihlásit</button>
    </div>
</div>




<?= $this->endSection(); ?>