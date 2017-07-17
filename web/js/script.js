$(document).ready(function () {
    $('.slider').slider({full_width: true});
});
$(document).ready(function () {

    $(".product-small").hide();
    $(".product-medium").hide();
    $(".product-large").hide();
    $(".product-premium").hide();


    $(".show-small").click(function () {
        $(".product-medium").hide("fast");
        $(".product-large").hide("fast");
        $(".product-small").show("fast");
    });
    $(".show-medium").click(function () {
        $(".product-small").hide("fast");
        $(".product-large").hide("fast");
        $(".product-medium").show("fast");
    });
    $(".show-large").click(function () {
        $(".product-medium").hide("fast");
        $(".product-small").hide("fast");
        $(".product-large").show("fast");
    });

    $(".show-premium").click(function () {
        $(".product-premium").show("fast");
    });
    $(".img").click(function () {
        $(".product-medium").hide("fast");
        $(".product-small").hide("fast");
        $(".product-large").hide("fast");
        $(".product-premium").hide("fast");
    });

});
$(".button-collapse").sideNav();
$(document).ready(function () {
    $('select').material_select();
});
$('#sendResumeButton').on('click', function (e) {
    e.preventDefault();
    $('.progress').removeClass('hiddendiv');
    var resume = $('#sendResumeFile').val();
    var formData = new FormData();
    formData.append('resume', $('input[type=file]')[0].files[0]);
    $.ajax({
        url: '/ajax/resume/send',
        type: 'POST',
        dataType: 'json',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            $('.ajaxStatus').html('<div class="center"><p>Votre CV a été envoyé avec succès ! <br /> Votre insription est maintenant terminée. Vous pouvez postuler à nos offres.</p></div>');
            $('#done-cv').attr("href", '/job');
        },
        error: function () {
            $('.ajaxStatus').html('<div class="center"><p>Une erreur s\'est produite. Veuillez réessayer.</p></div>');
        }
    });
});
$('#parseResumeButton').on('click', function (e) {
    e.preventDefault();
    var resume = $('#parseResumeFile').val();
    $('.progress').removeClass('hiddendiv');
    var formData = new FormData();
    formData.append('resume', $('input[type=file]')[0].files[0]);
    $.ajax({
        url: '/ajax/resume/parse',
        type: 'POST',
        dataType: 'json',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            var resume = JSON.parse(response.data);
            $('#fos_user_registration_form_firstname').val(resume.first_name);
            $('#fos_user_registration_form_lastname').val(resume.last_name);
            $('#fos_user_registration_form_email').val(resume.emails.primary);
            $('#fos_user_registration_form_title').val(resume.title);
            $('#fos_user_registration_form_experience').val(resume.experience);
            $('#fos_user_registration_form_salary').val(resume.salary);
            $('#fos_user_registration_form_salary').val(resume.current_pay);
            $('#fos_user_registration_form_wantedSalary').val(resume.desired_pay);
            $('#fos_user_registration_form_phone').val(resume.phone);
            $('.ajaxStatus').html('<div class="center"><p>Votre CV a été envoyé avec succès !</p></div>');
        },
        error: function () {
            $('.ajaxStatus').html('<div class="center"><p>Une erreur s\'est produite. Veuillez réessayer.</p></div>');
        }
    });
});
$(document).ready(function () {
    // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
});
$('#app_bundle_profile_type_submit').on('click', function (e) {
    $('#mobility_error').html('Ce champ doit être rempli<br />');
});