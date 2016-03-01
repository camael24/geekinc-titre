  var host   = 'ws://geek.ark.im:8889';
  var socket = null;

  try {
      socket = new WebSocket(host);
      socket.onopen = function () {
          console.log('connection is opened');
          return;
      };
      socket.onmessage = function (msg) {
          data = JSON.parse(msg.data);
          content = data.content;
          $('#titre')
            .css('background-color', content.bcolor)
            .css('color', content.color)
            .css('width', content.width)
            .text(content.titre);

          return;
      };
      socket.onclose = function () {
          console.log('connection is closed');
          return;
      };
  } catch (e) {
      console.log(e);
  }
