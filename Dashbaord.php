<?php 
session_start();
require './config/db.php';

$stmt = $pdo->prepare("SELECT * FROM users WHere username = ?");
$username= $_SESSION['username'];
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM contacts");
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? '';
  $position = $_POST['position'] ?? '';
  $email = $_POST['email'] ?? '';
  $phone_number = $_POST['phone_number'] ?? '';

  if (empty($name)) $error = "Name is required";
  if (empty($position)) $error = "Position is required";
  if (empty($email)) $error = "Email is required";
  if (empty($phone_number)) $error = "Phone number is required";


$stmt = $pdo->prepare('
 INSERT INTO contacts (name,position,email,phone_number) VALUES (?,?,?,?)');

 $stmt->execute([$name, $position, $email, $phone_number]);
 var_dump($stmt->errorInfo());
header("Location: dashboard.php");
exit();

}
else {
  echo "Invalid request method";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Manager</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet"/>
   <link rel="stylesheet" href="../assets/css/contact.css" />
</head>
<body>
   <?php if ($user): ?>
<header>
    <div class="user-info">
      <div class="avatar" id="avatarInitials">JD</div>
      <div class="user-details">
        <span class="user-name" id="displayName"><?=  htmlspecialchars($_SESSION['username']) ?></span>
        <span class="user-role">Administrator</span>
      </div>
    </div>
  <?php else: ?>
    <div>wrong </div>
     <?php endif; ?>

    <button class="btn-add" onclick="openModal()">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
      </svg>
      Add New
    </button>
  </header>
 
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
        <?php foreach ($contacts as $c): ?>
   
  <tr>
  <td><?= htmlspecialchars($c['name'] ?? 'null') ?></td>
  <td><?= htmlspecialchars($c['position'] ?? 'null') ?></td>
  <td><?= htmlspecialchars($c['email'] ?? 'null') ?></td>
  <td><?= htmlspecialchars($c['phone_number'] ?? 'null') ?></td>
  <td><button>Edit</button></td>
  <td><button>Delete</button></td>
</tr>
<?php endforeach; ?>
        </tbody>
      </table>
     
    </div>
  </main>
 
  <!-- ── Modal ── -->
  <div class="modal-overlay" id="modalOverlay">
    <div class="modal">
       <form class="modal-form" method="POST" action="../dashbaord.php">
      <div class="modal-title" id="modalTitle">Add New Contact</div>

      <div class="form-group" >
        <label>Contact Name</label>
        <input type="text" id="name" name="name" placeholder="e.g. Ada Okafor"/>
      </div>
      <div class="form-group">
        <label>Position</label>
        <input type="text" id="position" name="position" placeholder="e.g. Product Manager"/>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" id="email" name="email" placeholder="e.g. ada@company.com"/>
      </div>
      <div class="form-group">
        <label>Phone Number</label>
        <input type="tel" id="phone_number" name="phone_number" placeholder="e.g. +234 801 234 5678"/>
      </div>
 
      <div class="modal-actions">
<button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
        <button class="btn-save"  type="submit" >Save Contact</button>
      </div>
      </form>
    </div>
  </div>
  </body>
 
  <script>
   
 
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
        document.getElementById('edit').textContent = 'Edit Contact';
        document.getElementById('name').value     = c.name;
        document.getElementById('position').value = c.position;
        document.getElementById('email').value = c.email;
        document.getElementById('phone_number').value    = c.phone;
      } else {
        document.getElementById('modalTitle').textContent = 'Add New Contact';
        ['name','position','email','phone_number'].forEach(id => document.getElementById(id).value = '');
      }
      document.getElementById('modalOverlay').classList.add('open');
    }
 
    function closeModal() {
      document.getElementById('modalOverlay').classList.remove('open');
      editId = null;
    }
 
   
  </script>
</body>
</html>
 