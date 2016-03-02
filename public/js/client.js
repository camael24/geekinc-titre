var host   = 'ws://geek.ark.im:8889';
var socket = null;
var titleContainer = $('#title')

function showContainer() {
    $('#title').removeClass('hidden');
}

function hideafter(duration) {
  if(duration){
      setTimeout(function(){
          $('#title').addClass('hidden');
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

var duration =$('#title').data('duration');

if(duration){
 hideafter(duration)
}
