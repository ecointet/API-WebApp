/*
===== Web App To demonstrate tons of APIS
===== Built for demo purposes (by Postman)
===== Author: @ecointet (twitter)
*/

$("#intro").css({
    'background'    : 'url('+$("#company_background").val()+')'
});

function GetApiResult01(url)
{
    $('#loading').fadeIn();
    $('#button01').fadeOut("slow");

    var url = "/srv/remote-data.php?url="+url;
    console.log("API URL: ["+url+"]");

    try {
        $.getJSON(url, function( data ) {

            try {   
                console.log(data); //RESULT RAW

                var city = data.city;
                var photo = data.photo;

                $('#game01-result').html(city);
                $('#title').html(city);
                $('#description').html("is not far away from you!");
            
                $("#intro").css({
                    'background'    : 'url('+photo+')'
                }).animate({opacity: '0.3'}, "slow").animate({opacity: '1'}, "slow");
            }
            catch ({ name, message }) {
                console.log("error:" + name); // "TypeError"
                console.log("error desc: " + message); // "oops"
                $('#title').html("Oups.");
                $('#description').html("API Not working :( ");
                $("#intro").css({
                    'background'    : 'url('+$("#company_background").val()+')'
                });
              }
        })
        .done(function() {
            console.log( "API successfuly loaded" );
          })
          .fail(function() {
            console.log( "error" );
            $('#title').html("Oups.");
            $('#description').html("API Not working :( ");
          })
          .always(function() {
            console.log( "API stage: END" );
          });
    }
    catch ({ name, message }) {
        console.log("error:" + name); // "TypeError"
        console.log("error desc: " + message); // "oops"
        $('#title').html("Oups.");
        $('#description').html("API Not working :( ");
        $("#intro").css({
            'background'    : 'url('+$("#company_background").val()+')'
        });
      }

    $('#loading').fadeOut();
    $('#button01').fadeIn("slow");
}