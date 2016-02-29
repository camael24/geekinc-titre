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
              html += '<div class="list-group-item active" data-i="'+i+'">'+
              '<a href="#" class="details pull-right" data-i="'+i+'" style="visibility:hidden"><i class="fa fa-fw fa-edit"></i></a>'+
              '<a href="#" class="pull-right" style="visibility:hidden"><i class="fa fa-fw fa-rocket"></i></a>'+
              '<span class="badge">'+titres[i].date+'</span><i class="fa fa-fw fa-ticket"></i>['+titres[i].name+'] '+titres[i].content.titre+'</div>'
            }
            else {
              html += '<div class="list-group-item" data-i="'+i+'">'+
              '<a href="#" class="details pull-right" data-i="'+i+'"><i class="fa fa-fw fa-edit"></i></a>'+
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

$('.panel-body').on('click', '.details', function (e) {

  var i = $(this).data('i');

  titre = titres[i];

  $('#form_name').val(titre.name);
  $('#form_titre').val(titre.content.titre);
  $('#form_bcolor').val(titre.content.bcolor);
  $('#form_color').val(titre.content.color);
  $('#form_width').val(titre.content.width);
  $('#form_uri').val(titre.path);

})

updateTitres();
