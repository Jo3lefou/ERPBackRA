function dismissAlert(){
  $('#loading-alert').on('click', function(){
    $(this).fadeOut();
    $(this).find('.alert').fadeOut();
  })
}
$('.table .dropdown-menu li a').on( 'click', function (e) {
          e.preventDefault();
          var href = $(this).attr('href');
          var value = $(this).attr('rel');
          var action = $(this).attr('data-action');
          var text = $(this).html();
          $('#loading-bar').fadeIn();
          //alert('href: '+href+' rel: '+value);
          $.ajax( {
            type:"GET",
            url: href,
            dataType: "json",
            data: { value: value, action: action },
            success: function( data ) {
              if(data.type == 'update-model-ordered'){
                $('#mo-'+data.id).removeClass();
                $('#mo-'+data.id).addClass(data.class);
                if(data.action == "text-change"){
                  $('#mo-'+data.id).html(text+' <span class="caret"></span>');
                  if(data.newValue == '0') { 
                    var nClass="st-td";
                  }else{
                    if(data.newValue == '1') { 
                      var nClass="st-es";
                    }else{
                      if(data.newValue == '2') { 
                        var nClass="st-ew";
                      }else{
                        if(data.newValue == '3') { 
                          var nClass="st-ecp";
                        }else{
                          if(data.newValue == '4') { 
                            var nClass="st-epf";
                          }else{
                            if(data.newValue == '5') { 
                              var nClass="st-rs";
                            }else{
                              if(data.newValue == '6') { 
                                var nClass="st-rse";
                              }else{
                                if(data.newValue == '7') { 
                                  var nClass="st-cs";
                                }else{
                                  var nClass="st-lc";
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                  $('tr#production-'+data.id).removeClass();
                  $('tr#production-'+data.id).addClass(nClass);
                }
              }else{
                if(data.type == 'update-order'){
                  $('#o-'+data.id).removeClass();
                  $('#o-'+data.id).addClass(data.class);
                  $('#o-'+data.id).html(text+' <span class="caret"></span>');
                  $('tr#order-'+data.id).removeClass();
                  $('tr#order-'+data.id).addClass(data.lineclass);
                  if(data.datevalidation != ''){
                    $('tr#order-'+data.id+' td.validationdate').html(data.datevalidation);
                  }
                }else{
                  if(data.type == 'update-workroom'){
                    $('button#mow-'+data.id).html(text+' <span class="caret"></span>');
                  }else{
                    var message = data.error;
                    $('#loading-alert .alert-danger p').html(message);
                    $('#loading-alert').fadeIn().find('.alert-danger').fadeIn();
                    dismissAlert();
                  }
                }
              }
            },
            complete: function(){
              $('#loading-bar').fadeOut();
            }
          });
       });

$(document).ready(function(){

	// Color Picker Profile Edition
	$('.colorPicker').colorpicker();

	// Local Input on profile page.
	$('#locale label').on('click', function(){
		var val = $(this).find('input').val();
		$('#form_locale').val(val);
		$('#shop_locale').val(val);
		$('#matter_provider_locale').val(val);
		$('#OrderType_customer_locale').val(val);
	});

  // Token
  // set the length of the string
  var stringLength = 40;
  // list containing characters for the random string
  var stringArray = ['0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','!','?'];
  $('#generateToken').on('click', function(){
    //e.preventDefault();
    var rndString = "";
    // build a string with random characters
    for (var i = 1; i < stringLength; i++) { 
      var rndNum = Math.ceil(Math.random() * stringArray.length) - 1;
      rndString = rndString + stringArray[rndNum];
    };
    $("#shop_token").val(rndString);
    $("#user_token").val(rndString);
    return false;
  });

});
