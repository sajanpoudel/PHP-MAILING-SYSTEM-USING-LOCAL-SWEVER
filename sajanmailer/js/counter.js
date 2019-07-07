// Shows how many characters are left under a text field with a maxlength.
(function () {
  function attach(field) {
    var limit = parseInt(field.getAttribute('maxlength'), 10);
    if (!limit) return;
    var note = document.createElement('small');
    note.className = 'text-muted';
    field.parentNode.appendChild(note);
    function update() {
      note.textContent = limit - field.value.length + ' characters left';
    }
    field.addEventListener('input', update);
    update();
  }

  document.addEventListener('DOMContentLoaded', function () {
    var fields = document.querySelectorAll('input[maxlength][name="subject"], textarea[maxlength]');
    Array.prototype.forEach.call(fields, attach);
  });
})();
