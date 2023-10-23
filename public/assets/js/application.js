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
                "data": "is_active",
                "render": function (data, type, row, meta) {
                    if (data && data != '-') {
                        // Assuming "cb-switch" is the ID of the checkbox input element
                        var checkboxId = "cb-switch"; // Create a unique ID for each checkbox
                        if (data == 1) {
                            return '<div class="toggle-switch user_active_inactive"><label for="' + checkboxId + '"><input type="checkbox" id="' + checkboxId + '" name="is_active" value="" checked><span><small></small></span></label></div>';
                        } else {
                            return '<div class="toggle-switch user_active_inactive"><label for="' + checkboxId + '"><input type="checkbox" id="' + checkboxId + '" name="is_active" value=""><span><small></small></span></label></div>';
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
                    return '<a href="' + base_url + 'admin/users/edit/' + row['id'] + '"    class="edit_user" ><i class="fa fa-edit"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" class="user-delete" ><i class="fa fa-trash"></i></a>';
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
                        var checkboxId = "cb-switch"; // Create a unique ID for each checkbox
                        if (data == 1) {
                            return '<div class="toggle-switch part_active_inactive"><label for="' + checkboxId + '"><input type="checkbox" id="' + checkboxId + '" name="is_active" value="" checked><span><small></small></span></label></div>';
                        } else {
                            return '<div class="toggle-switch part_active_inactive"><label for="' + checkboxId + '"><input type="checkbox" id="' + checkboxId + '" name="is_active" value=""><span><small></small></span></label></div>';
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

function reload_users_tbl() {
    users_table.ajax.url(base_url + "api/users/list").load();
}


$(document).on('click', '.view_part', function () {
    let id = $(this).data('id');
    location.href = base_url + 'admin/parts/view/'+id;
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
            'part_name': { required: true,
             },
            'part_no': { required: true },
            'die_no': { required: true },
            'model': { required: true },
        },
        messages: {
            'part_name': { required: 'Please enter Part Name',
        },
            'part_no': { required: 'Please enter Part No' },
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
        
            $("#update_parts_data").find("input[name='is_active']").val('on');
            $("#update_parts_data").find("input[name='is_active']").prop("checked", true); // Check the checkbo
            checkbox.prop("checked", true); // Check the checkbox
        } else if(is_active == 0){
        
            $("#update_parts_data").find("input[name='is_active']").val('off');
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
            'part_no': { required: true },
            'model': { required: true },
            'die_no': { required: true },
            'model': { required: true },
        },
        messages: {
            'part_name': { required: 'Please enter Part Name' },
            'part_no': { required: 'Please enter Part No' },
            'model': { required: 'Please enter Model' },
            'die_no': { required: 'Please enter Die No' },
            'model': { required: 'Please enter Model' },
        }
    });

    $("#update_parts_data button").on('click', function (e) {
        e.preventDefault();

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
        }else{
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
// if ($("#start_jobs_data_left").length > 0) {
//     $.ajax({
//         type: 'POST', 
//         url: base_url + 'api/apiparts/add',
//         data: {},
//         beforeSend: function (xhr) {
//              },
//             }).done(function (data) {
//             successMsg(response.msg);


//             $.ajax({
//                 type: 'POST', // or 'GET', depending on your needs
//                 url: base_url + 'api/apiparts/get_api_data',
//                 data: {
//                     part_id: dataToSend.job_id,
//                     pins: dataToSend.pins
//                 },  
//                   beforeSend: function (xhr) {
//                         },
//             }).done(function (data) {
//                 var inputValue = data.model['id']; 
//                 $("#part_name").val(inputValue);
//                  $("#start_jobs_data_left").find("input[name='part_no']").val(data.result['part_id']);
//                 $("#start_jobs_data_left").find("input[name='model']").val(data.model['model']);

//                 var pins_array = data.formattedData['keys'].split(",");
//                 var pins_color = data.formattedData['values'].split(",");

//                 $(".pins-display").find(".pin-box").each(function (index) {
//                     if ($(this).hasClass('orange-pin')) {
//                         $(this).removeClass('orange-pin').addClass('gray-pin');
//                     }
//                 });

//                 for (let i in pins_array) {
//                     var pin_address = pins_array[i];
//                     var pin_color = pins_color[i];

//                     $(".pins-display").find(".pin-box").each(function (index) {
//                         //  console.log("pins address::", pin_address);
//                         if ($(this).attr('title') == pin_address) {
//                             if (pin_color === '0') {
//                                 $(this).addClass('red-pin');
//                             } else if (pin_color === '1') {
//                                 $(this).addClass('green-pin');
//                             } else {
                               
//                             }
//                         }
//                     });
//                 }

//             }).fail(function (data) {
//                 console.log("Not found");
//             });
//         }).fail(function (data) {
//             btn.removeClass('button--loading').attr('disabled', false);
//             if (typeof data.responseJSON.messages === 'object') {
//                 for (let i in data.responseJSON.messages) {
//                     failMsg(data.responseJSON.messages[i]);
//                 }
//             } else {
//                 let msg = data.responseJSON.messages.msg;
//                 failMsg(msg);
//             }

//         });
//     // });



// }


if ($("#start_jobs_data_left").length > 0) {
    $("#start_jobs_data_left").find("#part_name").select2();
    $.ajax({
        type: 'POST', 
        url: base_url + 'api/apiparts/add',
        data: {}, 
        beforeSend: function (xhr) {
              },
    }).done(function (data) {
        successMsg(data.msg);


        $.ajax({
            type: 'POST', // or 'GET', depending on your needs
            url: base_url + 'api/apiparts/get_api_data',
            data: {},
            beforeSend: function (xhr) {
            },
        }).done(function (data) {
            var inputValue = data.model['id'];

            $("#part_name").val('');
            if ($("#part_name").length > 0) {
            }
            $("#start_jobs_data_left").find("input[name='part_name']").val(inputValue);
            $("#start_jobs_data_left").find("input[name='part_no']").val(data.result['part_id']);
            $("#start_jobs_data_left").find("input[name='model']").val(data.model['model']);

            var pins_array = data.formattedData['keys'].split(",");
            var pins_color = data.formattedData['values'].split(",");

            $(".pins-display").find(".pin-box").each(function (index) {
                if ($(this).hasClass('orange-pin')) {
                    $(this).removeClass('orange-pin').addClass('gray-pin');
                }
            });

            for (let i in pins_array) {
                var pin_address = pins_array[i];
                var pin_color = pins_color[i];

                $(".pins-display").find(".pin-box").each(function (index) {
                    //  console.log("pins address::", pin_address);
                    if ($(this).attr('title') == pin_address) {
                        if (pin_color === '0') {
                            $(this).addClass('red-pin');
                        } else if (pin_color === '1') {
                            $(this).addClass('green-pin');
                        } else {
                           
                        }
                    }
                });
            }

        }).fail(function (data) {
            // $(btn_id).removeClass('button--loading').attr('disabled', false);

        });

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

if ($("#start_jobs_data").length > 0) {
    $("#start_jobs_data").find("#part_name").select2();
    $.ajax({
        type: 'POST', 
        url: base_url + 'api/apiparts/add',
        data: {}, 
        beforeSend: function (xhr) {
              },
    }).done(function (data) {
        successMsg(data.msg);


        $.ajax({
            type: 'POST', // or 'GET', depending on your needs
            url: base_url + 'api/apiparts/get_api_data',
            data: {},
            beforeSend: function (xhr) {
            },
        }).done(function (data) {
            var inputValue = data.model['id'];

            $("#part_name").val('');
            if ($("#part_name").length > 0) {
            }
            $("#start_jobs_data").find("input[name='part_name']").val(inputValue);
            $("#start_jobs_data").find("input[name='part_no']").val(data.result['part_id']);
            $("#start_jobs_data").find("input[name='model']").val(data.model['model']);

            var pins_array = data.formattedData['keys'].split(",");
            var pins_color = data.formattedData['values'].split(",");

            $(".pins-display").find(".pin-box").each(function (index) {
                if ($(this).hasClass('orange-pin')) {
                    $(this).removeClass('orange-pin').addClass('gray-pin');
                }
            });

            for (let i in pins_array) {
                var pin_address = pins_array[i];
                var pin_color = pins_color[i];

                $(".pins-display").find(".pin-box").each(function (index) {
                    //  console.log("pins address::", pin_address);
                    if ($(this).attr('title') == pin_address) {
                        if (pin_color === '0') {
                            $(this).addClass('red-pin');
                        } else if (pin_color === '1') {
                            $(this).addClass('green-pin');
                        } else {
                           
                        }
                    }
                });
            }

        }).fail(function (data) {
            // $(btn_id).removeClass('button--loading').attr('disabled', false);

        });

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





    // $("#start_jobs_data #part_name").on('change', function(){
    //     let id = $(this).val();

    //     // if(id>0) {
    //     //     $.ajax({
    //     //         url: base_url + 'api/parts/get_one/'+id,
    //     //         method: "GET",
    //     //         dataType: "json",
    //     //         beforeSend: function (xhr) {
    //     //             //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
    //     //         },
    //     //     }).done(function (data) {

    //     //         $("#start_jobs_data").find("input[name='part_name']").val(data.part_name);
    //     //         $("#start_jobs_data").find("input[name='part_no']").val(data.part_no);
    //     //         $("#start_jobs_data").find("input[name='model']").val(data.model);

    //     //         var pins_array = data.pins.split(",");
    //     //         $(".pins-display").find(".pin-box").each(function(index) {
    //     //             if($(this).hasClass('orange-pin')) {  
    //     //                 $(this).removeClass('orange-pin').addClass('gray-pin');
    //     //             }
    //     //         });

    //     //         for(let i in pins_array) {
    //     //             var pin_address = pins_array[i];                
    //     //             $(".pins-display").find(".pin-box").each(function(index){
    //     //                 console.log("pins address::", pin_address);
    //     //                 if($(this).attr('title') == pin_address) {                    
    //     //                     $(this).addClass('orange-pin');
    //     //                 }
    //     //             });
    //     //         }

    //     //     }).fail(function (data) {
    //     //         console.log("Not found");
    //     //     });
    //     // }        
    // });
}


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


$("#part-export").on('click', function(){
//     is_active = $("#is_active").val();
//     part_no = $("#part_no").val();
// var  = $("#v_id").val();
// var emp_id = $("#em_id").val();
// var role_id = $("#role_ids").val();
// var contractor_id = $("#contractor_ids").val();
// var e_id = $("#e_id").val();
// var role_category_id = $("#role_category_ids").val();
// var department_id = $("#department_ids").val(); 


    window.location.href =  base_url + 'admin/parts/export_part';
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
        
            $("#update_users").find("input[name='is_active']").val('on');
            $("#update_users").find("input[name='is_active']").prop("checked", true); // Check the checkbo
            checkbox.prop("checked", true); // Check the checkbox
        } else if(is_active == 0){
        
            $("#update_users").find("input[name='is_active']").val('off');
            $("#update_users").find("input[name='is_active']").prop("checked", false); // Check the checkbo
        }
    }).fail(function (data) {
        console.log("Not found");
    });
    $("#update_users").validate({
        rules: {
            'first_name': { required: true,
             },
            'last_name': { required: true },
            'email': { required: true },
            'phone_number': {  required: true, minlength: 10,
                maxlength: 12, },
            'username': { required: true },
            'password': {  minlength: 5 },
            'confirm_password': { 
                equalTo: "#password" },
            'email': { required: true ,
                email: true},
            'employee_id': { required: true },
        },
        messages: {
            'first_name': { required: 'Please enter first Name',
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
        form_data += '&is_active=' +is_Active_val;

        
        console.log(form_data);

        // let btn = $(this);

        // btn.addClass('button--loading').attr('disabled', true);

        $.ajax({
            url: base_url + 'api/users/update/' + id,
            method: "POST",
            data: form_data,
            dataType: "json",            beforeSend: function (xhr) {
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
            'first_name': { required: true,
             },
            'last_name': { required: true },
            'email': { required: true },
            'phone_number': { required: true, minlength: 10,
                maxlength: 12, },
            'username': { required: true },
            'password': {  required: true,minlength: 5 },
            'confirm_password': {  required: true,
                equalTo: "#password" },
            'email': { required: true ,
                email: true},
            'employee_id': { required: true },
        },
        messages: {
            'first_name': { required: 'Please enter first Name',
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
