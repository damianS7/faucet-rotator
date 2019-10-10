$(document).ready(function() {
    var table = $('#faucet-reports').DataTable( {
        "bJQueryUI": true,
        "iDisplayLength": 10
    } );

    $('#faucet-reports tbody').on( 'click', 'tr', function () {        
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        
    } );
} );

function showMessage(err) {
    $('.error').hide();
    $('.error').html('');
    $('.error').html(err);
    $('.error').fadeIn();
}

function checkFaucet() {
    var url = $("#faucet_url").val();
    
    if(url == "") {
        alertify.alert("Url field cannot be empty.");
        return;
    }

    $("#frame").attr('src', url);
    $("#frame").fadeIn();
}

function checkFields() {
    var name = $("#faucet_name").val();
    var url = $("#faucet_url").val();
    var min = $("#min_reward").val();
    var max = $("#max_reward").val();
    var time = $("#time").val();

    if(name == "" || name == null || url == "" || url == null || min == "" || min == null || max == "" || max == null || time == "" || time == null) {
        return false;
    }
    return true;
}

function addFaucet() {
    var name = $("#faucet_name").val();
    var url = $("#faucet_url").val();
    var min = $("#min_reward").val();
    var max = $("#max_reward").val();
    var time = $("#time").val();

    if(!checkFields()) {
        showMessage("You must fill all fields.");
        return;
    }
    
    $.ajax({ url: 'admin-functions.php',
        data: {action: 'add_faucet', name: name, url: url, min:min, max: max, time: time},
        type: 'post',

        success: function(r) {
            if(r == "") {
                $('.error').html('Faucet ' + name + ' added.');
                $("#faucet_name").val('');
                $("#faucet_url").val('');
                $("#min_reward").val('');
                $("#max_reward").val('');
                $("#time").val('');
                return; 
            }
            showMessage(r);
        }
    }); 

}

function updateFaucet() {
    var name = $("#faucet_name").val();
    var url = $("#faucet_url").val();
    var min = $("#min_reward").val();
    var max = $("#max_reward").val();
    var time = $("#time").val();
    var id = $("#id_faucet").val();

    if(!checkFields()) {
        showMessage("You must find a faucet before update.");
        return;
    }
    
    $.ajax({ url: 'admin-functions.php',
        data: {action: 'update_faucet', name: name, url: url, min:min, max: max, time: time, id: id},
        type: 'post',

        success: function(r) {
            if(r == "") {
                $('.error').html('Faucet ' + name + ' updated.');
                $("#faucet_name").val('');
                $("#faucet_url").val('');
                $("#min_reward").val('');
                $("#max_reward").val('');
                $("#time").val('');
                $("#id_faucet").val('');
                return; 
            }
            showMessage(r);
        }
    }); 
}

function showReports() {
    hideWindows();
    $(".reports").fadeIn();
}

function showFaucetManager() {
    hideWindows();
    $(".add").fadeIn();
}

function showAdsConfig() {
    hideWindows();
    $(".config").fadeIn();
}

function hideWindows() {
    $(".add").hide();
    $(".reports").hide();
    $(".config").hide();
    $("#frame").hide();
}

function findFaucet() {
    var u = $("#faucet_url").val();

    if(u == "") {
        $("#faucet_url").focus();
        showMessage("You must fill Faucet URL field. Example: If you want to find http://faucet.com?r=1111111111 you will enter faucet.com");
        return;
    }
    

    $.ajax({ url: 'admin-functions.php',
        data: {action: 'get_faucet', url: u},
        type: 'post',

        success: function(json) {
            json = jQuery.parseJSON(json);

            if(json == "") {
                showMessage("No faucet found.");
            } else {
                $("#id_faucet").val(json['id']);
                $("#faucet_name").val(json['faucet']);
                $("#faucet_url").val(json['url']);
                $("#min_reward").val(json['min_reward']);
                $("#max_reward").val(json['max_reward']);
                $("#time").val(json['time']);   
                showMessage('Faucet: ' + json['faucet'] +' founded');
                find = true;
            }
        }});
}


function deleteFaucet() {
    var i = $("#id_faucet").val();
    var p = $("#pass").val();

    if(i == "") {
        showMessage("You must find a faucet first.");
        return;
    }

    $.ajax({ url: 'admin-functions.php',
        data: {action: 'delete_faucet', id_faucet: i},
        type: 'post',

        success: function(json) {
            if(json == 1) {
                showMessage("Faucet deleted.");
                $("#id_faucet").val('');
                $("#faucet_name").val('');
                $("#faucet_url").val('');
                $("#min_reward").val('');
                $("#max_reward").val('');
                $("#time").val('');
            } else {
                showMessage(json);
            }
            find = false;
        }});
}

function getReport(id) {
    $.ajax({ url: 'admin-functions.php',
        data: {action: 'get_report', id_report: id},
        type: 'post',

        success: function(json) {
            json = jQuery.parseJSON(json);
            $("#report_id").val(json['id_report']);
            $("#report_title").val(json['title']);
            $("#report_message").val(json['message']);
        }});
}

function deleteReport() {
    var table = $('#faucet-reports').DataTable();
    table.row('.selected').remove().draw( false );      
    var id = $("#report_id").val();

    $.ajax({ url: 'admin-functions.php',
        data: {action: 'delete_report', report_id: id},
        type: 'post',

        success: function(json) {
            if(json == "") {
                $("#report_id").val('');
                $("#report_title").val('');
                $("#report_message").val('');
            }
        }});
}

function save() {
    var al = escape($("#ads-left").val());
    var at = escape($("#ads-top").val());
    var css = escape($("#custom_css").val());

    $.ajax({ url: 'admin-functions.php',
        data: {action: 'save', ads_left: al, ads_top: at, css: css},
        type: 'post',

        success: function(json) {
            alertify.alert(json);
        }
    });
}

function changePassword() {
    var ap = $("#actual_passw").val();
    var np = $("#new_passw").val();
    var np2 = $("#new_passw2").val();
    
    if(np != np2) {
        alertify.alert("New password doesn't match.");
        return;
    }

    $.ajax({ url: 'admin-functions.php',
        data: {action: 'change_password', actual_passw: ap, new_passw: np},
        type: 'post',

        success: function(json) {
            alertify.alert(json);
        }
    });

}