$(function () {
    $('.select2').select2();
    $('.select2-ajax').select2({
        ajax: {
            minimumInputLength: 3,
            url: '/admin/ajax',
            data: function (params) {
                var query = {
                    search: params.term,
                    className: $(this).attr('data-classname'),
                    target_field: $(this).attr('data-target-field')
                }

                return query;
            },
            dataType: 'json'
        }
    });
});