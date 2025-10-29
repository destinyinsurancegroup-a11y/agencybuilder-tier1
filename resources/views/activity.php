<div class="row">
  <div class="card form-card" style="flex:1; min-width:320px;">
    <h3>Record Activity</h3>
    <div class="row">
      <div class="input"><label>Leads</label><input id="n-leads" type="number" min="0" placeholder="0"></div>
      <div class="input"><label>Calls / Stops</label><input id="n-calls" type="number" min="0" placeholder="0"></div>
    </div>
    <div class="row">
      <div class="input"><label>Presentations</label><input id="n-pres" type="number" min="0" placeholder="0"></div>
      <div class="input"><label>Sales (Apps Written)</label><input id="n-sales" type="number" min="0" placeholder="0"></div>
    </div>
    <div class="row">
      <div class="input"><label>Premium Collected ($)</label><input id="n-prem" type="number" min="0" step="0.01" placeholder="0.00"></div>
    </div>
    <button class="btn" onclick="saveNumbers()">Save Numbers</button>
  </div>

  <div class="card" style="flex:1; min-width:320px;">
    <h3>Your Ratios (Auto)</h3>
    <table>
      <tbody>
        <tr><td>Calls ➜ Presentation</td><td id="r-call-pres">0</td></tr>
        <tr><td>Presentations ➜ Sale</td><td id="r-pres-sale">0</td></tr>
        <tr><td>Leads ➜ Presentation</td><td id="r-lead-pres">0</td></tr>
        <tr><td>Conversion %</td><td id="r-conv">0%</td></tr>
      </tbody>
    </table>
    <p style="color:#777;margin:8px 0 0;">Saved locally. Dashboard uses these values.</p>
  </div>
</div>

<script>
function calcAndDisplay(n){
  const leads = +n.leads||0, calls=+n.calls||0, pres=+n.presentations||0, sales=+n.sales||0;
  const callToPres = pres>0 ? (calls/pres).toFixed(1) : (calls>0? '∞' : '0');
  const presToSale = sales>0 ? (pres/sales).toFixed(1) : (pres>0? '∞' : '0');
  const leadToPres = pres>0 ? (leads/pres).toFixed(1) : (leads>0? '∞' : '0');
  const conv = pres>0 ? Math.round((sales/pres)*100) : 0;

  document.getElementById('r-call-pres').textContent = callToPres + " calls per presentation";
  document.getElementById('r-pres-sale').textContent = presToSale + " pres per sale";
  document.getElementById('r-lead-pres').textContent = leadToPres + " leads per presentation";
  document.getElementById('r-conv').textContent = conv + "%";
}

function saveNumbers(){
  const n = {
    leads: document.getElementById('n-leads').value,
    calls: document.getElementById('n-calls').value,
    presentations: document.getElementById('n-pres').value,
    sales: document.getElementById('n-sales').value,
    premium: document.getElementById('n-prem').value
  };
  localStorage.setItem('ab_numbers', JSON.stringify(n));
  calcAndDisplay(n);
  alert('Saved! Dashboard updated.');
}

// preload from storage
(function(){
  const n = JSON.parse(localStorage.getItem('ab_numbers')||'{}');
  if(n.leads!==undefined){ document.getElementById('n-leads').value=n.leads; }
  if(n.calls!==undefined){ document.getElementById('n-calls').value=n.calls; }
  if(n.presentations!==undefined){ document.getElementById('n-pres').value=n.presentations; }
  if(n.sales!==undefined){ document.getElementById('n-sales').value=n.sales; }
  if(n.premium!==undefined){ document.getElementById('n-prem').value=n.premium; }
  calcAndDisplay(n);
})();
</script>
