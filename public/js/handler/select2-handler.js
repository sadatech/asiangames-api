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
function setIfPatch(element, id, text){

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