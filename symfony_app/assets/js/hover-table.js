var addHoverClass = function(e) {
    if ($(e).hasClass("table-warning")) {
        $(e).addClass("t-warning-hover");
    } else if ($(e).hasClass("table-danger")) {
        $(e).addClass("t-danger-hover");
    } else if ($(e).hasClass("table-success")) {
        $(e).addClass("t-success-hover");
    } else {
        $(e).addClass("t-hover");
    }
};

$('table.table-hover tbody td').hover(function(){
    // @todo add construct
    var tbody = this.closest('tbody');
    var row = $(this).attr('data-row');
    if ($(this).is("[data-sub-row]")) {
        var isSubRow = true;
        var subRow = $(this).attr('data-sub-row');
    } else {
        var isSubRow = false;
    }

    if (isSubRow) {
        // add to all this sub-row
        $(tbody).find('[data-row='+ row +'][data-sub-row='+ subRow +']').each(function(){
            console.log(1);
            addHoverClass(this);
        });
        // find not sub-row
        $(tbody).find('[data-row='+ row +']').each(function(){
            if ( ! $(this).is("[data-sub-row]")) {
                console.log(2);
                addHoverClass(this);
            }
        });
    } else {
        // add to all tr/td from this row
        $(tbody).find('[data-row='+ row +']').each(function(){
            console.log(3);
            addHoverClass(this);
        });
    }

}, function () {
    var row = $(this).attr('data-row');
    var tbody = this.closest('tbody');

    // add to all tr/td from this row
    $(tbody).find('[data-row='+ row +']').each(function(){
        $(this).removeClass("t-hover")
            .removeClass("t-hover")
            .removeClass("t-warning-hover")
            .removeClass("t-danger-hover")
            .removeClass("t-success-hover");
    });
});
