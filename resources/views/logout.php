<div class="card" style="max-width:640px;">
  <h3>Logout</h3>
  <p>This will clear your local data (demo mode) and return you to the Dashboard.</p>
  <button class="btn" onclick="doLogout()">Confirm Logout</button>
</div>
<script>
function doLogout(){
  localStorage.removeItem('ab_numbers');
  window.location = '/?tab=dashboard';
}
</script>
