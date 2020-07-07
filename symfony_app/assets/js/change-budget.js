// add tih
$('button#add-budget').click(function() {
    var tih = $('input#tih').val();

    $.ajax({
        type: 'post',
        url: '/ajax/edit-budget',
        data: {
            'tih': tih,
            'hl': 0,
        },
        success: function(data) {
            location.reload(); // @todo
        },
    });

    $('input').val('');
});
// edit budget
$('button.budget-edit').click(function() {
    var row = this.closest('tr')
    var amount = $(row).find('.amount')[0];
    var input = $(row).find('input')[0];
    var cancel = $(row).find('.budget-cancel')[0];
    var submit = $(row).find('.budget-submit')[0];

    $('button.budget-edit').hide();
    $(amount).hide();
    $(input).show();
    $(input).focus().select()
    $(cancel).show();
    $(submit).show();

    $('button.budget-cancel').click(function() {
        $(submit).hide();
        $(cancel).hide();
        $(input).hide();
        $(amount).show();
        $('button.budget-edit').show();
    });

    $('button.budget-submit').click(function() {
        $(submit).hide();
        $(cancel).hide();
        $(input).hide();

        var tih = $('input.tih').val();
        var hl = $('input.hl').val();

        $.ajax({
            type: 'post',
            url: '/ajax/edit-budget',
            data: {
                'tih': tih,
                'hl': hl,
            },
            success: function(data) {
                location.reload(); // @todo
            },
        });
    });
});
