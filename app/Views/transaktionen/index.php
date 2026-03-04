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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= $title ?></h1>
        <div class="btn-group">
            <a href="?status=offen" class="btn btn-<?= $currentStatus == 'offen' ? 'danger' : 'outline-danger' ?>">Offen</a>
            <a href="?status=bezahlt" class="btn btn-<?= $currentStatus == 'bezahlt' ? 'success' : 'outline-success' ?>">Bezahlt</a>
            <a href="?status=" class="btn btn-<?= $currentStatus == '' ? 'secondary' : 'outline-secondary' ?>">Alle</a>
        </div>
    </div>

    <table class="table table-hover shadow-sm border">
        <thead class="table-light">
            <tr>
                <th>Datum</th>
                <th>Mieter / Objekt</th>
                <th>Beschreibung</th>
                <th class="text-end">Betrag</th>
                <th>Status</th>
                <th class="text-center">Aktion</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transaktionen as $t): ?>
            <tr>
                <td><?= date('d.m.Y', strtotime($t['datum'])) ?></td>
                <td>
                    <strong><?= esc($t['vorname']) ?> <?= esc($t['nachname']) ?></strong><br>
                    <small class="text-muted"><?= esc($t['haus_name']) ?>, Top <?= esc($t['top_nummer']) ?></small>
                </td>
                <td><?= esc($t['beschreibung']) ?></td>
                <td class="text-end"><strong>€ <?= number_format($t['betrag'], 2, ',', '.') ?></strong></td>
                <td>
                    <span class="badge bg-<?= $t['status'] == 'bezahlt' ? 'success' : 'danger' ?>">
                        <?= ucfirst($t['status']) ?>
                    </span>
                </td>
                <td class="text-center">
                    <?php if ($t['status'] == 'offen'): ?>
                        <form action="<?= base_url('transaktionen/markAsPaid/' . $t['id']) ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-success">Verbuchen</button>
                        </form>
                    <?php else: ?>
                        <span class="text-muted"><i class="bi bi-check-all"></i> Erledigt</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($transaktionen)): ?>
                <tr><td colspan="6" class="text-center p-4">Keine Einträge gefunden.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!----------------------content----------------------------------------->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>