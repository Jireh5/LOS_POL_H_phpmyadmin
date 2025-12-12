<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin — Los Pollos Hermanos</title>
  <title>Admin — Los Pollos Hermanos</title>
  <link rel="icon" type="image/png" href="images/losp.png">
  <link rel="stylesheet" href="styles.css">
  <style>
    * { box-sizing: border-box; }
    
    body {
      background: linear-gradient(135deg, rgba(245, 247, 250, 0.4) 20%, rgba(195, 207, 226, 0.4) 100%), 
                  url('images/los3.jpg') center/cover fixed no-repeat;
      background-attachment: fixed;
      padding: 0;
      margin: 0;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
      min-height: 100vh;
    }

    /* Sidebar Navigation */
    .admin-sidebar {
      position: fixed;
      left: 0;
      top: 0;
      width: 280px;
      height: 100vh;
      background: linear-gradient(180deg, #1a1a1a 0%, #2d2d2d 100%);
      padding: 30px 20px;
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.15);
      overflow-y: auto;
      z-index: 1000;
    }

    .admin-sidebar .logo-section {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 40px;
      padding-bottom: 20px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .admin-sidebar .logo-section img {
      height: 40px;
      width: auto;
    }

    .admin-sidebar .brand-name {
      color: #fff;
      font-size: 18px;
      font-weight: 700;
      margin: 0;
    }

    .admin-sidebar .brand-subtitle {
      color: #ff6b6b;
      font-size: 12px;
      margin: 0;
      font-weight: 500;
      letter-spacing: 0.5px;
    }

    .sidebar-nav {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .sidebar-nav li {
      margin-bottom: 8px;
    }

    .sidebar-nav a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      color: #ccc;
      text-decoration: none;
      border-radius: 8px;
      transition: all 0.3s ease;
      cursor: pointer;
      font-weight: 500;
      font-size: 15px;
    }

    .sidebar-nav a:hover,
    .sidebar-nav a.active {
      background: #ff6b6b;
      color: #fff;
      transform: translateX(4px);
    }

    .sidebar-icon {
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Main Content Area */
    .main-content {
      margin-left: 280px;
      padding: 40px;
    }

    .admin-header {
      background: white;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      margin-bottom: 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .admin-title {
      font-size: 32px;
      font-weight: 700;
      margin: 0;
      color: #1a1a1a;
    }

    .header-subtitle {
      color: #666;
      font-size: 14px;
      margin-top: 6px;
    }

    .admin-stats {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      margin-bottom: 40px;
    }

    .stat-card {
      background: white;
      padding: 24px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      border-left: 4px solid #ff6b6b;
    }

    .stat-label {
      color: #666;
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 8px;
    }

    .stat-number {
      font-size: 32px;
      font-weight: 700;
      color: #1a1a1a;
    }

    /* Tabs */
    .admin-tabs {
      display: flex;
      gap: 0;
      border-bottom: 2px solid white;
      background: white;
      border-radius: 12px 12px 0 0;
      padding: 0 40px;
      margin: 0;
    }

    .tab {
      padding: 16px 28px;
      border: none;
      background: transparent;
      cursor: pointer;
      font-size: 15px;
      font-weight: 600;
      color: #999;
      border-bottom: 3px solid transparent;
      margin-bottom: -2px;
      transition: all 0.3s ease;
      position: relative;
    }

    .tab:hover {
      color: #1a1a1a;
    }

    .tab.active {
      color: #ff6b6b;
      border-bottom-color: #ff6b6b;
    }

    /* Panels */
    .panel {
      display: none;
      background: white;
      padding: 40px;
      border-radius: 0 0 12px 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      animation: slideIn 0.3s ease;
    }

    .panel.active {
      display: block;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .panel h2 {
      font-size: 24px;
      margin: 0 0 8px 0;
      color: #1a1a1a;
    }

    .panel-desc {
      color: #999;
      font-size: 14px;
      margin-bottom: 28px;
    }

    /* Tables */
    .table-wrapper {
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      border: 1px solid #f0f0f0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th {
      background: #f9f9f9;
      padding: 16px;
      text-align: left;
      font-weight: 700;
      font-size: 13px;
      color: #1a1a1a;
      border-bottom: 2px solid #f0f0f0;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    td {
      padding: 16px;
      border-bottom: 1px solid #f5f5f5;
      font-size: 14px;
      color: #333;
    }

    tbody tr {
      transition: all 0.2s ease;
    }

    tbody tr:hover {
      background: #fafafa;
    }

    tbody tr:last-child td {
      border-bottom: none;
    }

    .placeholder {
      color: #999;
      font-style: italic;
      font-size: 13px;
    }

    /* Status Badge */
    .status-badge {
      display: inline-block;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .status-open {
      background: #d4edda;
      color: #155724;
    }

    .status-filled {
      background: #f8d7da;
      color: #721c24;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 2000;
      align-items: center;
      justify-content: center;
    }

    .modal.active {
      display: flex;
    }

    .modal-content {
      background: white;
      border-radius: 12px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
      max-width: 90%;
      max-height: 90vh;
      overflow-y: auto;
      width: 100%;
      animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
      from {
        transform: scale(0.95);
        opacity: 0;
      }
      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    .modal-header {
      padding: 24px;
      border-bottom: 2px solid #f0f0f0;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .modal-header h2 {
      margin: 0;
      font-size: 24px;
      color: #1a1a1a;
    }

    .modal-close {
      background: transparent;
      border: none;
      font-size: 24px;
      cursor: pointer;
      color: #999;
      padding: 0;
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 6px;
      transition: all 0.2s ease;
    }

    .modal-close:hover {
      background: #f5f5f5;
      color: #1a1a1a;
    }

    .modal-body {
      padding: 24px;
    }

    .job-info {
      background: #f9f9f9;
      padding: 16px;
      border-radius: 8px;
      margin-bottom: 24px;
      border-left: 4px solid #ff6b6b;
    }

    .job-info h3 {
      margin: 0 0 8px 0;
      color: #1a1a1a;
    }

    .job-info p {
      margin: 4px 0;
      color: #666;
      font-size: 14px;
    }

    /* Buttons */
    button {
      padding: 8px 16px;
      border: 1px solid #ddd;
      border-radius: 6px;
      background: #fff;
      cursor: pointer;
      font-size: 13px;
      font-weight: 600;
      color: #333;
      transition: all 0.2s ease;
    }

    button:hover:not(:disabled) {
      background: #ff6b6b;
      color: white;
      border-color: #ff6b6b;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
    }

    button:disabled {
      color: #ccc;
      border-color: #eee;
      cursor: not-allowed;
      background: #f9f9f9;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .admin-sidebar {
        width: 0;
        padding: 0;
      }

      .main-content {
        margin-left: 0;
        padding: 20px;
      }

      .admin-header {
        padding: 20px;
        flex-direction: column;
        text-align: center;
      }

      .admin-title {
        font-size: 24px;
      }

      .admin-stats {
        grid-template-columns: 1fr;
      }

      .admin-tabs {
        padding: 0 20px;
      }

      .tab {
        padding: 12px 16px;
        font-size: 13px;
      }

      .panel {
        padding: 20px;
      }

      th, td {
        padding: 12px;
        font-size: 13px;
      }
    }
  </style>
  <style>
    * { box-sizing: border-box; }
    
    body {
      background: linear-gradient(135deg, rgba(245, 247, 250, 0.4) 20%, rgba(195, 207, 226, 0.4) 100%), 
                  url('images/los3.jpg') center/cover fixed no-repeat;
      background-attachment: fixed;
      padding: 0;
      margin: 0;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
      min-height: 100vh;
    }

    /* Sidebar Navigation */
    .admin-sidebar {
      position: fixed;
      left: 0;
      top: 0;
      width: 280px;
      height: 100vh;
      background: linear-gradient(180deg, #1a1a1a 0%, #2d2d2d 100%);
      padding: 30px 20px;
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.15);
      overflow-y: auto;
      z-index: 1000;
    }

    .admin-sidebar .logo-section {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 40px;
      padding-bottom: 20px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .admin-sidebar .logo-section img {
      height: 40px;
      width: auto;
    }

    .admin-sidebar .brand-name {
      color: #fff;
      font-size: 18px;
      font-weight: 700;
      margin: 0;
    }

    .admin-sidebar .brand-subtitle {
      color: #ff6b6b;
      font-size: 12px;
      margin: 0;
      font-weight: 500;
      letter-spacing: 0.5px;
    }

    .sidebar-nav {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .sidebar-nav li {
      margin-bottom: 8px;
    }

    .sidebar-nav a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      color: #ccc;
      text-decoration: none;
      border-radius: 8px;
      transition: all 0.3s ease;
      cursor: pointer;
      font-weight: 500;
      font-size: 15px;
    }

    .sidebar-nav a:hover,
    .sidebar-nav a.active {
      background: #ff6b6b;
      color: #fff;
      transform: translateX(4px);
    }

    .sidebar-icon {
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Main Content Area */
    .main-content {
      margin-left: 280px;
      padding: 40px;
    }

    .admin-header {
      background: white;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      margin-bottom: 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .admin-title {
      font-size: 32px;
      font-weight: 700;
      margin: 0;
      color: #1a1a1a;
    }

    .header-subtitle {
      color: #666;
      font-size: 14px;
      margin-top: 6px;
    }

    .admin-stats {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      margin-bottom: 40px;
    }

    .stat-card {
      background: white;
      padding: 24px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      border-left: 4px solid #ff6b6b;
    }

    .stat-label {
      color: #666;
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 8px;
    }

    .stat-number {
      font-size: 32px;
      font-weight: 700;
      color: #1a1a1a;
    }

    /* Tabs */
    .admin-tabs {
      display: flex;
      gap: 0;
      border-bottom: 2px solid white;
      background: white;
      border-radius: 12px 12px 0 0;
      padding: 0 40px;
      margin: 0;
    }

    .tab {
      padding: 16px 28px;
      border: none;
      background: transparent;
      cursor: pointer;
      font-size: 15px;
      font-weight: 600;
      color: #999;
      border-bottom: 3px solid transparent;
      margin-bottom: -2px;
      transition: all 0.3s ease;
      position: relative;
    }

    .tab:hover {
      color: #1a1a1a;
    }

    .tab.active {
      color: #ff6b6b;
      border-bottom-color: #ff6b6b;
    }

    /* Panels */
    .panel {
      display: none;
      background: white;
      padding: 40px;
      border-radius: 0 0 12px 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      animation: slideIn 0.3s ease;
    }

    .panel.active {
      display: block;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .panel h2 {
      font-size: 24px;
      margin: 0 0 8px 0;
      color: #1a1a1a;
    }

    .panel-desc {
      color: #999;
      font-size: 14px;
      margin-bottom: 28px;
    }

    /* Tables */
    .table-wrapper {
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      border: 1px solid #f0f0f0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th {
      background: #f9f9f9;
      padding: 16px;
      text-align: left;
      font-weight: 700;
      font-size: 13px;
      color: #1a1a1a;
      border-bottom: 2px solid #f0f0f0;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    td {
      padding: 16px;
      border-bottom: 1px solid #f5f5f5;
      font-size: 14px;
      color: #333;
    }

    tbody tr {
      transition: all 0.2s ease;
    }

    tbody tr:hover {
      background: #fafafa;
    }

    tbody tr:last-child td {
      border-bottom: none;
    }

    .placeholder {
      color: #999;
      font-style: italic;
      font-size: 13px;
    }

    /* Status Badge */
    .status-badge {
      display: inline-block;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .status-open {
      background: #d4edda;
      color: #155724;
    }

    .status-filled {
      background: #f8d7da;
      color: #721c24;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 2000;
      align-items: center;
      justify-content: center;
    }

    .modal.active {
      display: flex;
    }

    .modal-content {
      background: white;
      border-radius: 12px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
      max-width: 90%;
      max-height: 90vh;
      overflow-y: auto;
      width: 100%;
      animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
      from {
        transform: scale(0.95);
        opacity: 0;
      }
      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    .modal-header {
      padding: 24px;
      border-bottom: 2px solid #f0f0f0;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .modal-header h2 {
      margin: 0;
      font-size: 24px;
      color: #1a1a1a;
    }

    .modal-close {
      background: transparent;
      border: none;
      font-size: 24px;
      cursor: pointer;
      color: #999;
      padding: 0;
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 6px;
      transition: all 0.2s ease;
    }

    .modal-close:hover {
      background: #f5f5f5;
      color: #1a1a1a;
    }

    .modal-body {
      padding: 24px;
    }

    .job-info {
      background: #f9f9f9;
      padding: 16px;
      border-radius: 8px;
      margin-bottom: 24px;
      border-left: 4px solid #ff6b6b;
    }

    .job-info h3 {
      margin: 0 0 8px 0;
      color: #1a1a1a;
    }

    .job-info p {
      margin: 4px 0;
      color: #666;
      font-size: 14px;
    }

    /* Buttons */
    button {
      padding: 8px 16px;
      border: 1px solid #ddd;
      border-radius: 6px;
      background: #fff;
      cursor: pointer;
      font-size: 13px;
      font-weight: 600;
      color: #333;
      transition: all 0.2s ease;
    }

    button:hover:not(:disabled) {
      background: #ff6b6b;
      color: white;
      border-color: #ff6b6b;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
    }

    button:disabled {
      color: #ccc;
      border-color: #eee;
      cursor: not-allowed;
      background: #f9f9f9;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .admin-sidebar {
        width: 0;
        padding: 0;
      }

      .main-content {
        margin-left: 0;
        padding: 20px;
      }

      .admin-header {
        padding: 20px;
        flex-direction: column;
        text-align: center;
      }

      .admin-title {
        font-size: 24px;
      }

      .admin-stats {
        grid-template-columns: 1fr;
      }

      .admin-tabs {
        padding: 0 20px;
      }

      .tab {
        padding: 12px 16px;
        font-size: 13px;
      }

      .panel {
        padding: 20px;
      }

      th, td {
        padding: 12px;
        font-size: 13px;
      }
    }
  </style>
</head>
<body>

  <!-- SIDEBAR NAVIGATION -->
  <aside class="admin-sidebar">
    <div class="logo-section">
      <img src="images/lph.png" alt="Logo">
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

  <script>
    // Function to switch tabs (called from nav links or buttons)
    function switchTab(panelId) {
      document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
      
      // Update sidebar active state
      document.querySelectorAll('.sidebar-nav a').forEach(a => a.classList.remove('active'));
      const sidebarLink = document.querySelector(`.sidebar-nav a[onclick*="'${panelId}'"]`);
      if (sidebarLink) sidebarLink.classList.add('active');
      
      // Find and activate the corresponding button
      const btn = document.querySelector(`.tab[data-target="${panelId}"]`);
      if (btn) {
        btn.classList.add('active');
        btn.setAttribute('aria-selected', 'true');
      }
      
      // Activate the panel
      const target = document.getElementById(panelId);
      if (target) {
        target.classList.add('active');
      }
    }

    // Tab switching logic (client-side only)
    document.querySelectorAll('.tab').forEach(btn => {
      btn.addEventListener('click', () => {
        const panelId = btn.getAttribute('data-target');
        switchTab(panelId);
      });
    });

    // Fetch and render Jobs
    async function fetchJobs() {
      const tbody = document.querySelector('#jobs-table tbody');
      tbody.innerHTML = '<tr><td colspan="8"><div class="placeholder">Loading jobs…</div></td></tr>';
      try {
        const res = await fetch('./fetch_jobs.php');
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const json = await res.json();
        if (!json.data) throw new Error('Invalid response');
        const rows = json.data;
        
        // Update stats
        document.getElementById('total-jobs').textContent = rows.length;
        
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
          const isFilled = r.position_filled && Number(r.position_filled) === 1;
          const status = isFilled ? 'Filled' : 'Open';
          const statusClass = isFilled ? 'status-filled' : 'status-open';
          return `
            <tr>
              <td>${id}</td>
              <td><strong>${title}</strong></td>
              <td>${description}</td>
              <td>${responsibilities}</td>
              <td>${skills}</td>
              <td>${branch}</td>
              <td><span class="status-badge ${statusClass}">${status}</span></td>
              <td>
                <button data-id="${id}" class="view-job">View Applicants</button>
              </td>
            </tr>`;
        }).join('');
      } catch (err) {
        tbody.innerHTML = `<tr><td colspan="8" class="placeholder">Error loading jobs: ${escapeHtml(err.message)}</td></tr>`;
        console.error(err);
      }
    }

    // Fetch and render Applicants
    async function fetchApplicants() {
      const tbody = document.querySelector('#applicants-table tbody');
      tbody.innerHTML = '<tr><td colspan="7"><div class="placeholder">Loading applicants…</div></td></tr>';
      try {
        const res = await fetch('./fetch_applicants.php');
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const json = await res.json();
        if (!json.data) throw new Error('Invalid response');
        const rows = json.data;
        
        // Update stats
        document.getElementById('total-applicants').textContent = rows.length;
        
        if (!rows.length) {
          tbody.innerHTML = '<tr><td colspan="7" class="placeholder">No applicants found.</td></tr>';
          return;
        }

        tbody.innerHTML = rows.map(r => {
          // Map exact DB column names from fetch_applicants.php
          const id = r.a_formID ?? r.id ?? '';
          const name = escapeHtml(r.Name ?? r.name ?? '');
          const email = escapeHtml(r.email ?? '');
          const jobApplied = escapeHtml(r.job_applied ?? '');
          const message = escapeHtml((r.applicant_info ?? '').toString().substring(0, 100));
          const appDate = escapeHtml(r.app_date ?? r.created_at ?? r.submitted_at ?? '');
          return `
            <tr>
              <td>${id}</td>
              <td><strong>${name}</strong></td>
              <td>${email}</td>
              <td><strong>${jobApplied}</strong></td>
              <td>${message}${message ? '…' : ''}</td>
              <td>${appDate}</td>
              <td><button class="view-applicant" data-id="${id}">View</button></td>
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

    // Initialize page by fetching both datasets
    window.addEventListener('DOMContentLoaded', () => {
      fetchJobs();
      fetchApplicants();
      fetchInquiries();
      
      // Add event listeners to view buttons for jobs
      document.addEventListener('click', (e) => {
        if (e.target.classList.contains('view-job')) {
          const jobId = e.target.getAttribute('data-id');
          const jobTitle = e.target.closest('tr').querySelector('td:nth-child(2)').textContent;
          const branch = e.target.closest('tr').querySelector('td:nth-child(6)').textContent;
          const status = e.target.closest('tr').querySelector('.status-badge').textContent;
          openJobApplicantsModal(jobId, jobTitle, branch, status);
        }
      });
    });

    // Open modal showing applicants for a specific job
    function openJobApplicantsModal(jobId, jobTitle, branch, status) {
      document.getElementById('modal-job-title').textContent = jobTitle;
      document.getElementById('modal-job-title-info').textContent = jobTitle;
      document.getElementById('modal-job-branch').textContent = branch;
      document.getElementById('modal-job-status').textContent = status;
      
      // Fetch applicants for this job
      fetchApplicantsForJob(jobId, jobTitle);
      
      // Show modal
      document.getElementById('job-applicants-modal').classList.add('active');
    }

    // Close the modal
    function closeJobApplicantsModal() {
      document.getElementById('job-applicants-modal').classList.remove('active');
    }

    // Close modal when clicking outside
    document.addEventListener('click', (e) => {
      const modal = document.getElementById('job-applicants-modal');
      if (e.target === modal) {
        closeJobApplicantsModal();
      }
    });

    // Fetch applicants for a specific job
    async function fetchApplicantsForJob(jobId, jobTitle) {
      const tbody = document.querySelector('#modal-applicants-table tbody');
      tbody.innerHTML = '<tr><td colspan="5"><div class="placeholder">Loading applicants…</div></td></tr>';
      
      try {
        const res = await fetch('./fetch_applicants.php');
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const json = await res.json();
        if (!json.data) throw new Error('Invalid response');
        
        // Filter applicants for this job
        const rows = json.data.filter(r => {
          const appliedJob = escapeHtml(r.job_applied ?? '');
          return appliedJob === jobTitle;
        });
        
        if (!rows.length) {
          tbody.innerHTML = '<tr><td colspan="5" class="placeholder">No applicants for this job.</td></tr>';
          return;
        }

        tbody.innerHTML = rows.map(r => {
          const id = r.a_formID ?? r.id ?? '';
          const name = escapeHtml(r.Name ?? r.name ?? '');
          const email = escapeHtml(r.email ?? '');
          const message = escapeHtml((r.applicant_info ?? '').toString().substring(0, 150));
          const appDate = escapeHtml(r.app_date ?? r.created_at ?? r.submitted_at ?? '');
          return `
            <tr>
              <td>${id}</td>
              <td><strong>${name}</strong></td>
              <td>${email}</td>
              <td>${message}${message ? '…' : ''}</td>
              <td>${appDate}</td>
            </tr>`;
        }).join('');
      } catch (err) {
        tbody.innerHTML = `<tr><td colspan="5" class="placeholder">Error loading applicants: ${escapeHtml(err.message)}</td></tr>`;
        console.error(err);
      }
    }

    // Fetch and render Inquiries
    async function fetchInquiries() {
      const tbody = document.querySelector('#inquiry-table tbody');
      tbody.innerHTML = '<tr><td colspan="5"><div class="placeholder">Loading inquiries…</div></td></tr>';
      try {
        const res = await fetch('./fetch_inquiry.php');
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const json = await res.json();
        
        // Check for error in response
        if (json.success === false) {
          throw new Error(json.error || 'Unknown error');
        }
        
        // Get rows from data property
        const rows = json.data ?? [];
        if (!Array.isArray(rows)) throw new Error('Invalid response format');
        
        // Update stats
        document.getElementById('total-inquiries').textContent = rows.length;
        
        if (!rows.length) {
          tbody.innerHTML = '<tr><td colspan="5" class="placeholder">Empty - No inquiries found.</td></tr>';
          return;
        }

        tbody.innerHTML = rows.map(r => {
          const id = r.inqID ?? r.id ?? '';
          const name = escapeHtml(r.name ?? '');
          const email = escapeHtml(r.email ?? '');
          const message = escapeHtml((r.message ?? '').toString().substring(0, 100));
          return `
            <tr>
              <td>${id}</td>
              <td><strong>${name}</strong></td>
              <td>${email}</td>
              <td>${message}${message ? '…' : ''}</td>
              <td><button class="view-inquiry" data-id="${id}">View</button></td>
            </tr>`;
        }).join('');
      } catch (err) {
        tbody.innerHTML = `<tr><td colspan="5" class="placeholder">Error loading inquiries: ${escapeHtml(err.message)}</td></tr>`;
        console.error(err);
      }
    }
  </script>

</body>
</html>