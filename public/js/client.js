try {
    var source    = new EventSource('server.php');
    
    source.onopen = function () {
        output.appendChild(document.createElement('hr'));

        return;
    };
    source.onmessage = function (evt) {
        var samp       = document.createElement('samp');
        samp.innerHTML = evt.data + '\n';
        output.appendChild(samp);

        return;
    };
} catch (e) {
    console.log(e);
}
