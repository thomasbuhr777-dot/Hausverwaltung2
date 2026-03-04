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
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('liegenschaften') ?>">Liegenschaften</a></li>
            <li class="breadcrumb-item active"><?= esc($liegenschaft['name']) ?></li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Stammdaten</h5>
                </div>
                <div class="card-body">
                    <p><strong>Adresse:</strong><br>
                    <?= esc($liegenschaft['strasse']) ?><br>
                    <?= esc($liegenschaft['plz']) ?> <?= esc($liegenschaft['ort']) ?></p>
                    <p><strong>Baujahr:</strong> <?= esc($liegenschaft['baujahr'] ?? 'N/A') ?></p>
                    <hr>
                    <a href="<?= base_url('liegenschaften/edit/' . $liegenschaft['id']) ?>" class="btn btn-sm btn-outline-secondary w-100">Bearbeiten</a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Einheiten / Wohnungen</h5>
                    <a href="<?= base_url('einheiten/new?liegenschaft_id=' . $liegenschaft['id']) ?>" class="btn btn-sm btn-success">+ Einheit hinzufügen</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Top</th>
                                <th>Typ</th>
                                <th>Fläche</th>
                                <th>Aktueller Mieter</th>
                                <th class="text-end">Aktion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($einheiten)): ?>
                                <?php foreach ($einheiten as $e): ?>
                                <tr>
                                    <td><strong><?= esc($e['top_nummer']) ?></strong></td>
                                    <td><span class="badge bg-info text-dark"><?= esc($e['einheit_typ']) ?></span></td>
                                    <td><?= number_format($e['flaeche_qm'], 2, ',', '.') ?> m²</td>
                                    <td>
                                        <?php if ($e['nachname']): ?>
                                            <a href="<?= base_url('kontakte/show/' . $e['vertrag_id']) ?>">
                                                <?= esc($e['vorname']) ?> <?= esc($e['nachname']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-danger"><i>Leerstand</i></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <a href="<?= base_url('einheiten/' . $e['id']) ?>" class="btn btn-sm btn-light border">Details</a>
                                    </td>
                                    <td>
                                    <form action="<?= base_url('einheiten/' . $e['id']) ?>" method="post" onsubmit="return confirm('Möchten Sie diese Einheit wirklich löschen? Alle Verknüpfungen gehen verloren.')">
                                     <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-link text-danger p-0">Einheit unwiderruflich löschen</button>
                                    </form>
                                </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center p-4">Noch keine Einheiten angelegt.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!----------------------content----------------------------------------->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>