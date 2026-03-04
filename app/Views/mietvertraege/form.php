<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
<!----------------------content----------------------------------------->

<div class="container mt-4">
    <h2><?= $title ?></h2>

    <form action="<?= base_url('mietvertraege') ?>" method="post">
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Einheit / Wohnung</label>
                <select name="einheit_id" class="form-select" required>
                    <option value="">-- Einheit wählen --</option>
                    <?php foreach ($einheiten as $e): ?>
                        <option value="<?= $e['id'] ?>" <?= ($selected_unit == $e['id']) ? 'selected' : '' ?>>
                            <?= esc($e['liegenschaft_name']) ?> - Top <?= esc($e['top_nummer']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Mieter</label>
                <select name="mieter_id" class="form-select" required>
                    <option value="">-- Mieter wählen --</option>
                    <?php foreach ($mieter as $m): ?>
                        <option value="<?= $m['id'] ?>"><?= esc($m['vorname']) ?> <?= esc($m['nachname']) ?></option>
                    <?php endforeach; ?>
                </select>
                <small><a href="<?= base_url('kontakte/new') ?>">+ Neuen Mieter anlegen</a></small>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Mietbeginn</label>
                <input type="date" name="start_datum" class="form-control" value="<?= old('start_datum') ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Mietende (optional)</label>
                <input type="date" name="end_datum" class="form-control" value="<?= old('end_datum') ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Kaltmiete (€)</label>
                <input type="number" step="0.01" name="kaltmiete" class="form-control" value="<?= old('kaltmiete') ?>" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>Nebenkosten Pauschale (€)</label>
                <input type="number" step="0.01" name="nebenkosten" class="form-control" value="<?= old('nebenkosten') ?>" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>Kaution (€)</label>
                <input type="number" step="0.01" name="kaution" class="form-control" value="<?= old('kaution') ?>">
            </div>
        </div>

        <input type="hidden" name="aktiv" value="1">

        <button type="submit" class="btn btn-success">Mietvertrag aktivieren</button>
    </form>
</div>
<!----------------------content----------------------------------------->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>