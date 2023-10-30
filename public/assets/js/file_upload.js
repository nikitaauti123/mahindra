var fileobj;
function upload_file(e, import_file = 'bulk_import', redirect_path = '') {
    e.preventDefault();
    fileobj = e.dataTransfer.files[0];
    ajax_file_upload(fileobj, import_file, redirect_path);
}

function file_explorer(import_file = 'bulk_import', redirect_path = '') {
    document.getElementById('selectfile').click();
    document.getElementById('selectfile').onchange = function () {
        fileobj = document.getElementById('selectfile').files[0];
        ajax_file_upload(fileobj, import_file, redirect_path);
    };
}

function ajax_file_upload(file_obj, import_file, redirect_path = '') {

    if (file_obj != undefined) {
        var form_data = new FormData();
        form_data.append('file',file_obj);
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST",import_file, true);
        document.getElementById("drag_upload_file").style.display = "none";
        document.getElementById("drag_upload_msg").style.display = "block";
        xhttp.onload = function (event) {
            console.log(xhttp.response);
            var res = JSON.parse(xhttp.response);
            alert(res.message);
           console.log(res);
             if (xhttp.status == 200) {
                document.getElementById("drag_upload_file").style.display = "block";
                document.getElementById("drag_upload_msg").style.display = "none";

               
                if (redirect_path != '') {
                    setTimeout(function () { location.href = redirect_path }, 1000);
                }


                //oOutput.innerHTML = "<img src='" + this.responseText + "' alt='The Image' />";
            } else {
                alert("Error " + xhttp.status + " occurred when trying to upload your file.");
                document.getElementById("drag_upload_file").style.display = "block";
                document.getElementById("drag_upload_msg").style.display = "none";
                // oOutput.innerHTML = "Error " + xhttp.status + " occurred when trying to upload your file.";
            }
        }

        xhttp.send(form_data);
    }
}

