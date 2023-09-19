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
    $("#users_list_tbl").DataTable({
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
                        return data == 1 ? 'Yes' : 'No';
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
                    return '<a href="javascript:void(0)"   class="edit_role" ><i class="fa fa-edit"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" class="user-delete" ><i class="fa fa-trash"></i></a>';
                }
            }
        ]
    });
}

//dashboard page
if($("#from_date").length>0) {
    $("#from_date").daterangepicker({
        "startDate": moment(),
        "endDate":  moment().add(1, 'month')
    }, function(start, end, label) {
      console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');

      $("#from_date").val( start.format('YYYY-MM-DD') + " - " + end.format('YYYY-MM-DD'));
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
                        return  '<div class="pin-count" title="'+data+'">'+count.length+'</div>';
                    } else {
                        return '-';
                    }
                }
            },
            {
                "data": "is_active",
                "render": function (data, type, row, meta) {
                    if (data && data != '-') {
                        return data == 1 ? 'Yes' : 'No';
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
                    let html = '<a href="'+base_url+'admin/parts/edit/'+row['id']+'"   class="edit_part" data-id="'+row['id']+'"><i class="fa fa-edit text-info"></i></a>';
                    html += '&nbsp;&nbsp;<a href="javascript:void(0);" class="delete_part" data-id="'+row['id']+'" ><i class="fa fa-trash text-danger"></i></a>';
                    return html;
                }
            }
        ]
    });
}

function reload_parts_tbl() {
    parts_table.ajax.url(base_url + "api/parts/list").load();
}

$(document).on('click', '.delete_part', function(){
    let id = $(this).data('id');

    var con = confirm("Do you really want to delete this record?");

    if (con) {
        $.ajax({
            url: base_url + 'api/parts/delete/'+id,
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
if($(".pins-display .pin-box").length>0) {
    $(".pins-display .pin-box").on('click', function(){
        if($(this).hasClass('gray-pin')) {
            $(this).removeClass('gray-pin');
            $(this).addClass('green-pin');
        } else {
            $(this).removeClass('green-pin');
            $(this).addClass('gray-pin');
        }        
    });
}

if($("#add_parts_data").length>0) {
    $("#add_parts_data").validate({
        rules: {
            'part_name' : {required: true},
            'part_no' : {required: true},
            'model' : {required: true},
        },
        messages: {
            'part_name' : {required:'Please enter Part Name'},
            'part_no' : {required:'Please enter Part No'},
            'model' : {required:'Please enter Model'},
        }
    });

    $("#add_parts_data button").on('click',function(e){
        e.preventDefault();

        let pins_selected = [];
        let i=0;

        $(".pins-display .pin-box").each(function(index){
            if($(this).hasClass('green-pin')) {
                pins_selected[i++] = $(this).attr('title');
            }
        });

        let form_data = $("#add_parts_data").serialize();
        form_data += '&selected_pins='+ pins_selected;    
        console.log(form_data);

        if (!$("#add_parts_data").valid()) {
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

if($("#update_parts_data").length>0) {

    let id = $("#update_parts_data").find("input[name='id']").val();
    $.ajax({
        url: base_url + 'api/parts/get_one/'+id,
        method: "GET",
        dataType: "json",
        beforeSend: function (xhr) {
            //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
        },
    }).done(function (data) {
        $("#update_parts_data").find("input[name='part_name']").val(data.part_name);
        $("#update_parts_data").find("input[name='part_no']").val(data.part_no);
        $("#update_parts_data").find("input[name='model']").val(data.model);

        var pins_array = data.pins.split(",");

        for(let i in pins_array) {
            var pin_address = pins_array[i];
            $(".pins-display").find(".pin-box").each(function(index){
                console.log("pins address::", pin_address);
                if($(this).attr('title') == pin_address) {                    
                    $(this).addClass('green-pin');
                }
            });
        }

    }).fail(function (data) {
        console.log("Not found");
    });


    $("#update_parts_data").validate({
        rules: {
            'part_name' : {required: true},
            'part_no' : {required: true},
            'model' : {required: true},
        },
        messages: {
            'part_name' : {required:'Please enter Part Name'},
            'part_no' : {required:'Please enter Part No'},
            'model' : {required:'Please enter Model'},
        }
    });

    $("#update_parts_data button").on('click',function(e){
        e.preventDefault();

        let pins_selected = [];
        let i=0;

        $(".pins-display .pin-box").each(function(index){
            if($(this).hasClass('green-pin')) {
                pins_selected[i++] = $(this).attr('title');
            }
        });

        let form_data = $("#update_parts_data").serialize();
        form_data += '&selected_pins='+ pins_selected;    
        console.log(form_data);

        if (!$("#update_parts_data").valid()) {
            return false;
        }

        let btn = $(this); 

        btn.addClass('button--loading').attr('disabled', true);
    
        $.ajax({
            url: base_url + 'api/parts/update/'+id,
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

if($("#start_jobs_data").length>0) {
    $("#start_jobs_data").find("#part_name").select2();

    $("#start_jobs_data #part_name").on('change', function(){
        let id = $(this).val();

        if(id>0) {
            $.ajax({
                url: base_url + 'api/parts/get_one/'+id,
                method: "GET",
                dataType: "json",
                beforeSend: function (xhr) {
                    //xhr.setRequestHeader('Authorization', "Bearer " + getCookie('auth_token'));
                },
            }).done(function (data) {
                $("#start_jobs_data").find("input[name='part_name']").val(data.part_name);
                $("#start_jobs_data").find("input[name='part_no']").val(data.part_no);
                $("#start_jobs_data").find("input[name='model']").val(data.model);
        
                var pins_array = data.pins.split(",");
    
                $(".pins-display").find(".pin-box").each(function(index) {
                    if($(this).hasClass('orange-pin')) {  
                        $(this).removeClass('orange-pin').addClass('gray-pin');
                    }
                });
        
                for(let i in pins_array) {
                    var pin_address = pins_array[i];                
                    $(".pins-display").find(".pin-box").each(function(index){
                        console.log("pins address::", pin_address);
                        if($(this).attr('title') == pin_address) {                    
                            $(this).addClass('orange-pin');
                        }
                    });
                }
        
            }).fail(function (data) {
                console.log("Not found");
            });
        }        
    });
}
