$(document).ready(function () {
    var $form = $('.form-signin'),
        $checkbox = $form.find('input[name="signup"]'),
        $passwordConfirm = $form.find('input[name="password_confirm"]');
    $checkbox.on('change', function () {
        $passwordConfirm.toggleClass('hidden');
    });
});

