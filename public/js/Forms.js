let redirect = function () {

    if (document.referrer) {

        window.location.href = document.referrer;

    } else {

        window.location.href = "/";

    }

};


function addError(input, error_text) {

    $(input).parent().addClass("form-error");

    $(input).parent().find('.form-error-text').text(error_text);

}


function removeError(input) {


    $(input).parent().removeClass("form-error");

    $(input).parent().find('.form-error-text').empty();

}

function validate_profile_url(url, id) {

    if (url == '') {

        addError(id, "URL adresa musí být vyplněna");

        return false;

    } else if (/[^a-zA-Z0-9-]/.test((url.trim()).toLowerCase())) {

        addError(id, "Url adresa může obsahovat pouze písmena anglické abecedy, čísla a pomlčky");

        return false;

    } else {

        removeError(id);

        return true;

    }
}

function validate_keywords(keywords, id) {

    if (keywords == '') {

        addError(id, "Klíčová slova musí být vyplněny");

        return false;

    } else if (/[^a-za-žA-ZA-Ž1-9, ]/.test((keywords.trim()).toLowerCase())) {

        addError(id, "Text obsahuje nepovolené znaky");

        return false;

    } else {

        removeError(id);

        return true;

    }

}

function validate_upload(text, id) {


    if (text == '') {

        addError(id, "Náhledový obrázek není nahrán");

        return false;

    } else {

        removeError(id);

        return true;

    }

}

function validate_firstname(name, id) {

    if (name == '') {

        addError(id, "Zadejte jméno");

        return false;

    } else if (name.length < 2) {

        addError(id, "Příliš krátké jméno");

    } else if (/[^a-zá-ž]/.test((name.trim()).toLowerCase())) {

        addError(id, "Jméno obsahuje nepovolené znaky");

        return false;

    } else {

        removeError(id);

        return true;

    }

}

function validate_lastname(name, id) {

    if (name == '') {

        addError(id, "Zadejte Příjmení");

        return false;

    } else if (name.length < 2) {

        addError(id, "Příliš krátké Příjmení");

    } else if (/[^a-zá-ž]/.test((name.trim()).toLowerCase())) {

        addError(id, "Příjmení obsahuje nepovolené znaky");

        return false;

    } else {

        removeError(id);

        return true;

    }

}

function validate_mail(email, id) {

    if (email == '') {

        addError(id, "Zadejte e-mail");

        return false;

    } else if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {

        addError(id, "Nesprávný formát e-mailu");

        return false;

    } else {

        removeError(id);

        return true;

    }

}

function validate_password(password, id) {

    if (password == '') {

        addError(id, "Zadejte heslo");

        return false;

    } else {

        removeError(id);

        return true;

    }

}

function password_equals(password, password2, id_password2) {

    if (password2 != '') {

        if (password != password2) {

            addError(id_password2, "Hesla se neshodují");

            return false;

        } else {

            removeError(id_password2);

            return true;

        }

    }

    return false;

}

function validate_password_registration(password, id) {

    if (password == '') {

        addError(id, "Zadejte heslo");

        return false;

    } else if (password.length < 5) {

        addError(id, "Heslo je příliš krátké");

        return false;

    } else {

        removeError(id);

        return true;

    }

}

function validate_password_repeat(password2, password, id) {

    if (password2 == '') {

        addError(id, "Potvrďte heslo");

    } else if (password2 != password) {

        addError(id, "Hesla se neshodují");

        return false;

    } else {

        removeError(id);

        return true;

    }


}

function validate_textarea(text, id) {

    if (text == '') {

        addError(id, "Pole musí být vyplněno");

        return false;

    } else {

        removeError(id);

        return true;

    }

}

function validate_contenteditable(text, id) {

    if (text == '' || text=="<p><br></p>") {
        $(id).addClass("form-error");
        $(id).parent().find('.form-error-text').text("Pole musí být vyplněno");
        return false;

    } else {

        $(id).removeClass("form-error");
        $(id).parent().find('.form-error-text').empty();

        return true;

    }

}

