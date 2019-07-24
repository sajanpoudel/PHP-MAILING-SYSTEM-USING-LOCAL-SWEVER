// Disables the send button after the first click so a double click cannot send the mail twice.
document.addEventListener('DOMContentLoaded', function () {
  var form = document.getElementById('mail-form');
  if (!form) return;
  form.addEventListener('submit', function () {
    var button = form.querySelector('button[type="submit"]');
    if (button) {
      button.disabled = true;
      button.textContent = 'Sending...';
    }
  });
});
