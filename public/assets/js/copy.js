
function copyToClipboard(elem,balloonElem) {

    let copyText = document.querySelector(elem);


    copyText.select();
    copyText.setSelectionRange(0, 99999); /*For mobile devices*/

    document.execCommand("copy");
    if(balloonElem){
        let balloon = document.querySelector(balloonElem);
        balloon.style.display = 'block';
        setTimeout(function () {
            balloon.style.display = 'none';
        },3000);
    }


}
