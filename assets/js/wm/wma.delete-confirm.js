$( document ).ready(function() {
    $('[data-wma-delete-url]').click(function (e) {
        var target = $(e.target);
        if (target.is("span") || target.is("i")) {
            target = target.parent();
        }
        var itemName = 'record';
        if (target.attr('data-wma-delete-item-name')) {
            itemName = target.data('wma-delete-item-name');
        }
        $.SmartMessageBox({
            title: "<i class='fa fa-times text-danger'></i> Are you sure you want to delete this "+itemName+"?",
            content: "This action cannot be undone, use caution! This will <strong class='text-danger'>Permanently Delete</strong> this "+itemName+" from the database!",
            buttons: '[Delete][Cancel]'
        }, function (ButtonPressed) {
            if (ButtonPressed === "Delete") {
                var deleteUrl = target.data('wma-delete-url');
                var csrfParam = yii.getCsrfParam();
                var obj = {};
                obj[csrfParam] = yii.getCsrfToken();
                $.redirect(deleteUrl, obj);
            }
            if (ButtonPressed === "Cancel") {

            }

        });
        e.preventDefault();
    })
});