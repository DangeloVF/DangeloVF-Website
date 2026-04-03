<h2>Qualifications</h2>
<aside id="qualifications-sidebar">
  <button type="button" id="qualification-new-btn">+ New Qualification</button>
  <ul id="qualifications-list">
    <?php foreach ($qualifications as $q): ?>
      <li>
        <button type="button" class="qualification-item" data-id="<?= h($q['id']) ?>">
          <?= h($q['qualification']) ?> (<?= h($q['institution']) ?>)
        </button>
      </li>
    <?php endforeach; ?>
  </ul>
</aside>

<div class="form-panel">
<form method="post" id="qualification-form" autocomplete="off">
  <input type="hidden" id="qualification-id" name="qualification_id" value="new">
  <input type="hidden" name="action" value="save_qualification">
  <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">

  <label for="qualification-institution">Institution</label><br>
  <input type="text" id="qualification-institution" name="institution"><br>

  <label for="qualification-title">Qualification</label><br>
  <input type="text" id="qualification-title" name="qualification"><br>

  <label for="qualification-grade">Grade</label><br>
  <input type="text" id="qualification-grade" name="grade"><br>

  <label for="qualification-year">Year</label><br>
  <input type="number" id="qualification-year" name="year" min="1900" max="2099"><br>

  <label for="qualification-order">Order</label><br>
  <input type="number" id="qualification-order" name="order_index" min="0" value="0"><br><br>

  <button type="submit" id="qualification-save-btn">Save Qualification</button>
</form>

<!-- Separate form for delete — JS sets qualification_id and submits this -->
<button type="button" id="qualification-delete-btn" hidden>Delete Qualification</button>
<form method="post" id="qualification-delete-form">
  <input type="hidden" name="action" value="delete_qualification">
  <input type="hidden" name="csrf_token" value="<?= h($csrfToken) ?>">
  <input type="hidden" name="qualification_id" id="qualification-delete-id" value="">
</form>
</div>

<script>
  const qualifications                = <?= json_encode($qualifications ?? []) ?>;
  const qualificationNewBtn           = document.getElementById('qualification-new-btn');
  const qualificationDeleteBtn        = document.getElementById('qualification-delete-btn');
  const qualificationDeleteForm       = document.getElementById('qualification-delete-form');
  const qualificationForm             = document.getElementById('qualification-form');
  const qualificationIdInput          = document.getElementById('qualification-id');
  const qualificationInstitutionInput = document.getElementById('qualification-institution');
  const qualificationTitleInput       = document.getElementById('qualification-title');
  const qualificationGradeInput       = document.getElementById('qualification-grade');
  const qualificationYearInput        = document.getElementById('qualification-year');
  const qualificationOrderInput       = document.getElementById('qualification-order');
  const qualificationDeleteIdInput    = document.getElementById('qualification-delete-id');

  function clearQualificationForm() {
    qualificationIdInput.value    = 'new';
    qualificationForm.reset();
    qualificationDeleteBtn.hidden = true;
  }

  function populateQualificationForm(qualification) {
    qualificationIdInput.value          = qualification.id;
    qualificationInstitutionInput.value = qualification.institution ?? '';
    qualificationTitleInput.value       = qualification.qualification ?? '';
    qualificationGradeInput.value       = qualification.grade ?? '';
    qualificationYearInput.value        = qualification.year ?? '';
    qualificationOrderInput.value       = qualification.order_index ?? 0;
    qualificationDeleteBtn.hidden       = false;
  }

  // Sidebar — click a qualification to load it into the form
  document.querySelectorAll('.qualification-item').forEach(btn => {
    btn.addEventListener('click', () => {
      const qualification = qualifications.find(q => q.id == btn.dataset.id);
      if (qualification) populateQualificationForm(qualification);
    });
  });

  // New Qualification — clear the form
  qualificationNewBtn.addEventListener('click', clearQualificationForm);

  // Delete — confirm, then submit the delete form
  qualificationDeleteBtn.addEventListener('click', () => {
    if (!confirm('Delete this qualification? This cannot be undone.')) return;
    qualificationDeleteIdInput.value = qualificationIdInput.value;
    qualificationDeleteForm.submit();
  });
</script>
