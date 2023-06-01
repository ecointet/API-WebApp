/*
===== Web App To demonstrate tons of APIS
===== Built for demo purposes (by Postman)
===== Author: @ecointet (twitter)
*/

$("#intro").css({
    'background'    : 'url('+$("#company_background").val()+')'
});

$('#company_name').on('input', function() {
  if ($('#company_name').val().length >= 2)
  {
  var url = "/srv/remote-data.php?id="+$("#company_name").val()+"%";

  $.getJSON(url, function(data) {
    try {   
        console.log(data); //RESULT RAW

        if (data.name != undefined)
        {
          var txt = "Do you mean <a href='/?id="+data.name+"'><b>"+data.name+"</b></a> ?"
         $("#suggestion").html(txt);
          console.log(" detected: "+txt);
      }
    }
    catch ({ name, message }) {
        console.log("error:" + name); // "TypeError"
        console.log("error desc: " + message); // "oops"
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
   
  
});

function urldecode(url) {
  return decodeURIComponent(url.replace(/\+/g, ' '));
}

function refreshUserData()
{
  GetClientIP();

  var url = "/srv/remote-data.php?id="+$("#company_name").val();

  $.getJSON(url, function(data) {
    try {   
        console.log(data); //RESULT RAW
        if (data.logo && data.background)
        {
          $("#company_logo").val(data.logo);
          $("#company_background").val(data.background);
          $("#company_api").val(urldecode(data.api));
        }
    }
    catch ({ name, message }) {
        console.log("error:" + name); // "TypeError"
        console.log("error desc: " + message); // "oops"
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

function GetApiResult01()
{

    url = encodeURI($('#company_api').val());

    $('#loading').fadeIn();
    refreshUserData();
    $('#button01').fadeOut("slow");

    var url = "/srv/remote-data.php?url="+url;

    if (!url.includes("mock"))
      url = url + $("#client_ip").val();

    console.log("CURRENT IP: ["+$("#client_ip").val()+"]");
    console.log("REMOTE API URL: ["+url+"]");

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

function GetClientIP()
{

  var url = encodeURI("/srv/remote-data.php?url="+"http://ip-api.com/json/");
  $.getJSON(url, function(data) {
    try {   
        console.log("GET CLIENT IP: " + data.query); //RESULT RAW

        $("#client_ip").val(data.query);
    }
    catch ({ name, message }) {
        console.log("error:" + name); // "TypeError"
        console.log("error desc: " + message); // "oops"
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