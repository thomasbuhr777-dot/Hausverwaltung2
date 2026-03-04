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
            <li class="breadcrumb-item"><a href="<?= base_url('liegenschaften/' . $einheit['liegenschaft_id']) ?>"><?= esc($einheit['liegenschaft_name']) ?></a></li>
            <li class="breadcrumb-item active">Top <?= esc($einheit['top_nummer']) ?></li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white d-flex justify-content-between">
                    <h5 class="mb-0">Einheitsdetails</h5>
                    <span class="badge bg-info"><?= esc($einheit['einheit_typ']) ?></span>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr><td><strong>Fläche:</strong></td><td><?= number_format($einheit['flaeche_qm'], 2, ',', '.') ?> m²</td></tr>
                        <tr><td><strong>Etage:</strong></td><td><?= esc($einheit['etage'] ?: 'N/A') ?></td></tr>
                        <tr><td><strong>Status:</strong></td>
                            <td><?= $mieter ? '<span class="text-success">Vermietet</span>' : '<span class="text-danger">Leerstand</span>' ?></td>
                        </tr>
                    </table>
                    <div class="mt-3">
                        <a href="<?= base_url('einheiten/' . $einheit['id'] . '/edit') ?>" class="btn btn-primary btn-sm">Bearbeiten</a>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header">Zähler</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead><tr><th>Typ</th><th>Nummer</th><th>Stand</th></tr></thead>
                        <tbody>
                            <?php foreach($zaehler as $z): ?>
                                <tr>
                                    <td><?= esc($z['typ']) ?></td>
                                    <td><?= esc($z['zaehler_nr']) ?></td>
                                    <td><?= number_format($z['letzter_wert'], 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if(empty($zaehler)): ?>
                                <tr><td colspan="3" class="text-center text-muted">Keine Zähler erfasst.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-<?= $mieter ? 'success' : 'warning' ?>">
                <div class="card-header">
                    <h5 class="mb-0">Aktueller Mieter</h5>
                </div>
                <div class="card-body text-center">
                    <?php if ($mieter): ?>
                        <h4><?= esc($mieter['vorname'] . ' ' . $mieter['nachname']) ?></h4>
                        <p class="text-muted">Mietbeginn: <?= date('d.m.Y', strtotime($mieter['start_datum'])) ?></p>
                        <hr>
                        <div class="d-flex justify-content-around">
                            <div><strong>Kaltmiete:</strong><br>€ <?= number_format($mieter['kaltmiete'], 2, ',', '.') ?></div>
                        </div>
                    <?php else: ?>
                        <div class="py-4">
                            <p class="text-muted">Diese Einheit steht aktuell leer.</p>
                            <a href="<?= base_url('mietvertraege/new?einheit_id=' . $einheit['id']) ?>" class="btn btn-success">Mietvertrag erstellen</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!----------------------content----------------------------------------->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>