
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin — Los Pollos Hermanos</title>
  <link rel="icon" type="image/png" href="images/losp.png">
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Small admin-specific styles to match existing design */
    body { padding: 24px; }
    .admin-header { display:flex; align-items:center; gap:16px; margin-bottom:18px }
    .admin-title { font-size:24px; margin:0 }
    .admin-tabs { display:flex; gap:8px; margin-bottom:16px }
    .tab { padding:8px 14px; border-radius:6px; border:1px solid #ddd; background:#fff; cursor:pointer }
    .tab.active { background:#111; color:#fff; }
    .panel { display:none; background:#fff; padding:16px; border-radius:8px; box-shadow:0 1px 4px rgba(0,0,0,0.06) }
    .panel.active { display:block }
    table { width:100%; border-collapse:collapse; margin-top:12px }
    th, td { padding:8px 10px; border-bottom:1px solid #eee; text-align:left }
    .placeholder { color:#666; font-style:italic }
  </style>
</head>
<body>

  <div class="admin-header">
    <img src="images/lph.png" alt="logo" style="height:44px">
    <div>
      <h1 class="admin-title">Admin Dashboard</h1>
      <div class="placeholder">Manage Jobs & Applicants</div>
    </div>
  </div>

  <div class="admin-tabs" role="tablist">
    <button class="tab active" data-target="jobs-panel" role="tab" aria-selected="true">Jobs</button>
    <button class="tab" data-target="applicants-panel" role="tab" aria-selected="false">Job Applicants</button>
    <button class="tab" data-target="inquiries-panel" role="tab" aria-selected="false">Inquiries</button>
  </div>

  <div id="jobs-panel" class="panel active" role="tabpanel">
    <h2>Jobs</h2>
    <p class="placeholder">Manage jobs</p>

    <table id="jobs-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Description</th>
          <th>Responsibilities</th>
          <th>Skills</th>
          <th>Branch</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

  <div id="applicants-panel" class="panel" role="tabpanel">
    <h2>Job Applicants</h2>
    <p class="placeholder">Lists of job applicants.</p>

    <table id="applicants-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Applied For</th>
          <th>Message / Pitch</th>
          <th>Application Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

  <div id="inquiries-panel" class="panel" role="tabpanel">
    <h2>Customer Inquiries</h2>
    <p class="placeholder">View all customer inquiries and messages.</p>

    <table id="inquiries-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Message</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

  <script>
    // Tab switching logic (client-side only)
    document.querySelectorAll('.tab').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        const target = document.getElementById(btn.getAttribute('data-target'));
        if (target) target.classList.add('active');
      });
    });

    // Fetch and render Jobs
    async function fetchJobs() {
      const tbody = document.querySelector('#jobs-table tbody');
      tbody.innerHTML = '<tr><td colspan="8">Loading jobs…</td></tr>';
      try {
        const res = await fetch('./fetch_jobs.php');
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const json = await res.json();
        if (!json.data) throw new Error('Invalid response');
        const rows = json.data;
        if (!rows.length) {
          tbody.innerHTML = '<tr><td colspan="8" class="placeholder">No jobs found.</td></tr>';
          return;
        }

        tbody.innerHTML = rows.map(r => {
          const id = r.jobid ?? r.id ?? '';
          const title = escapeHtml(r.job_name ?? r.job ?? '');
          const description = escapeHtml(r.job_description ?? r.description ?? '');
          const responsibilities = escapeHtml(r.Responsibilities ?? r.responsibilities ?? '');
          const skills = escapeHtml(r.req_skills ?? r.skills ?? '');
          const branch = escapeHtml(r.branch ?? r.location ?? '');
          const status = (r.position_filled && Number(r.position_filled) === 1) ? 'Filled' : 'Open';
          return `
            <tr>
              <td>${id}</td>
              <td>${title}</td>
              <td>${description}</td>
              <td>${responsibilities}</td>
              <td>${skills}</td>
              <td>${branch}</td>
              <td>${status}</td>
              <td>
                <button data-id="${id}" class="view-job">View</button>
                <button disabled class="secondary">(actions)</button>
              </td>
            </tr>`;
        }).join('');
      } catch (err) {
        tbody.innerHTML = `<tr><td colspan="5" class="placeholder">Error loading jobs: ${escapeHtml(err.message)}</td></tr>`;
        console.error(err);
      }
    }

    // Fetch and render Applicants
    async function fetchApplicants() {
      const tbody = document.querySelector('#applicants-table tbody');
      tbody.innerHTML = '<tr><td colspan="7">Loading applicants…</td></tr>';
      try {
        const res = await fetch('./fetch_applicants.php');
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const json = await res.json();
        if (!json.data) throw new Error('Invalid response');
        const rows = json.data;
        if (!rows.length) {
          tbody.innerHTML = '<tr><td colspan="7" class="placeholder">No applicants found.</td></tr>';
          return;
        }

        tbody.innerHTML = rows.map(r => {
          // Map exact DB column names from fetch_applicants.php
          const id = r.a_formID ?? r.id ?? '';
          const name = escapeHtml(r.Name ?? r.name ?? '');
          const email = escapeHtml(r.email ?? '');
          const appliedFor = escapeHtml(r.applicant_info ?? r.job_title ?? '');
          const message = escapeHtml((r.applicant_info ?? '').toString().substring(0, 100) + (r.applicant_info ? '…' : ''));
          const appDate = escapeHtml(r.app_date ?? r.created_at ?? r.submitted_at ?? '');
          return `
            <tr>
              <td>${id}</td>
              <td>${name}</td>
              <td>${email}</td>
              <td>${appliedFor}</td>
              <td>${message}</td>
              <td>${appDate}</td>
              <td><button disabled>(view)</button></td>
            </tr>`;
        }).join('');
      } catch (err) {
        tbody.innerHTML = `<tr><td colspan="7" class="placeholder">Error loading applicants: ${escapeHtml(err.message)}</td></tr>`;
        console.error(err);
      }
    }

    // Fetch and render Inquiries
    async function fetchInquiries() {
      const tbody = document.querySelector('#inquiries-table tbody');
      tbody.innerHTML = '<tr><td colspan="4">Loading inquiries…</td></tr>';
      try {
        const res = await fetch('./fetch_inquiry.php');
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const json = await res.json();
        if (!json.success || !json.data) throw new Error(json.error || 'Invalid response');
        const rows = json.data;
        if (!rows.length) {
          tbody.innerHTML = '<tr><td colspan="4" class="placeholder">No inquiries found.</td></tr>';
          return;
        }

        tbody.innerHTML = rows.map(r => {
          const id = r.inqID ?? r.id ?? '';
          const name = escapeHtml(r.name ?? '');
          const email = escapeHtml(r.email ?? '');
          const message = escapeHtml(r.message ?? '');
          return `
            <tr>
              <td>${id}</td>
              <td>${name}</td>
              <td>${email}</td>
              <td>${message}</td>
            </tr>`;
        }).join('');
      } catch (err) {
        tbody.innerHTML = `<tr><td colspan="4" class="placeholder">Error loading inquiries: ${escapeHtml(err.message)}</td></tr>`;
        console.error(err);
      }
    }

    // small helper to escape HTML
    function escapeHtml(str) {
      if (str === null || str === undefined) return '';
      return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/\"/g, '&quot;')
        .replace(/'/g, '&#39;');
    }

    // Initialize page by fetching all datasets
    fetchJobs();
    fetchApplicants();
    fetchInquiries();

    // NOTE: Actions like view/edit/delete are placeholders and disabled.
  </script>

</body>
</html>