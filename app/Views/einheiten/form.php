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

    <form action="<?= isset($einheit) ? base_url('einheiten/' . $einheit['id']) : base_url('einheiten') ?>" method="post">
        <?= csrf_field() ?>
        <?php if (isset($einheit)): ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>

        <div class="mb-3">
            <label>Zugehörige Liegenschaft</label>
            <select name="liegenschaft_id" class="form-select" required>
                <option value="">-- Bitte wählen --</option>
                <?php foreach ($liegenschaften as $l): ?>
                    <option value="<?= $l['id'] ?>" 
                        <?= old('liegenschaft_id', $einheit['liegenschaft_id'] ?? $selected_haus) == $l['id'] ? 'selected' : '' ?>>
                        <?= esc($l['name']) ?> (<?= esc($l['ort']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Top Nummer (z.B. Top 12 oder EG links)</label>
                <input type="text" name="top_nummer" class="form-control" value="<?= old('top_nummer', $einheit['top_nummer'] ?? '') ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Einheit Typ</label>
                <select name="einheit_typ" class="form-select">
                    <?php foreach(['Wohnung', 'Gewerbe', 'Garage', 'Keller'] as $typ): ?>
                        <option value="<?= $typ ?>" <?= old('einheit_typ', $einheit['einheit_typ'] ?? '') == $typ ? 'selected' : '' ?>>
                            <?= $typ ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Fläche in m²</label>
                <input type="number" step="0.01" name="flaeche_qm" class="form-control" value="<?= old('flaeche_qm', $einheit['flaeche_qm'] ?? '') ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Etage</label>
                <input type="text" name="etage" class="form-control" value="<?= old('etage', $einheit['etage'] ?? '') ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Speichern</button>
        <a href="javascript:history.back()" class="btn btn-secondary">Abbrechen</a>
    </form>
</div>
<!----------------------content----------------------------------------->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>