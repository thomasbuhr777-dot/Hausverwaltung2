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
        <a href="<?= base_url('liegenschaften/new') ?>" class="btn btn-success">+ Objekt anlegen</a>
    </div>

    <form action="<?= base_url('liegenschaften') ?>" method="get" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Name oder Straße suchen..." value="<?= esc($search) ?>">
        </div>
        <div class="col-md-3">
            <select name="ort" class="form-select">
                <option value="">Alle Orte</option>
                <?php foreach ($orte as $o): ?>
                    <option value="<?= $o['ort'] ?>" <?= $selected_ort == $o['ort'] ? 'selected' : '' ?>>
                        <?= esc($o['ort']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filtern</button>
        </div>
        <div class="col-md-1">
            <a href="<?= base_url('liegenschaften') ?>" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <table class="table table-hover shadow-sm">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Adresse</th>
                <th>PLZ / Ort</th>
                <th class="text-end">Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($liegenschaften)): ?>
                <?php foreach ($liegenschaften as $l): ?>
                <tr>
                    <td><strong><?= esc($l['name']) ?></strong></td>
                    <td><?= esc($l['strasse']) ?></td>
                    <td><?= esc($l['plz']) ?> <?= esc($l['ort']) ?></td>
                    <td class="text-end">
                         <a href="<?= base_url('liegenschaften/' . $l['id']) ?>" class="btn btn-sm btn-outline-secondary">Details</a>
                        <a href="<?= base_url('liegenschaften/' . $l['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary">Bearbeiten</a>
                        <form action="<?= base_url('liegenschaften/'.$l['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Wirklich löschen?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Löschen</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-center">Keine Liegenschaften gefunden.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="mt-3">
        <?= $pager->links('group1', 'default_full') ?>
    </div>
</div>

<!----------------------content----------------------------------------->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>