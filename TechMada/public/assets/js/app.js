/* ============================================================
   MadaTech — Global JavaScript
   UI Interactions, No Backend
   ============================================================ */

'use strict';

// ── Sidebar toggle ──────────────────────────────────────────
function initSidebar() {
  const toggle  = document.querySelector('.menu-toggle');
  const sidebar = document.querySelector('.sidebar');
  const overlay = document.querySelector('.sidebar-overlay');

  if (!toggle || !sidebar) return;

  toggle.addEventListener('click', () => {
    sidebar.classList.toggle('open');
    overlay.classList.toggle('show');
  });

  overlay?.addEventListener('click', () => {
    sidebar.classList.remove('open');
    overlay.classList.remove('show');
  });
}

// ── Dropdown menus ─────────────────────────────────────────
function initDropdowns() {
  document.querySelectorAll('[data-dropdown]').forEach(trigger => {
    const menuId = trigger.dataset.dropdown;
    const menu   = document.getElementById(menuId);
    if (!menu) return;

    trigger.addEventListener('click', e => {
      e.stopPropagation();
      const isOpen = menu.classList.contains('open');
      closeAllDropdowns();
      if (!isOpen) menu.classList.add('open');
    });
  });

  document.addEventListener('click', closeAllDropdowns);
}

function closeAllDropdowns() {
  document.querySelectorAll('.dropdown-menu.open, .notif-panel.open').forEach(el => {
    el.classList.remove('open');
  });
}

// ── Modal ──────────────────────────────────────────────────
function openModal(id) {
  const overlay = document.getElementById(id);
  if (overlay) {
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
  }
}

function closeModal(id) {
  const overlay = document.getElementById(id);
  if (overlay) {
    overlay.classList.remove('open');
    document.body.style.overflow = '';
  }
}

function initModals() {
  document.querySelectorAll('[data-modal-open]').forEach(btn => {
    btn.addEventListener('click', () => openModal(btn.dataset.modalOpen));
  });

  document.querySelectorAll('[data-modal-close]').forEach(btn => {
    btn.addEventListener('click', () => closeModal(btn.dataset.modalClose));
  });

  document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', e => {
      if (e.target === overlay) closeModal(overlay.id);
    });
  });

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      document.querySelectorAll('.modal-overlay.open').forEach(o => {
        closeModal(o.id);
      });
    }
  });
}

// ── Notifications panel ────────────────────────────────────
function initNotifications() {
  const btn   = document.querySelector('.notif-toggle');
  const panel = document.querySelector('.notif-panel');
  if (!btn || !panel) return;

  btn.addEventListener('click', e => {
    e.stopPropagation();
    panel.classList.toggle('open');
  });

  document.addEventListener('click', e => {
    if (!panel.contains(e.target)) panel.classList.remove('open');
  });
}

// ── Tabs ──────────────────────────────────────────────────
function initTabs() {
  document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('click', () => {
      const group = tab.closest('.tabs');
      group.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');

      const target = tab.dataset.tab;
      if (target) {
        document.querySelectorAll('[data-tab-content]').forEach(c => {
          c.style.display = c.dataset.tabContent === target ? '' : 'none';
        });
      }
    });
  });
}

// ── Toast notifications ────────────────────────────────────
function showToast(title, msg, type = 'info') {
  const icons = { success: '✅', error: '❌', warning: '⚠️', info: 'ℹ️' };
  const colors = { success: 'var(--success)', error: 'var(--danger)', warning: 'var(--warning)', info: 'var(--blue)' };

  let container = document.querySelector('.toast-container');
  if (!container) {
    container = document.createElement('div');
    container.className = 'toast-container';
    document.body.appendChild(container);
  }

  const toast = document.createElement('div');
  toast.className = 'toast';
  toast.innerHTML = `
    <div class="toast-icon" style="background:${colors[type]}20; color:${colors[type]};">${icons[type]}</div>
    <div class="flex-1">
      <div class="toast-title">${title}</div>
      <div class="toast-msg">${msg}</div>
    </div>
    <span class="toast-close" onclick="this.closest('.toast').remove()">✕</span>
  `;

  container.appendChild(toast);
  setTimeout(() => toast.remove(), 4000);
}

// ── Checkbox toggle ───────────────────────────────────────
function initCheckboxes() {
  document.querySelectorAll('.custom-check').forEach(cb => {
    cb.addEventListener('click', () => cb.classList.toggle('checked'));
  });
}

// ── Pagination ────────────────────────────────────────────
function initPagination() {
  document.querySelectorAll('.page-item:not(.dots)').forEach(item => {
    item.addEventListener('click', () => {
      const group = item.closest('.pagination');
      group?.querySelectorAll('.page-item').forEach(p => p.classList.remove('active'));
      item.classList.add('active');
    });
  });
}

