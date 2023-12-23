/**
 * =======================================
 * Function: count down timer
 * =======================================
 */
var setCountDownTimer = function ($wrapper, deadline) {
  var $dayCont = $wrapper.find('.count-down-timer__day > span');
  var $hourCont = $wrapper.find('.count-down-timer__hour > span');
  var $minuteCont = $wrapper.find('.count-down-timer__minute > span');
  var $secondCont = $wrapper.find('.count-down-timer__second > span');

  var x = setInterval(function () {
    var now = new Date().getTime();
    var t = deadline - now;
    var days = Math.floor(t / (1000 * 60 * 60 * 24));
    var hours = Math.floor((t % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((t % (1000 * 60)) / 1000);

    $dayCont.html(days);
    $hourCont.html(hours);
    $minuteCont.html(minutes);
    $secondCont.html(seconds);

    if (t < 0) {
      clearInterval(x);
      $dayCont.html('0');
      $hourCont.html('0');
      $minuteCont.html('0');
      $secondCont.html('0');
    }
  }, 1000);
};

$(document).ready(function () {
  $('[data-date]').each(function () {
    var date = new Date($(this).data('date')).getTime();
    setCountDownTimer($(this), date);
  });

  $('#PROJECT_SLIDER .project-slider__item').on('click', function () {
    const src = $(this).attr('src');

    $('#PROJECT_SLIDER .project-slider__image').attr('src', src);
  });
});
