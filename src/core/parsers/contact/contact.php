
<div class="col-12 mb-3">
    <h3 class="text-dark fs-4">
        <i class="<?= $tabs['font'] ?> me-3"></i> <strong> <?= $tabs['short'] ?> </strong>
    </h3>
</div>
<div class="col-12 col-sm-6">
    <div class="card mb-3 bg-light">
        <div class="card-body">
            <h5 class="card-title text-sm"> <i class="fa-solid fa-phone me-1"></i> Phone Number </h5>
            <p class="card-text"> <a href="tel:<?= $tabs['call'] ?>"> <?= $tabs['call'] ?> </a></p>
        </div>
    </div>
</div>
<div class="col-12 col-sm-6">
    <div class="card mb-3 bg-light">
        <div class="card-body">
            <h5 class="card-title text-sm"> <i class="fa-brands fa-whatsapp me-1"></i> Whatsapp</h5>
            <p class="card-text"><a href="https://api.whatsapp.com/send?phone=<?= str_replace(' ', '', $tabs['wapp']) ?>"> +<?= $tabs['wapp'] ?> </a></p>
        </div>
    </div>
</div>

<div class="col-12 col-sm-6">
    <div class="card mb-3 bg-light">
        <div class="card-body">
            <h5 class="card-title text-sm"><i class="fa-regular fa-envelope me-1"></i> eMail </h5>
            <p class="card-text"> <a href="mail:<?= $tabs['mail'] ?>"> <?= $tabs['mail'] ?> </a></p>
        </div>
    </div>
</div>
<div class="col-12 col-sm-6">
    <div class="card mb-3 bg-light">
        <div class="card-body">
            <h5 class="card-title text-sm"> <i class="fa-solid fa-link me-1"></i> Website</h5>
            <p class="card-text"> <a href="<?= $tabs['site'] ?>"> <?= $tabs['site'] ?> </a></p>
        </div>
    </div>
</div>