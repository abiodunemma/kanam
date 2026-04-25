<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Manager</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet"/>
</head>
<body>

<header>
    <div class="user-info">
      <div class="avatar" id="avatarInitials">JD</div>
      <div class="user-details">
        <span class="user-name" id="displayName">John Doe</span>
        <span class="user-role">Administrator</span>
      </div>
    </div>
 
    <button class="btn-add" onclick="openModal()">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
      </svg>
      Add New
    </button>
  </header>
 
  <!-- ── Main ── -->
  <main>
    <div class="section-title">Contacts</div>
    <div class="section-sub">Manage your team and external contacts</div>
 
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Contact Name</th>
            <th>Position</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Add</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          <!-- rows injected by JS -->
        </tbody>
      </table>
    </div>
  </main>
 
  <!-- ── Modal ── -->
  <div class="modal-overlay" id="modalOverlay">
    <div class="modal">
      <div class="modal-title" id="modalTitle">Add New Contact</div>
 
      <div class="form-group">
        <label>Contact Name</label>
        <input type="text" id="inputName" placeholder="e.g. Ada Okafor"/>
      </div>
      <div class="form-group">
        <label>Position</label>
        <input type="text" id="inputPosition" placeholder="e.g. Product Manager"/>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" id="inputEmail" placeholder="e.g. ada@company.com"/>
      </div>
      <div class="form-group">
        <label>Phone Number</label>
        <input type="tel" id="inputPhone" placeholder="e.g. +234 801 234 5678"/>
      </div>
 
      <div class="modal-actions">
        <button class="btn-cancel" onclick="closeModal()">Cancel</button>
        <button class="btn-save" onclick="saveContact()">Save Contact</button>
      </div>
    </div>
  </div>
 
  <script>
    let contacts = [
      { id: 1, name: "Amara Nwosu",   position: "Product Designer",  email: "amara@company.com",  phone: "+234 801 111 2233" },
      { id: 2, name: "Chukwuemeka O", position: "Backend Engineer",   email: "emeka@company.com",  phone: "+234 802 345 6789" },
      { id: 3, name: "Fatima Al-Said",position: "Marketing Lead",     email: "fatima@company.com", phone: "+234 803 987 6543" },
      { id: 4, name: "Kofi Mensah",   position: "Sales Executive",    email: "kofi@company.com",   phone: "+233 244 123 456"  },
    ];
 
    let editId = null;
    let nextId = 10;
 
    function initials(name) {
      return name.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase();
    }
 
    function colorFor(name) {
      const colors = ['#6c63ff','#ff6584','#3dd68c','#f7c948','#47b5ff','#ff9a45'];
      let h = 0; for (let c of name) h = (h * 31 + c.charCodeAt(0)) & 0xffff;
      return colors[h % colors.length];
    }
 
    function render() {
      const tbody = document.getElementById('tableBody');
      if (!contacts.length) {
        tbody.innerHTML = `<tr><td colspan="6">
          <div class="empty-state">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            <p>No contacts yet — click <strong>Add New</strong> to get started.</p>
          </div>
        </td></tr>`;
        return;
      }
 
      tbody.innerHTML = contacts.map(c => `
        <tr>
          <td>
            <div class="contact-name">
              <div class="contact-avatar" style="background:${colorFor(c.name)}20;border-color:${colorFor(c.name)}44;color:${colorFor(c.name)}">
                ${initials(c.name)}
              </div>
              <span class="contact-fullname">${c.name}</span>
            </div>
          </td>
          <td><span class="badge">${c.position}</span></td>
          <td><a class="email-link" href="mailto:${c.email}">${c.email}</a></td>
          <td><span class="phone">${c.phone}</span></td>
          <td class="action-cell">
            <button class="btn-edit" onclick="editContact(${c.id})">Edit</button>
          </td>
          <td class="action-cell">
            <button class="btn-delete" onclick="deleteContact(${c.id})">Delete</button>
          </td>
        </tr>
      `).join('');
    }
 
    function openModal(id = null) {
      editId = id;
      if (id) {
        const c = contacts.find(x => x.id === id);
        document.getElementById('modalTitle').textContent = 'Edit Contact';
        document.getElementById('inputName').value     = c.name;
        document.getElementById('inputPosition').value = c.position;
        document.getElementById('inputEmail').value    = c.email;
        document.getElementById('inputPhone').value    = c.phone;
      } else {
        document.getElementById('modalTitle').textContent = 'Add New Contact';
        ['inputName','inputPosition','inputEmail','inputPhone'].forEach(id => document.getElementById(id).value = '');
      }
      document.getElementById('modalOverlay').classList.add('open');
    }
 
    function closeModal() {
      document.getElementById('modalOverlay').classList.remove('open');
      editId = null;
    }
 
    function saveContact() {
      const name     = document.getElementById('inputName').value.trim();
      const position = document.getElementById('inputPosition').value.trim();
      const email    = document.getElementById('inputEmail').value.trim();
      const phone    = document.getElementById('inputPhone').value.trim();
 
      if (!name || !position || !email || !phone) {
        alert('Please fill in all fields.');
        return;
      }
 
      if (editId) {
        const c = contacts.find(x => x.id === editId);
        Object.assign(c, { name, position, email, phone });
      } else {
        contacts.push({ id: nextId++, name, position, email, phone });
      }
 
      closeModal();
      render();
    }
 
    function editContact(id)   { openModal(id); }
    function deleteContact(id) {
      if (confirm('Remove this contact?')) {
        contacts = contacts.filter(c => c.id !== id);
        render();
      }
    }
 
    // Close modal on overlay click
    document.getElementById('modalOverlay').addEventListener('click', function(e) {
      if (e.target === this) closeModal();
    });
 
    render();
  </script>
</body>
</html>
 