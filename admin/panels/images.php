<?php
defined('ADMIN_PANEL') or die('Direct access not permitted.');

$contentBase = __DIR__ . '/../../img/content';

// Ensure base directories exist
foreach (['projects', 'posts'] as $t) {
  if (!is_dir("$contentBase/$t")) mkdir("$contentBase/$t", 0755, true);
}

// Scan filesystem for existing UUID directories
function scanUuidDirs($contentBase, $type) {
  $dirs = [];
  $path = "$contentBase/$type";
  if (!is_dir($path)) return $dirs;
  foreach (scandir($path) as $d) {
    if ($d === '.' || $d === '..') continue;
    if (is_dir("$path/$d") && preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $d)) {
      $dirs[] = $d;
    }
  }
  return $dirs;
}

// List image files in a content directory
function listImages($contentBase, $type, $id) {
  $dir  = "$contentBase/$type/$id";
  $exts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif', 'svg'];
  $out  = [];
  if (!is_dir($dir)) return $out;
  foreach (scandir($dir) as $f) {
    if ($f === '.' || $f === '..') continue;
    if (in_array(strtolower(pathinfo($f, PATHINFO_EXTENSION)), $exts)) $out[] = $f;
  }
  return $out;
}

$projectDirs = scanUuidDirs($contentBase, 'projects');
$postDirs    = scanUuidDirs($contentBase, 'posts');

// Index DB entries by ID for quick lookup
$projectsById = array_column($projects ?? [], null, 'id');
$postsById    = array_column($posts    ?? [], null, 'id');

// Collect all IDs to show: every DB entry + every filesystem dir (union)
$allProjectIds = array_unique(array_merge(array_keys($projectsById), $projectDirs));
$allPostIds    = array_unique(array_merge(array_keys($postsById),    $postDirs));

function renderImageGroup($id, $entry, $type, $contentBase, $basePath, $csrfToken) {
  $orphaned = ($entry === null);
  $title    = $orphaned ? 'Unknown (orphaned)' : h($entry['title']);
  $images   = listImages($contentBase, $type, $id);
  $webBase  = '/img/content/' . $type . '/' . $id;
  $safeId   = preg_replace('/[^a-z0-9\-]/', '', $id); // safe for HTML id attr
  $typeLabel = rtrim($type, 's'); // "projects" → "project"
?>
  <div class="img-group-card<?= $orphaned ? ' orphaned' : '' ?>">
    <div class="img-group-header">
      <div>
        <h3><?= $title ?></h3>
        <code><?= h($id) ?></code>
      </div>
      <form method="post" onsubmit="return confirm('Delete this entire image directory and all its contents? This cannot be undone.')">
        <input type="hidden" name="action"     value="delete_image_dir">
        <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">
        <input type="hidden" name="type"       value="<?= h($type) ?>">
        <input type="hidden" name="id"         value="<?= h($id) ?>">
        <button type="submit" class="btn-delete-dir">Delete Directory</button>
      </form>
    </div>

    <?php if (!$orphaned): ?>

      <?php if (!empty($entry['thumbnail'])): ?>
        <div class="img-group-section">
          <p class="img-section-label">Thumbnail</p>
          <div class="img-grid">
            <div class="img-item">
              <img src="<?= $basePath . h($entry['thumbnail']) ?>" alt="">
              <div class="img-item-footer">
                <code>![alt](<?= h($entry['thumbnail']) ?>)</code>
                <button type="button" class="btn-copy" onclick="navigator.clipboard.writeText('![alt](<?= h($entry['thumbnail']) ?>)')">Copy</button>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <div class="img-group-section">
        <div class="img-section-header">
          <p class="img-section-label">Content Images</p>
          <input type="file" id="tab-upload-<?= $safeId ?>" accept="image/*" style="display:none"
            onchange="uploadTabImage(this.files[0], '<?= h($type) ?>', '<?= h($id) ?>', this)">
          <button type="button" class="btn-img-upload"
            onclick="document.getElementById('tab-upload-<?= $safeId ?>').click()">
            ⬆ Upload Image
          </button>
        </div>

        <?php if (empty($images)): ?>
          <p style="font-family:var(--font-mono);font-size:0.8rem;color:var(--dim)">No images uploaded yet.</p>
        <?php else: ?>
          <div class="img-grid">
            <?php foreach ($images as $filename):
              $path = $webBase . '/' . $filename;
            ?>
              <div class="img-item">
                <img src="<?= $basePath . h($path) ?>" alt="">
                <div class="img-item-footer">
                  <code>![alt](<?= h($path) ?>)</code>
                  <button type="button" class="btn-copy" onclick="navigator.clipboard.writeText('![alt](<?= h($path) ?>)')">Copy</button>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

    <?php else: ?>
      <p style="font-family:var(--font-mono);font-size:0.8rem;color:var(--light-magenta);padding:1rem 0">
        This directory has no matching <?= $typeLabel ?> in the database. Delete it to clean up.
      </p>
    <?php endif; ?>
  </div>
<?php
}
?>

<h2>Images</h2>

<h3 style="font-family:var(--font-display);font-size:1.4rem;color:var(--cyan);margin:1.5rem 0 1rem">Projects</h3>
<?php if (empty($allProjectIds)): ?>
  <p style="font-family:var(--font-mono);color:var(--dim)">No projects yet.</p>
<?php else: ?>
  <?php foreach ($allProjectIds as $id):
    renderImageGroup($id, $projectsById[$id] ?? null, 'projects', $contentBase, $basePath, $csrfToken);
  endforeach; ?>
<?php endif; ?>

<h3 style="font-family:var(--font-display);font-size:1.4rem;color:var(--cyan);margin:2.5rem 0 1rem">Posts</h3>
<?php if (empty($allPostIds)): ?>
  <p style="font-family:var(--font-mono);color:var(--dim)">No posts yet.</p>
<?php else: ?>
  <?php foreach ($allPostIds as $id):
    renderImageGroup($id, $postsById[$id] ?? null, 'posts', $contentBase, $basePath, $csrfToken);
  endforeach; ?>
<?php endif; ?>
