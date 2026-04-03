<h2>Posts</h2>
<div id="posts-layout">

  <aside id="posts-sidebar">
    <button type="button" id="post-new-btn">+ New Post</button>
    <ul id="post-list">
      <?php foreach ($posts as $p): ?>
        <li>
          <button type="button" class="post-item" data-id="<?= h($p['id']) ?>">
            <?= h($p['title']) ?>
          </button>
        </li>
      <?php endforeach; ?>
    </ul>
  </aside>

  <div id="post-form-panel">
    <form method="post" id="post-form" enctype="multipart/form-data" autocomplete="off">
      <input type="hidden" name="action" value="save_post">
      <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">
      <input type="hidden" name="post_id" id="post-id" value="new">

      <label for="post-title">Title</label><br>
      <input type="text" id="post-title" name="title" maxlength="255"><br>

      <label for="post-slug">Slug</label><br>
      <input type="text" id="post-slug" name="slug" maxlength="255"><br>

      <label for="post-excerpt">Excerpt (Markdown)</label>
      <div class="md-editor">
        <textarea id="post-excerpt" name="excerpt"></textarea>
        <div class="md-preview" id="post-excerpt-preview"></div>
      </div>

      <div class="md-label-bar">
        <label for="post-body">Body (Markdown)</label>
        <button type="button" class="btn-img-upload" id="post-img-btn">⬆ Upload Image</button>
        <input type="file" id="post-img-file" accept="image/*" style="display:none">
      </div>
      <div class="md-editor">
        <textarea id="post-body" name="body"></textarea>
        <div class="md-preview" id="post-body-preview"></div>
      </div>

      <label for="post-tags">Tags (comma-separated)</label><br>
      <input type="text" id="post-tags" name="tags"><br>

      <label>Thumbnail</label><br>
      <div id="post-thumbnail-drop-zone">
        <span id="post-thumbnail-drop-label">Drop image here or click to browse</span>
        <img id="post-thumbnail-preview" src="" alt="" hidden>
        <input type="file" id="post-thumbnail-file" name="thumbnail_file">
      </div>
      <label for="post-thumbnail-url">Or paste a URL:</label><br>
      <input type="text" id="post-thumbnail-url" name="thumbnail_url" maxlength="511"><br>

      <label>Featured?</label><br>
      <input type="radio" id="post-featured-yes" name="featured" value="1">
      <label for="post-featured-yes">Yes</label>
      <input type="radio" id="post-featured-no" name="featured" value="0" checked>
      <label for="post-featured-no">No</label><br>

      <label for="post-year">Year</label><br>
      <input type="number" id="post-year" name="year" min="2000" max="2099"><br>

      <label for="post-order">Order</label><br>
      <input type="number" id="post-order" name="order_index" value="0" min="0"><br><br>

      <label>Publish?</label><br>
      <input type="radio" id="post-published-yes" name="published" value="1">
      <label for="post-published-yes">Yes</label>
      <input type="radio" id="post-published-no" name="published" value="0" checked>
      <label for="post-published-no">No</label><br>

      <label for="post-published-on">Publish date (leave blank to use now)</label><br>
      <input type="datetime-local" id="post-published-on" name="published_on"><br><br>

      <button type="submit">Save Post</button>
    </form>

    <!-- Separate form for delete — JS sets post_id and submits this -->
    <button type="button" id="post-delete-btn" hidden>Delete Post</button>
    <form method="post" id="post-delete-form">
      <input type="hidden" name="action" value="delete_post">
      <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">
      <input type="hidden" name="post_id" id="post-delete-id" value="">
    </form>
  </div>

</div>

