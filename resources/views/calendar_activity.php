<div class="row">
  <div class="card" style="flex:2; min-width:360px;">
    <h3>Upcoming Appointments</h3>
    <table>
      <thead><tr><th>Date</th><th>Time</th><th>With</th><th>Type</th><th>Notes</th></tr></thead>
      <tbody id="appt-body">
        <tr><td>2025-10-30</td><td>10:00 AM</td><td>John Scott</td><td>Presentation</td><td>Bring term illustrations</td></tr>
      </tbody>
    </table>
  </div>
  <div class="card form-card" style="flex:1; min-width:320px;">
    <h3>Add Appointment</h3>
    <div class="row">
      <div class="input"><label>Date</label><input id="a-date" type="date"></div>
      <div class="input"><label>Time</label><input id="a-time" type="time"></div>
    </div>
    <div class="row">
      <div class="input"><label>With</label><input id="a-with" placeholder="Contact name"></div>
      <div class="input"><label>Type</label>
        <select id="a-type">
          <option>Call</option><option>Presentation</option><option>Service</option>
        </select>
      </div>
    </div>
    <div class="input"><label>Notes</label><textarea id="a-notes" rows="3"></textarea></div>
    <button class="btn" onclick="addAppt()">Add</button>
  </div>
</div>

<script>
function addAppt(){
  const body = document.getElementById('appt-body');
  const d = document.getElementById('a-date').value||'';
  const t = document.getElementById('a-time').value||'';
  const w = document.getElementById('a-with').value||'';
  const ty= document.getElementById('a-type').value||'';
  const n = document.getElementById('a-notes').value||'';
  if(!d||!t||!w){ alert('Please enter date, time, and with whom.'); return; }
  const tr = document.createElement('tr');
  tr.innerHTML = `<td>${d}</td><td>${t}</td><td>${w}</td><td>${ty}</td><td>${n}</td>`;
  body.appendChild(tr);
}
</script>
