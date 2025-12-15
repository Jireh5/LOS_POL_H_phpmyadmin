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
        
        // NEW: Store applicants globally for modal lookup
        allApplicants = rows;
        
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
              <td><button class="view-applicant-btn" data-id="${id}">View</button></td>
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
      fetchInquiries(); // This must be called to populate allInquiries

      // Add event listeners to view buttons for jobs (EXISTING LOGIC)
      document.addEventListener('click', (e) => {
        if (e.target.classList.contains('view-job')) {
          const jobId = e.target.getAttribute('data-id');
          const jobTitle = e.target.closest('tr').querySelector('td:nth-child(2)').textContent;
          const branch = e.target.closest('tr').querySelector('td:nth-child(6)').textContent;
          const status = e.target.closest('tr').querySelector('.status-badge').textContent;
          openJobApplicantsModal(jobId, jobTitle, branch, status);
        }
      });
      
      // Event delegation for both inquiry and applicant view buttons
      document.addEventListener('click', (e) => {
        // Inquiry View Button Logic
        if (e.target.classList.contains('view-inquiry-btn')) {
          const inquiryId = e.target.getAttribute('data-id');
          const inquiryData = allInquiries.find(i => String(i.inqID) === inquiryId);
          
          if (inquiryData) {
            openInquiryDetailsModal(inquiryData);
          }
        }
        
        // NEW: Applicant View Button Logic
        if (e.target.classList.contains('view-applicant-btn')) {
          const applicantId = e.target.getAttribute('data-id');
          // Important: Searches the allApplicants array
          const applicantData = allApplicants.find(a => String(a.a_formID ?? a.id) === applicantId);
          
          if (applicantData) {
            openApplicantDetailsModal(applicantData);
          }
        }
      });
      // End of DOMContentLoaded block
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
        
        if (json.success === false) {
          throw new Error(json.error || 'Unknown error');
        }
        
        const rows = json.data ?? [];
        if (!Array.isArray(rows)) throw new Error('Invalid response format');
        
        allInquiries = rows; 
        
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
          
          const isUnread = !(r.seen && Number(r.seen) === 1); 
          const wrapTag = isUnread ? 'strong' : 'span'; 

          return `
            <tr>
              <td><${wrapTag}>${id}</${wrapTag}></td>
              <td><${wrapTag}>${name}</${wrapTag}></td>
              <td><${wrapTag}>${email}</${wrapTag}></td>
              <td><${wrapTag}>${message}${message ? '…' : ''}</${wrapTag}></td>
              <td><button class="view-inquiry-btn" data-id="${id}">View</button></td>
            </tr>`;
        }).join('');
      } catch (err) {
        tbody.innerHTML = `<tr><td colspan="5" class="placeholder">Error loading inquiries: ${escapeHtml(err.message)}</td></tr>`;
        console.error(err);
      }
    }

    // Open modal showing full applicant details
    function openApplicantDetailsModal(applicantData) {
      document.getElementById('modal-applicant-id').textContent = applicantData.a_formID ?? applicantData.id ?? '';
      document.getElementById('modal-applicant-name').textContent = applicantData.Name ?? applicantData.name ?? '';
      document.getElementById('modal-applicant-email').textContent = applicantData.email;
      document.getElementById('modal-applicant-job').textContent = applicantData.job_applied;
      document.getElementById('modal-applicant-date').textContent = applicantData.app_date ?? applicantData.created_at ?? applicantData.submitted_at ?? '';
      document.getElementById('modal-applicant-message').textContent = applicantData.applicant_info;

      document.getElementById('applicant-details-modal').classList.add('active');
    }

    // Close the applicant modal
    function closeApplicantDetailsModal() {
      document.getElementById('applicant-details-modal').classList.remove('active');
    }

    // Function to handle marking an inquiry as seen
    async function markInquiryAsSeen(inqID) {
      // Disable button while processing
      const markSeenBtn = document.getElementById('mark-seen-button');
      markSeenBtn.disabled = true;

      try {
        const formData = new FormData();
        formData.append('id', inqID);

        const res = await fetch('./mark_inquiry_seen.php', {
          method: 'POST',
          body: formData
        });

        const json = await res.json();

        if (json.success) {
          // Action proceeds without an alert
          closeInquiryDetailsModal(); // Close modal
          fetchInquiries(); // Refresh the table to remove bolding
        } else {
          // Log the failure silently to the console
          throw new Error(json.error || 'Unknown error occurred.');
        }
      } catch (err) {
        console.error('Failed to update inquiry status:', err); // Log the error to the console
      } finally {
        markSeenBtn.disabled = false; 
      }
    }

    // Global variable to store all fetched data for quick access
    let allInquiries = [];
    let allApplicants = [];

    // Open modal showing full inquiry details
    function openInquiryDetailsModal(inquiryData) {
      document.getElementById('modal-inquiry-id').textContent = inquiryData.inqID;
      document.getElementById('modal-inquiry-name').textContent = inquiryData.name;
      document.getElementById('modal-inquiry-email').textContent = inquiryData.email;
      document.getElementById('modal-inquiry-message').textContent = inquiryData.message;

      const isUnread = !(inquiryData.seen && Number(inquiryData.seen) === 1); 
      const statusText = isUnread ? 'Unseen' : 'Seen';
      const statusClass = isUnread ? 'status-filled' : 'status-open'; // Using status-filled for Unseen

      const statusBadge = document.getElementById('modal-inquiry-status');
      statusBadge.textContent = statusText;
      statusBadge.className = `status-badge ${statusClass}`;
      
      const markSeenBtn = document.getElementById('mark-seen-button');
      markSeenBtn.setAttribute('data-id', inquiryData.inqID);
      markSeenBtn.disabled = !isUnread; // Only enable if it's unread

      document.getElementById('inquiry-details-modal').classList.add('active');

      // If it's unread, immediately mark it as seen upon opening the modal
      if (isUnread) {
         // You can either mark it seen here, or wait for the button click.
         // Per your request, we will wait for the button click.
      }
    }

    // Close the inquiry modal
    function closeInquiryDetailsModal() {
      document.getElementById('inquiry-details-modal').classList.remove('active');
    }

    // Close modal when clicking outside (for the new modal)
    document.addEventListener('click', (e) => {
      const modal = document.getElementById('inquiry-details-modal');
      if (e.target === modal) {
        closeInquiryDetailsModal();
      }
    });

