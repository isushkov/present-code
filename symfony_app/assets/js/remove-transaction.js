$('button.remove').click(function() {
    var elem = $(this).closest('tr');
    var id = $(this).closest('tr').attr('data-row');

    $.ajax({
        type: 'post',
        url: '/ajax/remove-transaction',
        data: {
            'id': id,
        },
        success: function(data) {
            elem.remove();
        },
    });
});
