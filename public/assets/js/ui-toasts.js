/**
 * UI Toasts
 */

'use strict';
// Function to initialize and show the toast
// Function to create and show the toast
function showToast(tipe,message) {
  let bg = 'bg-'+tipe;
  // Create the toast container div
  const toastContainer = document.createElement('div');
  toastContainer.classList.add('toast-container');
  toastContainer.classList.add('position-fixed', 'top-0', 'end-0', 'm-3');
  toastContainer.style.position = 'fixed';
  toastContainer.style.zIndex = '9999';

  // Create the toast itself
  const toast = document.createElement('div');
  toast.classList.add('bs-toast', 'toast', 'fade', 'show',bg);
  toast.setAttribute('role', 'alert');
  toast.setAttribute('aria-live', 'assertive');
  toast.setAttribute('aria-atomic', 'true');

  // Create the toast header
  const toastHeader = document.createElement('div');
  toastHeader.classList.add('toast-header');

  const icon = document.createElement('i');
  icon.classList.add('bx', 'bx-bell', 'me-2');

  const title = document.createElement('div');
  title.classList.add('me-auto', 'fw-semibold');
  title.textContent = 'Bootstrap';  // Optional: set the title of the toast

  const time = document.createElement('small');
  time.textContent = '';  // Optional: set time

  const closeBtn = document.createElement('button');
  closeBtn.setAttribute('type', 'button');
  closeBtn.classList.add('btn-close');
  closeBtn.setAttribute('data-bs-dismiss', 'toast');
  closeBtn.setAttribute('aria-label', 'Close');

  // Append elements to toast header
  // toastHeader.appendChild(icon);
  // toastHeader.appendChild(title);
  toastHeader.appendChild(time);
  toastHeader.appendChild(closeBtn);

  // Create the toast body
  const toastBody = document.createElement('div');
  toastBody.classList.add('toast-body');
  toastBody.textContent = message; // Optional: set the body text

  // Append the header and body to the toast
  toast.appendChild(toastHeader);
  toast.appendChild(toastBody);

  // Append the toast to the toast container
  toastContainer.appendChild(toast);

  // Append the toast container to the body of the page
  document.body.appendChild(toastContainer);

  // Initialize and show the toast
  const toastInstance = new bootstrap.Toast(toast);
  toastInstance.show();

  // Optional: remove the toast after it disappears
  toast.addEventListener('hidden.bs.toast', () => {
    toastContainer.remove();
  });
}




(function () {
  // Bootstrap toasts example
  // --------------------------------------------------------------------
  const toastPlacementExample = document.querySelector('.toast-placement-ex'),
    toastPlacementBtn = document.querySelector('#showToastPlacement');
  let selectedType, selectedPlacement, toastPlacement;

  // Dispose toast when open another
  function toastDispose(toast) {
    if (toast && toast._element !== null) {
      if (toastPlacementExample) {
        toastPlacementExample.classList.remove(selectedType);
        DOMTokenList.prototype.remove.apply(toastPlacementExample.classList, selectedPlacement);
      }
      toast.dispose();
    }
  }
  // Placement Button click
  if (toastPlacementBtn) {
    toastPlacementBtn.onclick = function () {
      if (toastPlacement) {
        toastDispose(toastPlacement);
      }
      selectedType = document.querySelector('#selectTypeOpt').value;
      selectedPlacement = document.querySelector('#selectPlacement').value.split(' ');

      toastPlacementExample.classList.add(selectedType);
      DOMTokenList.prototype.add.apply(toastPlacementExample.classList, selectedPlacement);
      toastPlacement = new bootstrap.Toast(toastPlacementExample);
      toastPlacement.show();
    };
  }
})();
