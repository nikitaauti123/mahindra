/** Custom Application Javascript  */
// import SlimSelect from 'slim-select';
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
        "responsive": true,
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
                    return '<a href="' + base_url + 'admin/users/edit/' + row['id'] + '"    class="edit_user" ><i class="fa fa-edit text-primary"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" data-id="' + row['id'] + '" class="delete_user" ><i class="fa fa-trash"></i></a>';
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
var from_date_completed_date = getUrlParameter('from_date');
var to_date_completed_date = getUrlParameter('to_date');
if(from_date_completed_date != ''){
    $("#completed_jobs_list_form #from_date").daterangepicker({
        clearBtn: true,
        "showDropdowns": true,
        locale: {
            format: date_formate_com
        },
        startDate: moment(from_date_completed_date, date_formate_com),
        endDate: moment(to_date_completed_date, date_formate_com),
        maxDate: new Date(),
    });
}else{

if ($("#completed_list_tbl_data").length > 0) {
    if ($("#from_date").length > 0) {
        $("#from_date").daterangepicker({
            startDate: moment().subtract(1, 'month'),
            endDate: new Date(),
            
        }, function (start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');

            $("#from_date").val(start.format('YYYY-MM-DD') + " - " + end.format('YYYY-MM-DD'));
        });
    }
}
}

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
                    let html = '<a href="javascript:void(0);" class="view_part " data-id="' + row['id'] + '" ><i class="fa fa-eye text-success"></i></a>';

                    html += '&nbsp;&nbsp <a href="' + base_url + 'admin/parts/edit/' + row['id'] + '"   class="edit_part" data-id="' + row['id'] + '"><i class="fa fa-edit text-info"></i></a>';

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
            $("#"+pin_address).addClass('green-pin');
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

function elapsedMilliseconds(startTime)
{
    var n = new Date();
    var s = n.getTime();
    var diff = s - startTime;
    return diff;
}

var ws = '';
function websocket_call(data, side) {
    var event_part_id = '';
    ws = new WebSocket(data.WEBSOCKET_URL);
    ws.onmessage = (event) => {
        //var date = new Date();
        //console.log("start time::", date);
        add_loader_el();
        var jsonData = JSON.parse(event.data);
        if(typeof jsonData.pins == 'string') {
            var pins_data = JSON.parse(jsonData.pins)  
        } else {
            var pins_data = jsonData.pins;
        }

        var part_id = jsonData.id;

        var change_pin_colors = true;

        if($(".digital-clock").length>0 && !$(".digital-clock").is(":visible")) {
            change_pin_colors = false;
        }

        //console.log("pins_data", Object.keys(pins_data).length);

        var startTime = new Date().getTime();
        if(change_pin_colors == true) {
            for (let i in pins_data) {
                $("#"+i).removeClass('green-pin').removeClass('red-pin').removeClass('orange-pin').removeClass('gray-pin');

                let style_class = 'gray-pin';
                if(pins_data[i] == 0) {
                    style_class = 'green-pin';
                } else if (pins_data[i] == 1) { 
                    style_class = 'red-pin';
                } else if(pins_data[i] == 2) {
                    style_class = 'orange-pin';
                } else if(pins_data[i] == 3) {
                    style_class = 'gray-pin';
                }
                $("#"+i).addClass(style_class);
            }

            console.log("time required::", elapsedMilliseconds(startTime));
        }

        if ( part_id != event_part_id ) {
            event_part_id = part_id
            $.ajax({
                type: 'GET', 
                url: base_url + 'api/parts/get_one/' + part_id,
                data: {},
            }).done(function (data) {
                $(".part_name").text(data['part_name']);
                $(".part_no").text(data['part_no']);
                $(".model").text(data['model']);
                $(".die_no").text(data['die_no']);
            }).fail(function (data) {
                console.log("No part details found!");
            });
        }
        remove_loader_el();

        

        if(jsonData.part_ok_status == true) {
            $(".status_message").html("<div class='alert alert-success'>Current job status :: Ok</div>");
        } else {
            $(".status_message").html("<div class='alert alert-danger'>Current job status :: Not Ok</div>");
        }
    }

    //ws.addEventListener("error", (event) => {
        //remove_loader_el();
        //console.log("WebSocket error: ", event);
        //web_socket_init(side);
    //});

    ws.addEventListener("close", (event) => {
        remove_loader_el();
        //console.log("WebSocket close: ", event);
        web_socket_init(side);
    });
    
    
}

function add_loader_el() {
    if($(".lds-ellipsis").length==0) {
        $('.loader').html('<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>');
    } 
}

function remove_loader_el() {
    if($(".lds-ellipsis").length>0) {
        $('.loader').html('');
    } 
}

