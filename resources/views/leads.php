<?php
$csvPreview = [];
$singleLead  = null;

if ($_SERVER['REQUEST_METHOD']==='POST') {
    if (isset($_POST['single_lead_submit'])) {
        $singleLead = [
            'name'   => $_POST['name'] ?? '',
            'source' => $_POST['source'] ?? '',
            'phone'  => $_POST['phone'] ?? '',
            'email'  => $_POST['email'] ?? '',
        ];
    }

    if (isset($_POST['csv_upload_submit']) && isset($_FILES['csv'])) {
        if (is_uploaded_file($_FILES['csv']['tmp_name'])) {
            if (($h = fopen($_FILES['csv']['tmp_name'], 'r')) !== false) {
                $head = fgetcsv($h); // header row
                while (($row = fgetcsv($h)) !== false) {
                    $csvPreview[] = $row;
                }
                fclose($h);
            }
        }
    }
}
?>

<div class="row">
  <div class="card form-card" style="flex:1; min-width:320px;">
    <h3>Add a Single Lead</h3>
    <form method="post">
      <div class="row">
        <div class="input"><label>Name</label><input name="name" placeholder="Jane Doe"></div>
        <div class="input"><label>Source</label><input name="source" placeholder="Facebook / Referral / Web"></div>
      </div>
      <div class="row">
        <div class="input"><label>Phone</label><input name="phone" placeholder="(555) 555-5555"></div>
        <div class="input"><label>Email</label><input name="email" placeholder="jane@example.com"></div>
      </div>
      <button class="btn" name="single_lead_submit">Save Lead (Preview)</button>
    </form>

    <?php if ($singleLead): ?>
    <div class="card" style="margin-top:16px;">
      <h3>Preview</h3>
      <p><strong><?=htmlspecialchars($singleLead['name'])?></strong> • <?=htmlspecialchars($singleLead['source'])?><br>
      <?=htmlspecialchars($singleLead['phone'])?> • <?=htmlspecialchars($singleLead['email'])?></p>
      <p style="color:#777;margin:0;">(In Tier 2, this will save to the database and create a contact detail page.)</p>
    </div>
    <?php endif; ?>
  </div>

  <div class="card form-card" style="flex:1; min-width:320px;">
    <h3>Bulk Upload (CSV)</h3>
    <form method="post" enctype="multipart/form-data">
      <div class="input"><label>CSV file</label><input type="file" name="csv" accept=".csv"></div>
      <p style="font-size:13px;color:#777;margin:8px 0 16px;">CSV headers: <code>Name,Source,Phone,Email</code></p>
      <button class="btn" name="csv_upload_submit">Upload & Preview</button>
    </form>

    <?php if ($csvPreview): ?>
      <div style="margin-top:16px;">
        <h3>Parsed Rows</h3>
        <table>
          <thead><tr><th>Name</th><th>Source</th><th>Phone</th><th>Email</th></tr></thead>
          <tbody>
          <?php foreach($csvPreview as $r): ?>
            <tr>
              <td><?=htmlspecialchars($r[0] ?? '')?></td>
              <td><?=htmlspecialchars($r[1] ?? '')?></td>
              <td><?=htmlspecialchars($r[2] ?? '')?></td>
              <td><?=htmlspecialchars($r[3] ?? '')?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        <p style="color:#777;margin:8px 0 0;">(In Tier 2, clicking “Import” will create contacts.)</p>
      </div>
    <?php endif; ?>
  </div>
</div>
