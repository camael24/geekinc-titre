var host   = 'ws://geek.ark.im:8889';
var socket = null;
var titleContainer = $('#title')

function updateTitre(message, duration) {
  titleContainer.textContent = title.text;
  showContainer(message);
  hideafter(5);
}

function showContainer() {
    titleContainer.classList.remove('hidden');
}

function hideafter(duration) {
  if(duration){
      setTimeout(function(){
          titleContainer.classList.add('hidden');
      }, duration*1000);
  }
}
try {
    socket = new WebSocket(host);
    socket.onopen = function () {
        console.log('connection is opened');

        return;
    };
    socket.onmessage = function (msg) {
        data = JSON.parse(msg.data);
        content = data.content;

        console.log(data);
        $('#title')
          .removeClass('geekinc')
          .addClass(content.class)
          .text(content.titre);
        if(content.duration)
        {
          hideafter(duration);
        }

        return;
    };
    socket.onclose = function () {
        console.log('connection is closed');
        return;
    };
} catch (e) {
    console.log(e);
}
showContainer();

var duration = titleContainer.data('duration');

if(duration){
 hideafter(duration)
}
