<h2>Bio</h2>
<form method="post" id="bio-form" autocomplete="off">
  <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">
  <select id="bio-version-select" name="bio_version">
    <option value="new">— New Entry —</option>
    <?php foreach ($bioVersions as $version): ?>
      <option value="<?= h($version['id']) ?>">
        <?= h($version['name']) ?> — <?= h($version['headline']) ?> — <?= $version['updated_on'] ?> <?= $version['active'] ? '(active)' : '' ?>
      </option>
    <?php endforeach; ?>
  </select>

  <label for="bio-name">Name:</label><br>
  <input type="text" id="bio-name" name="name"><br>

  <label for="bio-headline">Headline:</label><br>
  <input type="text" id="bio-headline" name="headline"><br>

  <label for="bio-about">About (Markdown):</label>
  <div class="md-editor">
    <textarea id="bio-about" name="about"></textarea>
    <div class="md-preview" id="bio-about-preview"></div>
  </div>

  <label for="bio-available">Status:</label><br>
  <div class="status-indicator">
    <select id="bio-available" name="available">
      <option value="ready">Ready</option>
      <option value="busy">Busy</option>
      <option value="offline">Offline</option>
    </select>
    <span id="bio-status-dot" class="status-dot"></span>
    <span id="bio-status-label" class="status-label"></span>
  </div>

  <label>Make active?</label><br>
  <input type="radio" id="bio-active-yes" name="active" value="1">
  <label for="bio-active-yes">Yes</label>
  <input type="radio" id="bio-active-no" name="active" value="0" checked>
  <label for="bio-active-no">No</label><br>

  <button type="submit" name="action" value="save_bio">Save Changes</button>
</form>

<script>
  const bioVersions        = <?= json_encode($bioVersions ?? []) ?>;
  const bioVersionSelect   = document.getElementById('bio-version-select');
  const bioNameInput       = document.getElementById('bio-name');
  const bioHeadlineInput   = document.getElementById('bio-headline');
  const bioAboutInput      = document.getElementById('bio-about');
  const bioAboutPreview    = document.getElementById('bio-about-preview');
  const bioAvailableSelect = document.getElementById('bio-available');
  const bioActiveYes       = document.getElementById('bio-active-yes');
  const bioActiveNo        = document.getElementById('bio-active-no');

  const updateBioAboutPreview = mdPreview(bioAboutInput, bioAboutPreview)

  function clearBioForm() {
    bioVersionSelect.value   = 'new';
    bioNameInput.value       = '';
    bioHeadlineInput.value   = '';
    bioAboutInput.value      = '';
    bioAvailableSelect.value = 'ready';
    bioActiveYes.checked     = false;
    bioActiveNo.checked      = true;
    updateBioAboutPreview()
    updateStatusDot('ready')
  }

  function populateBioForm(version) {
    bioVersionSelect.value   = version.id;
    bioNameInput.value       = version.name ?? '';
    bioHeadlineInput.value   = version.headline ?? '';
    bioAboutInput.value      = version.about ?? '';
    bioAvailableSelect.value = version.available ?? 'ready';
    bioActiveYes.checked     = version.active == 1;
    bioActiveNo.checked      = version.active != 1;
    updateBioAboutPreview()
    updateStatusDot(version.available ?? 'ready')
  }

  // Version dropdown — populate or clear the form instantly
  bioVersionSelect.addEventListener('change', () => {
    if (bioVersionSelect.value === 'new') {
      clearBioForm();
    } else {
      const version = bioVersions.find(v => v.id == bioVersionSelect.value);
      if (version) populateBioForm(version);
    }
  });

  // Status dot — live colour indicator next to the dropdown
  const statusColors = { ready: '#00ff88', busy: '#ffe500', offline: '#ff4444' }
  const statusLabels = { ready: 'Available', busy: 'Busy', offline: 'Offline' }
  const bioStatusDot   = document.getElementById('bio-status-dot')
  const bioStatusLabel = document.getElementById('bio-status-label')

  function updateStatusDot(value) {
    const color = statusColors[value] ?? 'transparent'
    bioStatusDot.style.background  = color
    bioStatusDot.style.boxShadow   = color !== 'transparent' ? `0 0 6px ${color}` : 'none'
    bioStatusLabel.style.color     = color
    bioStatusLabel.textContent     = statusLabels[value] ?? ''
  }

  bioAvailableSelect.addEventListener('change', () => updateStatusDot(bioAvailableSelect.value))

  // On page load, populate with the active version
  const activeBio = bioVersions.find(v => v.active == 1);
  if (activeBio) populateBioForm(activeBio);
</script>
