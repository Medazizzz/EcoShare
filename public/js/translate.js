document.addEventListener('DOMContentLoaded', () => {
  const buttons = document.querySelectorAll('[data-translate-button]');

  if (!buttons.length) {
    return;
  }

  function detectTargetLanguage(text) {
    // Very simple heuristic: if there are many French accented chars, target EN; otherwise FR
    const hasFrenchChars = /[éèêàùçâîôû]/i.test(text);
    return hasFrenchChars ? 'en' : 'fr';
  }

  buttons.forEach((btn) => {
    btn.addEventListener('click', async () => {
      const card = btn.closest('[data-translate-container]');
      if (!card) return;

      const textEl = card.querySelector('[data-translate="true"]');
      if (!textEl) return;

      const original = textEl.textContent.trim();
      if (!original) return;

      const targetSelect = card.querySelector('[data-translate-target]');
      let target = targetSelect ? targetSelect.value : detectTargetLanguage(original);

      btn.disabled = true;
      const originalLabel = btn.innerHTML;
      btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ...';

      try {
        const response = await fetch('/api/translate', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify({ text: original, target })
        });

        if (!response.ok) {
          throw new Error('HTTP ' + response.status);
        }

        const data = await response.json();
        if (data.translated) {
          textEl.textContent = data.translated;

          // remove existing badge
          const existingBadge = card.querySelector('.google-translate-badge');
          if (existingBadge) existingBadge.remove();

          const badge = document.createElement('div');
          badge.className = 'google-translate-badge mt-2 small text-muted';
          badge.innerHTML = '🌐 Translated by <strong>Google Translate</strong> <button type="button" class="btn btn-link btn-xs p-0 ms-2 text-decoration-none">&times;</button>';

          const closeBtn = badge.querySelector('button');
          closeBtn.addEventListener('click', () => badge.remove());

          textEl.parentNode.appendChild(badge);
        }
      } catch (e) {
        console.error('Translation error', e);
        alert('Erreur lors de la traduction. Veuillez réessayer.');
      } finally {
        btn.disabled = false;
        btn.innerHTML = originalLabel;
      }
    });
  });
});
