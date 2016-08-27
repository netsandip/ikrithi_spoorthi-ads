function loadPublications(obj, publication) {
    var vendor_id = obj.value;
    $(publication).html("<option>Loading...</option>");
    $.ajax({
        url: BASE_URL + "vendor/find_publications/" + vendor_id,
        dataType: 'html',
        success: function (response) {
            $(publication).html(response);
        }
    });
}

function loadCoordinators(obj) {
    var vendor_id = obj.value;
    $('#coordinators').html("<option>Loading...</option>");
    $.ajax({
        url: BASE_URL + "vendor/find_coordinators_html/" + vendor_id,
        dataType: 'html',
        success: function (response) {
            $('#coordinators').html(response);
        }
    });
}

function checkCommission(obj) {
    var vendor_id = obj.value;
//    $('#gross_amount_container').html("<option>Loading...</option>");
    $.ajax({
        url: BASE_URL + "vendor/get_commission/" + vendor_id,
        dataType: 'json',
        success: function (response) {
            var html = '';

                console.log(response.result);
            if (response.result === 'success') {
                var commission = parseFloat(response.commission);
                if (commission > 0) {
                    html += '<tr>';
                    html += '<td colspan="6" class="text-right">Commission (<small id="vendor_commission">' + response.commission + '</small><small>%</small>)</td>';
                    html += '<td class="text-right" colspan="1" id="commission_amount">';
                    html += '</td>';
                    html += '<td></td>';
                    html += '</tr>';
                    $('#gross_amount_container').after(html);
                    window.commission = commission;
                    computeCommission();
                } else {
                    window.commission = 0;
                }
            }
        }
    });
}

function loadEditions(obj, edition) {
//    console.log(obj.value);
//    console.log($(obj).val());
    var publication_id = $(obj).find(':selected').data('id');
    $('#' + edition).html("<option>Loading...</option>");
    $.ajax({
        url: BASE_URL + "publication/find_editions/" + publication_id,
        dataType: 'html',
        success: function (response) {
            $('#' + edition).html(response);
        }
    });
}

//function loadPackages(obj, package) {
//    var publication_id = $(obj).find(':selected').data('id');
//    var ad_type_id = $('select[name="ad_type"]').val();
//    $('#' + package).html("<option>Loading...</option>");
//    $.ajax({
//        url: BASE_URL + "publication/find_packages/" + publication_id + "/" + ad_type_id,
//        dataType: 'html',
//        success: function (response) {
//            $('#' + package).html(response);
//        }
//    });
//}

function loadPackages(obj, package) {
//    var publication_id = $(obj).find(':selected').data('id');
    var ad_type_id = $('select[name="ad_type"]').val();
    var vendor_id = $('#vendor').val();

    $('#' + package).html("<option>Loading...</option>");
    $.ajax({
//        url: BASE_URL + "publication/find_packages/" + publication_id + "/" + ad_type_id,
        url: BASE_URL + "vendor/find_packages/" + vendor_id + "/" + ad_type_id,
        dataType: 'html',
        success: function (response) {
            $('#' + package).html(response);
        }
    });
}

function resetEditions() {
    $('.editions').each(function () {
        $(this).html('<option value="">Select Edition</option>');
    });
}

function resetPackages() {
    $('.packages').each(function () {
        $(this).html('<option value="">Select Package</option>');
    });
}

$(document).on("click", ".ro_form_insertion_date", function () {
    $(this).datepicker({
        todayHighlight: true,
        multidate: true,
        format: 'dd/mm/yyyy',
    }).focus();
});

//function showDatepicker(obj) {
//    console.log(obj);
//    $(obj).datepicker({
//        todayHighlight: true,
//        multidate: true,
//    }).focus();
//}