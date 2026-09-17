document.addEventListener('submit', function(e) {
    var form = e.target;
    var grecaptcha_input = form.querySelector('[name="g-recaptcha-code"]');

    if (grecaptcha_input && grecaptcha_input.value == '') {
        e.preventDefault();
        e.stopImmediatePropagation();

        grecaptcha.ready(function() {
            grecaptcha.execute(recaptcha_site_key, {action: 'submit'}).then(function(token) {
                grecaptcha_input.value = token;
                form.requestSubmit();
            });
        });

        return false;
    }
});