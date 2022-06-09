function CheckArrayOrObjectBindData(payload_data)
{
    var data = null;

    if (payload_data != null)
    {
        if (payload_data instanceof Array)
        {
            if (payload_data.length == 0)
            {
                return "";
            }

            data = payload_data[0];
        } else {
            data = payload_data;
        }
    } else {
        return "";
    }

    return data;
}

function hide_result(id_bind)
{
    var label_msg = document.getElementById(id_bind);
    if (label_msg == null)
    {
        return;
    }
    label_msg.style.display = "none";
    label_msg.text = "";
}

function ClearValidateForm(id_form)
{
    var clear_form = document.getElementById(id_form);
    if (clear_form != null && clear_form != undefined) {
        clear_form.classList.remove("was-validated");
    }
}

function BindTextValue(id, data, key = null)
{
    if (key)
    {
        if (data.hasOwnProperty(key))
        {
            if (document.getElementById(id))
            {
                document.getElementById(id).value = data[key];
            }
        }
    }
    else
    {
        if (document.getElementById(id))
        {
            document.getElementById(id).value = data;
        }
    }
}

function BindInnerTextValue(id, data, key = null)
{
    if (key)
    {
        if (data.hasOwnProperty(key))
        {
            if (document.getElementById(id))
            {
                document.getElementById(id).innerHTML = data[key];
            }
        }
    }
    else
    {
        if (document.getElementById(id))
        {
            document.getElementById(id).innerHTML = data;
        }
    }
}

function GenerateAlertModal()
{
    if (document.getElementById("his_modal_alert") != null)
    {
        return document.getElementById("his_modal_alert");
    }

    let alrt_container = document.createElement("div");
    alrt_container.setAttribute("class", "modal fade");
    alrt_container.setAttribute("role", "dialog");
    alrt_container.setAttribute("data-backdrop", "static");
    alrt_container.setAttribute("data-keyboard", "false");
    alrt_container.id = "his_modal_alert";

    let alrt_container_sub = document.createElement("div");
    alrt_container_sub.setAttribute("class", "modal-dialog");

    let alrt_container_content = document.createElement("div");
    alrt_container_content.setAttribute("class", "modal-content");

    let alrt_title_container = document.createElement("div");
    alrt_title_container.setAttribute("class", "modal-header");

    let alrt_title = document.createElement("div");
    alrt_title.setAttribute("class", "modal-title");
    alrt_title.id = "his_modal_alert_title";

    let close_btn = document.createElement("button");
    close_btn.setAttribute("type", "button");
    close_btn.setAttribute("class", "btn-close");
    close_btn.setAttribute("data-bs-dismiss", "modal");
    close_btn.setAttribute("aria-label", "Close");

    alrt_title_container.append(alrt_title);
    alrt_title_container.append(close_btn);

    let alert_content = document.createElement("div");
    alert_content.setAttribute("class", "modal-body text-center");

    let alert_content_text = document.createElement("div");
    alert_content_text.id = "his_modal_alert_text";

    alert_content.append(alert_content_text);

    alrt_container_content.append(alrt_title_container);
    alrt_container_content.append(alert_content);

    alrt_container_sub.append(alrt_container_content);

    alrt_container.append(alrt_container_sub);

    return alrt_container;
}

