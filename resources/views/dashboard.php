<div class="cards">
  <div class="card"><h3>Leads</h3><div class="big" id="d-leads">0</div></div>
  <div class="card"><h3>Presentations</h3><div class="big" id="d-pres">0</div></div>
  <div class="card"><h3>Sales</h3><div class="big" id="d-sales">0</div></div>
  <div class="card"><h3>Conversion</h3><div class="big" id="d-cvr">0%</div></div>
</div>

<script>
// pull agent numbers from localStorage (set on Activity tab)
(function(){
  const num = JSON.parse(localStorage.getItem('ab_numbers')||'{}');
  const leads = +num.leads||0;
  const pres  = +num.presentations||0;
  const sales = +num.sales||0;
  const cvr   = pres>0 ? Math.round((sales/pres)*100) : 0;

  document.getElementById('d-leads').textContent = leads;
  document.getElementById('d-pres').textContent  = pres;
  document.getElementById('d-sales').textContent = sales;
  document.getElementById('d-cvr').textContent   = cvr + '%';
})();
</script>
