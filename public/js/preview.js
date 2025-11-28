/**
 * preview.js
 * Shows image preview before uploading in create/edit forms
 * Validates file type and size before preview
 */

console.log('Image preview script loaded');

// Initialize image preview functionality
document.addEventListener('DOMContentLoaded', function () {
  // Get all file input elements with id 'image'
  const imageInput = document.getElementById('image');

  if (!imageInput) {
    console.log('No image input found on this page');
    return;
  }

  console.log('Image preview initialized');

  /**
   * Handle file selection and show preview
   */
  imageInput.addEventListener('change', function (e) {
    const file = e.target.files[0];

    // If no file selected, hide preview
    if (!file) {
      hidePreview();
      return;
    }

    console.log(`File selected: ${file.name}, Size: ${file.size} bytes`);

    // Validate file size (5MB max)
    const maxSize = 5 * 1024 * 1024; // 5MB in bytes
    if (file.size > maxSize) {
      alert('Image size must be less than 5MB');
      this.value = ''; // Clear the input
      hidePreview();
      console.warn('File too large, cleared input');
      return;
    }

    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!allowedTypes.includes(file.type)) {
      alert('Only JPG and PNG images are allowed');
      this.value = ''; // Clear the input
      hidePreview();
      console.warn('Invalid file type, cleared input');
      return;
    }

    // Show preview
    showPreview(file);
  });

  /**
   * Show image preview using FileReader
   */
  function showPreview(file) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');

    if (preview && previewContainer) {
      // Read file and display preview
      const reader = new FileReader();

      reader.onload = function (e) {
        preview.src = e.target.result;
        previewContainer.style.display = 'block';
        console.log('Image preview displayed');
      };

      reader.onerror = function () {
        console.error('Error reading file');
        alert('Error loading image preview');
      };

      reader.readAsDataURL(file);
    }
  }

  /**
   * Hide image preview
   */
  function hidePreview() {
    const previewContainer = document.getElementById('imagePreview');
    if (previewContainer) {
      previewContainer.style.display = 'none';
      console.log('Image preview hidden');
    }
  }

  /**
   * Clear image - called by "Remove Image" button
   */
  window.clearImage = function () {
    imageInput.value = '';
    hidePreview();
    console.log('Image cleared by user');
  };

  console.log('Image preview event listeners attached');
});