<script>
  const posts = <?= json_encode($posts ?? []) ?>;

  const postNewBtn           = document.getElementById('post-new-btn');
  const postDeleteBtn        = document.getElementById('post-delete-btn');
  const postDeleteForm       = document.getElementById('post-delete-form');
  const postForm             = document.getElementById('post-form');
  const postIdInput          = document.getElementById('post-id');
  const postTitleInput       = document.getElementById('post-title');
  const postSlugInput        = document.getElementById('post-slug');
  const postExcerptInput         = document.getElementById('post-excerpt');
  const postExcerptPreview       = document.getElementById('post-excerpt-preview');
  const postBodyInput            = document.getElementById('post-body');
  const postBodyPreview          = document.getElementById('post-body-preview');
  const postImgFile              = document.getElementById('post-img-file');
  const updatePostExcerptPreview = mdPreview(postExcerptInput, postExcerptPreview)
  const updatePostBodyPreview    = mdPreview(postBodyInput, postBodyPreview)

  document.getElementById('post-img-btn').addEventListener('click', () => postImgFile.click())
  postImgFile.addEventListener('change', () => {
    if (postImgFile.files[0]) {
      uploadContentImage(postImgFile.files[0], 'posts', postIdInput.value, postBodyInput)
      postImgFile.value = ''
    }
  })
  const postTagsInput        = document.getElementById('post-tags');
  const postThumbUrlInput    = document.getElementById('post-thumbnail-url');
  const postFeaturedYes      = document.getElementById('post-featured-yes');
  const postFeaturedNo       = document.getElementById('post-featured-no');
  const postYearInput        = document.getElementById('post-year');
  const postOrderInput       = document.getElementById('post-order');
  const postPublishedYes     = document.getElementById('post-published-yes');
  const postPublishedNo      = document.getElementById('post-published-no');
  const postPublishedOnInput = document.getElementById('post-published-on');
  const postDeleteIdInput    = document.getElementById('post-delete-id');

  // ── Thumbnail drag/drop ──
  // Prefixed with "post" to avoid clashing with the projects panel consts
  const postThumbDropZone  = document.getElementById('post-thumbnail-drop-zone');
  const postThumbFileInput = document.getElementById('post-thumbnail-file');
  const postThumbPreview   = document.getElementById('post-thumbnail-preview');
  const postThumbDropLabel = document.getElementById('post-thumbnail-drop-label');

  postThumbDropZone.addEventListener('click', (e) => {
    if (e.target === postThumbFileInput) return;
    postThumbFileInput.click();
  });

  function showPostThumbPreview(file) {
    if (!file || !file.type.startsWith('image/')) return;
    const reader = new FileReader();
    reader.onload = e => {
      postThumbPreview.src      = e.target.result;
      postThumbPreview.hidden   = false;
      postThumbDropLabel.hidden = true;
    };
    reader.readAsDataURL(file);
  }

  postThumbFileInput.addEventListener('change', () => showPostThumbPreview(postThumbFileInput.files[0]));

  postThumbDropZone.addEventListener('dragover', e => {
    e.preventDefault();
    postThumbDropZone.classList.add('drag-over');
  });

  postThumbDropZone.addEventListener('dragleave', () => postThumbDropZone.classList.remove('drag-over'));

  postThumbDropZone.addEventListener('drop', e => {
    e.preventDefault();
    postThumbDropZone.classList.remove('drag-over');
    const file = e.dataTransfer.files[0];
    const dt   = new DataTransfer();
    dt.items.add(file);
    postThumbFileInput.files = dt.files;
    showPostThumbPreview(file);
  });

  // ── Form helpers ──
  function clearPostForm() {
    postIdInput.value         = 'new';
    postForm.reset();
    postYearInput.value       = new Date().getFullYear();
    postDeleteBtn.hidden      = true;
    postThumbPreview.hidden   = true;
    postThumbDropLabel.hidden = false;
    updatePostExcerptPreview()
    updatePostBodyPreview()
  }

  function populatePostForm(post) {
    const tagsArray = post.tags ? JSON.parse(post.tags) : [];
    postIdInput.value          = post.id;
    postTitleInput.value       = post.title ?? '';
    postSlugInput.value        = post.slug ?? '';
    postExcerptInput.value     = post.excerpt ?? '';
    postBodyInput.value        = post.body ?? '';
    updatePostExcerptPreview()
    updatePostBodyPreview()
    postTagsInput.value        = tagsArray.join(', ');
    postThumbUrlInput.value    = post.thumbnail ?? '';
    postFeaturedYes.checked    = post.featured == 1;
    postFeaturedNo.checked     = post.featured != 1;
    postYearInput.value        = post.year ?? '';
    postOrderInput.value       = post.order_index ?? 0;
    postPublishedYes.checked   = post.published == 1;
    postPublishedNo.checked    = post.published != 1;
    // Convert "YYYY-MM-DD HH:MM:SS" → "YYYY-MM-DDTHH:MM" for datetime-local input
    postPublishedOnInput.value = post.published_on ? post.published_on.replace(' ', 'T').slice(0, 16) : '';
    postDeleteBtn.hidden       = false;

    if (post.thumbnail) {
      postThumbPreview.src      = basePath + post.thumbnail;
      postThumbPreview.hidden   = false;
      postThumbDropLabel.hidden = true;
    } else {
      postThumbPreview.hidden   = true;
      postThumbDropLabel.hidden = false;
    }
  }

  // Sidebar — click a post to load it into the form
  document.querySelectorAll('.post-item').forEach(btn => {
    btn.addEventListener('click', () => {
      const post = posts.find(p => p.id === btn.dataset.id);
      if (post) populatePostForm(post);
    });
  });

  // New Post — clear the form
  postNewBtn.addEventListener('click', clearPostForm);

  // Delete — confirm, then submit the delete form
  postDeleteBtn.addEventListener('click', () => {
    if (!confirm('Delete this post? This cannot be undone.')) return;
    postDeleteIdInput.value = postIdInput.value;
    postDeleteForm.submit();
  });
</script>
