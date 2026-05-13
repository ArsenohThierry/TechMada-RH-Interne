/* ============================================================
   MadaTech — Shared Layout Components
   Generates sidebar & topbar HTML dynamically
   ============================================================ */

const ROLE_EMPLOYEE = 'employee';
const ROLE_HR       = 'hr';
const ROLE_ADMIN    = 'admin';

const USERS = {
  employee: { name: 'Marie Dupont',    role: 'Développeuse Senior', initials: 'MD', color: 'var(--grad-rose)' },
  hr:       { name: 'Sophie Laurent',  role: 'Responsable RH',      initials: 'SL', color: 'var(--grad-blue)' },
  admin:    { name: 'Thomas Bernard',  role: 'Administrateur',      initials: 'TB', color: 'var(--grad-mix)'  },
};

// SVG Icons
const ICONS = {
  dashboard: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>',
  calendar: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
  list: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>',
  chart: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="2" x2="12" y2="22"/><path d="M17 5H9.5a1.5 1.5 0 0 0-1.5 1.5v12a1.5 1.5 0 0 0 1.5 1.5H17"/><polyline points="21 12 17 9 13 13 9 9"/></svg>',
  user: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
  bell: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>',
  check: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>',
  document: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>',
  users: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
  building: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 21v-3a2 2 0 0 1 2-2h3V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v11h3a2 2 0 0 1 2 2v3"/><line x1="9" y1="9" x2="9" y2="13"/><line x1="15" y1="13" x2="15" y2="17"/></svg>',
  tag: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>',
  settings: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M12 1v6m0 6v6M4.22 4.22l4.24 4.24m5.08 5.08l4.24 4.24M1 12h6m6 0h6M4.22 19.78l4.24-4.24m5.08-5.08l4.24-4.24"/></svg>',
  logout: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3"/><polyline points="15 8 20 3 25 8"/><line x1="20" y1="3" x2="20" y2="15"/></svg>',
  lock: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>',
  help: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>',
  clock: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
  close: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
};

const NAV_CONFIG = {
  employee: [
    {
      label: 'Principal',
      items: [
        { icon: ICONS.dashboard, label: 'Tableau de bord',   href: 'dashboard-employee.html' },
        { icon: ICONS.calendar, label: 'Nouvelle demande',   href: 'new-request.html', badge: null },
        { icon: ICONS.list, label: 'Mes demandes',       href: 'my-requests.html', badge: { count: 2, color: 'blue' } },
        { icon: ICONS.chart, label: 'Solde de congés',    href: 'leave-balance.html' },
      ]
    },
    {
      label: 'Compte',
      items: [
        { icon: ICONS.user, label: 'Mon profil',         href: 'profile.html' },
        { icon: ICONS.bell, label: 'Notifications',      href: '#', badge: { count: 5, color: 'rose' } },
      ]
    }
  ],
  hr: [
    {
      label: 'Principal',
      items: [
        { icon: ICONS.dashboard, label: 'Tableau de bord',    href: 'dashboard-hr.html' },
        { icon: ICONS.check, label: 'Validation',         href: 'validation.html', badge: { count: 7, color: 'warning' } },
        { icon: ICONS.chart, label: 'Soldes employés',    href: 'hr-balances.html' },
        { icon: ICONS.document, label: 'Historique',         href: 'hr-history.html' },
      ]
    },
    {
      label: 'Navigation',
      items: [
        { icon: ICONS.user, label: 'Mon profil',         href: 'profile.html' },
        { icon: ICONS.bell, label: 'Notifications',      href: '#', badge: { count: 7, color: 'rose' } },
      ]
    }
  ],
  admin: [
    {
      label: 'Tableau de bord',
      items: [
        { icon: ICONS.dashboard, label: 'Vue d\'ensemble',    href: 'dashboard-admin.html' },
      ]
    },
    {
      label: 'Gestion',
      items: [
        { icon: ICONS.users, label: 'Employés',           href: 'employees.html' },
        { icon: ICONS.building, label: 'Départements',       href: 'departments.html' },
        { icon: ICONS.tag, label: 'Types de congé',    href: 'leave-types.html' },
        { icon: ICONS.settings, label: 'Ajust. des soldes', href: 'balance-adjust.html' },
      ]
    },
    {
      label: 'Compte',
      items: [
        { icon: ICONS.user, label: 'Mon profil',         href: 'profile.html' },
        { icon: ICONS.bell, label: 'Notifications',      href: '#', badge: { count: 3, color: 'rose' } },
      ]
    }
  ]
};

