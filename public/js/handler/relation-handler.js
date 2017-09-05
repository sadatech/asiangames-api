// Checking if branch still has child data in kind sport
function branchKindRelation(branchSportId) {
    // return branchSportId;
    return JSON.parse($.ajax({
        type: 'POST',
        url: 'relation/branchkind',
        dataType: 'json',
        data: { branchSportId: branchSportId },
        global: false,
        async: false,
        success: function (data) {
            return data;
        }
    }).responseText);
}

// Checking if kind sport still has child data in type sport
function kindTypeRelation(kindSportId) {
    return JSON.parse($.ajax({
        type: 'POST',
        url: 'relation/kindtype',
        dataType: 'json',
        data: { kindSportId: kindSportId },
        global: false,
        async: false,
        success: function (data) {
            return data;
        }
    }).responseText);
}