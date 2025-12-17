document.addEventListener('DOMContentLoaded', () => {
  try {
    emailjs.init("qKsuBnK_Tkfr1NDnL");
  } catch (error) {
    console.error("EmailJS failed to load.", error);
  }

  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-img');
  const closeBtn = document.getElementById('lightbox-close');
  
  if (lightbox && lightboxImg) {
    document.querySelectorAll('.menu-item-card img').forEach(img => {
      img.style.cursor = 'pointer';
      img.addEventListener('click', () => {
        lightboxImg.src = img.src;
        lightbox.classList.add('open');
        lightbox.setAttribute('aria-hidden', 'false');
      });
    });

    if (closeBtn) {
      closeBtn.addEventListener('click', () => {
        lightbox.classList.remove('open');
        lightbox.setAttribute('aria-hidden', 'true');
      });
    }
    
    lightbox.addEventListener('click', (e) => {
        if(e.target === lightbox) {
            lightbox.classList.remove('open');
            lightbox.setAttribute('aria-hidden', 'true');
        }
    });
  }

  const jobs = [
    {
      id: 'asst-manager',
      title: 'Assistant Manager',
      location: 'Downtown Branch',
      status: 'open',
      description: 'Oversee daily operations, ensure quality standards, coordinate shifts.',
      responsibilities: ['Manage staff schedules', 'Quality control', 'Inventory oversight'],
      skills: ['Leadership', 'Customer service', 'Inventory basics']
    },
    {
      id: 'line-cook',
      title: 'Line Cook',
      location: 'Main Kitchen',
      status: 'filled',
      description: 'Prepare menu items according to standard recipes. Maintain cleanliness.',
      responsibilities: ['Cook menu items', 'Maintain temps', 'Prep ingredients'],
      skills: ['Speed & accuracy', 'Food safety', 'Teamwork', 'Culinary techniques', 'Ability to stay calm under pressure']
    },
    {
      id: 'delivery-driver',
      title: 'Delivery Driver',
      location: 'Citywide',
      status: 'open',
      description: 'Deliver orders safely and on time, represent the brand professionally.',
      responsibilities: ['Timely deliveries', 'Customer interaction', 'Vehicle upkeep'],
      skills: ['Navigation', 'Punctuality', 'Communication']
    },
    {
      id: 'front-staff',
      title: 'Front-of-House Staff',
      location: 'All Branches',
      status: 'open',
      description: 'Greet customers, take orders, and keep service fast and friendly.',
      responsibilities: ['Order taking', 'Cash handling', 'Customer care'],
      skills: ['Friendly attitude', 'Cash handling', 'Basic POS']
    }
  ];

  const jobsGrid = document.getElementById('jobs-grid');

  function getFilledJobs() {
    return JSON.parse(localStorage.getItem('filledPositions') || '{}');
  }

  function renderJobs() {
    if (!jobsGrid) return;
    
    jobsGrid.innerHTML = ''; 
    const filled = getFilledJobs();

    jobs.forEach(job => {
      const isFilled = job.status === 'filled' || filled[job.id];
      const card = document.createElement('div');
      card.className = 'job-card';

      card.innerHTML = `
        <h3>${job.title}</h3>
        <div class="chip">${job.location}</div>
        <p style="margin-top:8px;">${job.description}</p>
        <div style="margin-top:10px">
          <strong>Responsibilities:</strong>
          <ul>${job.responsibilities.map(r => `<li>${r}</li>`).join('')}</ul>
        </div>
        <div><strong>Required skills:</strong> ${job.skills.join(', ')}</div>
        <div class="job-actions">
          ${isFilled
            ? `<button class="cta secondary" disabled>Position Filled</button>`
            : `<button class="cta apply-btn" data-job="${job.id}">Apply Now</button>`
          }
          <button class="cta secondary details-btn" data-details="${job.id}">Details</button>
        </div>
      `;
      jobsGrid.appendChild(card);
    });

    attachJobEventListeners();
  }

  function attachJobEventListeners() {
    document.querySelectorAll('.apply-btn').forEach(btn => {
      btn.addEventListener('click', e => {
        const jobId = e.target.getAttribute('data-job');
        openApplyModal(jobId);
      });
    });

    document.querySelectorAll('.details-btn').forEach(btn => {
      btn.addEventListener('click', e => {
        const jobId = e.target.getAttribute('data-details');
        toggleDetails(jobId, e.target.closest('.job-card'));
      });
    });
  }

  function toggleDetails(jobId, card) {
    const job = jobs.find(j => j.id === jobId);
    const existing = card.querySelector('.more');
  
  if (existing) {
    existing.classList.add('closing');
    
    existing.addEventListener('animationend', () => {
      existing.remove();
    }, { once: true });

  } else {
    const div = document.createElement('div');
    div.className = 'more';
    div.innerHTML = `
      <div style="border-top: 1px dashed #ccc; margin-bottom: 8px;"></div>
      <em>Full Description:</em> ${job.description}<br>
      <strong>Skills:</strong> ${job.skills.join(', ')}
    `;
    
    const actions = card.querySelector('.job-actions');
    card.insertBefore(div, actions);
  }
}
  const applyModal = document.getElementById('apply-modal');
  const applyForm = document.getElementById('apply-form');
  const applyCancelBtn = document.getElementById('apply-cancel');
  let currentJobTitle = ""; 

  function openApplyModal(jobId) {
    const job = jobs.find(j => j.id === jobId);
    if (!job || !applyModal) return;

    //set state
    currentJobTitle = job.title;
    
    //modal ui
    const modalTitle = document.getElementById('modal-job-title');
    if(modalTitle) modalTitle.innerText = `Apply for: ${job.title}`;

    //show modal overlay
    applyModal.classList.add('open');
    applyModal.setAttribute('aria-hidden', 'false');
  }

  function closeApplyModal() {
    if (applyModal) {
      applyModal.classList.remove('open');
      applyModal.setAttribute('aria-hidden', 'true');
      if(applyForm) applyForm.reset();
    }
  }

  if (applyCancelBtn) {
    applyCancelBtn.addEventListener('click', closeApplyModal);
  }

  if (applyModal) {
      applyModal.addEventListener('click', (e) => {
          if (e.target === applyModal) {
              closeApplyModal();
          }
      });
  }

// submit
if (applyForm) {
  applyForm.addEventListener('submit', e => {
    e.preventDefault();

    // capture data before closing the modal
    const formData = {
      job_title: currentJobTitle,
      from_name: document.getElementById('app-name').value,
      reply_to: document.getElementById('app-email').value,
      message: document.getElementById('app-cv').value
    };

    // close modal
    closeApplyModal();

    // loading overlay elements
    const overlay = document.getElementById('status-overlay');
    const loader = document.getElementById('overlay-loader');
    const title = document.getElementById('overlay-title');
    const msg = document.getElementById('overlay-message');
    const okBtn = document.getElementById('overlay-ok-btn');

    // overlaying
    overlay.style.zIndex = "999999";
    overlay.className = 'overlay-visible';
    loader.style.display = 'block';
    okBtn.style.display = 'none';
    title.innerText = "Processing...";
    title.style.color = "#000";
    msg.innerText = "Please wait while we save your application to the database.";

    // *** DATABASE SUBMISSION LOGIC ***
    fetch('php/handle_application.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(formData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(() => {
        // SUCCESS HANDLING
        loader.style.display = 'none';
        title.innerText = "Application Saved!";
        title.style.color = "#2e7d32";
        msg.innerText = `Thank you, ${formData.from_name}. Your application has been logged.`;
        okBtn.style.display = 'inline-block';
        okBtn.innerText = "OK, Great!";

        okBtn.onclick = () => {
          overlay.className = 'overlay-hidden';
        };
    })
    .catch((error) => {
        // ERROR HANDLING
        console.error('DATABASE FAILED:', error);
        loader.style.display = 'none';
        title.innerText = "Submission Failed";
        title.style.color = "#c90a0a";
        msg.innerText = "We couldn't save your application to the database. Check console for details.";
        okBtn.style.display = 'inline-block';
        okBtn.innerText = "Close";

        okBtn.onclick = () => {
          overlay.className = 'overlay-hidden';
        };
    });
  });
}

renderJobs();
  
// contact form for general inquiries
const contactForm = document.getElementById('contact-form');
if (contactForm) {
  contactForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const overlay = document.getElementById('status-overlay');
    const loader = document.getElementById('overlay-loader');
    const title = document.getElementById('overlay-title');
    const msg = document.getElementById('overlay-message');
    const okBtn = document.getElementById('overlay-ok-btn');

    const templateParams = {
      from_name: document.getElementById('con-name').value,
      reply_to: document.getElementById('con-email').value,
      message: document.getElementById('con-message').value
    };

    overlay.style.zIndex = "999999";
    overlay.className = 'overlay-visible';
    loader.style.display = 'block';
    okBtn.style.display = 'none';
    title.innerText = "Processing...";
    title.style.color = "#000";
    msg.innerText = "Please wait while we save your inquiry to the database.";

    // *** DATABASE SUBMISSION LOGIC ***
    fetch('php/handle_inquiry.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(templateParams)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(() => {
        // SUCCESS HANDLING
        loader.style.display = 'none';
        title.innerText = "Inquiry Saved!";
        title.style.color = "#2e7d32";
        msg.innerText = `Thank you, ${templateParams.from_name}. Your message has been logged.`;
        okBtn.style.display = 'inline-block';
        okBtn.innerText = "Return to Site";

        okBtn.onclick = () => {
            overlay.className = 'overlay-hidden';
            contactForm.reset();
        };
    })
    .catch((error) => {
        // ERROR HANDLING
        console.error('DATABASE FAILED:', error);
        loader.style.display = 'none';
        title.innerText = "Submission Failed";
        title.style.color = "#c90a0a";
        msg.innerText = "We couldn't save your inquiry to the database. Check console for details.";
        okBtn.style.display = 'inline-block';
        okBtn.innerText = "Close";

        okBtn.onclick = () => {
            overlay.className = 'overlay-hidden';
        };
    });
  });
}
});



