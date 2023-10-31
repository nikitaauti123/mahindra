/** Custom Application Javascript  */
import { successMsg, failMsg } from "./messages.js";

function check_login(form_id, btn_id) {

    if (!$(form_id).valid()) {
        return false;
    }

    var form_data = $(form_id).serialize();
    $(btn_id).addClass('button--loading').attr('disabled', true);

    $.ajax({
        url: base_url + 'api/user/login',
        method: "POST",
        data: form_data,
        dataType: "json",
        beforeSend: function (xhr) {
            //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
        },
    }).done(function (data) {
        $(btn_id).removeClass('button--loading').attr('disabled', false);
        successMsg(data.msg);
        location.href = base_url + 'admin/dashboard';
    }).fail(function (data) {
        $(btn_id).removeClass('button--loading').attr('disabled', false);
        if (typeof data.responseJSON.messages === 'object') {
            for (let i in data.responseJSON.messages) {
                failMsg(data.responseJSON.messages[i]);
            }
        } else {
            let msg = data.responseJSON.messages.msg;
            failMsg(msg);
        }

    });
}

$("#login_btn").on('click', function (e) {
    e.preventDefault();
    $("#login_form").validate({
        rules: {

        },
        messages: {

        },
        errorPlacement: function (error, element) {

        }
    })
    check_login("#login_form", "#login_btn");
});

