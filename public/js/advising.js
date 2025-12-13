function getmeetings() {
    var courseid = document.getElementById("catalogcourse").value;
    $.get("/universitybylaws/bylawgradingschema/getprograms/" + courseid, function (response) {
        var data = JSON.parse(response);
        var table = "<table  class=\"table table-striped table-bordered dt-responsive text-center tablebody\">";
        var head = "<thead>"
                    +"<th>Choose</th>"
                    +"<th>Type</th>"
                    +"<th>Room</th>"
                    +"<th>Day</th>"
                    +"<th>Period</th>"
                    +"</thead>";
        var htmlOut = "";
        var body = "<tbody>";
        var endbody = "</tbody>" + "</table>";

        const sizeRow = document.getElementById("meetingtables").cloneNode(true);
        document.querySelector(".meeting-container").appendChild(sizeRow);
        
        $("#meetingtables").html(table + head + body+ endbody+htmlOut);


    });
}


function test() {
    var courseid = document.getElementById("catalogcourse").value;
    $.get("/universitybylaws/bylawgradingschema/getprograms/" + courseid, function (response) {
        var data = JSON.parse(response);
        var table = "<option  value =\"\" selected disabled>Choose Program </option>";
        var htmlOut = "";
        for (var i = 0; i < data.length; i++) {
            htmlOut +=
                '<option value="' +
                data[i]["id"] +
                '">' +
                data[i]["name_english"]
                "</option>";
        }
        $("#meetingtables").html(table + htmlOut);
    });
}