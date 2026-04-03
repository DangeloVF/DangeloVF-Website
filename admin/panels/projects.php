<h2>Projects</h2>
<div id="projects-layout">

  <aside id="project-sidebar">
    <button type="button" id="project-new-btn">+ New Project</button>
    <ul id="project-list">
      <?php foreach ($projects as $p): ?>
        <li>
          <button type="button" class="project-item" data-id="<?= h($p['id']) ?>">
            <?= h($p['title']) ?>
          </button>
        </li>
      <?php endforeach; ?>
    </ul>
  </aside>

  <div id="project-form-panel">
    <form method="post" id="project-form" enctype="multipart/form-data" autocomplete="off">
      <input type="hidden" name="action" value="save_project">
      <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">
      <input type="hidden" name="project_id" id="project-id" value="new">

      <label for="project-title">Title</label><br>
      <input type="text" id="project-title" name="title" maxlength="255"><br>

      <label for="project-slug">Slug</label><br>
      <input type="text" id="project-slug" name="slug" maxlength="255"><br>

      <div class="md-label-bar">
        <label for="project-description">Description (Markdown)</label>
        <button type="button" class="btn-img-upload" id="proj-img-btn">⬆ Upload Image</button>
        <input type="file" id="proj-img-file" accept="image/*" style="display:none">
      </div>
      <div class="md-editor">
        <textarea id="project-description" name="description"></textarea>
        <div class="md-preview" id="project-description-preview"></div>
      </div>

      <label for="project-tags">Tags (comma-separated)</label><br>
      <input type="text" id="project-tags" name="tags"><br>

      <label for="project-github-url">GitHub URL</label><br>
      <input type="text" id="project-github-url" name="github_url" maxlength="511"><br>

      <label for="project-live-url">Live URL</label><br>
      <input type="text" id="project-live-url" name="live_url" maxlength="511"><br>

      <label>Thumbnail</label><br>
      <div id="thumbnail-drop-zone">
        <span id="thumbnail-drop-label">Drop image here or click to browse</span>
        <img id="thumbnail-preview" src="" alt="" hidden>
        <input type="file" id="thumbnail-file" name="thumbnail_file">
      </div>
      <label for="project-thumbnail-url">Or paste a URL:</label><br>
      <input type="text" id="project-thumbnail-url" name="thumbnail_url" maxlength="511"><br>

      <label>Featured?</label><br>
      <input type="radio" id="project-featured-yes" name="featured" value="1">
      <label for="project-featured-yes">Yes</label>
      <input type="radio" id="project-featured-no" name="featured" value="0" checked>
      <label for="project-featured-no">No</label><br>

      <label for="project-year">Year</label><br>
      <input type="number" id="project-year" name="year" min="2000" max="2099"><br>

      <label for="project-order">Order</label><br>
      <input type="number" id="project-order" name="order_index" value="0" min="0"><br><br>

      <button type="submit">Save Project</button>
    </form>

    <!-- Separate form for delete — JS sets project_id and submits this -->
    <button type="button" id="project-delete-btn" hidden>Delete Project</button>
    <form method="post" id="project-delete-form">
      <input type="hidden" name="action" value="delete_project">
      <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">
      <input type="hidden" name="project_id" id="project-delete-id" value="">
    </form>
  </div>

</div>

