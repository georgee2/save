function getmeetings() {
    var academic = document.getElementById("academic_year_code").value;
    var semester = document.getElementById("semester_code").value;
    $.get("/classscheduling/joinmeetings/getmeeting/" + academic + "/" + semester, function (response) {
        var data = JSON.parse(response);
        var select = "<option  value =\"\" selected disabled>Choose Meeting </option>";
        var htmlOut = "";
        for (var i = 0; i < data.length; i++) {
            htmlOut +=
                '<option value="' +
                data[i]["id"] +
                '">' +
                'Code:' + " " + 
                data[i]["course_code_english"] + "-" +" "+data[i]["course_code_english"]
                +" " + "|" +" "
                +'Course:' + " " + 
                data[i]["course_name_english"] + "-" +" "+data[i]["course_name_arabic"]
                +" " + "|" +" "
                +'Period/Day:' + " " + 
                data[i]["name_english"]+ "-" + data[i]["name_arabic"]+" " + data[i]["start_time"] + "-" +" "+data[i]["end_time"]
                +" " + "|" +" "
                +'Type:' + " " + 
                data[i]["type_en"] + "-" +" "+data[i]["type_ar"]
                +" " + "|" +" "
                +'Room:' + " " + 
                data[i]["trans_room_en"] + "-" +" "+data[i]["trans_room_ar"]
                "</option>";
        }
        $("#meeting_code").html(select + htmlOut);
    });
}

function getmeetings_join() {
    var academic = document.getElementById("academic_year_code").value;
    var semester = document.getElementById("semester_code").value;
    var meeting = document.getElementById("meeting_code").value;
    $.get("/classscheduling/joinmeetings/getjoinmeeting/" + academic + "/" + semester + "/" + meeting, function (response) {
        var data = JSON.parse(response);
        var htmlOut = "";
        for (var i = 0; i < data.length; i++) {
            htmlOut +=
                '<option value="' +
                data[i]["id"] +
                '">' +
                'Code:' + " " + 
                data[i]["course_code_english"] + "-" +" "+data[i]["course_code_english"]
                +" " + "|" +" "
                +'Course:' + " " + 
                data[i]["course_name_english"] + "-" +" "+data[i]["course_name_arabic"]
                +" " + "|" +" "
                +'Period/Day:' + " " + 
                data[i]["name_english"]+ "-" + data[i]["name_arabic"]+" " + data[i]["start_time"] + "-" +" "+data[i]["end_time"]
                +" " + "|" +" "
                +'Type:' + " " + 
                data[i]["type_en"] + "-" +" "+data[i]["type_ar"]
                +" " + "|" +" "
                +'Room:' + " " + 
                data[i]["trans_room_en"] + "-" +" "+data[i]["trans_room_ar"]
                "</option>";
        }
        $("#join_meeting").html(htmlOut);
    });
}