function web_socket_init(side ='left') {
    add_loader_el();
    $.ajax({
        url: base_url + 'api/parts/get_api_url',
        method: "GET",
        data: {side: side},
        dataType: "json",
        success: function (data) {
            /* const ws = new WebSocket(data.WEBSOCKET_URL);
            var part_id = '';
            var event_part_id = '';
            var data = '';
            var pins = '';
            ws.onmessage = (event) => {
                var jsonData = JSON.parse(event.data);
                remove_loader_el(); */
                /*
                part_id = jsonData.part_id;
                //pin_status = jsonData.pin_status;
                pins = jsonData.pin_status
                console.log(pins);
                data = jsonData.pin_status;
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
                                $(this).removeClass('red-pin').addClass('green-pin');
                            } else if (pin_color.trim().toLowerCase() === 'false') {
                                $(this).removeClass('green-pin').addClass('red-pin');
                            }
                        }
                    });
                } */


                //let part_id = jsonData.id;

                /* if (part_id != event_part_id) {
                    $(".part_name").html(data.part_name);
                    $("#part_no").html(data.part_no);
                    $("#model").html(data.model);
                    $("#die_no").html(data.die_no);
                    event_part_id = part_id;
                } */

                //var pins_data = JSON.parse(jsonData.pins);
                /* var pins_data = jsonData.pins;
                $(".pin-box").each(function () {
                    let title = $(this).attr('title');
                    for (let i in pins_data) {
                        console.log("data.pins[i] ::", pins_data[i]);
                        let style_class = 'gray-pin';
                        if (i == title) {
                            $(this).removeClass('green-pin');
                            $(this).removeClass('red-pin');
                            $(this).removeClass('orange-pin');
                            $(this).removeClass('gray-pin');

                            if (pins_data[i] == 0) {
                                style_class = 'green-pin';
                            } else if (pins_data[i] == 1) {
                                style_class = 'red-pin';
                            } else if (pins_data[i] == 2) {
                                style_class = 'orange-pin';
                            } else if (pins_data[i] == 3) {
                                style_class = 'gray-pin';
                            }
                            $(this).addClass(style_class);
                        }
                    }
                });*/
                /* $.ajax({
                    type: 'POST', // or 'GET', depending on your needs
                    url: base_url + 'api/jobs/set_api_jobs',
                    data: {part_id:part_id,pins:pins,side:'left'},
                    beforeSend: function (xhr) {
                    },
                }).done(function (data) {
                    
                }).fail(function (data) {

                }); */

                /* if (part_id != event_part_id) {
                    event_part_id = part_id
                    $.ajax({
                        type: 'GET', // or 'GET', depending on your needs
                        url: base_url + 'api/parts/get_one/' + part_id,
                        data: {},
                        beforeSend: function (xhr) {
                        },
                    }).done(function (data) {
                        $("#part_name").val('');
                        $(".part_name").text(data['part_name']);
                        $("#part_no").text(data['part_no']);
                        $("#model").text(data['model']);
                        $("#die_no").text(data['die_no']);
                       
                    }).fail(function (data) {

                    }); 
                }*/
            //}

           /*  ws.addEventListener("error", (event) => {
                remove_loader_el();
                console.log("WebSocket error: ", event);
                web_socket_init(side);
            }); */

            websocket_call(data, side);
        }
    });
}


/* if ($("#start_jobs_data_right").length > 0) {
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
            var event_part_id = '';
            var data = '';
            var pins = '';
            ws.onmessage = (event) => {
                var jsonData = JSON.parse(event.data);
                part_id = jsonData.part_id;
                pins=jsonData.pin_status
                data = jsonData.pin_status;
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
                                $(this).removeClass('red-pin').addClass('green-pin');
                            } else if (pin_color.trim().toLowerCase() === 'false') {
                                $(this).removeClass('green-pin').addClass('red-pin');
                            }
                        }
                    });
                }

                $.ajax({
                    type: 'POSt', // or 'GET', depending on your needs
                    url: base_url + 'api/jobs/set_api_jobs',
                    data: {part_id:part_id,pins:pins,side:'right'},
                    beforeSend: function (xhr) {
                    },
                }).done(function (data) {
                }).fail(function (data) {

                });

                if (part_id != event_part_id) {
                    event_part_id = part_id
                    $.ajax({
                        type: 'GET', // or 'GET', depending on your needs
                        url: base_url + 'api/parts/get_one/' + part_id,
                        data: {},
                        beforeSend: function (xhr) {
                        },
                    }).done(function (data) {
                        $("#part_name").val('');
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
                    });
                }
            }
        }

    })
} */

// } */

// 0 - green
// 1 - red
// 2 - orange 
// 3 - gray

var event_part_id = '';

function fetch_job_details_from_db(side, part_id) {
    $.ajax({
        url: base_url + 'api/jobs/get_api_data',
        method: "POST",
        data: { 'side': side, part_id },
        dataType: "json",
        success: function (data) {
            let part_id = data.id;

            if (part_id != event_part_id) {
                $(".part_name").html(data.part_name);
                $("#part_no").html(data.part_no);
                $("#model").html(data.model);
                $("#die_no").html(data.die_no);
                event_part_id = part_id;
            }

            $(".pin-box").each(function () {
                let title = $(this).attr('title');

                var pins_data = JSON.parse(data.pins);

                for (let i in pins_data) {
                    console.log("data.pins[i] ::", pins_data[i]);

                    let style_class = 'gray-pin';
                    if (i == title) {
                        $(this).removeClass('green-pin');
                        $(this).removeClass('red-pin');
                        $(this).removeClass('orange-pin');
                        $(this).removeClass('gray-pin');

                        if (pins_data[i] == 0) {
                            style_class = 'green-pin';
                        } else if (pins_data[i] == 1) {
                            style_class = 'red-pin';
                        } else if (pins_data[i] == 2) {
                            style_class = 'orange-pin';
                        } else if (pins_data[i] == 3) {
                            style_class = 'gray-pin';
                        }
                        $(this).addClass(style_class);
                    }
                }
            });

            //if(leftInterval!='') {
            //clearTimeout(leftInterval);
            //leftInterval = setTimeout(fetch_job_details_from_db(side, part_id), 5000);
            //console.log("leftInterval", leftInterval);
            //}
        },
    });

}