function validate_date(day, month, year, label) {

    let today = new Date();

    let form_date = Date.parse(month + "/" + day + "/" + year);

    let timeDiff = Math.floor((today - form_date) / (1000 * 3600 * 24));

    if (timeDiff <= 0) {


        addError(label, "Nesprávné datum");

        return false;

    } else {

        removeError(label);

        return true;

    }

}

function validate_radios(value, id) {

    if (value == undefined) {

        addError(id, "Musíte vybrat jednu z možností");

        return false;

    } else {

        removeError(id);

        return true;

    }

}

$('#email').on("blur", function () {
    validate_mail($(this).val(), "#email");
});

$('#name').on("blur", function () {
    validate_firstname($(this).val(), "#name");
});

$('#surname').on("blur", function () {
    validate_lastname($(this).val(), "#surname");
});

$('#password').on("blur", function () {
    validate_password($(this).val(), "#password");
});

$('#old-password').on("blur", function () {
    validate_password($(this).val(), "#old-password");
});

$('#password-new').on("blur", function () {

    validate_password_registration($(this).val(), "#password-new");

    password_equals($(this).val(), $('#password2').val(), '#password2');

});


$('#password2').on("blur", function () {

    validate_password_repeat($(this).val(), $('#password-new').val(), "#password2");

});

$('#birthday-day, #birthday-month, #birthday-year').on("change", function () {

    validate_date($("#birthday-day").val(), $("#birthday-month").val(), $("#birthday-year").val(), '#birth-date');

});

$('#profile_url').on("blur", function () {
    validate_profile_url($(this).val(), "#profile_url")
});

let login = function (form_data) {

    $.ajax({

        type: 'POST',

        url: 'login',

        data: form_data,

        beforeSend: function () {

            $(".login-button").attr("disabled", "disabled");

        },

        success: function (data) {

            data = JSON.parse(data);

            if (!data.success) {

                if (data.errors.login) {

                    addError('#password', data.errors.login);

                }

            } else {

                redirect();

            }

        },

        complete: function () {

            $(".login-button").removeAttr("disabled");

        }

    });

};

let register = function (form_data) {

    $.ajax({

        type: 'POST',

        url: 'register',

        data: form_data,

        beforeSend: function () {

            $(".register-button").attr("disabled", "disabled");

        },

        success: function (data) {

            data = JSON.parse(data);

            if (!data.success) {


                if (data.errors.mail) {

                    addError('#email', data.errors.mail);

                } else {

                    removeError('#email');

                }

            } else {

                redirect();

            }

        },

        complete: function () {

            $(".register-button").removeAttr("disabled");


        }

    });

};


let addComment = function (form_data) {

    $.ajax({

        type: 'POST',

        url: 'add_comment',

        data: form_data,

        beforeSend: function () {

            $(".add-comment-button").attr("disabled", "disabled");

        },

        success: function (data) {

            $(data).hide().prependTo('.all-comments').show('fast');

            $('#new-comment-text').html('');

            comments.offset++;

        },

        complete: function () {

            $(".add-comment-button").removeAttr("disabled");

        }

    });

};


$('.login-form').on("submit", function (e) {

    e.preventDefault();

    $('.form-error-text').empty();

    $('.form-error').removeClass('form-error');

    let form_data = {

        email: $('#email').val(),

        password: $('#password').val()

    };

    let valid_email = validate_mail(form_data.email, "#email");

    let valid_password = validate_password(form_data.password, "#password");

    if (valid_email && valid_password) {

        login(form_data);

    }

});

$('.register-form').on("submit", function (e) {

    e.preventDefault();

    $('.form-error-text').empty();

    $('.form-error').removeClass('form-error');

    let form_data = {

        name: $('#name').val().trim(),

        surname: $('#surname').val().trim(),

        email: $('#email').val(),

        password: $('#password-new').val(),

        password2: $('#password2').val(),

        birth_day: $('#birthday-day').val(),

        birth_month: $('#birthday-month').val(),

        birth_year: $('#birthday-year').val(),

        gender: $("input[name='gender']:checked").val()

    };

    let valid_name = validate_firstname(form_data.name, "#name");

    let valid_lastname = validate_lastname(form_data.surname, "#surname");

    let valid_email = validate_mail(form_data.email, "#email");

    let valid_password = validate_password_registration(form_data.password, "#password-new");

    let valid_password2 = validate_password_repeat(form_data.password2, form_data.password, "#password2");

    let valid_date = validate_date(form_data.birth_day, form_data.birth_month, form_data.birth_year, "#birth-date");

    let valid_gender = validate_radios(form_data.gender, ".radio-option");

    if (valid_email && valid_password && valid_password2 && valid_name && valid_lastname && valid_date && valid_gender) {

        register(form_data);

    }

});