function GenerateConfirmModal(extra_id, yes_call_back = null, no_call_back = null)
{
    let alrt_container = document.createElement("div");
    alrt_container.setAttribute("class", "modal fade");
    alrt_container.setAttribute("role", "dialog");
    alrt_container.setAttribute("data-backdrop", "static");
    alrt_container.setAttribute("data-keyboard", "false");
    alrt_container.id = "his_modal_confirm_" + extra_id;

    let alrt_container_sub = document.createElement("div");
    alrt_container_sub.setAttribute("class", "modal-dialog");

    let alrt_container_content = document.createElement("div");
    alrt_container_content.setAttribute("class", "modal-content");

    // titile
    let alrt_title_container = document.createElement("div");
    alrt_title_container.setAttribute("class", "modal-header");

    let alrt_title = document.createElement("div");
    alrt_title.setAttribute("class", "modal-title");
    alrt_title.id = "his_modal_confirm_title_" + extra_id;

    let close_btn = document.createElement("button");
    close_btn.setAttribute("type", "button");
    close_btn.setAttribute("class", "btn-close");
    close_btn.setAttribute("data-bs-dismiss", "modal");
    close_btn.setAttribute("aria-label", "Close");

    alrt_title_container.append(alrt_title);
    alrt_title_container.append(close_btn);

    // content
    let alert_content = document.createElement("div");
    alert_content.setAttribute("class", "modal-body text-center");

    let alert_content_text = document.createElement("div");
    alert_content_text.id = "his_modal_confirm_text_" + extra_id;

    alert_content.append(alert_content_text);


    // footer
    let alrt_footer_container = document.createElement("div");
    alrt_footer_container.setAttribute("class", "modal-footer");

    let yes_btn = document.createElement("button");
    yes_btn.setAttribute("type", "button");
    yes_btn.setAttribute("class", "btn btn-update");
    yes_btn.id = "his_modal_confirm_btn_yes_" + extra_id;
    yes_btn.innerText = "Đồng ý";
    yes_btn.onclick = function() {
        if (yes_call_back)
        {
            yes_call_back(this);
        }
    };

    let no_btn = document.createElement("button");
    no_btn.setAttribute("type", "button");
    no_btn.setAttribute("class", "btn");
    no_btn.id = "his_modal_confirm_btn_no_" + extra_id;
    no_btn.innerText = "Không";
    no_btn.onclick = function() {
        if (no_call_back)
        {
            no_call_back(this);
        }
    };

    alrt_footer_container.append(no_btn);
    alrt_footer_container.append(yes_btn);

    alrt_container_content.append(alrt_title_container);
    alrt_container_content.append(alert_content);
    alrt_container_content.append(alrt_footer_container);

    alrt_container_sub.append(alrt_container_content);
    alrt_container.append(alrt_container_sub);

    return alrt_container;
}

/**
 * Register the click handler for the YES button
 * @extra_id the id of the modal
 * @handler handler registered
 */
function HisRegistHandlerConfirmYes(extra_id, handler)
{
    RegisterClickHandler(document.getElementById("his_modal_confirm_btn_yes_" + extra_id), handler);
}

/**
 * Register the click handler for the NO button
 * @extra_id the id of the modal
 * @handler handler registered
 */
function HisRegistHandlerConfirmNo(extra_id, handler)
{
    RegisterClickHandler(document.getElementById("his_modal_confirm_btn_no_" + extra_id), handler);
}

/**
 * Show the modal have extra_id
 * @extra_id the id of the modal
 * @title the title of the modal
 * @msg the message that we need to show
 */
function HisShowConfirm(extra_id, title, msg)
{
    document.getElementById("his_modal_confirm_title_" + extra_id).innerHTML = title;
    show_result("his_modal_confirm_text_" + extra_id, msg, "col-12 h-100 alert alert-danger text-center");
    document.getElementById("his_modal_confirm_btn_yes_" + extra_id).style.display = "";
    document.getElementById("his_modal_confirm_btn_no_" + extra_id).style.display = "";
    $("#his_modal_confirm_" + extra_id).modal('show');
    // (new bootstrap.Modal(document.getElementById("his_modal_confirm_" + extra_id ), {})).show();
    // $("#his_modal_confirm_" + extra_id).modal('show');
}

/**
 * Show the modal have extra_id with the warning layout
 * @extra_id the id of the modal
 * @title the title of the modal
 * @msg the message that we need to show
 */
function HisShowConfirmWarning(extra_id, title, msg)
{
    document.getElementById("his_modal_confirm_title_" + extra_id).innerHTML = title;
    show_result("his_modal_confirm_text_" + extra_id, msg, "col-12 h-100 alert alert-warning text-center");
    $("#his_modal_confirm_" + extra_id).modal('show');
    // (new bootstrap.Modal(document.getElementById("his_modal_confirm_" + extra_id), {})).show();
    // $("#his_modal_confirm_" + extra_id).modal('show');
}

/**
 * Show the modal have extra_id
 * @extra_id the id of the modal
 * @title the title of the modal
 * @msg the message that we need to show
 */
function HisShowConfirmSucessResult(extra_id, msg)
{
    show_result("his_modal_confirm_text_" + extra_id, msg, "col-12 h-100 alert alert-success text-center");
    // (new bootstrap.Modal(document.getElementById("his_modal_confirm_" + extra_id), {})).show();
    document.getElementById("his_modal_confirm_btn_yes_" + extra_id).style.display = "none";
    document.getElementById("his_modal_confirm_btn_no_" + extra_id).style.display = "none";
    // if (!$('#his_modal_confirm_' + extra_id).hasClass('show'))
    // {
    //     $("#his_modal_confirm_" + extra_id).modal('show');
    // }
}

