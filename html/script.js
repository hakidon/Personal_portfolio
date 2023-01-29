let dropzone = document.getElementById('drop-area');
let download = document.getElementById('download');

let reload = function () {window.location.reload();}
let clear = function () {download.innerHTML = '';}

let buttonVisible = function (name) {let id = document.getElementById(name); id.style.visibility = 'visible';}
let buttonHidden  = function (name) {let id = document.getElementById(name); id.style.visibility = 'hidden';}

let displayUploads = function (data)
{
    let mess = document.getElementById('message');
    if (data == "1" || data == "2")
    {
        buttonVisible('refresh');
        if (data == "1") {mess.innerHTML = "File is not a pdf";}
        else {mess.innerHTML = "File size is too big";}
    }
    else
    {
        buttonVisible('download');

        clear();
        let anchor = document.createElement('a');
        anchor.setAttribute("id","anchor");
        let name = data.split('/');
        anchor.download = name[1];
        anchor.href = data;
        const scriptHTML = '<button></button>';
        anchor.innerHTML = scriptHTML;
        anchor.innerText = "Download";
        anchor.style.color = "white";
        anchor.style.padding = "10px 10px 10px 10px";
        anchor.style.borderRadius = "5px";
        anchor.style.visibility = "visible";

        download.appendChild(anchor);
        console.log(download);
    }
}

let uploads = function (files)
{
    let formData = new FormData(),
        xhr = new XMLHttpRequest();

    formData.append('fileToUpload', files[0]);

    xhr.onload = function ()
    {
        let data = JSON.stringify(this.responseText).replace(/"|\\r|\\n/g, '');
        displayUploads(data);
    }
    xhr.open('post', 'upload.php');
    xhr.send(formData);
    document.getElementById('fileToUpload').value= null;
    window.alert("Please wait, your file is processing...");
}

dropzone.ondrop = function (e) {
    e.preventDefault();
    uploads(e.dataTransfer.files);
    this.className = 'drop-area';
    return false;
}

dropzone.ondragover = function () {
    this.className = 'drop-area dragover';
    return false;
}

dropzone.ondragleave = function () {
    this.className = 'drop-area';
    return false;
}