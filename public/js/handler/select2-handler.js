var filters = {};

// Set options
function setOptions (url, placeholder, data, processResults) {
    return {
        ajax: {
            url: url,
            method: 'POST',
            dataType: 'json',
            delay: 250,
            data: data,
            processResults: processResults
        },        
        width: '100%',
        placeholder: placeholder,
    }
}

// Filter data method
function filterData (search, term) {

    // Check if term is ""
    (term == "") ? term = "all" : term = term;

    var results = {};
    if ($.isEmptyObject(this.filters)) {
        return {
            [search]: term
        }
    }

    for (var filter in this.filters) {
        results[filter] = this.filters[filter];
        results[search] = term
    }
    return results;
}

// Set select2 for PATCH METHOD
function setSelect2IfPatch(element, id, text){

    if($('input[name=_method]').val() == "PATCH"){

        element.select2("trigger", "select", {
            data: { id: id, text: text }
        });

        // Remove validation of success
        element.closest('.form-group').removeClass('has-success');

        var span = element.parent('.input-group').children('.input-group-addon');
        span.addClass('display-hide');

        // Remove focus from selection
        element.next().removeClass('select2-container--focus');

    }

}

// Set select2 for PATCH METHOD => FOR MODALS
function setSelect2IfPatchModal(element, id, text){

    element.select2("trigger", "select", {
        data: { id: id, text: text }
    });

    // Remove validation of success
    element.closest('.form-group').removeClass('has-success');

    var span = element.parent('.input-group').children('.input-group-addon');
    span.addClass('display-hide');

    // Remove focus from selection
    element.next().removeClass('select2-container--focus');

}

// Reset select2
function select2Reset(element){

    element.select2('val','All');

    // Remove validation of success
    element.closest('.form-group').removeClass('has-success');

    var span = element.parent('.input-group').children('.input-group-addon');
    span.addClass('display-hide');

    // Remove focus from selection
    element.next().removeClass('select2-container--focus');

}

/*
 * Select2 validation
 *
 */ 

window.select2Change = function(element, formParam){

    // harus cek di html nya (harus pake attr "required")
    if(element.prop('required')) {

        var form = formParam;
        var errorAlert = $('.alert-danger', form);
        var successAlert = $('.alert-success', form);

        // set success class to the control group
        element.closest('.form-group').removeClass('has-error').addClass('has-success');

        // For select2 option
        var span = element.parent('.input-group').children('.input-group-addon');
        span.removeClass('display-hide');

        var spanIcon = $(span).children('i');
        spanIcon.removeClass('fa-warning').addClass("fa-check");
        spanIcon.removeClass('font-red').addClass("font-green");
        spanIcon.attr("data-original-title", "");

        // Check if all requirement valid and show success text
        if(errorAlert.is(":visible") || successAlert.is(":visible")){
            var errors = 0;
            form.each(function(){
                if($(this).find('.form-group').hasClass('has-error')){
                    errors += 1;
                } 
            });            

            if(errors == 0){ 
                successAlert.show();
                errorAlert.hide();
            }else{
                successAlert.hide();
                errorAlert.show();
            }
        }

    }
}