// cyclicity
$('tr[data-row=input] td[data-column=cyclicity] select').on('change', function() {
    var selectCyclicity = $(this).find('option:selected')[0]
    var table = this.closest('table')
    var rowInput = $(table).find('tbody tr[data-row=input]')[0];
    var inputDay = $(rowInput).find('td[data-column=day] input')[0];
    var eachDay = $(rowInput).find('td[data-column=day] span')[0];

    if (selectCyclicity.text == 'e_month') {
        $(eachDay).hide();
        $(inputDay).show();
    } else if (selectCyclicity.text == 'e_week') {
        $(eachDay).hide();
        $(inputDay).show();
    } else if (selectCyclicity.text == 'e_day') {
        $(inputDay).hide();
        $(eachDay).show();
    } else {
        console.log('uncorrect cyclicity');
    }
});

$('button.add').click(function() {
    var table = this.closest('table')

    $('tr[data-row=error-wrapper] td div.error').each(function(){
        $(this).remove();
    });

    var type = $(table).attr('data-typetransactions');
    var rowInput = $(table).find('tbody tr[data-row=input]')[0];

    var cyclicity = $(rowInput).find('td[data-column=cyclicity] select').find(':selected').text();
    if (cyclicity == 'e_day') {
        var day = '1';
    } else {
        var day = $(rowInput).find('td[data-column=day] input')[0].value;
    }
    var amount = $(rowInput).find('td[data-column=amount] input')[0].value;
    var description = $(rowInput).find('td[data-column=description] input')[0].value;

    var countError = 0;
    var error = '';
    function isNumeric(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

    // day
    if (day.length < 1) {
        countError++;
        error = error +'day is empty<br/>';
    } else {
        if (isNumeric(day)) {
            if (Number(day) < 1) {
                countError++;
                error = error +'min day = 1<br/>';
            }
            if (cyclicity == 'e_month') {
                if (Number(day) > 28) {
                    countError++;
                    error = error + 'max day in month = 28<br/>';
                }
            }
            if (cyclicity == 'e_week') {
                if (Number(day) > 7) {
                    countError++;
                    error = error +'max day in week = 7<br/>';
                }
            }
        } else {
            error = error + 'day must be number<br/>';
        }
    }

    // amount
    if (amount.length < 1) {
        countError++;
        error = error +'amount is empty<br/>';
    } else {
        if (isNumeric(amount)) {
            if (amount.length > 10) {
                countError++;
                error = error +'max length amount = 10<br/>';
            }
            if (Number(amount) < 1) {
                countError++;
                error = error +'min amount = 1<br/>';
            }
        } else {
            error = error + 'amount must be number<br/>';
        }
    }

    // description
    if (description.length > 50) {
        countError++;
        error = error +'max length description = 50<br/>';
    }
    if (description.length < 1) {
        countError++;
        error = error +'description is empty<br/>';
    }

    // showOnHomePage
    var showOnHomePageTmp = $(rowInput).find('td[data-column=show-on-homepage] select').find(':selected').text();
    if (showOnHomePageTmp == 'yes') {
        var showOnHomePage = 1;
    } else if (showOnHomePageTmp == 'no') {
        var showOnHomePage = 0;
    }

    if (countError == 0) {
        $.ajax({
            type: 'post',
            url: '/ajax/add-transaction',
            data: {
                'type': type,
                'cyclicity': cyclicity,
                'day': day,
                'amount': amount,
                'description': description,
                'show-on-homepage': showOnHomePage,
            },
            success: function(data) {
                location.reload(); // @todo
            },
        });
    } else {
        var html = $('<div class="error">'+ error +'</div>');
        $(table).find('tr[data-row=error-wrapper] td')[0].append(html[0]);
    }
    $('input').val('');

    // reset selects
    $(rowInput).find('select').prop('selectedIndex', 0);
    // hide day e_day default
    var eachDay = $(rowInput).find('td[data-column=day] span')[0];
    console.log(eachDay);
    $('span.default-eday').hide();
    // show day input
    var inputDay = $(rowInput).find('td[data-column=day] input')[0];
    $(inputDay).show();

});
