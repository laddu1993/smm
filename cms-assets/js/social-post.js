$(function() {
    $('#daterange').daterangepicker({
            minDate: new Date(),
            timePicker: true,
            timePickerIncrement: 30,
            singleDatePicker: true,
            minYear: 2018,
            maxYear: parseInt(moment().format('M/DD hh:mm A'), 1)
        },
        function(start) {
            var dates = moment(start);
            var dd_date = formatDate(dates);
            $("#calender-date").text(dd_date);
            $('#schedule_date').val(dates);
            $("#removeschuleding").css("display", "block");

        });
});
$("#removeschuleding").click(function() {
    $("#calender-date").empty();
    $('#schedule_date').removeAttr('value');
    $("#removeschuleding").css("display", "none");
})

// file upload js
function getFile() {
    document.getElementById("upfile").click();
}

function formatDate(date) {
    var d = new Date(date),
    month = '' + (d.getMonth() + 1),
    day = '' + d.getDate(),
    year = d.getFullYear();

    var res = d.toString().split(" ");
    var time = res[4];
    var time_hms = time.toString().split(":");

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    hr = (time_hms[0] + d.getHours()).slice(-2);
    min = (time_hms[1] + d.getMinutes()).slice(-2);
    sec = (time_hms[2] + d.getSeconds()).slice(-2);

    var today_date = [year, month, day].join('-');
    var today_time = [hr, min, sec].join(':');
    //console.log(today_time);
    return [today_date, today_time].join(' ');
}

// twitter validation
$(document).ready(function() {
    var text_max = 140;
    var social_text_length;
    var twitter_text_length;

    $('#field1').keyup(function() {
        social_text_length = $('#field1').val().length;
        $('#textarea_feedback').html((text_max - $(this).val().length) + " characters remaining If you want to post on twitter");
        if (social_text_length >= text_max) {
            $('#textarea_feedback').html('Post limit exceeded so this content will not able to post on Twitter!');
            $('.chechbox-twitter').css('display', 'block');
        } else {
            // $('#textarea_feedback').html(text_length + ' characters remaining');
            $('.chechbox-twitter').css('display', 'none');
            $('#txt').css('display', 'none');
            $('#txt').val("");
            text_length = 0;
            $('#textarea_feedback2').hide();
            $('#textarea_feedback2').html("Characters left: " + (text_max));
            $('#twitter').prop('checked', false);
            $('#twitter').attr('checked', false);
        }
    }); 

    $('#txt').keyup(function(e) {
        twitter_text_length = $('#txt').val().length;
        $("#textarea_feedback2").html();
        $('#textarea_feedback2').html(twitter_text_length);
        if (twitter_text_length >= text_max) {
            $('#textarea_feedback2').html("Characters left: " + (text_max - $(this).val().length));
        } else {
            $('#textarea_feedback2').html("Characters left: " + (text_max - $(this).val().length));


        }
    });
});

$(document).ready(function() {
    $('#twitter').on('click', function() {
        if (this.checked) {
            $('#txt').show();
            $('#textarea_feedback2').show();
        } else {
            $('#txt').hide();
            $('#textarea_feedback2').hide();
        }
    });
});

