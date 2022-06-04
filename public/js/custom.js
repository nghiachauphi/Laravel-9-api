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

function BindTextValue(id, data, key = null)
{
    if (id == null || data == null)
    {
        return;
    }

    var elem = id;
    if (typeof id  === "string")
    {
        elem = document.getElementById(id);
    }

    if (elem == null)
    {
        return;
    }

    if (key)
    {
        if (data.hasOwnProperty(key))
        {
            if (typeof data[key] === 'string' && !(data[key]).includes("Chọn"))
            {
                elem.innerHTML = data[key];
            }

            if (typeof data[key] === 'number')
            {
                elem.innerHTML = data[key];
            }
        }
    }
    else
    {
        if (typeof data === 'string' && !data.includes("Chọn"))
        {
            elem.innerHTML = data;
        }

        if (typeof data === 'number')
        {
            elem.innerHTML = data;
        }
    }
}