/* if ($("#start_jobs_data_left").length > 0) { 
    fetch_job_details_from_db('left');
}

if ($("#start_jobs_data_right").length > 0) { 
    fetch_job_details_from_db('right');
} */

function check_path_and_change_sidebar() {
    var pathname = window.location.pathname;
    let paths = pathname.split("/");

    if (paths.length == 6) {
        paths.pop();
        pathname = paths.join("/");
    } else if (paths.length == 5) {
        paths.pop();
        pathname = paths.join("/");
    }

    if (
        pathname == '/public/admin/parts/add' ||
        pathname == '/public/admin/parts/edit' ||
        pathname == '/public/admin/parts/view' ||
        pathname == '/public/jobs/right_job' ||
        pathname == '/public/jobs/left_job' ||
        pathname == '/public/jobs' ||
        pathname == '/public/admin/parts'
    ) {
        $("body").addClass('sidebar-collapse');
    }

    if (
        pathname == '/admin/parts/add' ||
        pathname == '/admin/parts/edit' ||
        pathname == '/admin/parts/view' ||
        pathname == '/jobs/right_job' ||
        pathname == '/jobs/left_job'
    ) {
        $("body").addClass('sidebar-collapse');
    }
}


check_path_and_change_sidebar();
//$('.end_time_left').hide();
var leftInterval = '';
if ($('.end_time_left').is(":visible")) {
    let id = $('#update_id_left').val();
    /*fetch_job_details_from_db('left', id);
    leftInterval = setInterval(function () { fetch_job_details_from_db('left', id); }, 5000);
    */
    web_socket_init('left');
    //leftInterval = setInterval(function () { web_socket_init('left'); }, 5000);
    //clockUpdate();
    leftInterval = setInterval(clockUpdate, 1000);
}

var rightInterval = '';
if ($('.end_time_right').is(":visible")) {
    let id = $('#update_id_right').val();
    //fetch_job_details_from_db('right', id);
    //rightInterval = setInterval(function () { fetch_job_details_from_db('right', id) }, 5000);
    web_socket_init('right');
    //rightInterval = setInterval(function () { web_socket_init('right'); }, 5000);
    //clockUpdate();
    rightInterval = setInterval(clockUpdate, 1000);
}


if($("#right_side_tv_display").is(":visible")) {
    web_socket_init('right');
}

if($("#left_side_tv_display").is(":visible")) {
    web_socket_init('left');
}