$('.comment-form').on("submit", function (e) {

    e.preventDefault();

    $('.form-error-text').empty();

    $('.form-error').removeClass('form-error');

    let form_data = {

        text: $('#new-comment-text').html(),

        //data pro výběr komentáře z databáze

    };
    let valid_text = validate_contenteditable(form_data.text, $(this).find("#new-comment-text"));
    if (valid_text) {

        addComment(form_data);

    }

});

let reply_to;

function placeCaretAtEnd(el) {

    el.focus();

    if (typeof window.getSelection != "undefined"

        && typeof document.createRange != "undefined") {

        var range = document.createRange();

        range.selectNodeContents(el);

        range.collapse(false);

        var sel = window.getSelection();

        sel.removeAllRanges();

        sel.addRange(range);

    } else if (typeof document.body.createTextRange != "undefined") {

        var textRange = document.body.createTextRange();

        textRange.moveToElementText(el);

        textRange.collapse(false);

        textRange.select();

    }

}

$(document).on("click", ".reply-button", function () {

    reply_to = $(this).closest(".comment-content").parent().attr("id");


});

$(document).on("click", ".parent-reply", function () {

    $form = $(this).closest(".comment").find(".reply-input").find("#new-reply-text")

    $form.html("");

    $form.focus();


});

$(document).on("click", ".reply-to-reply", function () {

    $reply = $(this).closest(".comment").find(".reply-input").find("#new-reply-text");

    $reply.html($(this).attr("data-comment_link"));

    placeCaretAtEnd($reply.get(0));


});

$(document).on("submit", ".reply-form", function (e) {

    if (reply_to == undefined) {

        reply_to = 0;

    }

    e.preventDefault();

    $('.form-error-text').empty();

    $('.form-error').removeClass('form-error');

    let form_data = {

        text: $($(this).find("#new-reply-text")).html(),

        id: $(this).attr("reply-form_id"),

        reply_to: reply_to

        //data pro výběr komentáře z databáze

    };


    $that = $(this);


    let valid_text = validate_contenteditable(form_data.text, $(this).find("#new-reply-text"));
    if (valid_text) {

        $.ajax({

            type: 'POST',

            url: 'add_reply',

            data: form_data,

            beforeSend: function () {

                $that.find(".add-comment-button").attr("disabled", "disabled");

            },

            success: function (data) {

                $replies = $that.closest(".comment-replies").find(".rendered-replies");

                $(data).hide().appendTo($replies).show('fast');

                $that.find("textarea").val('');

                $that.closest(".reply-input").css("display", "none");

            },

            complete: function () {

                $that.find(".add-comment-button").removeAttr("disabled");

            }

        });

    }

})


$('.edit-form').on("submit", function (e) {

    $('.form-error-text').empty();

    $('.form-error').removeClass('form-error');

    let form_data = {

        name: $('#name').val().trim(),

        surname: $('#surname').val().trim(),

        email: $('#email').val().trim(),

        url: $('#profile_url').val().trim(),

        birth_day: $('#birthday-day').val(),

        birth_month: $('#birthday-month').val(),

        birth_year: $('#birthday-year').val(),

        gender: $("input[name='gender']:checked").val()

    };

    let valid_name = validate_firstname(form_data.name, "#name");

    let valid_lastname = validate_lastname(form_data.surname, "#surname");

    let valid_email = validate_mail(form_data.email, "#email");

    let valid_date = validate_date(form_data.birth_day, form_data.birth_month, form_data.birth_year, "#birth-date");

    let valid_gender = validate_radios(form_data.gender, ".radio-option");

    let valid_url = validate_profile_url(form_data.url, "#profile_url");

    if ((valid_email && valid_name && valid_lastname && valid_date && valid_gender && valid_url) != true) {

        e.preventDefault();

    }

});

