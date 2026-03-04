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
    <h1 class="mb-4"><?= $title ?></h1>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body text-center">
                    <h6>Liegenschaften</h6>
                    <h2><?= $anzahl_objekte ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body text-center">
                    <h6>Einheiten Gesamt</h6>
                    <h2><?= $anzahl_einheiten ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-<?= $leerstand > 0 ? 'warning' : 'success' ?> text-white shadow-sm">
                <div class="card-body text-center">
                    <h6>Leerstand</h6>
                    <h2><?= $leerstand ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white shadow-sm">
                <div class="card-body text-center">
                    <h6>Offene Forderungen</h6>
                    <h2>€ <?= number_format($offene_posten, 2, ',', '.') ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Aktuelle Instandhaltung</h5>
                    <a href="/tickets" class="btn btn-sm btn-outline-primary">Alle Tickets</a>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Einheit</th>
                                <th>Problem</th>
                                <th>Status</th>
                                <th>Datum</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($neueste_tickets as $t): ?>
                            <tr>
                                <td>Top <?= esc($t['top_nummer']) ?></td>
                                <td><?= esc($t['titel']) ?></td>
                                <td><span class="badge bg-secondary"><?= esc($t['status']) ?></span></td>
                                <td><?= date('d.m.Y', strtotime($t['created_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($neueste_tickets)): ?>
                                <tr><td colspan="4" class="text-center p-3">Keine aktiven Meldungen.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">Schnellzugriff</div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="/liegenschaften/new" class="btn btn-outline-dark">Haus anlegen</a>
                        <a href="/kontakte/new" class="btn btn-outline-dark">Mieter anlegen</a>
                        <a href="/mietvertraege/new" class="btn btn-outline-dark">Vertrag erstellen</a>
                        <hr>
                        <button class="btn btn-primary" onclick="alert('Export gestartet...')">NK-Abrechnung (PDF)</button>
                        <hr>
                        <form action="<?= base_url('dashboard/runSollstellung') ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-warning w-100 mt-2">Sollstellung jetzt ausführen</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!----------------------content----------------------------------------->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>