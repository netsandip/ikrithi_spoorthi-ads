$(function () {
    $('#side-menu').metisMenu();
});

$('.input-daterange').datepicker({
    todayHighlight: true,
    format: 'dd/mm/yyyy',
});

// Load datatable
$(document).ready(function () {
    $('#dataTableClients').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: BASE_URL + 'client/fetch_post',
            type: 'post'
        },
        columns: [
            {
                class: "sl-no text-center",
                orderable: false,
//                data: null,
//                defaultContent: ""
            },
            {},
            {},
            {},
            {
                class: "actions text-center",
                orderable: false,
            }
        ],
        order: [[1, 'asc']]
    });

    $('#dataTableVendors').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: BASE_URL + 'vendor/fetch_post',
            type: 'post'
        },
        columns: [
            {class: "sl-no text-center", orderable: false, }, {}, {}, {}, {},
            {class: "actions text-center", orderable: false, }
        ],
        order: [[1, 'asc']]
    });

    $('#dataTableVendorTypes').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: BASE_URL + 'vendor_type/fetch_post',
            type: 'post'
        },
        columns: [
            {class: "sl-no text-center", orderable: false, }, {},
            {class: "actions text-center", orderable: false, }
        ],
        order: [[1, 'asc']]
    });
    
    $('#dataTablePageTypes').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: BASE_URL + 'page_type/fetch_post',
            type: 'post'
        },
        columns: [
            {class: "sl-no text-center", orderable: false, }, {},
            {class: "actions text-center", orderable: false, }
        ],
        order: [[1, 'asc']]
    });

    $('#dataTablePublications').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: BASE_URL + 'publication/fetch_post',
            type: 'post'
        },
        columns: [
            {class: "sl-no text-center", orderable: false, }, {},{},
            {class: "actions text-center", orderable: false, }
        ],
        order: [[1, 'asc']]
    });

    var dataTableEditions = $('#dataTableEditions').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: BASE_URL + 'edition/fetch_post',
            type: 'post'
        },
        columns: [
            {class: "sl-no text-center", orderable: false, }, {},
            {class: "actions text-center", orderable: false, }
        ],
        order: [[1, 'asc']]
    });
    
    var dataTableTax = $('#dataTableTax').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: BASE_URL + 'tax/fetch_post',
            type: 'post'
        },
        columns: [
            {class: "sl-no text-center", orderable: false, }, {},{},{},
            {class: "actions text-center", orderable: false, }
        ],
        order: [[1, 'asc']]
    });

    $('#dataTableAdTypes').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: BASE_URL + 'ad_type/fetch_post',
            type: 'post'
        },
        columns: [
            {class: "sl-no text-center", orderable: false, }, {},{},{},
            {class: "actions text-center", orderable: false, }
        ],
        order: [[1, 'asc']]
    });

    $('#dataTableMaterialTypes').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: BASE_URL + 'material_type/fetch_post',
            type: 'post'
        },
        columns: [
            {class: "sl-no text-center", orderable: false, }, {},
            {class: "actions text-center", orderable: false, }
        ],
        order: [[1, 'asc']]
    });

    $('#dataTableMaterialStatus').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: BASE_URL + 'material_status/fetch_post',
            type: 'post'
        },
        columns: [
            {class: "sl-no text-center", orderable: false, }, {},
            {class: "actions text-center", orderable: false, }
        ],
        order: [[1, 'asc']]
    });
    
    $('#dataTablePackages').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: BASE_URL + 'package/fetch_post',
            type: 'post'
        },
        columns: [
            {class: "sl-no text-center", orderable: false, }, {},{},{},{class: "text-center"},{class: "text-center"},
            {class: "actions text-center", orderable: false, }
        ],
        order: [[1, 'asc']]
    });

    $('#dataTableReleaseOrders').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: BASE_URL + 'release_order/fetch_post',
            type: 'post'
        },
        columns: [
            {class: "sl-no text-center", orderable: false, }, {class: "text-center"},{},{},{},{},{class: "text-right"},
            {class: "actions text-center", orderable: false, }
        ],
        order: [[1, 'desc']]
    });
    $('#dataTableInvoices').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: BASE_URL + 'invoice/fetch_post',
            type: 'post'
        },
        columns: [
            {class: "sl-no text-center", orderable: false, }, {class: "text-center"}, {class: "text-center"}, {},{class: "text-right"},
            {class: "actions text-center", orderable: false, }
        ],
        order: [[1, 'asc']]
    });

    // DELETE
    $("#select_all").on('click', function () { // bulk checked
        var status = this.checked;
        $(".chk_row").each(function () {
            $(this).prop("checked", status);
        });
    });

    $('#btn_delete').on("click", function (event) { // triggering delete one by one
        if (!confirm('Sure you want to delete the records?')) {
            return false;
        }
        if ($('.chk_row:checked').length > 0) {  // at-least one checkbox checked
            var ids = [];
            $('.chk_row').each(function () {
                if ($(this).is(':checked')) {
                    ids.push($(this).val());
                }
            });
            var ids_string = ids.toString();  // array to string conversion 
            $.ajax({
                type: "POST",
                url: BASE_URL + "edition/bulk_delete",
                data: {data_ids: ids_string},
                success: function (result) {
                    dataTableEditions.draw(); // redrawing datatable
                },
                async: false
            });
        }
    });
    // DELETE
});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function () {
    $(window).bind("load resize", function () {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1)
            height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function () {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
});

/*
 * Vendor form
 */
$(document).on('click', '#btn_add_vendor_coordinator', function () {
    html = '<tr>';
    html += '<td>' + vendor_form_coordinator_fullname + '</td>';
    html += '<td>' + vendor_form_coordinator_phone + '</td>';
    html += '<td>' + vendor_form_coordinator_email + '</td>';
    html += '<td>' + vendor_form_coordinator_designation + '</td>';
    html += '<td class="text-center"><a class="btn btn-danger btn-sm btn-remove-vendor-coordinator"><i class="fa fa-remove"></i></a></td>';
    html += '</tr>';
    $('.form_coordinator').append(html);
});
$(document).on('click', '.btn-remove-vendor-coordinator', function () {
    $(this).parent().parent().remove();
});

/*
 * Client form
 */
$(document).on('click', '#btn_add_client_coordinator', function () {
    html = '<tr>';
    html += '<td>' + client_form_coordinator_fullname + '</td>';
    html += '<td>' + client_form_coordinator_phone + '</td>';
    html += '<td>' + client_form_coordinator_email + '</td>';
    html += '<td>' + client_form_coordinator_designation + '</td>';
    html += '<td class="text-center"><a class="btn btn-danger btn-sm btn-remove-client-coordinator"><i class="fa fa-remove"></i></a></td>';
    html += '</tr>';
    $('.form_coordinator').append(html);
});
$(document).on('click', '.btn-remove-client-coordinator', function () {
    $(this).parent().parent().remove();
});