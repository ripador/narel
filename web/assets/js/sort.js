$(function() {
  $('.response').hide();

  var sortable = $("#sortable");
  sortable.sortable();
  sortable.disableSelection();

  $('#check').on('click', function(e) {
    $('.response').hide();
    var stop = false;
    var pos = 1;
    var ant = 0;

    sortable.find('li').each(function (idx) {
      var obj = $(this);
      var val = parseInt(obj.attr('data-value'));

      if (stop == false && val < ant) {
        //updateResponse("EL NÚMERO " + val + " ESTÀ A LA POSICIÓ " + pos, false);
        $('#ko').show();
        stop = true;
      }
      pos++;
      ant = val;
    });

    if (stop == false) {
      //updateResponse("MOLT BÉ", true);
      $('#ok').show();
    }
  });
});