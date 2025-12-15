<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin — Los Pollos Hermanos</title>
  <title>Admin — Los Pollos Hermanos</title>
  <link rel="icon" type="image/png" href="../images/losp.png">
  <link rel="stylesheet" href="../css/admin_styles.css">

</head>
<body>

  <!-- SIDEBAR NAVIGATION -->
  <aside class="admin-sidebar">
    <div class="logo-section">
      <img src="../images/lph.png" alt="Logo">
      <div>
        <p class="brand-name">Los Pollos Hermanos Admin</p>
        <p class="brand-subtitle">Dashboard</p>
      </div>
    </div>

    <ul class="sidebar-nav">
      <li>
        <a href="javascript:void(0)" onclick="switchTab('jobs-panel')" class="active">
          <span class="sidebar-icon">📋</span>
          Jobs Management
        </a>
      </li>
      <li>
        <a href="javascript:void(0)" onclick="switchTab('applicants-panel')">
          <span class="sidebar-icon">👥</span>
          Job Applicants
        </a>
      </li>
      <li>
        <a href="javascript:void(0)" onclick="switchTab('inquiry-panel')">
          <span class="sidebar-icon">💬</span>
          Inquiries
        </a>
      </li>
    </ul>
  </aside>

  <!-- MAIN CONTENT -->
  <div class="main-content">
    <div class="admin-header">
      <div>
        <h1 class="admin-title">Management Dashboard</h1>
        <p class="header-subtitle">View and manage jobs and applicant submissions</p>
      </div>
    </div>

    <div class="admin-stats">
      <div class="stat-card">
        <div class="stat-label">Total Jobs</div>
        <div class="stat-number" id="total-jobs">0</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Total Applicants</div>
        <div class="stat-number" id="total-applicants">0</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Total Inquiries</div>
        <div class="stat-number" id="total-inquiries">0</div>
      </div>
    </div>

    <div class="admin-tabs" role="tablist">
      <button class="tab active" data-target="jobs-panel" role="tab" aria-selected="true">📋 Jobs</button>
      <button class="tab" data-target="applicants-panel" role="tab" aria-selected="false">👥 Job Applicants</button>
      <button class="tab" data-target="inquiry-panel" role="tab" aria-selected="false">💬 Inquiries</button>
    </div>

    <div id="jobs-panel" class="panel active" role="tabpanel">
      <h2>Jobs Management</h2>
      <p class="panel-desc">Overview of all job listings</p>
      <div class="table-wrapper">
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
    </div>

    <div id="applicants-panel" class="panel" role="tabpanel">
      <h2>Job Applicants</h2>
      <p class="panel-desc">Overview of job applications submitted</p>
      <div class="table-wrapper">
        <table id="applicants-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Job Applied</th>
              <th>Message / Pitch</th>
              <th>Application Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>

    <div id="inquiry-panel" class="panel" role="tabpanel">
      <h2>Inquiries</h2>
      <p class="panel-desc">Overview of customer inquiries and messages</p>
      <div class="table-wrapper">
        <table id="inquiry-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Message</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal for viewing applicants by job -->
  <div id="job-applicants-modal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Applicants for <span id="modal-job-title"></span></h2>
        <button class="modal-close" onclick="closeJobApplicantsModal()">✕</button>
      </div>
      <div class="modal-body">
        <div class="job-info">
          <h3 id="modal-job-title-info"></h3>
          <p><strong>Branch:</strong> <span id="modal-job-branch"></span></p>
          <p><strong>Status:</strong> <span id="modal-job-status"></span></p>
        </div>
        <div class="table-wrapper">
          <table id="modal-applicants-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message / Pitch</th>
                <th>Application Date</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for viewing Applicant details -->
  <div id="applicant-details-modal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
      <div class="modal-header">
        <h2>Applicant Details (ID: <span id="modal-applicant-id"></span>)</h2>
        <button class="modal-close" onclick="closeApplicantDetailsModal()">✕</button>
      </div>
      <div class="modal-body">
        <div class="job-info">
          <p><strong>Name:</strong> <span id="modal-applicant-name"></span></p>
          <p><strong>Email:</strong> <span id="modal-applicant-email"></span></p>
          <p><strong>Applying For:</strong> <span id="modal-applicant-job"></span></p>
          <p><strong>Date Submitted:</strong> <span id="modal-applicant-date"></span></p>
        </div>
        
        <h3>Full Message / Pitch:</h3>
        <p id="modal-applicant-message" style="
          white-space: pre-wrap; 
          background: #f0f0f0; 
          padding: 15px; 
          border-radius: 8px;
          border-left: 3px solid #ff6b6b;
        "></p>
        
        <div style="text-align: right; margin-top: 20px;">
          <button onclick="closeApplicantDetailsModal()">Close</button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Modal for viewing inquiries details -->
   <div id="inquiry-details-modal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Inquiry Details (ID: <span id="modal-inquiry-id"></span>)</h2>
        <button class="modal-close" onclick="closeInquiryDetailsModal()">✕</button>
      </div>
      <div class="modal-body">
        <div class="job-info">
          <p><strong>Name:</strong> <span id="modal-inquiry-name"></span></p>
          <p><strong>Email:</strong> <span id="modal-inquiry-email"></span></p>
          <p><strong>Status:</strong> <span id="modal-inquiry-status" class="status-badge"></span></p>
        </div>
        
        <h3>Message:</h3>
        <p id="modal-inquiry-message" style="
          white-space: pre-wrap; 
          background: #f0f0f0; 
          padding: 15px; 
          border-radius: 8px;
          border-left: 3px solid #ccc;
        "></p>
        
        <div style="text-align: right; margin-top: 20px;">
          <button id="mark-seen-button" onclick="markInquiryAsSeen(this.getAttribute('data-id'))" data-id="" disabled>
            Mark as Seen
          </button>
        </div>
      </div>
    </div>
  </div>


  <script src="admin_script.js"></script>

</body>
</html>