<script>
  const projects = <?= json_encode($projects ?? []) ?>;

  const projectNewBtn        = document.getElementById('project-new-btn');
  const projectDeleteBtn     = document.getElementById('project-delete-btn');
  const projectDeleteForm    = document.getElementById('project-delete-form');
  const projectIdInput       = document.getElementById('project-id');
  const projectForm          = document.getElementById('project-form');
  const projectTitleInput    = document.getElementById('project-title');
  const projectSlugInput     = document.getElementById('project-slug');
  const projectDescInput         = document.getElementById('project-description');
  const projectDescPreview       = document.getElementById('project-description-preview');
  const projImgFile              = document.getElementById('proj-img-file');
  const updateProjectDescPreview = mdPreview(projectDescInput, projectDescPreview)

  document.getElementById('proj-img-btn').addEventListener('click', () => projImgFile.click())
  projImgFile.addEventListener('change', () => {
    if (projImgFile.files[0]) {
      uploadContentImage(projImgFile.files[0], 'projects', projectIdInput.value, projectDescInput)
      projImgFile.value = ''
    }
  })
  const projectTagsInput     = document.getElementById('project-tags');
  const projectGithubInput   = document.getElementById('project-github-url');
  const projectLiveInput     = document.getElementById('project-live-url');
  const projectThumbUrlInput = document.getElementById('project-thumbnail-url');
  const projectOrderInput    = document.getElementById('project-order');
  const projectYearInput     = document.getElementById('project-year');
  const projectFeaturedYes   = document.getElementById('project-featured-yes');
  const projectFeaturedNo    = document.getElementById('project-featured-no');
  const projectDeleteIdInput = document.getElementById('project-delete-id');

  // ── Thumbnail drag/drop ──
  const thumbDropZone  = document.getElementById('thumbnail-drop-zone');
  const thumbFileInput = document.getElementById('thumbnail-file');
  const thumbPreview   = document.getElementById('thumbnail-preview');
  const thumbDropLabel = document.getElementById('thumbnail-drop-label');

  thumbDropZone.addEventListener('click', (e) => {
    if (e.target === thumbFileInput) return;
    thumbFileInput.click();
  });

  function showThumbPreview(file) {
    if (!file || !file.type.startsWith('image/')) return;
    const reader = new FileReader();
    reader.onload = e => {
      thumbPreview.src      = e.target.result;
      thumbPreview.hidden   = false;
      thumbDropLabel.hidden = true;
    };
    reader.readAsDataURL(file);
  }

  thumbFileInput.addEventListener('change', () => showThumbPreview(thumbFileInput.files[0]));

  thumbDropZone.addEventListener('dragover', e => {
    e.preventDefault();
    thumbDropZone.classList.add('drag-over');
  });

  thumbDropZone.addEventListener('dragleave', () => thumbDropZone.classList.remove('drag-over'));

  thumbDropZone.addEventListener('drop', e => {
    e.preventDefault();
    thumbDropZone.classList.remove('drag-over');
    const file = e.dataTransfer.files[0];
    const dt   = new DataTransfer();
    dt.items.add(file);
    thumbFileInput.files = dt.files;
    showThumbPreview(file);
  });

  // ── Form helpers ──
  function clearProjectForm() {
    projectIdInput.value    = 'new';
    projectForm.reset();
    projectYearInput.value  = new Date().getFullYear();
    projectDeleteBtn.hidden = true;
    thumbPreview.hidden     = true;
    thumbDropLabel.hidden   = false;
    updateProjectDescPreview()
  }

  function populateProjectForm(project) {
    const tagsArray = project.tags ? JSON.parse(project.tags) : [];
    projectIdInput.value       = project.id;
    projectTitleInput.value    = project.title ?? '';
    projectSlugInput.value     = project.slug ?? '';
    projectDescInput.value     = project.description ?? '';
    projectTagsInput.value     = tagsArray.join(', ');
    updateProjectDescPreview()
    projectGithubInput.value   = project.github_url ?? '';
    projectLiveInput.value     = project.live_url ?? '';
    projectThumbUrlInput.value = project.thumbnail ?? '';
    projectOrderInput.value    = project.order_index ?? 0;
    projectYearInput.value     = project.year ?? '';
    projectFeaturedYes.checked = project.featured == 1;
    projectFeaturedNo.checked  = project.featured != 1;
    projectDeleteBtn.hidden    = false;

    if (project.thumbnail) {
      thumbPreview.src      = basePath + project.thumbnail; 
      thumbPreview.hidden   = false;
      thumbDropLabel.hidden = true;
    } else {
      thumbPreview.hidden   = true;
      thumbDropLabel.hidden = false;
    }
  }

  // Sidebar — click a project to load it into the form
  document.querySelectorAll('.project-item').forEach(btn => {
    btn.addEventListener('click', () => {
      const project = projects.find(p => p.id === btn.dataset.id);
      if (project) populateProjectForm(project);
    });
  });

  // New Project — clear the form
  projectNewBtn.addEventListener('click', clearProjectForm);

  // Delete — confirm, then submit the delete form
  projectDeleteBtn.addEventListener('click', () => {
    if (!confirm('Delete this project? This cannot be undone.')) return;
    projectDeleteIdInput.value = projectIdInput.value;
    projectDeleteForm.submit();
  });
</script>
