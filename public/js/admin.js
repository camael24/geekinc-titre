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
          for(i=0; i< titres.length; i++){
            if(titres[i].content.name == current.content.name) {
              html += '<div class="list-group-item active" data-i="'+i+'"><div class="btn-group pull-right">'+
              '<a href="#" class="btn btn-xs btn-default details" data-i="'+i+'"><i class="fa fa-fw fa-edit"></i></a>'+
              '</div><span class="badge">'+titres[i].date+'</span><i class="fa fa-fw fa-ticket"></i>['+titres[i].name+'] '+titres[i].content.titre+'</div>'
            }
            else {
              html += '<div class="list-group-item" data-i="'+i+'">'+

              '<div class="btn-group btn-xs pull-right">'+
              '<a href="#" class="btn btn-xs btn-default details" data-i="'+i+'"><i class="fa fa-fw fa-edit"></i></a>'+
              '<a href="#" class="btn btn-xs btn-primary activate" data-uri="'+titres[i].path+'"><i class="fa fa-fw fa-rocket"></i></a>'+
              '</div><span class="badge pull-right">'+titres[i].date+'</span><i class="fa fa-fw fa-ticket"></i>['+titres[i].name+'] '+titres[i].content.titre+
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
    updateTitres();
  })

})

$('.form_close').on('click', function(e) {
  e.preventDefault();

  $('.div_form').hide();
})

$('.form_send').on('click', function (e) {
  e.preventDefault();

  data = {
    uri: $('#form_uri').val(),
    name: $('#form_name').val(),
    titre: $('#form_titre').val(),
    bcolor: $('#form_bcolor').val(),
    color: $('#form_color').val(),
    width: $('#form_width').val()

  };

  $.post('/api/', data, function (data) {

    updateTitres();
  })

})

$('.panel-body').on('click', '.details', function (e) {

e.preventDefault();
  var i = $(this).data('i');

  $('.div_form').show();
  titre = titres[i];

  $('#form_name').val(titre.content.name);
  $('#form_titre').val(titre.content.titre);
  $('#form_bcolor').val(titre.content.bcolor);
  $('#form_color').val(titre.content.color);
  $('#form_width').val(titre.content.width);
  $('#form_uri').val(titre.path);


  updateTitres();
})

$('.trashed').on('click', function (e) {
  e.preventDefault();

  $.post('/api/delete', 'uri='+$('#form_uri').val(), function (data) {

    $('#form_name').val();
    $('#form_titre').val();
    $('#form_bcolor').val();
    $('#form_color').val();
    $('#form_width').val();
    $('#form_uri').val();

    updateTitres();
  })
});

updateTitres();
