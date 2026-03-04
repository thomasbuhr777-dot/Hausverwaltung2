<!doctype html>
<html lang="de" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= esc($title ?? 'Hausverwaltung') ?></title>

    <!-- Bootstrap + Icons -->
    <link rel="stylesheet" href="<?= base_url('css/fontawesome/css/all.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/styles.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.4/font/bootstrap-icons.css">
  

    <style>
        .avatar {
            width: 32px;
            height: 32px;
            object-fit: cover;
            border-radius: 999px;
            border: 1px;
        }

        .btn-icon {
            border: 1px;
            border-radius: 999px;
            width: 2rem;
            height: 2rem;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-icon > i { line-height: 1; }
        .navbar .vr { align-self: stretch; }
        .footer-text {font-size:14px; }
    </style>

    <?= $this->renderSection('styles') ?>
</head>


<body data-page="<?= $page ?? '' ?>" class="d-flex flex-column min-vh-100">
    

<!-- partials navbar -->
   <?= view('partials/navbar') ?>



    <main class="flex-fill container py-4 pt-5 bg-body-tertiary">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
 <?= view('partials/footer') ?>


<script type="module" src="<?= base_url('js/main.js') ?>"></script>

<?php if (!empty($pageJS)): ?>
<script type="module"
        src="<?= base_url("js/pages/$pageJS.js") ?>">
</script>
<?php endif; ?>


     <?= $this->renderSection('scripts') ?>

