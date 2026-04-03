<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../api/config.php';

function h($str) {
  return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

if (isset($_POST['logout'])) {
  logout();
}

if (!isset($_SESSION['admin']) && isset($_POST['username']) && isset($_POST['password'])) {
  $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
  if (!attemptLogin($_POST['username'], $_POST['password'])) {
    $error = checkRateLimit($ip)
      ? "Incorrect username or password."
      : "Too many failed attempts. Please try again in 15 minutes.";
  }
}

if (isset($_SESSION['admin'])) {
  define('ADMIN_PANEL', true);

  // Set base path for testing locally vs in prod
  $basePath = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false)
  ? 'http://' . $_SERVER['HTTP_HOST'] . '/dangelovf'
  : '';

  $csrfToken = csrfToken();

  if (isset($_POST['action'])) {
    verifyCsrf();
    require_once __DIR__ . '/handlers/bio.php';
    require_once __DIR__ . '/handlers/projects.php';
    require_once __DIR__ . '/handlers/skills.php';
    require_once __DIR__ . '/handlers/qualifications.php';
    require_once __DIR__ . '/handlers/posts.php';
    require_once __DIR__ . '/handlers/upload_image.php';
  }

  $bioVersions    = db()->query("SELECT * FROM bio ORDER BY updated_on DESC")->fetchAll();
  $projects       = db()->query("SELECT * FROM projects ORDER BY order_index ASC")->fetchAll();
  $skills         = db()->query("SELECT * FROM skills ORDER BY order_index ASC")->fetchAll();
  $qualifications = db()->query("SELECT * FROM qualifications ORDER BY year DESC")->fetchAll();
  $posts          = db()->query("SELECT * FROM posts ORDER BY published_on DESC")->fetchAll();

}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin — DangeloVF</title>
  <link rel="stylesheet" href="admin.css">
  <script src="js/marked.umd.js"></script>
  <?php if (isset($csrfToken)): ?>
  <script>const CSRF_TOKEN = '<?= h($csrfToken) ?>'</script>
  <?php endif; ?>
  <script>
    // ── Tab switching ──
    document.addEventListener('DOMContentLoaded', () => {
      const panels  = document.querySelectorAll('[id^="tab-"]');
      const buttons = document.querySelectorAll('.tab-btn');

      function showTab(name) {
        panels.forEach(p  => p.hidden = true);
        buttons.forEach(b => b.classList.remove('active'));
        const target = document.getElementById('tab-' + name);
        const btn    = document.querySelector('[data-panel="' + name + '"]');
        if (target) target.hidden = false;
        if (btn)    btn.classList.add('active');
        localStorage.setItem('adminTab', name);
      }

      buttons.forEach(btn => {
        btn.addEventListener('click', () => showTab(btn.dataset.panel));
      });

      if (buttons.length) showTab(localStorage.getItem('adminTab') ?? 'bio');
    });
  </script>
  <script>
    // Insert text at the textarea cursor position and fire input event (triggers preview)
    function insertAtCursor(textarea, text) {
      const start = textarea.selectionStart
      const end   = textarea.selectionEnd
      textarea.value = textarea.value.substring(0, start) + text + textarea.value.substring(end)
      textarea.selectionStart = textarea.selectionEnd = start + text.length
      textarea.dispatchEvent(new Event('input'))
    }

    // Upload an image file and insert the markdown at the cursor (inline editor buttons)
    async function uploadContentImage(file, type, id, textarea) {
      if (!id || id === 'new') {
        alert('Save the ' + (type === 'projects' ? 'project' : 'post') + ' first before uploading images.')
        return
      }
      const fd = new FormData()
      fd.append('action',     'upload_image')
      fd.append('type',       type)
      fd.append('id',         id)
      fd.append('image',      file)
      fd.append('csrf_token', CSRF_TOKEN)
      try {
        const res  = await fetch('index.php', { method: 'POST', body: fd })
        const data = await res.json()
        if (data.error) { alert('Upload failed: ' + data.error); return }
        insertAtCursor(textarea, `![alt text](${data.path})`)
      } catch (e) {
        alert('Upload failed.')
      }
    }

    // Upload an image from the Images tab — reloads the page on success
    async function uploadTabImage(file, type, id, inputEl) {
      const fd = new FormData()
      fd.append('action',     'upload_image')
      fd.append('type',       type)
      fd.append('id',         id)
      fd.append('image',      file)
      fd.append('csrf_token', CSRF_TOKEN)
      try {
        const res  = await fetch('index.php', { method: 'POST', body: fd })
        const data = await res.json()
        if (data.error) { alert('Upload failed: ' + data.error); return }
        location.reload()
      } catch (e) {
        alert('Upload failed.')
      } finally {
        inputEl.value = ''
      }
    }

    function mdPreview(textarea, preview) {
      function update() {
        preview.innerHTML = marked.parse(textarea.value || '')
      }
      textarea.addEventListener('input', update)
      return update
    }
  </script>
</head>
<body>

<!-- ── Site logo — links back to main site ── -->
<div class="site-bar">
  <a href="/" class="site-logo">dangelovf<span>.com</span></a>
</div>

<?php if (!isset($_SESSION['admin'])): ?>

  <!-- ── Login ── -->
  <div class="login-wrap">
    <h2>Admin Login</h2>
    <form method="post">
      <label for="username">Username</label>
      <input type="text" id="username" name="username">

      <label for="password">Password</label>
      <input type="password" id="password" name="password">

      <input type="submit" value="Log In">

      <?php if (isset($error)): ?>
        <p class="error"><?= h($error) ?></p>
      <?php endif; ?>
    </form>
  </div>

<?php else: ?>

  <!-- ── Admin panel ── -->
  <div class="admin-header">
    <h1>DangeloVF Admin</h1>
    <form method="post">
      <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">
      <button type="submit" name="logout">Log Out</button>
    </form>
  </div>

  <nav id="admin-nav">
    <button type="button" class="tab-btn" data-panel="bio">Bio</button>
    <button type="button" class="tab-btn" data-panel="projects">Projects</button>
    <button type="button" class="tab-btn" data-panel="skills">Skills</button>
    <button type="button" class="tab-btn" data-panel="qualifications">Qualifications</button>
    <button type="button" class="tab-btn" data-panel="posts">Posts</button>
    <button type="button" class="tab-btn" data-panel="images">Images</button>
  </nav>

  <div id="tab-bio">
    <div class="panel-inner">
      <?php include __DIR__ . '/panels/bio.php'; ?>
    </div>
  </div>

  <div id="tab-projects" hidden>
    <div class="panel-inner">
      <?php include __DIR__ . '/panels/projects.php'; ?>
    </div>
  </div>

  <div id="tab-skills" hidden>
    <div class="panel-inner">
      <?php include __DIR__ . '/panels/skills.php'; ?>
    </div>
  </div>

  <div id="tab-qualifications" hidden>
    <div class="panel-inner">
      <?php include __DIR__ . '/panels/qualifications.php'; ?>
    </div>
  </div>

  <div id="tab-posts" hidden>
    <div class="panel-inner">
      <?php include __DIR__ . '/panels/posts.php'; ?>
    </div>
  </div>

  <div id="tab-images" hidden>
    <div class="panel-inner">
      <?php include __DIR__ . '/panels/images.php'; ?>
    </div>
  </div>


<?php endif; ?>

</body>
</html>
