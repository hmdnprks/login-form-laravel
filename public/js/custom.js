$(document).ready(function () {
  $('.password-toggle').click(function () {
      var inputField = $(this).prev('input');
      var fieldType = inputField.attr('type');

      if (fieldType === 'password') {
          inputField.attr('type', 'text');
          $(this).removeClass('fa-eye').addClass('fa-eye-slash');
      } else {
          inputField.attr('type', 'password');
          $(this).removeClass('fa-eye-slash').addClass('fa-eye');
      }
  });
});