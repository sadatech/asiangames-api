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


// Checking if countries still has child data in athletes
function countryAthleteRelation(countryId) {
    return JSON.parse($.ajax({
        type: 'POST',
        url: 'relation/countryathlete',
        dataType: 'json',
        data: { countryId: countryId },
        global: false,
        async: false,
        success: function (data) {
            return data;
        }
    }).responseText);
}

// Checking if type sport still has child data in match entry
function typeMatchRelation(typeSportId) {
    return JSON.parse($.ajax({
        type: 'POST',
        url: 'relation/typematch',
        dataType: 'json',
        data: { typeSportId: typeSportId },
        global: false,
        async: false,
        success: function (data) {
            return data;
        }
    }).responseText);
}

// Checking if athlete still has child data in match group
function athleteMatchGroupRelation(athleteId) {
    return JSON.parse($.ajax({
        type: 'POST',
        url: 'relation/athletematchgroup',
        dataType: 'json',
        data: { athleteId: athleteId },
        global: false,
        async: false,
        success: function (data) {
            return data;
        }
    }).responseText);
}

// Checking if match entry still has child data in match group
function athleteMatchGroupRelation(matchEntryId) {
    return JSON.parse($.ajax({
        type: 'POST',
        url: 'relation/matchentrymatchgroup',
        dataType: 'json',
        data: { matchEntryId: matchEntryId },
        global: false,
        async: false,
        success: function (data) {
            return data;
        }
    }).responseText);
}