// ── Calendar ──────────────────────────────────────────────
function initCalendar(containerId) {
  const container = document.getElementById(containerId);
  if (!container) return;

  const now = new Date();
  let month = now.getMonth();
  let year  = now.getFullYear();

  const leavesDays = [5, 6, 14, 15, 22];
  const holidays   = [1, 11];

  function render() {
    const first = new Date(year, month, 1).getDay();
    const days  = new Date(year, month + 1, 0).getDate();
    const months = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];

    const prevDays = (first + 6) % 7;

    let html = `
      <div class="flex items-center justify-between mb-4">
        <button class="btn btn-ghost btn-sm btn-icon" onclick="calPrev('${containerId}')">‹</button>
        <span class="font-display font-bold text-sm">${months[month]} ${year}</span>
        <button class="btn btn-ghost btn-sm btn-icon" onclick="calNext('${containerId}')">›</button>
      </div>
      <div class="cal-header">
        ${['Lu','Ma','Me','Je','Ve','Sa','Di'].map(d => `<div class="cal-day-name">${d}</div>`).join('')}
      </div>
      <div class="calendar-grid">
    `;

    const prevMonthDays = new Date(year, month, 0).getDate();
    for (let i = prevDays - 1; i >= 0; i--) {
      html += `<div class="cal-day other-month">${prevMonthDays - i}</div>`;
    }

    for (let d = 1; d <= days; d++) {
      const isToday   = d === now.getDate() && month === now.getMonth() && year === now.getFullYear();
      const isLeave   = leavesDays.includes(d);
      const isHoliday = holidays.includes(d);
      let cls = 'cal-day';
      if (isToday)   cls += ' today';
      if (isLeave)   cls += ' leave';
      if (isHoliday) cls += ' holiday';
      html += `<div class="${cls}" onclick="calSelect(this)">${d}</div>`;
    }

    const remaining = 42 - prevDays - days;
    for (let d = 1; d <= remaining; d++) {
      html += `<div class="cal-day other-month">${d}</div>`;
    }

    html += `</div>`;
    container.innerHTML = html;
    container._month = month;
    container._year  = year;
  }

  window.calPrev = (id) => {
    month--;
    if (month < 0) { month = 11; year--; }
    render();
  };

  window.calNext = (id) => {
    month++;
    if (month > 11) { month = 0; year++; }
    render();
  };

  window.calSelect = (el) => {
    container.querySelectorAll('.cal-day.selected').forEach(d => d.classList.remove('selected'));
    el.classList.add('selected');
  };

  render();
}

// ── Progress bars ─────────────────────────────────────────
function animateProgressBars() {
  document.querySelectorAll('.progress-fill[data-width]').forEach(bar => {
    setTimeout(() => {
      bar.style.width = bar.dataset.width + '%';
    }, 100);
  });
}

// ── Animated counters ─────────────────────────────────────
function animateCounters() {
  document.querySelectorAll('[data-count]').forEach(el => {
    const target = parseInt(el.dataset.count);
    const duration = 800;
    const start = performance.now();

    function update(now) {
      const elapsed = now - start;
      const progress = Math.min(elapsed / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      el.textContent = Math.round(eased * target);
      if (progress < 1) requestAnimationFrame(update);
    }

    requestAnimationFrame(update);
  });
}

// ── Fake chart bars ────────────────────────────────────────
function renderChartBars(data, containerId) {
  const container = document.getElementById(containerId);
  if (!container) return;

  const max = Math.max(...data.map(d => d.value));

  const barsHtml = data.map(d => {
    const pct = (d.value / max) * 100;
    const cls  = d.color || 'blue';
    return `<div class="chart-bar ${cls}" data-value="${d.value}" style="height:${pct}%" title="${d.label}: ${d.value}"></div>`;
  }).join('');

  const labelsHtml = data.map(d => `<div class="chart-label">${d.label}</div>`).join('');

  container.innerHTML = `
    <div class="chart-bars">${barsHtml}</div>
    <div class="chart-labels">${labelsHtml}</div>
  `;
}

// ── Active nav item ────────────────────────────────────────
function setActiveNav() {
  const path = window.location.pathname.split('/').pop();
  document.querySelectorAll('.nav-item').forEach(item => {
    const href = item.getAttribute('href') || '';
    if (href && href.includes(path)) {
      item.classList.add('active');
    }
  });
}

// ── Row action buttons ─────────────────────────────────────
function initTableActions() {
  document.querySelectorAll('[data-action]').forEach(btn => {
    btn.addEventListener('click', e => {
      const action = btn.dataset.action;
      const row    = btn.closest('tr');
      const name   = row?.querySelector('.table-user-name')?.textContent || 'cet élément';

      if (action === 'approve') {
        const badge = row.querySelector('.badge');
        if (badge) {
          badge.className = 'badge badge-approved';
          badge.innerHTML = '<span></span> Approuvé';
        }
        showToast('Demande approuvée', `La demande de ${name} a été approuvée.`, 'success');
      }

      if (action === 'reject') {
        const badge = row.querySelector('.badge');
        if (badge) {
          badge.className = 'badge badge-rejected';
          badge.innerHTML = '<span></span> Refusé';
        }
        showToast('Demande refusée', `La demande de ${name} a été refusée.`, 'error');
      }

      if (action === 'delete') {
        showToast('Supprimé', `${name} a été supprimé.`, 'warning');
        row?.remove();
      }

      if (action === 'edit') {
        openModal('modal-edit');
      }
    });
  });
}

// ── Form submit ────────────────────────────────────────────
function initForms() {
  document.querySelectorAll('[data-submit]').forEach(btn => {
    btn.addEventListener('click', () => {
      const msg   = btn.dataset.submit;
      const modal = btn.closest('.modal-overlay');
      showToast('Succès', msg, 'success');
      if (modal) closeModal(modal.id);
    });
  });
}

// ── Init all ──────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  initSidebar();
  initDropdowns();
  initModals();
  initNotifications();
  initTabs();
  initCheckboxes();
  initPagination();
  initTableActions();
  initForms();
  animateProgressBars();
  animateCounters();
  setActiveNav();
});