/**
 * Show the modal have extra_id
 * @extra_id the id of the modal
 * @title the title of the modal
 * @msg the message that we need to show
 */
function HisShowConfirmErrorResult(extra_id, msg)
{
    show_result("his_modal_confirm_text_" + extra_id, msg, "col-12 h-100 alert alert-danger text-center");
    // (new bootstrap.Modal(document.getElementById("his_modal_confirm_" + extra_id), {})).show();
    document.getElementById("his_modal_confirm_btn_yes_" + extra_id).style.display = "none";
    document.getElementById("his_modal_confirm_btn_no_" + extra_id).style.display = "none";
    // if (!$('#his_modal_confirm_' + extra_id).hasClass('show'))
    // {
    //     $("#his_modal_confirm_" + extra_id).modal('show');
    // }
}

/**
 * Clear content and hide the modal have extra_id
 * @extra_id the id of the modal
 */
function HisClearAndHideConfirm(extra_id)
{
    // (new bootstrap.Modal(document.getElementById(), {})).hide();
    $("#his_modal_confirm_" + extra_id).modal('hide');
    document.getElementById("his_modal_confirm_title_" + extra_id).innerHTML = "";
    document.getElementById("his_modal_confirm_text_" + extra_id).innerHTML = "";
}

function show_result(id_bind, msg_bind, class_show = "")
{
    var label_msg = document.getElementById(id_bind);
    label_msg.style.display = "block";
    label_msg.removeAttribute("class");
    label_msg.setAttribute("class",class_show);
    label_msg.innerHTML = msg_bind;
}

/**
 * Register the click handler for the NO button
 * @extra_id the id of the modal
 * @handler handler registered
 */
function HisRegistHandlerConfirmNo(extra_id, handler)
{
    RegisterClickHandler(document.getElementById("his_modal_confirm_btn_no_" + extra_id), handler);
}

// register a handler click event for a element
function RegisterClickHandler(element, handler)
{
    if (element)
    {
        element.addEventListener("click", function(event) {
            if (handler)
            {
                handler(event);
            }
        });
    }
}

/**
 * Show alert modal with success layout
 * @title the title of the modal
 * @msg the message that we need to show
 */
function HisShowAlertSuccess(title, msg)
{
    document.getElementById("his_modal_alert_title").innerHTML = title;
    show_result("his_modal_alert_text", msg, "col-12 h-100 alert alert-success text-center");
    // $("#his_modal_alert").show();
    // (new bootstrap.Modal(document.getElementById("his_modal_alert"), {})).show();
    $("#his_modal_alert").modal('show');
}

/**
 * Show alert modal with warning layout
 * @title the title of the modal
 * @msg the message that we need to show
 */
function HisShowAlertWarning(title, msg)
{
    document.getElementById("his_modal_alert_title").innerHTML = title;
    show_result("his_modal_alert_text", msg, "col-12 h-100 alert alert-warning text-center");
    // (new bootstrap.Modal(document.getElementById("his_modal_alert"), {})).show();
    $("#his_modal_alert").modal('show');
}

/**
 * Show alert modal with error layout
 * @title the title of the modal
 * @msg the message that we need to show
 */
function HisShowAlertError(title, msg)
{
    document.getElementById("his_modal_alert_title").innerHTML = title;
    show_result("his_modal_alert_text", msg, "col-12 h-100 alert alert-danger text-center");
    // (new bootstrap.Modal(document.getElementById("his_modal_alert"), {})).show();
    $("#his_modal_alert").modal('show');
}


/**
 * clear content and hide alert modal
 */
function HisClearAlert()
{
    document.getElementById("his_modal_alert_title").innerHTML = "";
    document.getElementById("his_modal_alert_text").innerHTML = "";
    // $("#his_modal_alert").hide();
    $("#his_modal_alert").modal('hide');
}

function HiddenElement(id, _true = true)
{
    if (id)
    {
        if (document.getElementById(id))
        {
            if (_true)
            {
                document.getElementById(id).setAttribute("hidden", true);
            }
            else
            {
                document.getElementById(id).removeAttribute("hidden", false);
            }
        }
    }
}

function ReadOnlyElement(id, _true = true)
{
    if (id)
    {
        if (document.getElementById(id))
        {
            if (_true)
            {
                document.getElementById(id).setAttribute("readonly", true);
            }
            else
            {
                document.getElementById(id).removeAttribute("readonly");
            }
        }
    }
}