function renderLayout(role, currentPage, pageTitle) {
  const user = USERS[role];
  const nav  = NAV_CONFIG[role];

  const sectionsHtml = nav.map(section => {
    const items = section.items.map(item => {
      const isActive = item.href === currentPage;
      const badge    = item.badge
        ? `<span class="nav-badge ${item.badge.color}">${item.badge.count}</span>`
        : '';
      return `
        <a class="nav-item ${isActive ? 'active' : ''}" href="${item.href}">
          <span class="nav-icon">${item.icon}</span>
          <span>${item.label}</span>
          ${badge}
        </a>`;
    }).join('');

    return `
      <div class="sidebar-section">
        <div class="sidebar-section-label">${section.label}</div>
        ${items}
      </div>`;
  }).join('');

  const roleLabels = { employee: 'Employé', hr: 'Resp. RH', admin: 'Admin' };
  const roleLinks  = {
    employee: '<a href="dashboard-employee.html">Employé</a>',
    hr:       '<a href="dashboard-hr.html">RH</a>',
    admin:    '<a href="dashboard-admin.html">Admin</a>',
  };

  document.body.insertAdjacentHTML('afterbegin', `
    <div class="sidebar-overlay" onclick="document.querySelector('.sidebar').classList.remove('open');this.classList.remove('show');"></div>

    <aside class="sidebar">
      <div class="sidebar-logo">
        <div class="sidebar-logo-icon">H</div>
        <span class="sidebar-logo-text">MadaTech</span>
        <span class="sidebar-logo-badge">Pro</span>
      </div>

      <div class="sidebar-user">
        <div class="sidebar-avatar" style="background:${user.color}">
          ${user.initials}
          <span class="online-dot"></span>
        </div>
        <div class="sidebar-user-info">
          <div class="sidebar-user-name">${user.name}</div>
          <div class="sidebar-user-role">${user.role}</div>
        </div>
        <div data-dropdown="role-dd" style="cursor:pointer; color:var(--text-muted); font-size:12px;">${ICONS.settings}</div>
        <div class="dropdown-menu" id="role-dd">
          <div class="dropdown-item" onclick="window.location='../index.html'">${ICONS.logout} Déconnexion</div>
          <div class="dropdown-divider"></div>
          <div style="padding:6px 12px; font-size:10px; color:var(--text-muted); font-weight:700; text-transform:uppercase; letter-spacing:0.06em;">Changer de rôle</div>
          <a class="dropdown-item" href="dashboard-employee.html">${ICONS.user} Vue Employé</a>
          <a class="dropdown-item" href="dashboard-hr.html">${ICONS.building} Vue RH</a>
          <a class="dropdown-item" href="dashboard-admin.html">${ICONS.settings} Vue Admin</a>
        </div>
      </div>

      <nav class="sidebar-nav">
        ${sectionsHtml}
      </nav>

      <div class="sidebar-footer">
        <a href="../index.html">
          ${ICONS.logout}
          <span>Déconnexion</span>
        </a>
      </div>
    </aside>

    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-toggle" onclick="document.querySelector('.sidebar').classList.toggle('open'); document.querySelector('.sidebar-overlay').classList.toggle('show');">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <div class="topbar-breadcrumb">
          <span>HIRA</span>
          <span>/</span>
          <span>${roleLabels[role]}</span>
          <span>/</span>
          <span class="current">${pageTitle}</span>
        </div>
        <div class="topbar-search">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" placeholder="Rechercher...">
          <span style="font-size:11px;color:var(--text-dim);margin-left:auto;">⌘K</span>
        </div>
      </div>
      <div class="topbar-right">
        <div style="position:relative;">
          <button class="topbar-btn notif-toggle">
            ${ICONS.bell}
            <span class="topbar-notif-dot"></span>
          </button>
          <div class="notif-panel">
            <div class="notif-header">
              <h4>Notifications</h4>
              <span>Tout marquer lu</span>
            </div>
            <div class="notif-item unread">
              <div class="notif-item-icon" style="background:var(--success-bg);color:var(--success);">${ICONS.check}</div>
              <div class="notif-item-text">
                <div class="notif-item-title">Demande approuvée — Congés annuels 12-16 mai</div>
                <div class="notif-item-time">Il y a 2 heures</div>
              </div>
              <div class="notif-unread-dot"></div>
            </div>
            <div class="notif-item unread">
              <div class="notif-item-icon" style="background:var(--warning-bg);color:var(--warning);">${ICONS.clock}</div>
              <div class="notif-item-text">
                <div class="notif-item-title">Rappel : 3 demandes en attente de validation</div>
                <div class="notif-item-time">Il y a 4 heures</div>
              </div>
              <div class="notif-unread-dot"></div>
            </div>
            <div class="notif-item">
              <div class="notif-item-icon" style="background:rgba(59,130,246,0.1);color:var(--blue);">${ICONS.calendar}</div>
              <div class="notif-item-text">
                <div class="notif-item-title">Lucas Martin a posé une demande de congé</div>
                <div class="notif-item-time">Hier, 14:32</div>
              </div>
            </div>
            <div class="notif-item">
              <div class="notif-item-icon" style="background:var(--danger-bg);color:var(--danger);">${ICONS.close}</div>
              <div class="notif-item-text">
                <div class="notif-item-title">Demande refusée — RTT 8 mai</div>
                <div class="notif-item-time">Hier, 09:15</div>
              </div>
            </div>
          </div>
        </div>
        <button class="topbar-btn" title="Aide">${ICONS.help}</button>
        <div class="topbar-avatar" style="background:${user.color};">${user.initials}</div>
      </div>
    </div>
  `);
}