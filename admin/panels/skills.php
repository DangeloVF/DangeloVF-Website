<h2>Skills</h2>
<aside id="skills-sidebar">
  <button type="button" id="skill-new-btn">+ New Skill</button>
  <ul id="skills-list">
    <?php foreach ($skills as $s): ?>
      <li>
        <button type="button" class="skill-item" data-id="<?= h($s['id']) ?>">
          <?= h($s['name']) ?> (<?= h($s['category']) ?>)
        </button>
      </li>
    <?php endforeach; ?>
  </ul>
</aside>

<div class="form-panel">
<form method="post" id="skill-form" autocomplete="off">
  <input type="hidden" id="skill-id" name="skill_id" value="new">
  <input type="hidden" name="action" value="save_skill">
  <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">

  <label for="skill-name">Name</label><br>
  <input type="text" id="skill-name" name="name"><br>

  <label for="skill-category">Category</label><br>
  <input type="text" id="skill-category" name="category" list="skill-categories-list">
  <datalist id="skill-categories-list"></datalist><br>

  <label for="skill-proficiency">Proficiency (0–100)</label><br>
  <input type="number" id="skill-proficiency" name="proficiency" min="0" max="100"><br>

  <label for="skill-order">Order</label><br>
  <input type="number" id="skill-order" name="order_index" min="0" value="0"><br><br>

  <button type="submit" id="skill-save-btn">Save Skill</button>
</form>

<!-- Separate form for delete — JS sets skill_id and submits this -->
<button type="button" id="skill-delete-btn" hidden>Delete Skill</button>
<form method="post" id="skill-delete-form">
  <input type="hidden" name="action" value="delete_skill">
  <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">
  <input type="hidden" name="skill_id" id="skill-delete-id" value="">
</form>
</div>

<script>
  const skills             = <?= json_encode($skills ?? []) ?>;
  const skillNewBtn        = document.getElementById('skill-new-btn');
  const skillDeleteBtn     = document.getElementById('skill-delete-btn');
  const skillDeleteForm    = document.getElementById('skill-delete-form');
  const skillForm          = document.getElementById('skill-form');
  const skillIdInput       = document.getElementById('skill-id');
  const skillNameInput     = document.getElementById('skill-name');
  const skillCategoryInput = document.getElementById('skill-category');
  const skillProfInput     = document.getElementById('skill-proficiency');
  const skillOrderInput    = document.getElementById('skill-order');
  const skillDeleteIdInput = document.getElementById('skill-delete-id');
  const skillCatList       = document.getElementById('skill-categories-list');

  // Populate the category datalist with distinct values from existing skills
  [...new Set(skills.map(s => s.category).filter(Boolean))].forEach(cat => {
    const opt = document.createElement('option');
    opt.value = cat;
    skillCatList.appendChild(opt);
  });

  function clearSkillForm() {
    skillIdInput.value    = 'new';
    skillForm.reset();
    skillDeleteBtn.hidden = true;
  }

  function populateSkillForm(skill) {
    skillIdInput.value       = skill.id;
    skillNameInput.value     = skill.name ?? '';
    skillCategoryInput.value = skill.category ?? '';
    skillProfInput.value     = skill.proficiency ?? 0;
    skillOrderInput.value    = skill.order_index ?? 0;
    skillDeleteBtn.hidden    = false;
  }

  // Sidebar — click a skill to load it into the form
  document.querySelectorAll('.skill-item').forEach(btn => {
    btn.addEventListener('click', () => {
      const skill = skills.find(s => s.id == btn.dataset.id);
      if (skill) populateSkillForm(skill);
    });
  });

  // New Skill — clear the form
  skillNewBtn.addEventListener('click', clearSkillForm);

  // Delete — confirm, then submit the delete form
  skillDeleteBtn.addEventListener('click', () => {
    if (!confirm('Delete this skill? This cannot be undone.')) return;
    skillDeleteIdInput.value = skillIdInput.value;
    skillDeleteForm.submit();
  });
</script>