if ($("#users_list_tbl").length > 0) {
    // table
    var users_table = $("#users_list_tbl").DataTable({
        "ordering": true,
        'order': [[1, 'asc']],
        'serverMethod': 'get',
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...',
            "emptyTable": "There is no record to display"
        },
        "dom": 'Bfrtip',
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"],
        "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All'],
        ],
        "ajax": {
            "url": base_url + "api/users/list",
            "dataSrc": "",
        },
        "columns": [
            {
                "data": null,
                "render": function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                "data": "profile_photo",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "first_name",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "last_name",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "email",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "phone",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "username",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "emp_id",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "roles",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "is_active",
                "render": function (data, type, row, meta) {
                    if (data && data != '-') {
                        // Assuming "cb-switch" is the ID of the checkbox input element
                        var checkboxId = "cb-switch";
                        // Create a unique ID for each checkbox
                        var dynamicHTML = '<div class="toggle-switch user_active_inactive" id="' + checkboxId + '" >';
                        if (data == 1) {
                            dynamicHTML += '<label for="' + checkboxId + '"><input  style="display:none"  type="checkbox" name="is_active" value="" checked><span><small></small></span></label></div>';
                        } else {
                            dynamicHTML += '<label for="' + checkboxId + '"><input   style="display:none"  type="checkbox"  name="is_active" value=""><span><small></small></span></label></div>';
                        }
                        return dynamicHTML;

                    } else {
                        return '-';
                    }
                }
            },

            {
                "data": "created_at",
                "render": function (data, type, row, meta) {
                    if (data && data != '-') {
                        return (data);
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "updated_at",
                "render": function (data, type, row, meta) {
                    if (data && data != '-') {
                        return (data);
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": null,
                "render": function (data, type, row, meta) {
                    return '<a href="' + base_url + 'admin/users/edit/' + row['id'] + '"    class="edit_user" ><i class="fa fa-edit"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" data-id="' + row['id'] + '" class="delete_user" ><i class="fa fa-trash"></i></a>';
                }
            }
        ]
    });
    $("#users_list_tbl tbody").on("click", ".user_active_inactive", function () {
        var rowData = users_table.row($(this).closest("tr")).data();
        user_active_inactive(rowData.id, rowData.is_active);
    });

}

function user_active_inactive(id, is_active) {
    var res = confirm("Do you want to update this User status?");
    if (res == true) {
        $.ajax({
            url: base_url + 'api/users/update_is_active',
            method: "POST",
            data: { id: id, is_active: is_active },
            dataType: "json",
            success: function (data) {
                successMsg(data.msg);
                $('#users_list_tbl').DataTable().ajax.reload();
            },
            error: function (xhr, status, error) {

                console.error("Error:", error);
            }
        });
    }

}
//dashboard page
if ($("#from_date").length > 0) {
    $("#from_date").daterangepicker({
        "startDate": moment(),
        "endDate": moment().add(1, 'month')
    }, function (start, end, label) {
        console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');

        $("#from_date").val(start.format('YYYY-MM-DD') + " - " + end.format('YYYY-MM-DD'));
    });
}

// Parts
if ($("#parts_list_tbl").length > 0) {
    // table
    var parts_table = $("#parts_list_tbl").DataTable({
        "ordering": true,
        'order': [[0, 'asc']],
        'serverMethod': 'get',
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...',
            "emptyTable": "There is no record to display"
        },
        "dom": 'Bfrtip',
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"],
        "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All'],
        ],
        "ajax": {
            "url": base_url + "api/parts/list",
            "dataSrc": "",
        },
        "columns": [
            {
                "data": null,
                "render": function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                "data": "part_no",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "part_name",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "model",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },

            {
                "data": "pins",
                "render": function (data, type, row, meta) {
                    if (data) {
                        let count = data.split(",");
                        return '<div class="pin-count" title="' + data + '">' + count.length + '</div>';
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "die_no",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "is_active",
                "render": function (data, type, row, meta) {
                    if (data && data != '-') {
                        // Assuming "cb-switch" is the ID of the checkbox input element
                        var checkboxId = "cb-switch";
                        // Create a unique ID for each checkbox
                        var dynamicHTML = '<div class="toggle-switch part_active_inactive" id="' + checkboxId + '" >';
                        if (data == 1) {
                            dynamicHTML += '<label for="' + checkboxId + '"><input  style="display:none"  type="checkbox" name="is_active" value="" checked><span><small></small></span></label></div>';
                        } else {
                            dynamicHTML += '<label for="' + checkboxId + '"><input   style="display:none"  type="checkbox"  name="is_active" value=""><span><small></small></span></label></div>';
                        }
                        return dynamicHTML;

                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "created_at",
                "render": function (data, type, row, meta) {
                    if (data && data != '-') {
                        return (data);
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "updated_at",
                "render": function (data, type, row, meta) {
                    if (data && data != '-') {
                        return (data);
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": null,
                "render": function (data, type, row, meta) {
                    let html = '<a href="' + base_url + 'admin/parts/edit/' + row['id'] + '"   class="edit_part" data-id="' + row['id'] + '"><i class="fa fa-edit text-info"></i></a>';
                    html += '&nbsp;&nbsp;<a href="javascript:void(0);" class="view_part" data-id="' + row['id'] + '" ><i class="fa fa-eye text-primary"></i></a>';

                    html += '&nbsp;&nbsp;<a href="javascript:void(0);" class="delete_part" data-id="' + row['id'] + '" ><i class="fa fa-trash text-danger"></i></a>';

                    return html;
                }
            }
        ]
    });

    $("#parts_list_tbl tbody").on("click", ".part_active_inactive", function () {
        var rowData = parts_table.row($(this).closest("tr")).data();
        part_active_inactive(rowData.id, rowData.is_active);
    });
}

// Parts
if ($("#jobs_list_tbl").length > 0) {
    // table
    var jobs_table = $("#jobs_list_tbl").DataTable({
        "ordering": true,
        'order': [[0, 'asc']],
        'serverMethod': 'get',
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...',
            "emptyTable": "There is no record to display"
        },
        "dom": 'Bfrtip',
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"],
        "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All'],
        ],
        "ajax": {
            "url": base_url + "api/jobs/list",
            "dataSrc": "",
        },
        "columns": [
            {
                "data": null,
                "render": function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                "data": "part_no",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "part_name",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "model",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "pins",
                "render": function (data, type, row, meta) {
                    if (data) {
                        let count = data.split(",");
                        return '<div class="pin-count" title="' + data + '">' + count.length + '</div>';
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": null,
                "render": function (data, type, row, meta) {
                    return '1';
                }
            },
            {
                "data": "is_active",
                "render": function (data, type, row, meta) {
                    if (data && data != '-') {
                        // Assuming "cb-switch" is the ID of the checkbox input element
                        var checkboxId = "cb-switch"; // Create a unique ID for each checkbox
                        if (data == 1) {
                            return '<div class="toggle-switch job_active_inactive"><label for="' + checkboxId + '"><input type="checkbox" id="' + checkboxId + '" name="is_active" value="" checked><span><small></small></span></label></div>';
                        } else {
                            return '<div class="toggle-switch job_active_inactive"><label for="' + checkboxId + '"><input type="checkbox" id="' + checkboxId + '" name="is_active" value=""><span><small></small></span></label></div>';
                        }
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "created_at",
                "render": function (data, type, row, meta) {
                    if (data && data != '-') {
                        return (data);
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "updated_at",
                "render": function (data, type, row, meta) {
                    if (data && data != '-') {
                        return (data);
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": null,
                "render": function (data, type, row, meta) {
                    let html = '-';
                    //let html = '<a href="'+base_url+'admin/parts/edit/'+row['id']+'"   class="edit_part" data-id="'+row['id']+'"><i class="fa fa-edit text-info"></i></a>';
                    //html += '&nbsp;&nbsp;<a href="javascript:void(0);" class="delete_part" data-id="'+row['id']+'" ><i class="fa fa-trash text-danger"></i></a>';
                    return html;
                }
            }
        ]
    });
    $("#jobs_list_tbl tbody").on("click", ".job_active_inactive", function () {
        var rowData = parts_table.row($(this).closest("tr")).data();
        job_active_inactive(rowData.id, rowData.is_active);
    });
}

function reload_parts_tbl() {
    parts_table.ajax.url(base_url + "api/parts/list").load();
}

function reload_roles_tbl() {
    roles_table.ajax.url(base_url + "api/roles/list").load();
}

function reload_users_tbl() {
    users_table.ajax.url(base_url + "api/users/list").load();
}
function reload_permission_tbl() {
    permission_table.ajax.url(base_url + "api/permissions/list").load();
}


$(document).on('click', '.view_part', function () {
    let id = $(this).data('id');
    location.href = base_url + 'admin/parts/view/' + id;
});
$(document).on('click', '.delete_part', function () {
    let id = $(this).data('id');

    var con = confirm("Do you really want to delete this record?");

    if (con) {
        $.ajax({
            url: base_url + 'api/parts/delete/' + id,
            method: "POST",
            dataType: "json",
            beforeSend: function (xhr) {
                //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
            },
        }).done(function (data) {
            successMsg(data.msg);
            reload_parts_tbl();
        }).fail(function (data) {
            if (typeof data.responseJSON.messages === 'object') {
                for (let i in data.responseJSON.messages) {
                    failMsg(data.responseJSON.messages[i]);
                }
            } else {
                let msg = data.responseJSON.messages.msg;
                failMsg(msg);
            }
        });
    }
});


$(document).on('click', '.delete_user', function () {
    let id = $(this).data('id');

    var con = confirm("Do you really want to delete this record?");

    if (con) {
        $.ajax({
            url: base_url + 'api/users/delete/' + id,
            method: "POST",
            dataType: "json",
            beforeSend: function (xhr) {
                //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
            },
        }).done(function (data) {
            successMsg(data.msg);
            reload_users_tbl();
        }).fail(function (data) {
            if (typeof data.responseJSON.messages === 'object') {
                for (let i in data.responseJSON.messages) {
                    failMsg(data.responseJSON.messages[i]);
                }
            } else {
                let msg = data.responseJSON.messages.msg;
                failMsg(msg);
            }
        });
    }
});

//pins
if ($(".pins-display .pin-box").length > 0) {
    $(".pins-display .pin-box").on('click', function () {
        if ($(this).hasClass('gray-pin')) {
            $(this).removeClass('gray-pin');
            $(this).addClass('green-pin');
        } else {
            $(this).removeClass('green-pin');
            $(this).addClass('gray-pin');
        }
    });
}

if ($("#add_parts_data").length > 0) {
    $("#add_parts_data").validate({
        rules: {
            'part_name': {
                required: true,
            },

            'die_no': { required: true },
            'model': { required: true },
        },
        messages: {
            'part_name': {
                required: 'Please enter Part Name',
            },
            'die_no': { required: 'Please enter Die No' },
            'model': { required: 'Please enter Model' },
        }
    });

    $("#add_parts_data button").on('click', function (e) {
        e.preventDefault();

        let pins_selected = [];
        let i = 0;

        $(".pins-display .pin-box").each(function (index) {
            if ($(this).hasClass('green-pin')) {
                pins_selected[i++] = $(this).attr('title');
            }
        });

        let form_data = $("#add_parts_data").serialize();
        form_data += '&selected_pins=' + pins_selected;
        console.log(form_data);

        if ($("#add_parts_data").valid()) {
            if (pins_selected.length === 0) {
                // If it's empty, prevent the form submission and show an error message
                e.preventDefault();
                alert('Please select at least one pin.');
            } else {
                // Continue with form submission or other actions
            }
        } else {
            return false;
        }

        let btn = $(this);

        btn.addClass('button--loading').attr('disabled', true);

        $.ajax({
            url: base_url + 'api/parts/add',
            method: "POST",
            data: form_data,
            dataType: "json",
            beforeSend: function (xhr) {
                //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
            },
        }).done(function (data) {
            btn.removeClass('button--loading').attr('disabled', false);
            successMsg(data.msg);
            location.href = base_url + 'admin/parts/list';
        }).fail(function (data) {
            btn.removeClass('button--loading').attr('disabled', false);
            if (typeof data.responseJSON.messages === 'object') {
                for (let i in data.responseJSON.messages) {
                    failMsg(data.responseJSON.messages[i]);
                }
            } else {
                let msg = data.responseJSON.messages.msg;
                failMsg(msg);
            }

        });
    });
}

if ($("#update_parts_data").length > 0) {

    let id = $("#update_parts_data").find("input[name='id']").val();
    $.ajax({
        url: base_url + 'api/parts/get_one/' + id,
        method: "GET",
        dataType: "json",
        beforeSend: function (xhr) {
            //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
        },
    }).done(function (data) {
        $("#update_parts_data").find("input[name='part_name']").val(data.part_name);
        $("#update_parts_data").find("input[name='part_no']").val(data.part_no);
        $("#update_parts_data").find("input[name='model']").val(data.model);
        $("#update_parts_data").find("input[name='die_no']").val(data.die_no);
        var is_active = data.is_active;
        var checkbox = $("#is_active");
        if (is_active == 1) {

            $("#update_parts_data").find("input[name='is_active']").prop("checked", true); // Check the checkbo
            checkbox.prop("checked", true); // Check the checkbox
        } else if (is_active == 0) {

            $("#update_parts_data").find("input[name='is_active']").prop("checked", false); // Check the checkbo
        }
        var pins_array = data.pins.split(",");

        for (let i in pins_array) {
            var pin_address = pins_array[i];
            $(".pins-display").find(".pin-box").each(function (index) {
                console.log("pins address::", pin_address);
                if ($(this).attr('title') == pin_address) {
                    $(this).addClass('green-pin');
                }
            });
        }

    }).fail(function (data) {
        console.log("Not found");
    });


    $("#update_parts_data").validate({
        rules: {
            'part_name': { required: true },
            'model': { required: true },
            'die_no': { required: true },
            'model': { required: true },
        },
        messages: {
            'part_name': { required: 'Please enter Part Name' },
            'model': { required: 'Please enter Model' },
            'die_no': { required: 'Please enter Die No' },
            'model': { required: 'Please enter Model' },
        }
    });

    $("#update_parts_data button").on('click', function (e) {
        e.preventDefault();

        var is_active = $("input[name='is_active']:checked").length;

        let pins_selected = [];
        let i = 0;

        $(".pins-display .pin-box").each(function (index) {
            if ($(this).hasClass('green-pin')) {
                pins_selected[i++] = $(this).attr('title');
            }
        });


        let form_data = $("#update_parts_data").serialize();
        form_data += '&selected_pins=' + pins_selected;
        console.log(form_data);

        if ($("#update_parts_data").valid()) {
            if (pins_selected.length === 0) {
                // If it's empty, prevent the form submission and show an error message
                e.preventDefault();
                alert('Please select at least one pin.');
                return false;
            }
        } else {
            return false;
        }

        let btn = $(this);

        btn.addClass('button--loading').attr('disabled', true);

        $.ajax({
            url: base_url + 'api/parts/update/' + id,
            method: "POST",
            data: form_data,
            dataType: "json",
            beforeSend: function (xhr) {
                //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
            },
        }).done(function (data) {
            btn.removeClass('button--loading').attr('disabled', false);
            successMsg(data.msg);
            location.href = base_url + 'admin/parts/list';
        }).fail(function (data) {
            btn.removeClass('button--loading').attr('disabled', false);
            if (typeof data.responseJSON.messages === 'object') {
                for (let i in data.responseJSON.messages) {
                    failMsg(data.responseJSON.messages[i]);
                }
            } else {
                let msg = data.responseJSON.messages.msg;
                failMsg(msg);
            }

        });
    });
}

if ($("#start_jobs_data_left").length > 0) {
    $("#start_jobs_data_left").find("#part_name").select2();
    $.ajax({
        url: base_url + 'api/parts/get_api_url',
        method: "GET",
        dataType: "json",
        success: function (data) {
            //alert(data.WEBSOCKET_URL);
            const ws = new WebSocket(data.WEBSOCKET_URL);  // Replace with your server URL

            $("#result").html("Title: " + data.title);
             var part_id = '';
            const event_part_id = '';
            var data = '';
            ws.onmessage = (event) => {
                var jsonData = JSON.parse(event.data);
                part_id = jsonData.part_id;
                data = jsonData.pin_status;
                // }
                if (part_id != event_part_id) {
                    let values = '';
                    let correctInsertedValues = '';
                    for (const key in data) {
                        if (data.hasOwnProperty(key)) {
                            if (values !== "") {
                                values += ", "; // Add a comma and space if values is not empty
                                correctInsertedValues += ", "; // Add a comma and space if correctInsertedValues is not empty
                            }
                            values += key;
                            correctInsertedValues += data[key].correct_inserted;
                        }
                    }


                    var pins_array = values.split(",");
                    var pins_color = correctInsertedValues.split(",");

                    for (let i in pins_array) {

                        var pin_address = pins_array[i];
                        var pin_color = pins_color[i];
                        $(".pins-display").find(".pin-box").each(function (index) {
                            var title = $(this).attr('title');
                            var pattern = new RegExp(".*" + pin_address.replace(/[.*+?^${}()|[\]\\]/g, '\\$&').replace(/-/g, '\\$&').replace(/ /g, '.?') + ".*", 'i');

                            if (pattern.test(title)) {
                                if (pin_color.trim().toLowerCase() === 'true') {
                                    $(this).addClass('green-pin');
                                } else if (pin_color.trim().toLowerCase() === 'false') {
                                    $(this).addClass('red-pin');
                                } 
                            }
                        });

                    }


                    $.ajax({
                        type: 'GET', // or 'GET', depending on your needs
                        url: base_url + 'api/parts/get_one/' + part_id,
                        data: {},
                        beforeSend: function (xhr) {
                        },
                    }).done(function (data) {

                        $("#part_name").val('');
                        if ($("#part_name").length > 0) {
                        }

                        $(".part_name").text(data['part_name']);
                        $("#part_no").text(data['part_no']);
                        $("#model").text(data['model']);
                        $("#die_no").text(data['die_no']);


                        $(".pins-display").find(".pin-box").each(function (index) {
                            if ($(this).hasClass('orange-pin')) {
                                $(this).removeClass('orange-pin').addClass('gray-pin');
                            }
                        });



                    }).fail(function (data) {
                        // $(btn_id).removeClass('button--loading').attr('disabled', false);

                    });
                }
            }
        }

    })
}


if ($("#start_jobs_data_right").length > 0) {
    $("#start_jobs_data_right").find("#part_name").select2();

    $.ajax({
        url: base_url + 'api/parts/get_api_url',
        method: "GET",
        dataType: "json",
        success: function (data) {
            // alert(data.WEBSOCKET_URL);
            const ws = new WebSocket(data.WEBSOCKET_URL);  // Replace with your server URL

            $("#result").html("Title: " + data.title);
          var part_id = '';
            const event_part_id = '';
            var data = '';
            ws.onmessage = (event) => {
                var jsonData = JSON.parse(event.data);
                part_id = jsonData.part_id;
                data = jsonData.pin_status;
                // }
                if (part_id != event_part_id) {
                    let values = '';
                    let correctInsertedValues = '';
                    for (const key in data) {
                        if (data.hasOwnProperty(key)) {
                            if (values !== "") {
                                values += ", "; // Add a comma and space if values is not empty
                                correctInsertedValues += ", "; // Add a comma and space if correctInsertedValues is not empty
                            }
                            values += key;
                            correctInsertedValues += data[key].correct_inserted;
                        }
                    }


                    var pins_array = values.split(",");
                    var pins_color = correctInsertedValues.split(",");

                    for (let i in pins_array) {

                        var pin_address = pins_array[i];
                        var pin_color = pins_color[i];
                        $(".pins-display").find(".pin-box").each(function (index) {
                            var title = $(this).attr('title');
                            var pattern = new RegExp(".*" + pin_address.replace(/[.*+?^${}()|[\]\\]/g, '\\$&').replace(/-/g, '\\$&').replace(/ /g, '.?') + ".*", 'i');

                            if (pattern.test(title)) {
                                if (pin_color.trim().toLowerCase() === 'true') {
                                    $(this).addClass('green-pin');
                                } else if (pin_color.trim().toLowerCase() === 'false') {
                                    $(this).addClass('red-pin');
                                } 
                            }
                        });

                    }


                    $.ajax({
                        type: 'GET', // or 'GET', depending on your needs
                        url: base_url + 'api/parts/get_one/' + part_id,
                        data: {},
                        beforeSend: function (xhr) {
                        },
                    }).done(function (data) {

                        $("#part_name").val('');
                        if ($("#part_name").length > 0) {
                        }

                        $(".part_name").text(data['part_name']);
                        $("#part_no").text(data['part_no']);
                        $("#model").text(data['model']);
                        $("#die_no").text(data['die_no']);


                        $(".pins-display").find(".pin-box").each(function (index) {
                            if ($(this).hasClass('orange-pin')) {
                                $(this).removeClass('orange-pin').addClass('gray-pin');
                            }
                        });



                    }).fail(function (data) {
                        // $(btn_id).removeClass('button--loading').attr('disabled', false);

                    });
                }
            }
        }

    })
}
// if ($("#start_jobs_data").length > 0) {
//     $("#start_jobs_data").find("#part_name").select2();

//     $.ajax({
//         type: 'POST', // or 'GET', depending on your needs
//         url: base_url + 'api/jobs/get_api_data',
//         data: {side:'right'},
//         beforeSend: function (xhr) {
//         },
//     }).done(function (data) {
//       //  var inputValue = data.formattedData['id'];

//         $("#part_name").val('');
//         if ($("#part_name").length > 0) {
//         }

// $(".part_name").text(data['part_name']);
// $("#part_no").text(data['part_no']);
// $("#model").text(data['model']);
// $("#die_no").text(data['die_no']);
//         var pins_array = data['keys'].split(",");
//         var pins_color = data['values'].split(",");

//         $(".pins-display").find(".pin-box").each(function (index) {
//             if ($(this).hasClass('orange-pin')) {
//                 $(this).removeClass('orange-pin').addClass('gray-pin');
//             }
//         });

//         for (let i in pins_array) {
//             var pin_address = pins_array[i];
//             var pin_color = pins_color[i];

//             $(".pins-display").find(".pin-box").each(function (index) {
//                 //  console.log("pins address::", pin_address);
//                 if ($(this).attr('title') == pin_address) {
//                     if (pin_color === '0') {
//                         $(this).addClass('red-pin');
//                     } else if (pin_color === '1') {
//                         $(this).addClass('green-pin');
//                     } else {

//                     }
//                 }
//             });
//         }

//     }).fail(function (data) {
//         // $(btn_id).removeClass('button--loading').attr('disabled', false);

//     });
// }


$(document).ready(function () {
    if ($('.digital-clock').length > 0) {
        var interval = '';
        $("#start_time").on('click', function (e) {
            e.preventDefault();
            clockUpdate();
            //if(interval != '') {
            interval = setInterval(clockUpdate, 1000);
            //}

        });
        $("#stop_time").on('click', function (e) {
            e.preventDefault();
            clearInterval(interval);
        });
    }
});

function clockUpdate() {
    var date = new Date();
    //$('.digital-clock').css({'color': '#fff', 'text-shadow': '0 0 6px #ff0'});
    function addZero(x) {
        if (x < 10) {
            return x = '0' + x;
        } else {
            return x;
        }
    }

    function twelveHour(x) {
        if (x > 12) {
            return x = x - 12;
        } else if (x == 0) {
            return x = 12;
        } else {
            return x;
        }
    }

    var h = addZero(twelveHour(date.getHours()));
    var m = addZero(date.getMinutes());
    var s = addZero(date.getSeconds());

    $('.digital-clock').text(h + ':' + m + ':' + s)

}


$("#part-export").on('click', function () {
    //     is_active = $("#is_active").val();
    //     part_no = $("#part_no").val();
    // var  = $("#v_id").val();
    // var emp_id = $("#em_id").val();
    // var role_id = $("#role_ids").val();
    // var contractor_id = $("#contractor_ids").val();
    // var e_id = $("#e_id").val();
    // var role_category_id = $("#role_category_ids").val();
    // var department_id = $("#department_ids").val(); 


    window.location.href = base_url + 'admin/parts/export_part';
});






if ($("#update_users").length > 0) {

    let id = $("#update_users").find("input[name='id']").val();
    $.ajax({
        url: base_url + 'api/users/get_one/' + id,
        method: "GET",
        dataType: "json",
        beforeSend: function (xhr) {
            //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
        },
    }).done(function (data) {
        $("#update_users").find("input[name='first_name']").val(data.first_name);
        $("#update_users").find("input[name='last_name']").val(data.last_name);

        $("#update_users").find("input[name='email']").val(data.email);
        $("#update_users").find("input[name='phone_number']").val(data.phone);
        $("#update_users").find("input[name='employee_id']").val(data.emp_id);
        $("#update_users").find("input[name='username']").val(data.username);
        // $("#update_users").find("input[name='is_active']").val(data.is_active);
        var is_active = data.is_active;
        var checkbox = $("#is_active");
        if (is_active == 1) {

            //$("#update_users").find("input[name='is_active']").val('on');
            $("#update_users").find("input[name='is_active']").prop("checked", true); // Check the checkbo
            checkbox.prop("checked", true); // Check the checkbox
        } else if (is_active == 0) {

            //$("#update_users").find("input[name='is_active']").val('off');
            $("#update_users").find("input[name='is_active']").prop("checked", false); // Check the checkbo
        }

        $.ajax({
            url: base_url + 'api/users/get_role_names',
            method: "POST",
            dataType: "json",
            data: {
                user_id: data.id
            }, //v_mac: v_mac,
            success: function (user_data) {
                //  alert(user_data.role_id['role_id'])
                if (user_data.role_id !== null) {
                    $("#role_id").val(user_data.role_id['role_id']);
                }

            },
            error: function (error) {
                console.error("Error:", error);
                //   console.error("Error fetching employees:", error);
            },

        });

    }).fail(function (data) {
        console.log("Not found");
    });
    $("#update_users").validate({
        rules: {
            'first_name': {
                required: true,
            },
            'last_name': { required: true },
            'email': { required: true },
            'phone_number': {
                required: true, minlength: 10,
                maxlength: 12,
            },
            'username': { required: true },
            'password': { minlength: 5 },
            'confirm_password': {
                equalTo: "#password"
            },
            'email': {
                required: true,
                email: true
            },
            'employee_id': { required: true },
        },
        messages: {
            'first_name': {
                required: 'Please enter first Name',
            },
            'last_name': { required: 'Please enter last Name' },
            'email': { required: 'Please enter Die No' },
            'phone_number': { required: 'Please enter Phone Number' },
            'username': { required: 'Please enter User Name' },

            'employee_id': { required: 'Please enter employee Id' },
        }
    });

    $("#update_users button").on('click', function (e) {
        e.preventDefault();


        if (!$("#update_users").valid()) {
            return false;
        }
        let i = 0;
        var is_Active_val = $("#update_users").find("input[name='is_active']").prop('checked') ? 'on' : '';
        var form_data = $('#update_users').serialize();
        form_data += '&is_active=' + is_Active_val;


        console.log(form_data);

        // let btn = $(this);

        // btn.addClass('button--loading').attr('disabled', true);

        $.ajax({
            url: base_url + 'api/users/update/' + id,
            method: "POST",
            data: form_data,
            dataType: "json", beforeSend: function (xhr) {
                //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
            },
        }).done(function (data) {
            // btn.removeClass('button--loading').attr('disabled', false);
            successMsg(data.msg);
            location.href = base_url + 'admin/users/list';
            reload_users_tbl();
        }).fail(function (data) {
            // btn.removeClass('button--loading').attr('disabled', false);
            if (typeof data.responseJSON.messages === 'object') {
                for (let i in data.responseJSON.messages) {
                    failMsg(data.responseJSON.messages[i]);
                }
            } else {
                let msg = data.responseJSON.messages.msg;
                failMsg(msg);
            }

        });
    });
}


if ($("#add_users").length > 0) {
    $("#add_users").validate({
        rules: {
            'first_name': {
                required: true,
            },
            'last_name': { required: true },
            'email': { required: true },
            'phone_number': {
                required: true, minlength: 10,
                maxlength: 12,
            },
            'username': { required: true },
            'password': { required: true, minlength: 5 },
            'confirm_password': {
                required: true,
                equalTo: "#password"
            },
            'email': {
                required: true,
                email: true
            },
            'employee_id': { required: true },
        },
        messages: {
            'first_name': {
                required: 'Please enter first Name',
            },
            'last_name': { required: 'Please enter last Name' },
            'email': { required: 'Please enter email' },
            'phone_number': { required: 'Please enter Phone Number' },
            'username': { required: 'Please enter User Name' },
            'password': { required: 'Please enter password' },

            'confirm_password': { required: 'Please enter confirm password' },

            'employee_id': { required: 'Please enter employee Id' },
        }
    });

    $("#add_users button").on('click', function (e) {
        e.preventDefault();


        let form_data = $("#add_users").serialize();
        console.log(form_data);

        if (!$("#add_users").valid()) {
            return false;
        }

        let btn = $(this);

        btn.addClass('button--loading').attr('disabled', true);

        $.ajax({
            url: base_url + 'api/users/add/',
            method: "POST",
            data: form_data,
            dataType: "json",

            beforeSend: function (xhr) {
                //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
            },
        }).done(function (data) {
            btn.removeClass('button--loading').attr('disabled', false);
            successMsg(data.msg);
            location.href = base_url + 'admin/users/list';
            reload_users_tbl();
        }).fail(function (data) {
            btn.removeClass('button--loading').attr('disabled', false);
            if (typeof data.responseJSON.messages === 'object') {
                for (let i in data.responseJSON.messages) {
                    failMsg(data.responseJSON.messages[i]);
                }
            } else {
                let msg = data.responseJSON.messages.msg;
                failMsg(msg);
            }

        });
    });
}


function part_active_inactive(id, is_active) {
    var res = confirm("Do you want to update this part status?");
    if (res == true) {
        $.ajax({
            url: base_url + 'api/parts/update_is_active',
            method: "POST",
            data: { id: id, is_active: is_active },
            dataType: "json",
            success: function (data) {
                successMsg(data.msg);
                $('#parts_list_tbl').DataTable().ajax.reload();
            },
            error: function (xhr, status, error) {

                console.error("Error:", error);
            }
        });
    }

}


function job_active_inactive(id, is_active) {
    var res = confirm("Do you want to update this job status?");
    if (res == true) {
        $.ajax({
            url: base_url + 'api/jobs/update_is_active',
            method: "POST",
            data: { id: id, is_active: is_active },
            dataType: "json",
            success: function (data) {
                successMsg(data.msg);
                $('#jobs_list_tbl').DataTable().ajax.reload();
            },
            error: function (xhr, status, error) {

                console.error("Error:", error);
            }
        });
    }

}




if ($("#roles_list_tbl").length > 0) {
    // table
    var roles_table = $("#roles_list_tbl").DataTable({
        "ordering": true,
        'order': [[0, 'asc']],
        'serverMethod': 'get',
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...',
            "emptyTable": "There is no record to display"
        },
        "dom": 'Bfrtip',
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"],
        "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All'],
        ],
        "ajax": {
            "url": base_url + "api/roles/list",
            "dataSrc": "",
        },
        "columns": [
            {
                "data": null,
                "render": function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                "data": "name",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },

            {
                "data": "permission",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "is_active",
                "render": function (data, type, row, meta) {
                    if (data && data != '-') {
                        // Assuming "cb-switch" is the ID of the checkbox input element
                        var checkboxId = "cb-switch";
                        // Create a unique ID for each checkbox
                        var dynamicHTML = '<div class="toggle-switch roles_active_inactive" id="' + checkboxId + '" >';
                        if (data == 1) {
                            dynamicHTML += '<label for="' + checkboxId + '"><input  style="display:none"  type="checkbox" name="is_active" value="" checked><span><small></small></span></label></div>';
                        } else {
                            dynamicHTML += '<label for="' + checkboxId + '"><input   style="display:none"  type="checkbox"  name="is_active" value=""><span><small></small></span></label></div>';
                        }
                        return dynamicHTML;

                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": null,
                "render": function (data, type, row, meta) {
                    return '<a href="' + base_url + 'admin/roles/edit/' + row['id'] + '"    class="edit_user" ><i class="fa fa-edit"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" data-id="' + row['id'] + '" class="delete_roles" ><i class="fa fa-trash"></i></a>';
                }
            }

        ]
    });
    $("#roles_list_tbl tbody").on("click", ".roles_active_inactive", function () {
        var rowData = roles_table.row($(this).closest("tr")).data();
        roles_active_inactive(rowData.id, rowData.is_active);
    });
}


if ($("#add_roles").length > 0) {
    $("#add_roles").validate({
        rules: {
            'name': {
                required: true,
            },
            "permission_id[]": {
                required: true,
            },
        },
        messages: {
            'name': {
                required: 'Please enter role Name',
            },
            "permission_id[]": {
                required: 'Please enter permission',
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
    });

    $("#add_roles button").on('click', function (e) {
        e.preventDefault();


        let form_data = $("#add_roles").serialize();
        console.log(form_data);

        if (!$("#add_roles").valid()) {
            return false;
        }

        let btn = $(this);

        btn.addClass('button--loading').attr('disabled', true);

        $.ajax({
            url: base_url + 'api/roles/add/',
            method: "POST",
            data: form_data,
            dataType: "json",

            beforeSend: function (xhr) {
                //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
            },
        }).done(function (data) {
            btn.removeClass('button--loading').attr('disabled', false);
            successMsg(data.msg);
            location.href = base_url + 'admin/roles/list';
            reload_roles_tbl();
        }).fail(function (data) {
            btn.removeClass('button--loading').attr('disabled', false);
            if (typeof data.responseJSON.messages === 'object') {
                for (let i in data.responseJSON.messages) {
                    failMsg(data.responseJSON.messages[i]);
                }
            } else {
                let msg = data.responseJSON.messages.msg;
                failMsg(msg);
            }

        });
    });
}


function roles_active_inactive(id, is_active) {
    var res = confirm("Do you want to update this Roles status?");
    if (res == true) {
        $.ajax({
            url: base_url + 'api/roles/update_is_active',
            method: "POST",
            data: { id: id, is_active: is_active },
            dataType: "json",
            success: function (data) {
                successMsg(data.msg);
                $('#roles_list_tbl').DataTable().ajax.reload();
            },
            error: function (xhr, status, error) {

                console.error("Error:", error);
            }
        });
    }

}

$(document).on('click', '.delete_roles', function () {
    let id = $(this).data('id');

    var con = confirm("Do you really want to delete this record?");

    if (con) {
        $.ajax({
            url: base_url + 'api/roles/delete/' + id,
            method: "POST",
            dataType: "json",
            beforeSend: function (xhr) {
                //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
            },
        }).done(function (data) {
            successMsg(data.msg);
            reload_roles_tbl();
        }).fail(function (data) {
            if (typeof data.responseJSON.messages === 'object') {
                for (let i in data.responseJSON.messages) {
                    failMsg(data.responseJSON.messages[i]);
                }
            } else {
                let msg = data.responseJSON.messages.msg;
                failMsg(msg);
            }
        });
    }
});




if ($("#update_roles").length > 0) {
    let id = $("#update_roles").find("input[name='id']").val();
    $.ajax({
        url: base_url + 'api/roles/get_one/' + id,
        method: "GET",
        dataType: "json",
        beforeSend: function (xhr) {
            //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
        },
    }).done(function (data) {
        $("#update_roles").find("input[name='name']").val(data.name);

        var is_active = data.is_active;
        var checkbox = $("#is_active");
        if (is_active == 1) {
            // $("#update_roles").find("input[name='is_active']").val('on');
            $("#update_roles").find("input[name='is_active']").prop("checked", true); // Check the checkbo
            checkbox.prop("checked", true); // Check the checkbox
        } else if (is_active == 0) {

            ///  $("#update_roles").find("input[name='is_active']").val('off');
            $("#update_roles").find("input[name='is_active']").prop("checked", false); // Check the checkbo
        }


        $.ajax({
            url: base_url + 'api/users/get_permission_names',
            method: "POST",
            dataType: "json",
            data: {
                role_id: data.id
            }, //v_mac: v_mac,
            success: function (user_data) {
                var permissionIds = user_data.map(function (user) {
                    return user.permission_id;
                });
                $.each(permissionIds, function (index, value) {
                    var checkbox = $('input[name="permission_id[]"][value="' + value + '"]');
                    if (checkbox.length) {
                        checkbox.prop('checked', true);
                    }
                });
            },
            error: function (error) {
                console.error("Error:", error);
                //   console.error("Error fetching employees:", error);
            },

        });

    }).fail(function (data) {
        console.log("Not found");
    });

    $("#update_roles").validate({
        rules: {
            'name': {
                required: true,
            },
            "permission_id[]": {
                required: true,
            },
        },
        messages: {
            'name': {
                required: 'Please enter role Name',
            },
            "permission_id[]": {
                required: 'Please select permission',
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
    });

    $("#update_roles button").on('click', function (e) {
        e.preventDefault();

        let id = $("#update_roles").find("input[name='id']").val();

        let form_data = $("#update_roles").serialize();
        console.log(form_data);

        if (!$("#update_roles").valid()) {
            return false;
        }

        let btn = $(this);

        btn.addClass('button--loading').attr('disabled', true);

        $.ajax({
            url: base_url + 'api/roles/update/' + id,
            method: "POST",
            data: form_data,
            dataType: "json",

            beforeSend: function (xhr) {
                //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
            },
        }).done(function (data) {
            btn.removeClass('button--loading').attr('disabled', false);
            successMsg(data.msg);
            location.href = base_url + 'admin/roles/list';
            reload_roles_tbl();
        }).fail(function (data) {
            btn.removeClass('button--loading').attr('disabled', false);
            if (typeof data.responseJSON.messages === 'object') {
                for (let i in data.responseJSON.messages) {
                    failMsg(data.responseJSON.messages[i]);
                }
            } else {
                let msg = data.responseJSON.messages.msg;
                failMsg(msg);
            }

        });
    });
}


if ($("#permission_list_tbl").length > 0) {
    // table
    var permission_table = $("#permission_list_tbl").DataTable({
        "ordering": true,
        'order': [[0, 'asc']],
        'serverMethod': 'get',
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...',
            "emptyTable": "There is no record to display"
        },
        "dom": 'Bfrtip',
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"],
        "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All'],
        ],
        "ajax": {
            "url": base_url + "api/permissions/list",
            "dataSrc": "",
        },
        "columns": [
            {
                "data": null,
                "render": function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                "data": "permission_id",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "description",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "is_active",
                "render": function (data, type, row, meta) {
                    if (data && data != '-') {
                        // Assuming "cb-switch" is the ID of the checkbox input element
                        var checkboxId = "cb-switch";
                        // Create a unique ID for each checkbox
                        var dynamicHTML = '<div class="toggle-switch permission_active_inactive" id="' + checkboxId + '" >';
                        if (data == 1) {
                            dynamicHTML += '<label for="' + checkboxId + '"><input  style="display:none"  type="checkbox" name="is_active" value="" checked><span><small></small></span></label></div>';
                        } else {
                            dynamicHTML += '<label for="' + checkboxId + '"><input   style="display:none"  type="checkbox"  name="is_active" value=""><span><small></small></span></label></div>';
                        }
                        return dynamicHTML;

                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": null,
                "render": function (data, type, row, meta) {
                    return '<a href="' + base_url + 'admin/permissions/edit/' + row['id'] + '"    class="edit_user" ><i class="fa fa-edit"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" data-id="' + row['id'] + '" class="delete_permission" ><i class="fa fa-trash"></i></a>';
                }
            }

        ]
    });
    $("#permission_list_tbl tbody").on("click", ".permission_active_inactive", function () {
        var rowData = permission_table.row($(this).closest("tr")).data();
        permission_active_inactive(rowData.id, rowData.is_active);
    });
}


function permission_active_inactive(id, is_active) {
    var res = confirm("Do you want to update this permission status?");
    if (res == true) {
        $.ajax({
            url: base_url + 'api/permissions/update_is_active',
            method: "POST",
            data: { id: id, is_active: is_active },
            dataType: "json",
            success: function (data) {
                successMsg(data.msg);
                $('#permission_list_tbl').DataTable().ajax.reload();
            },
            error: function (xhr, status, error) {

                console.error("Error:", error);
            }
        });
    }

}




if ($("#add_permission").length > 0) {

    jQuery.validator.addMethod("letterswithbasicpunc", function (value, element) {
        return this.optional(element) || /^[a-z_-]+$/i.test(value);
    }, "Enter A-z Letters AND (-_) only");

    $("#add_permission").validate({
        rules: {
            'permission_id': {
                required: true,
                letterswithbasicpunc: true,
            },
            'description': {
                required: true,
            },
        },
        messages: {
            'permission_id': {
                required: 'Please enter permission',
            },
            'description': {
                required: 'Please enter description',
            },
        }
    });

    $("#add_permission button").on('click', function (e) {
        e.preventDefault();


        let form_data = $("#add_permission").serialize();
        console.log(form_data);

        if (!$("#add_permission").valid()) {
            return false;
        }

        let btn = $(this);

        btn.addClass('button--loading').attr('disabled', true);

        $.ajax({
            url: base_url + 'api/permissions/add/',
            method: "POST",
            data: form_data,
            dataType: "json",

            beforeSend: function (xhr) {
                //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
            },
        }).done(function (data) {
            btn.removeClass('button--loading').attr('disabled', false);
            successMsg(data.msg);
            location.href = base_url + 'admin/permissions/list';
            reload_permission_tbl();
        }).fail(function (data) {
            btn.removeClass('button--loading').attr('disabled', false);
            if (typeof data.responseJSON.messages === 'object') {
                for (let i in data.responseJSON.messages) {
                    failMsg(data.responseJSON.messages[i]);
                }
            } else {
                let msg = data.responseJSON.messages.msg;
                failMsg(msg);
            }

        });
    });
}


$(document).on('click', '.delete_permission', function () {
    let id = $(this).data('id');

    var con = confirm("Do you really want to delete this record?");

    if (con) {
        $.ajax({
            url: base_url + 'api/permissions/delete/' + id,
            method: "POST",
            dataType: "json",
            beforeSend: function (xhr) {
                //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
            },
        }).done(function (data) {
            successMsg(data.msg);
            reload_permission_tbl();
        }).fail(function (data) {
            if (typeof data.responseJSON.messages === 'object') {
                for (let i in data.responseJSON.messages) {
                    failMsg(data.responseJSON.messages[i]);
                }
            } else {
                let msg = data.responseJSON.messages.msg;
                failMsg(msg);
            }
        });
    }
});


if ($("#update_permission").length > 0) {
    let id = $("#update_permission").find("input[name='id']").val();
    $.ajax({
        url: base_url + 'api/pemissions/get_one/' + id,
        method: "GET",
        dataType: "json",
        beforeSend: function (xhr) {
            //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
        },
    }).done(function (data) {

        $("#update_permission").find("input[name='permission_id']").val(data.permission_id);
        $("#update_permission").find("input[name='description']").val(data.description);

        var is_active = data.is_active;
        var checkbox = $("#is_active");
        if (is_active == 1) {
            //$("#update_permission").find("input[name='is_active']").val('on');
            $("#update_permission").find("input[name='is_active']").prop("checked", true); // Check the checkbo
            checkbox.prop("checked", true); // Check the checkbox
        } else if (is_active == 0) {

            //$("#update_permission").find("input[name='is_active']").val('off');
            $("#update_permission").find("input[name='is_active']").prop("checked", false); // Check the checkbo
        }
    }).fail(function (data) {
        console.log("Not found");
    });

    $("#update_permission").validate({
        rules: {
            'permission_id': {
                required: true,
            },
            'description': {
                required: true,
            },
        },
        messages: {
            'permission_id': {
                required: 'Please enter permission',
            },
            'description': {
                required: 'Please enter description',
            },
        }
    });

    $("#update_permission button").on('click', function (e) {
        e.preventDefault();

        let id = $("#update_permission").find("input[name='id']").val();

        let form_data = $("#update_permission").serialize();
        console.log(form_data);

        if (!$("#update_permission").valid()) {
            return false;
        }

        let btn = $(this);

        btn.addClass('button--loading').attr('disabled', true);

        $.ajax({
            url: base_url + 'api/permissions/update/' + id,
            method: "POST",
            data: form_data,
            dataType: "json",

            beforeSend: function (xhr) {
                //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
            },
        }).done(function (data) {
            btn.removeClass('button--loading').attr('disabled', false);
            successMsg(data.msg);
            location.href = base_url + 'admin/permissions/list';
            reload_permission_tbl();
        }).fail(function (data) {
            btn.removeClass('button--loading').attr('disabled', false);
            if (typeof data.responseJSON.messages === 'object') {
                for (let i in data.responseJSON.messages) {
                    failMsg(data.responseJSON.messages[i]);
                }
            } else {
                let msg = data.responseJSON.messages.msg;
                failMsg(msg);
            }

        });
    });
}


$(document).on("click", "#select_all", function () {
    if ($(this).is(":checked") == true) {
        $("input[name='permission_id[]']").attr("checked", "checked");
    } else {
        $("input[name='permission_id[]']").attr("checked", false);
    }
});



var date_formate = 'DD-MM-YYYY';
var defaultStartDate = moment().subtract(7, 'days').format('DD-MM-YYYY');
$('input[name="f_date"]').daterangepicker({
    locale: {
        format: date_formate
    },
    startDate: defaultStartDate,

});

$('#f_date').change(function () {
    hide_show_complete_job();
});

$('#part_name_filter').change(function () {
    hide_show_complete_job();
});

$('#part_no_filter').change(function () {
    hide_show_complete_job();   
});
$('#part_model_filter').change(function () {
    hide_show_complete_job();    
});
$('#part_die_no_filter').change(function () {
    hide_show_complete_job();    
});

function hide_show_complete_job() {    
   reload_complete_tbl();
    $("#completed_list_tbl").show();
}
var completed_table;
$(document).ready(function () {
    completed_table = generate_table();
});

 

function generate_table() {

if ($("#completed_list_tbl").length > 0) {
    var part_no = $("#part_no_filter").val();
    var from_to_date = $("#f_date").val();
    var dateParts = from_to_date.split(" - ");
    // The first part (index 0) will be the "from date," and the second part (index 1) will be the "to date."
    var from_date = dateParts[0];
    var to_date =  dateParts[1];
    var part_name = $("#part_name_filter").val();
    var model = $("#part_model_filter").val();   
    var die_no = $("#part_die_no_filter").val(); 
    var dataTable = $("#completed_list_tbl").DataTable({
        "ordering": true,
        'order': [[0, 'asc']],
        'serverMethod': 'get',
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...',
            "emptyTable": "There is no record to display"
        },
        "dom": 'Bfrtip',
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"],
        "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All'],
        ],
        "ajax": {
            "url": base_url + "api/jobs/completed_list?from_date=" + from_date + "&to_date=" + to_date + "&part_no=" + part_no + "&part_name=" + part_name + "&model=" + model + "&die_no=" + die_no,
            "dataSrc": "",
        },
        "columns": [
            {
                "data": null,
                "render": function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                "data": "part_no",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "part_name",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "model",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "die_no",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "created_at",
                "render": function (data, type, row, meta) {
                    if (data && data != '-') {
                        return (data);
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "updated_at",
                "render": function (data, type, row, meta) {
                    if (data && data != '-') {
                        return (data);
                    } else {
                        return '-';
                    }
                }
            },

            {
                "data": "is_active",
                "render": function (data, type, row, meta) {
                    if (data && data != '-') {
                        // Assuming "cb-switch" is the ID of the checkbox input element
                        var checkboxId = "cb-switch"; // Create a unique ID for each checkbox
                        if (data == 1) {
                            return '<div style="  pointer-events: none;" class="toggle-switch "><label for="' + checkboxId + '"><input type="checkbox" id="' + checkboxId + '" name="is_active" value="" checked><span><small></small></span></label></div>';
                        } else {
                            return '<div style="  pointer-events: none;" class="toggle-switch"><label for="' + checkboxId + '"><input type="checkbox" id="' + checkboxId + '" name="is_active" value=""><span><small></small></span></label></div>';
                        }
                    } else {
                        return '-';
                    }
                }
            },
        ]
    });
}
return dataTable;
}

function reload_complete_tbl() {
    
    var part_no = $("#part_no_filter").val();
    var from_to_date = $("#f_date").val();
    var dateParts = from_to_date.split(" - ");
    // The first part (index 0) will be the "from date," and the second part (index 1) will be the "to date."
    var from_date = dateParts[0];
    var to_date =  dateParts[1];
    var part_name = $("#part_name_filter").val();  
    // alert(to_date); 
    var model = $("#part_model_filter").val();   
    var die_no = $("#part_die_no_filter").val(); 
    completed_table.ajax.url(base_url + "api/jobs/completed_list?from_date=" +
        from_date +
        "&to_date=" +
        to_date +
        "&part_no=" +
        part_no +
        "&part_name=" +
        part_name +
        "&model=" +
        model +        
        "&die_no=" +
        die_no).load();
}