$('#password-form').on("submit", function (e) {

    $('.form-error-text').empty();

    $('.form-error').removeClass('form-error');

    form_data = {

        password_old: $("#old-password").val(),

        password_new: $("#old-password").val(),

        password_new_repeat: $("#old-password").val()

    };

    let valid_old_password = validate_password(form_data.password_old, "#old-password");

    let valid_password_new = validate_password_registration(form_data.password_new, "#password-new");

    let valid_password_repeat = password_equals(form_data.password_new, form_data.password_new_repeat, '#password2');

    if ((valid_old_password && valid_password_new && valid_password_repeat) != true) {

        e.preventDefault();

    }


});


$('.new-article').on("submit", function (e) {


    $('.form-error-text').empty();

    $('.form-error').removeClass('form-error');
    document.getElementById("content").value = document.getElementById("content-editor").innerHTML;
    let form_data = {

        title: $('#title').val().trim(),

        url: $('#url').val().trim(),

        keywords: $('#keywords').val(),

        upload_text: $('.upload-text').text(),

        preview: $('#description').val(),

        content: $('#content').val(),

    };

    let valid_title = validate_textarea(form_data.title, "#title");

    let valid_url = validate_profile_url(form_data.url, "#url");

    let valid_keywords = validate_keywords(form_data.keywords, "#keywords");

    let valid_preview_text = validate_textarea(form_data.preview, "#description");

    let valid_content = validate_contenteditable(form_data.content, ".editor");
    let valid_upload = validate_upload(form_data.upload_text, "#preview-image");

    if ((valid_title && valid_url && valid_keywords && valid_preview_text && valid_content && valid_upload) != true) {

        e.preventDefault();

    }

});

function readURL(input) {


    if (input.files && input.files[0]) {

        let file = input.files[0];


        let fileType = file["type"];

        let ValidImageTypes = ["image/gif", "image/jpeg", "image/png"];

        if ($.inArray(fileType, ValidImageTypes) < 0) {

            alert("Vybraný soubor nemá podporovaný formát (gif, jpg, png)");

        } else {

            let reader = new FileReader();


            reader.onload = function (e) {

                $('#profile-picture-img').attr('src', e.target.result);

            };


            reader.readAsDataURL(input.files[0]);

        }


    }

}


$("#profile-picture").on("change", function () {

    readURL(this);

});

$('[contenteditable]').on('paste', function (e) {
    e.preventDefault();
    var text = (e.originalEvent || e).clipboardData.getData('text/plain');
    document.execCommand('insertText', false, text);
});
let btn = document.querySelector(".sai");
let getText = document.querySelector(".getText");
let content = document.querySelector(".getcontent");
let editorContent = document.querySelector(".editor");


function copy() {
    document.execCommand("copy", false, "");
}
function execute(selector, command)
{
    $(selector).on("click",function()
    {
        document.execCommand(command, false, '');
        editorContent.focus();
    })
}
execute(".italic","italic");
execute(".bold","bold");
execute(".undo","undo");
execute(".redo","redo");
execute(".unordered_list","insertUnorderedList");
execute(".remove_format","removeFormat");
$(".remove_format").on("click",function()
{
    document.execCommand("removeFormat", false, '');
    document.execCommand("formatBlock", false, 'p');
    editorContent.focus();
})


function format_block(selector, tag)
{
    $(selector).on("click",function() {
        document.execCommand('formatBlock', false, tag);
        editorContent.focus();
    })
}
format_block(".heading1","h1");
format_block(".heading2","h2");
format_block(".heading3","h3");
format_block(".heading4","h4");
format_block(".heading5","h5");
format_block(".heading6","h6");


$(".link").on("click", function () {
    let url = prompt("Vložte adresu URL včetně http/https");
    document.execCommand("createLink", false, url);
    editorContent.focus();
});
$(".color").on("click", function () {
    let color = prompt("Vložte kód barvy, např.:#f1f233");
    document.execCommand("foreColor", true, color);
});
document.execCommand("defaultParagraphSeparator", true, "p");


