$(document).ready(function () {
    if ($('.digital-clock').length > 0) {
        $(".start_time_left").on('click', function (e) {
            e.preventDefault();
            var id = $('#part_left_id').val();
            if (id == '') {
                alert('Please select part name.');
                return false;
            }
            
            if($(this).attr('disabled') != 'disabled') {    
                $(this).attr('disabled', true);         
                timer = 0;
                leftInterval = setInterval(clockUpdate, 1000);
                var btn_id = $(this);
                $.ajax({
                    url: base_url + 'api/jobs/set_job_actions',
                    method: "POST",
                    data: { 'side': 'left', part_id: id, time: 'start_time' },
                    dataType: "json",
                }).done(function (data) {
                    successMsg(data.msg);
                    $('#update_id_left').val(data.lastInsertid);
                    $('#part_left_id').parent('div').hide();
                    $('.start_time_left').hide();
                    $('.end_time_left').show();
                    $('.digital-clock').show();
                    $("#display_part-details").show();

                    if ($("#start_jobs_data_left").length > 0) {

                        $(".part_name").html('');
                        $(".part_no").html('');
                        $(".model").html('');
                        $(".die_no").html('');

                        // production code
                        //fetch_job_details_from_db('left', id);
                        /* leftInterval = setInterval(function(){                        
                            fetch_job_details_from_db('left', id)},                         
                            5000
                        ); */

                        web_socket_init('left');                    
                    }

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
        });

        $(".end_time_left").on('click', function (e) {
            e.preventDefault();
            var id = $('#update_id_left').val();
            var btn_id = $(this);
            $.ajax({
                url: base_url + 'api/jobs/set_job_actions',
                method: "POST",
                data: { 'side': 'left', id: id, time: 'end_time' },
                dataType: "json",
            }).done(function (data) {
                successMsg(data.msg);
                $('#part_left_id').parent('div').show();
                $('.start_time_left').show();
                $('.end_time_left').hide();
                $('.digital-clock').hide();
                $("#display_part-details").hide();
                $('#part_left_id').val('');
                timer = 0;
                clearInterval(leftInterval);
                $(".start_time_left").attr('disabled', false);
            }).fail(function (data) {
                $(btn_id).attr('disabled', false);
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

        $(".start_time_right").on('click', function (e) {
            e.preventDefault();

            var id = $('#part_right_id').val();
            var btn_id = $(this);
            if (id == '') {
                alert('please select part name first');
                return false;
            }

            if($(this).attr('disabled') != 'disabled') {    
                $(this).attr('disabled', true);        
                timer = 0;
                rightInterval = setInterval(clockUpdate, 1000);
                $.ajax({
                    url: base_url + 'api/jobs/set_job_actions',
                    method: "POST",
                    data: { 'side': 'right', part_id: id, time: 'start_time' },
                    dataType: "json",
                }).done(function (data) {

                    successMsg(data.msg);
                    $('#update_id_right').val(data.lastInsertid);
                    $('#part_right_id').parent('div').hide();
                    $('.start_time_right').hide();
                    $('.end_time_right').show();
                    $("#display_part-details").show();
                    $('.digital-clock').show();

                    if ($("#start_jobs_data_right").length > 0) {

                        $(".part_name").html('');
                        $(".part_no").html('');
                        $(".model").html('');
                        $(".die_no").html('');

                        /*  fetch_job_details_from_db('right', id);
                        rightInterval = setTimeInterval(function () { 
                            fetch_job_details_from_db('right', id) 
                        }, 5000); */
                        
                        web_socket_init('right');
                    }

                }).fail(function (data) {
                    $(btn_id).attr('disabled', false);
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

        $(".end_time_right").on('click', function (e) {
            e.preventDefault();
            
            let id = $('#update_id_right').val();
            var btn_id = $(this);
            $.ajax({
                url: base_url + 'api/jobs/set_job_actions',
                method: "POST",
                data: { 'side': 'right', id: id, time: 'end_time' },
                dataType: "json",
            }).done(function (data) {
                successMsg(data.msg);
                $('#part_right_id').parent('div').show();
                $('.start_time_right').show();
                $('.end_time_right').hide();
                $('.digital-clock').hide();
                $('#part_right_id').val('');
                $("#display_part-details").hide();
                timer = 0;
                clearInterval(rightInterval);
                $(".start_time_right").attr('disabled', false);
            }).fail(function (data) {
                $(btn_id).attr('disabled', false);
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
});
var timer = 0;
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

   /*  var h = addZero(twelveHour(date.getHours()));
    var m = addZero(date.getMinutes());
    var s = addZero(date.getSeconds()); */
    

    var new_hr = Math.floor((timer / 3600));
    var new_m = Math.floor((timer % 3600) / 60);
    var h = new_hr>0?addZero(new_hr):addZero(0);
    var m = new_m>0?addZero(new_m):addZero(0);
    var s = addZero(Math.floor(timer % 60));

    timer++;

    $('.digital-clock').text(h + ':' + m + ':' + s);
}

$("#part-export").on('click', function () {
    window.location.href = base_url + 'admin/parts/export_part';
});

if ($("#update_users").length > 0) {
    new SlimSelect({
        select: '#role_id'
    });
    let id = $("#update_users").find("input[name='id']").val();
    $.ajax({
        url: base_url + 'api/users/get_one/' + id,
        method: "GET",
        dataType: "json",
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
            $("#update_users").find("input[name='is_active']").prop("checked", true); // Check the checkbo
            checkbox.prop("checked", true); // Check the checkbox
        } else if (is_active == 0) {
            $("#update_users").find("input[name='is_active']").prop("checked", false); // Check the checkbo
        }
        $.ajax({
            url: base_url + 'api/users/get_role_names',
            method: "POST",
            dataType: "json",
            data: {
                user_id: data.id
            },
            success: function (user_data) {
                if (user_data.role_id!== null) {
                    $("#update_users").find("select[name='role_id']").val(user_data.role_id['role_id']);
                    $("#role_id").css("display", "block");
                    $("#role_id").css("display", "none");
                }
            },
            error: function (error) {
                console.error("Error:", error);
            },
        });

    }).fail(function (data) {
        console.log("Not found");
    });

    $("#update_users").validate({
        rules: {
            'first_name': { required: true },
            'last_name': { required: true },
            'email': { required: true },
            'phone_number': { minlength: 10, maxlength: 12 },
            'username': { required: true },
            'password': { minlength: 5 },
            'confirm_password': { equalTo: "#password" },
            'email': { required: true, email: true },
            },
        messages: {
            'first_name': { required: 'Please enter first Name' },
            'last_name': { required: 'Please enter last Name' },
            'email': { required: 'Please enter Die No' },
            'username': { required: 'Please enter User Name' },
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

$(document).ready(function () {
    if ($("#add_users").length > 0) {
        new SlimSelect({
            select: '#role_id'
        });
        $("#add_users").validate({
            rules: {
                'first_name': {
                    required: true,
                },
                'last_name': { required: true },
                'email': { required: true },
                'phone_number': {
                   minlength: 10,
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
               
            },
            messages: {
                'first_name': {
                    required: 'Please enter first Name',
                },
                'last_name': { required: 'Please enter last Name' },
                'email': { required: 'Please enter email' },
                'username': { required: 'Please enter User Name' },
                'password': { required: 'Please enter password' },

                'confirm_password': { required: 'Please enter confirm password' },

                }
        });

        $("#add_users button").on('click', function (e) {
            e.preventDefault();
            let form_data = $("#add_users").serialize();
            console.log(form_data);
            if (!$("#add_users").valid()) {
                return false;
            }
            $.ajax({
                url: base_url + 'api/users/add/',
                method: "POST",
                data: form_data,
                dataType: "json",

                beforeSend: function (xhr) {
                    //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
                },
            }).done(function (data) {
                 successMsg(data.msg);
                location.href = base_url + 'admin/users/list';
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
        });
    }
});

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
                    return '<a href="' + base_url + 'admin/roles/edit/' + row['id'] + '"    class="edit_user" ><i class="fa fa-edit text-primary"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" data-id="' + row['id'] + '" class="delete_roles" ><i class="fa fa-trash"></i></a>';
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
        $.ajax({
            url: base_url + 'api/roles/add/',
            method: "POST",
            data: form_data,
            dataType: "json",

            beforeSend: function (xhr) {
                //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
            },
        }).done(function (data) {
            successMsg(data.msg);
            location.href = base_url + 'admin/roles/list';
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
            $("#update_roles").find("input[name='is_active']").prop("checked", true); // Check the checkbo
            checkbox.prop("checked", true); // Check the checkbox
        } else if (is_active == 0) {
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
        $.ajax({
            url: base_url + 'api/roles/update/' + id,
            method: "POST",
            data: form_data,
            dataType: "json",

            beforeSend: function (xhr) {
                //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
            },
        }).done(function (data) {
             successMsg(data.msg);
            location.href = base_url + 'admin/roles/list';
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
                    return '<a href="' + base_url + 'admin/permissions/edit/' + row['id'] + '"    class="edit_user" ><i class="fa fa-edit text-primary"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" data-id="' + row['id'] + '" class="delete_permission" ><i class="fa fa-trash"></i></a>';
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
        $.ajax({
            url: base_url + 'api/permissions/add/',
            method: "POST",
            data: form_data,
            dataType: "json",

            beforeSend: function (xhr) {
                //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
            },
        }).done(function (data) {
            successMsg(data.msg);
            location.href = base_url + 'admin/permissions/list';
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
        $.ajax({
            url: base_url + 'api/permissions/update/' + id,
            method: "POST",
            data: form_data,
            dataType: "json",

            beforeSend: function (xhr) {
                //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
            },
        }).done(function (data) {
       successMsg(data.msg);
            location.href = base_url + 'admin/permissions/list';
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
    });
}
$(document).on("click", "#select_all", function () {
    if ($(this).is(":checked") == true) {
         $("input[name='permission_id[]']").prop("checked", true);
        $("input[name='permission_id[]']").attr("checked", "checked");
    } else {
        $("input[name='permission_id[]']").prop("checked", false);
      }
});
var date_formate = 'DD-MM-YYYY HH:mm A';
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

        new SlimSelect({
            select: '#part_name_filter'
        });


        new SlimSelect({
            select: '#part_no_filter'
        });
        new SlimSelect({
            select: '#part_model_filter'
        });
        new SlimSelect({
            select: '#part_die_no_filter'
        });

        var part_no = $("#part_no_filter").val();
        var from_to_date = $("#f_date").val();
        var dateParts = from_to_date.split(" - ");

        // The first part (index 0) is the "from date," and the second part (index 1) is the "to date."
        var from_date_str = dateParts[0];
        var to_date_str = dateParts[1];

        // Use Moment.js to parse and format the dates
        var from_date = moment(from_date_str, "DD-MM-YYYY hh:mm A").format("DD-MM-YYYY");
        var to_date = moment(to_date_str, "DD-MM-YYYY hh:mm A").format("DD-MM-YYYY");


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

            ]
        });
    }
    return dataTable;
}
function reload_complete_tbl() {
    var part_no = $("#part_no_filter").val();
    var from_to_date = $("#f_date").val();
    var dateParts = from_to_date.split(" - ");

    // The first part (index 0) is the "from date," and the second part (index 1) is the "to date."
    var from_date_str = dateParts[0];
    var to_date_str = dateParts[1];

var from_date = moment(from_date_str, "DD-MM-YYYY hh:mm A").format("DD-MM-YYYY");
    var to_date = moment(to_date_str, "DD-MM-YYYY hh:mm A").format("DD-MM-YYYY");

    var part_name = $("#part_name_filter").val();
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



var date_formate = 'DD-MM-YYYY HH:mm A';
var defaultStartDate = moment().subtract(7, 'days').format('DD-MM-YYYY');
$('input[name="f_date_history"]').daterangepicker({
    locale: {
        format: date_formate
    },
    startDate: defaultStartDate,

});
$('#f_date_history').change(function () {
    hide_show_complete_history();
});

$('#part_name_filter_history').change(function () {
    hide_show_complete_history();
});

$('#part_no_filter_history').change(function () {
    hide_show_complete_history();
});
$('#part_model_filter_history').change(function () {
    hide_show_complete_history();
});
$('#part_die_no_filter_history').change(function () {
    hide_show_complete_history();
});

function hide_show_complete_history() {
    reload_history_tbl();
    $("#history_list_tbl").show();
}
var history_table;
history_table = generate_table_history();
function generate_table_history() {
    if ($("#history_list_tbl").length > 0) {


        new SlimSelect({
            select: '#part_name_filter_history',
        })


        new SlimSelect({
            select: '#part_no_filter_history',
        })
        new SlimSelect({
            select: '#part_model_filter_history'
        });

        new SlimSelect({
            select: '#part_die_no_filter_history'
        });

        var part_no = $("#part_no_filter_history").val();
        var from_to_date = $("#f_date_history").val();
        var dateParts = from_to_date.split(" - ");

        // The first part (index 0) is the "from date," and the second part (index 1) is the "to date."
        var from_date_str = dateParts[0];
        var to_date_str = dateParts[1];

        // Use Moment.js to parse and format the dates
        var from_date = moment(from_date_str, "DD-MM-YYYY hh:mm A").format("DD-MM-YYYY");
        var to_date = moment(to_date_str, "DD-MM-YYYY hh:mm A").format("DD-MM-YYYY");

         var part_name = $("#part_name_filter_history").val();
        var model = $("#part_model_filter_history").val();
        var die_no = $("#part_die_no_filter_history").val();
        var dataTable = $("#history_list_tbl").DataTable({
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
                "url": base_url + "api/jobs/history_list?from_date=" + from_date + "&to_date=" + to_date + "&part_no=" + part_no + "&part_name=" + part_name + "&model=" + model + "&die_no=" + die_no,
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

            ]
        });
    }
    return dataTable;
}

function reload_history_tbl() {
    var part_no = $("#part_no_filter_history").val();
    var from_to_date = $("#f_date_history").val();
    var dateParts = from_to_date.split(" - ");
    var from_date_str = dateParts[0];
    var to_date_str = dateParts[1];
    var from_date = moment(from_date_str, "DD-MM-YYYY hh:mm A").format("DD-MM-YYYY");
    var to_date = moment(to_date_str, "DD-MM-YYYY hh:mm A").format("DD-MM-YYYY");

    var part_name = $("#part_name_filter_history").val();
    var model = $("#part_model_filter_history").val();
    var die_no = $("#part_die_no_filter_history").val();
    history_table.ajax.url(base_url + "api/jobs/history_list?from_date=" +
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

$('.start_time_left').change(function () {
    let id = $('#part_left_id').val();
});

function convertDateFormat_new(inputDate) {
    var dateParts = inputDate.split("-");
    var day = dateParts[0];
    var month = dateParts[1];
    var year = dateParts[2];
    
    // Create a new date in "MM/DD/YYYY" format
    var outputDate = month + '/' + day + '/' + year;
    return outputDate;
}
var report_completed_jobs_tbl = completed_jobs_tbl();

function completed_jobs_tbl() {
    if ($("#completed_list_tbl_data").length > 0) {  
        var job_Action_id = $("#uri_segment").val();
        var part_no = $("#cmp_part_no_filter").val();
        var from_date_completed_date = getUrlParameter('from_date');
        var to_date_completed_date = getUrlParameter('to_date');
     if(from_date_completed_date !=''){
            var from_date =convertDateFormat_new(from_date_completed_date);
            var to_date = convertDateFormat_new(to_date_completed_date);
     }else{
        var from_to_date = $("#from_date").val();;
        var dateParts = from_to_date.split(" - ");       
        var from_date = dateParts[0].trim();
        var to_date = dateParts[1].trim();
     }
        var part_name = $("#cmp_part_name_filter").val();
        var model = $("#cmp_part_model_filter").val();
        var die_no = $("#cmp_part_die_no_filter").val();
        var dataTable = $("#completed_list_tbl_data").DataTable({
            "ordering": true,
            'order': [[0, 'asc']],
            'serverMethod': 'get',
            'language': {
                'loadingRecords': '&nbsp;',
                'processing': 'Loading...',
                "emptyTable": "There is no record to display"
            },
            // "dom": 'Bfrtip',
            // buttons: true,
            // "lengthChange": false,
            "autoWidth": false,
            "buttons": ["csv", "excel", "print"],
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All'],
            ],
            "ajax": {
                "url": base_url + "api/jobs/report_completed_list?from_date=" + from_date + "&to_date=" + to_date + "&part_no=" + part_no + "&part_name=" + part_name + "&model=" + model + "&die_no=" + die_no+"&job_Action_id="+job_Action_id,
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
                    "data": "start_time",
                    "render": function (data, type, row, meta) {
                        if (data && data != '-') {
                            return (data.replace(" ", "<br>"));
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    "data": "end_time",
                    "render": function (data, type, row, meta) {
                        if (data && data != '-') {
                            return (data.replace(" ", "<br>"));
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    "data": "total_time",
                    "render": function (data, type, row, meta) {
                        if (data) {
                            return data;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    "data": "wrong_pins",
                    "render": function (data, type, row, meta) {
                        if (data) {
                            return data;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    "data": "correct_pins",
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
                        if (data != '') {
                            return data.split(",").length;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    "data": null,
                    "render": function (data, type, row, meta) {
                        if (row['pins']) {
                            var perc = 0;
                            if(row['correct_pins']>0) {
                                perc = (row['correct_pins'] / row['pins'].split(",").length)* 100; 
                                perc = perc.toFixed(2);
                            }
                            return perc;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    "data": "image_url",
                    "render": function (data, type, row, meta) {
                        if (data && data != '-') {
                            return '<a href="' + base_url +"assets/img/"+ data + '" target="_blank"><img src="' + base_url +"assets/img/"+ data + '" height="60px" width="80px" style="object-fit: cover;" /></a>';
                        } else {
                            return '-';
                        }
                    }
                }

            ]
        });
    }
    return dataTable;
}


function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}
function reload_completed_jobs_tbl() {
    var part_no = $("#cmp_part_no_filter").val();
    var from_to_date = $("#from_date").val();
    var dateParts = from_to_date.split(" - ");

    var from_date_str = dateParts[0].trim();
    var to_date_str = dateParts[1].trim();
   var from_date = convertDateFormat(from_date_str);
    var to_date = convertDateFormat(to_date_str);
    var part_name = $("#cmp_part_name_filter").val();
    var model = $("#cmp_part_model_filter").val();
    var die_no = $("#cmp_part_die_no_filter").val();

    report_completed_jobs_tbl.ajax.url(
        base_url + "api/jobs/report_completed_list?" +
        "from_date=" + from_date +
        "&to_date=" + to_date +
        "&part_no=" + part_no +
        "&part_name=" + part_name +
        "&model=" + model +
        "&die_no=" + die_no
    ).load();
}
var date_formate_com = 'DD-MM-YYYY';

var from_date_completed_date = getUrlParameter('from_date');
var to_date_completed_date = getUrlParameter('to_date');
if(from_date_completed_date != ''){
    $("#completed_jobs_list_form #from_date").daterangepicker({
        clearBtn: true,
        "showDropdowns": true,
        locale: {
            format: date_formate_com
        },
        startDate: moment(from_date_completed_date, date_formate_com),
        endDate: moment(to_date_completed_date, date_formate_com),
        maxDate: new Date(),
    });
}else{
if ($("#completed_list_tbl_data").length > 0) {
    $("#completed_jobs_list_form #from_date").daterangepicker({
        clearBtn: true,
        "showDropdowns": true,
        locale: {
            format: date_formate_com
        },

        startDate: moment().subtract(1, 'month'),
        endDate: new Date(),
        maxDate: new Date(),
    });
}
}

$('#completed_jobs_list_form #from_date').on('apply.daterangepicker', function (ev, picker) {
    reload_completed_jobs_tbl();
});

if ($("#completed_list_tbl_data").length > 0) {
    new SlimSelect({
        select: '#cmp_part_name_filter',
        onChange: (newVal) => {
            reload_completed_jobs_tbl();
        }
    });

    new SlimSelect({
        select: '#cmp_part_no_filter',
        onChange: (newVal) => {
            reload_completed_jobs_tbl();
        }
    });
    new SlimSelect({
        select: '#cmp_part_model_filter',
        onChange: (newVal) => {
            reload_completed_jobs_tbl();
        }
    });
    new SlimSelect({
        select: '#cmp_part_die_no_filter',
        onChange: (newVal) => {
            reload_completed_jobs_tbl();
        }
    });
}

if ($("#part_left_id").length > 0) {
    new SlimSelect({
        select: '#part_left_id',
        onChange: (newVal) => {

        }
    });
}

var date_formate = 'DD-MM-YYYY';
var defaultStartDate = moment().subtract(7, 'days').format('DD-MM-YYYY');
$('input[name="from_date_dashboard"]').daterangepicker({
     clearBtn: true,
    "showDropdowns": true,
    locale: {
        format: date_formate
    },
    startDate: moment().subtract(1, 'month'),
    endDate: new Date(),
    maxDate: new Date(),

});


$('#from_date_dashboard').change(function () {
   // hide_show_complete_job();
   get_all_count();
});

if($('#from_date_dashboard').length>0) {
    get_all_count();
   
    var from_to_date = $("#from_date_dashboard").val();
    var dateParts = from_to_date.split(" - ");
    var from_date_str = dateParts[0].trim();
    var to_date_str = dateParts[1].trim();
   var from_date = convertDateFormat(from_date_str);
    var to_date = convertDateFormat(to_date_str);
    var anchor = $(".myAnchor");

    if (anchor.length) {
        anchor.attr("href", base_url+ 'admin/reports/completed_jobs_list?from_date=' + from_date_str + '&to_date=' + to_date_str);
  }
}

function convertDateFormat(inputDate) {
    var dateParts = inputDate.split(" ");
    var dayMonthYear = dateParts[0].split("-");
    var time = dateParts[1];
    var year = dayMonthYear[2].slice(-4);
    var formattedDate = dayMonthYear[1] + "/" + dayMonthYear[0] + "/" + year;
    return formattedDate;
}

function get_all_count() {
    var from_to_date = $("#from_date_dashboard").val();
    var dateParts = from_to_date.split(" - ");
    var from_date_str = dateParts[0].trim();
    var to_date_str = dateParts[1].trim();
   var from_date = convertDateFormat(from_date_str);
    var to_date = convertDateFormat(to_date_str);
    $.ajax({
        url: base_url + 'api/users/get_all_count',
        method: "POST",
        data: { from_date: from_date, to_date: to_date },
        dataType: "json",
        beforeSend: function () { },
        complete: function () {

        },
        success: function (data) {
            var anchor = $(".myAnchor");

            // Check if the anchor is found
            if (anchor.length) {
                // Update the href attribute
                   anchor.attr("href", base_url+ 'admin/reports/completed_jobs_list?from_date=' + from_date_str + '&to_date=' + to_date_str);
          }
    
            $("#total_completed_jobs").html(parseInt(data.total_completed_jobs));
             $("#averag_hour_required").html(Number(data.averag_hour_required).toFixed(2));
            var completedJobData = data.completed_job;
            var count = completedJobData.length; // Get the count
            for (var i = 0; i < count; i++) {
                var completedJob = completedJobData[i];
                var partNo = completedJob.part_no;
                var startTime = completedJob.start_time;
                var side = completedJob.side;
                if (completedJob.end_time == null) {
                    var process = 'Inprocess Job'
                } else {
                    var process = 'Completed Job'
                }
                // Clone the template and set dynamic values for part_no and start_time
                var $item = $("<li class='item'>" +
                    "<div class='product-info'>" +
                    "<a href='javascript:void(0)' class='product-title'>" +
                    "<span class='part-no'></span>" +

                    "<span class='badge badge-warning float-right start-time'></span>" +
                    "</a>" +
                    "<span class='product-description process'></span>" +
                    "(<span class='side'></span>)" +
                    "</div>" +
                    "</li>");

                $item.find('.part-no').text(partNo);
                $item.find('.side').text(side);
                $item.find('.start-time').text(formatDate(startTime));
                $item.find('.process').text(process);

                // Append the cloned item to the list
                $(".products-list.product-list-in-card").append($item);
            }

        },
        error: function () { }
    });
}

function formatDate(dateString) {
    var date = new Date(dateString);
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var day = date.getDate();
    var month = months[date.getMonth()];
    var year = date.getFullYear();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12;
    if (minutes < 10) {
        minutes = '0' + minutes;
    }
    var formattedDate = day + '-' + month + '-' + year + ' ' + hours + ':' + minutes + ' ' + ampm;

    return formattedDate;
}

if ($("#dashboard_list_tbl").length > 0) {
    // table
    var dashboard_table = $("#dashboard_list_tbl").DataTable({
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
            "url": base_url + "api/jobs/report_list_dashboard",
            "dataSrc": "",
        },
        "columns": [
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
                "data": "end_time",
                "render": function (data, type, row, meta) {

                    // Assuming "cb-switch" is the ID of the checkbox input element
                    var checkboxId = "cb-switch";
                    // Create a unique ID for each checkbox
                    if (data !== 'null') {
                        return 'completed';
                    } else {
                        return 'pending';
                    }


                }
            },
            {
                "data": "completed_time",
                "render": function (data, type, row, meta) {
                    if (data) {
                        return data;
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": null,
                "render": function (data, type, row, meta) {
                    return '<a href="' + base_url + 'admin/reports/completed_jobs_list/' + row['id'] + '" ><i class="fa fa-eye"></i></a>';
                }
            }

        ]
    });
}

if ($("#part_right_id").length > 0) {
    new SlimSelect({
        select: '#part_right_id',
        onChange: (newVal) => {

        }
    });
}

$("#completed-job-export").on('click', function () {   
        var part_no = $("#cmp_part_no_filter").val();
        var from_to_date = $("#from_date").val();
        var dateParts = from_to_date.split(" - ");
        var from_date_str = dateParts[0].trim();
        var to_date_str = dateParts[1].trim();
       var from_date = convertDateFormat(from_date_str);
        var to_date = convertDateFormat(to_date_str);
        var part_name = $("#cmp_part_name_filter").val();
        var model = $("#cmp_part_model_filter").val();
        var die_no = $("#cmp_part_die_no_filter").val();
    window.location.href = base_url + 'api/jobs/export_completed_job?part_no='+part_no+'&from_date='+from_date+"&to_date="+to_date+'&part_name='+part_name+'&model='+model+'&die_no='+die_no;
});

$("#completed-job-pdf").on('click', function () {   
    var part_no = $("#cmp_part_no_filter").val();
    var from_to_date = $("#from_date").val();
    var dateParts = from_to_date.split(" - ");
    var from_date_str = dateParts[0].trim();
    var to_date_str = dateParts[1].trim();
   var from_date = convertDateFormat(from_date_str);
    var to_date = convertDateFormat(to_date_str);

    var part_name = $("#cmp_part_name_filter").val();
    var model = $("#cmp_part_model_filter").val();
    var die_no = $("#cmp_part_die_no_filter").val();
window.location.href = base_url + 'api/jobs/pdf_completed_job?part_no='+part_no+'&from_date='+from_date+"&to_date="+to_date+'&part_name='+part_name+'&model='+model+'&die_no='+die_no;
});