// file size validation
var imgpath;
$("#upfile").change(function () {
    var fileSize = this.files[0];
    var sizeInMb = fileSize.size/1024;
    var sizeLimit= 1024;
    var imgname = $("#upfile").val().substring($("#upfile").val().lastIndexOf('\\') + 1);
    var imgextn = imgname.substring(imgname.lastIndexOf('.') + 1);

    if ((sizeInMb < sizeLimit) && (imgextn == "jpg" || imgextn == "png" || imgextn == "jpeg")) {
        $("#remove_image label").html(imgname);
        $("#image_cancel").css("display","block");
        $("#image_cancel").css("position","absolute");
        $("#image_cancel").css("bottom","125px");
        $("#image_cancel").css("right","36px");
        readURL(this);
        $("#uploading_size_limit").css("display","none");
        }
    else {
        $("#remove_image label").html("select image");
         $("#image_cancel").css("display","none");
        $("#uploading_size_limit").css("display","block");
        imgpath = null;
    }
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            imgpath = e.currentTarget.result;
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function myFunction() {
    var social_post_length = jQuery.trim($("#field1").val()).length;
    var twitter_post_length = jQuery.trim($("#txt").val()).length;
    var social_text = $('#field1').val();
    if (social_post_length > 0 || imgpath != null) {
        $('.suggestion_panel').css('display', 'block');
        $('.social_post_preview_panel').css('display', 'block');
    } else if (twitter_post_length > 0) {
        $('.social_post_preview_panel').css('display', 'block');
        $('.suggestion_panel').css('display', 'none');
    } else {
        $('.suggestion_panel').css('display', 'none');
        $('.social_post_preview_panel').css('display', 'none');
    }

    if (social_post_length > 0) {
        document.getElementById("field2").innerHTML = document.getElementById("field1").value;
        $('.social_post').css('display', 'block');
        $('.sentiment_analysis').css('display', 'block');
    } else {
        document.getElementById("field2").innerHTML = "";
        $('.social_post').css('display', 'none');
        $('.sentiment_analysis').css('display', 'none');
    }

    if ((twitter_post_length > 0) && ($('#twitter').is(':checked')) == true) {
        document.getElementById("text1").innerHTML = document.getElementById("txt").value;
        $('.twitter_post').css('display', 'block');
    } else {
        document.getElementById("text1").innerHTML = "";
        $('.twitter_post').css('display', 'none');
    }

    if (imgpath != null) {
        $("#image-tag").html("<img src=" + imgpath + "  alt='your image' accept='image/*' />");
    } else {
        $("#image-tag").empty();
    }

    if (social_post_length != null) {
        $.ajax({
            type: "POST",
            url: "http://social.altmarkit.com/SocialPost/sentiment",
            async : true,
            dataType: 'json',
            cache: 'false',
            data:{'social_text':social_text,'reqtype':'get_analysis'},
            success : function(data){
                var new_data = JSON.stringify(data);
                //console.log(data);
                $('#polarity').text(data.sentiment.polarity);
                $('#subjectivity').text(data.sentiment.subjectivity);
                $('#polarity_confidence').text(data.sentiment.polarity_confidence);
                $('#subjectivity_confidence').text(data.sentiment.subjectivity_confidence);
                var hashtags = data.entities.entities.keyword;
                var arrayLength = hashtags.length;
                var rowTemplate = '';
                for (var i = 0; i < arrayLength; i++) {
                    rowTemplate += '<tr><td>';
                    rowTemplate += hashtags[i];
                    rowTemplate += '</td></tr>';
                }
                $('#hashtag_suggestions').html(rowTemplate);
            }
        });
    }
}

// success popup functionality
$("#successfully_save").click(function() {
    $(".social_post_preview_panel").css("display", "none");
    $(".suggestion_panel").css("display", "none");
    $('#field1').val('');
    $("#textarea_feedback").css("display", "none");
    $(".chechbox-twitter").css("display", "none");
    $("#txt").css("display", "none");
    $("#txt").val('');
    $("#textarea_feedback2").css("display", "none");
    $("#remove_image label").html("select image");
    $("#remove_image")
    $("#exampleModalCenter .close").click(); //to hide the modal//
});

$(window).load(function() {
    $(".trigger").click(function() {
        $('.hover_bkgr_fricc').show();
    });


    $('.popupCloseButton').click(function() {
        $('.hover_bkgr_fricc').hide();
    });
});


$(document).ready(function() {
    $('#example').DataTable();
});


jQuery(function() {
    var checks = $('#Twitter, #Facebook, #Facebook_group, #LinkedIn ,#LinkedIn_company');
    checks.click(function() {
        if (checks.filter(':checked').length >= 1) {
            $('.p_fb').show();
        } else {
            $('.p_fb').hide();
        }
    }).triggerHandler('click')
})

$("#image_cancel").click(function() {
    $("#remove_image label").val("");
});