$(document).on('change', 'form[data-autosubmit] select, form[data-autosubmit] input:not([data-pjax="0"])', function(event) {
    $(this.form).addClass('is--waiting').trigger('submit');
});

$(document).on("click", "[type=submit]", function (event) {
    if ($(this).attr('name') == 'command') {
        var form = $(this).parents('form');

        set_form_command(form, $(this).attr('value'));
    }
});

$(document).on("change", ":input[data-autosubmit]", function () {
    var command = $(this).attr('data-autosubmit');
    set_form_command($(this).parents('form'), command);
    $(this.form).addClass('is--waiting').trigger('submit');
});

function set_form_command(form, command) {
    if (form.length) {
        var command_input = $(form).find('input[type=hidden][name=command]');
        if (!command_input.length) {
            $(form).append('<input type="hidden" name="command" value="'+command+'"/>');
        } else {
            $(command_input).attr('value', command);
        }
    }
}


$(document).on("submit", "form[data-pjax-block]", function (event) {
    var pjax_block = $(this).attr('data-pjax-block');
    var pjax_push = $(pjax_block).is('[data-pjax-push-state]');
    $(this).addClass('form_pjax_preloader');
    $(pjax_block).addClass('block_pjax_preloader');
    jQuery.pjax.submit(event, {"push":pjax_push, "replace":false, "timeout": 10000, "scrollTo":false, "container": pjax_block});
});

$(document).on("click", "a[data-pjax-block]", function (event) {
    var pjax_block = $(this).attr('data-pjax-block');
    var pjax_push = $(pjax_block).is('[data-pjax-push-state]');
    $(this).addClass('btn_pjax_preloader');
    $(pjax_block).addClass('block_pjax_preloader');
    jQuery.pjax.click(event, {"push":pjax_push, "replace":false, "timeout": 10000, "scrollTo":false, "container": pjax_block});
});

$(document).on('pjax:complete', function(event) {
    $(event.relatedTarget).removeClass('form_pjax_preloader btn_pjax_preloader');
    $(event.target).removeClass('block_pjax_preloader');
});