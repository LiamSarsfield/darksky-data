$(document).ready(function () {
    $('.submit-darksky-data').on('click', function () {
        if (!$('.darksky-data-form').validationEngine('validate')) {
            return false;
        } else {
            save_darksky_data_item($(".darksky-data-form").serialize())
        }
    });
    $('#darksky-data-modal-open').on('click', function () {
        add_darksky_data_item();
    });

    $('.datatable').DataTable({
        "ajax": '/admin/ajax_get_darksky_data',
        "processing": true,
        "serverSide": true,
        "language": {
            processing: '<div class="spinner-border m-auto" role="status"><span class="sr-only">Loading...</span></div>'
        },
        "columns": [
            {"data": "username"},
            {"data": "lat"},
            {"data": "lng"},
            {"data": "date_requested"},
            {
                "render": function (data, type, row, meta) {
                    return '<div class="dropdown" data-darksky_data_item="' + row.id + '">\n' +
                        '  <button class="btn btn-primary dropdown-toggle" type="button" id="actions-dropdown" \n' +
                        '  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>\n' +
                        '  <div class="bg-info dropdown-menu" aria-labelledby="dropdownMenuButton">\n' +
                        '  <a class="bg-info text-white dropdown-item view-darksky-data-item" href="#">View</a>\n' +
                        '  <a class="bg-info text-white dropdown-item delete-darksky-data-item" href="#">Delete</a>\n' +
                        '  </div>\n' +
                        '</div>'
                }, "orderable": false
            }
        ], "drawCallback": function (settings, json) {
            view_darksky_data_modal_listener();
            delete_darksky_data_model_listener();
        }, "order": [[3, "desc"]]
    });
});

function save_darksky_data_item(data) {
    $.post("/admin/ajax_save_darksky_data", data, function (reply) {
        reply = JSON.parse(reply);
        if (reply.response !== 'error') {
            open_darksky_data_item(reply.darksky_data);
            $('.datatable').DataTable().ajax.reload();
        }
        $('.darksky-data-form').prepend(reply.message);
    });
}

function view_darksky_data_modal_listener() {
    $('.view-darksky-data-item').on('click', function () {
        $.post("/admin/ajax_get_darksky_data_item", {"id": $(this).parents('.dropdown').data('darksky_data_item')},
            function (darksky_data_item) {
                open_darksky_data_item(JSON.parse(darksky_data_item));
            });
    });
}

function delete_darksky_data_model_listener() {
    $('.delete-darksky-data-item').on('click', function () {
        $.post("/admin/ajax_delete_darksky_data", {"id": $(this).parents('.dropdown').data('darksky_data_item')},
            function (reply) {
                reply = JSON.parse(reply);
                add_alert(reply.response, reply.message);
            });
        $('.datatable').DataTable().ajax.reload();
    });
}

function open_darksky_data_item(darksky_data_item) {
    for (darksky_property in darksky_data_item) {
        let property_element = $('.darksky-data-body').find(`#${darksky_property}`);
        if (property_element.length === 1) {
            property_element.val(darksky_data_item[darksky_property]);
        }
    }
    $('#darksky-data-modal').modal().find('.read-only-darksky-data').removeClass('d-none');
    $('.darksky-data-form').find('input').prop('readonly', true);
    $('#darksky-data-modal').find('.modal-footer').removeClass('d-flex').addClass('d-none');
    $('#darksky-data-modal').find('.modal-header > .modal-title').text('View data');
    $('.darksky-data-body').find('.alert-info').remove();
}

function add_darksky_data_item() {
    $('#darksky-data-modal').modal().find('.read-only-darksky-data').addClass('d-none');
    $('.darksky-data-form').find('input').val('').prop('readonly', false);
    $('#darksky-data-modal').find('.modal-footer').addClass('d-flex').removeClass('d-none');
    $('#darksky-data-modal').find('.modal-header > .modal-title').text('Add data');
}

function validate_coordinates(input) {
    if (/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}/.test($(input).val())) {
        return true;
    } else {
        return "Invalid " + $(input).attr('name');
    }
    return "test";
}

function add_alert(type, message) {
    let alert = $('.alert-clone').clone(true).removeClass('d-none').addClass(`alert-${type}`);
    alert.find('.alert-content-status').text(type);
    alert.find('.alert-content').text(message);
    $('.fixed-alert-popup').append(alert);
}