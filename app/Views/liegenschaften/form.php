<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
<!----------------------content----------------------------------------->

<h2><?= $title ?></h2>

<?php if (session()->has('errors')) : ?>
    <div class="alert alert-danger">
        <?php foreach (session('errors') as $error) : ?>
            <li><?= $error ?></li>
        <?php endforeach ?>
    </div>
<?php endif ?>

<form action="<?= base_url('liegenschaften/' . $liegenschaft['id']) ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">
    
    <div class="form-group">
        <label>Name der Liegenschaft</label>
        <input type="text" name="name" class="form-control" value="<?= old('name', $liegenschaft['name'] ?? '') ?>">
    </div>

    <div class="row">
        <div class="col-md-6">
            <label>Straße</label>
            <input type="text" name="strasse" class="form-control" value="<?= old('strasse', $liegenschaft['strasse'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <label>PLZ</label>
            <input type="text" name="plz" class="form-control" value="<?= old('plz', $liegenschaft['plz'] ?? '') ?>">
        </div>
         <div class="col-md-3">
            <label>Ort</label>
            <input type="text" name="ort" class="form-control" value="<?= old('ort', $liegenschaft['ort'] ?? '') ?>">
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Speichern</button>
    <a href="/liegenschaften" class="btn btn-secondary mt-3">Abbrechen</a>
</form>
<!----------------------content----------------------------------------->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>