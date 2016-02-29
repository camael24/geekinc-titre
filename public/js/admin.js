var titres = [];

function updateTitres() {

  // Update count


  $.get('/api/titres', function (data) {

    data = JSON.parse(data);
    titres = data;


      $('.titre_count').text(titres.length)
    //    <a href="#" class="list-group-item">
            //<span class="badge">just now</span>
            //<i class="fa fa-fw fa-calendar"></i> Calendar updated
        //</a>

        var html = '';
        var current = {};
        $.get('/api/current', function(data) {
          current = JSON.parse(data);

          console.log(current);

          for(i=0; i< titres.length; i++){
            if(titres[i].path == current.path) {
              html += '<div class="list-group-item active">'+
              '<a href="#" class="pull-right" style="visibility:hidden"><i class="fa fa-fw fa-rocket"></i></a>'+
              '<span class="badge">'+titres[i].date+'</span><i class="fa fa-fw fa-ticket"></i>['+titres[i].name+'] '+titres[i].content.titre+'</div>'
            }
            else {
              html += '<div class="list-group-item">'+
              '<a href="#" class="activate pull-right" data-uri="'+titres[i].path+'"><i class="fa fa-fw fa-rocket"></i></a>'+
              '<span class="badge pull-right">'+titres[i].date+'</span><i class="fa fa-fw fa-ticket"></i>['+titres[i].name+'] '+titres[i].content.titre+
              '</div>'
            }
          }

        $('.titre_list').empty().html(html);
      });

  })

}

$('.panel-body').on('click', '.activate', function (e) {

  var uri = $(this).data('uri');

  $.post('/api/define', 'uri='+uri, function (data) {

    console.log(data);
    updateTitres();
  })


})

updateTitres();
