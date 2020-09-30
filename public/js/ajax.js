(function($) {
    $.fn.PostRequest = function(options) {
    var settings = $.extend({
      type : 'POST',
      fields : null
    }, options );
  
      var form = $(this);
  
      try{
        form.on( "submit", function( event ) {
          jQuery('.loader').show();
          event.preventDefault();
          fields = $(this).serialize();
  
          var formData = new FormData($(this)[0]);
  
          fields += '&'+$(this).attr('id')+'=true';
          formData.append($(this).attr('id'), 'true');
          if(settings.fields != null){
            $.each( settings.fields, function( key, value ) {
              fields += '&'+key+'='+value;
              formData.append(key, value);
            });
          }
  
          $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $("#csrf_token").val()
              }
          });

          $.ajax({
            type: settings.type,
            url: $(this).attr('action'),
            data: formData,
            contentType : $(this).attr( "enctype", "multipart/form-data" ),
            processData: false,
            contentType: false,
            success: function(data) {
              try{
                var obj = jQuery.parseJSON(data);
                if(obj.status){
                  if(obj.redirect && obj.redirect != ''){
                    window.location = obj.redirect;
                  }else
                  if(obj.reload){
                    location.reload();
                  }else{
                    alert(obj.msg);
                  }
                  $(form)[0].reset();
                }else{
                  alert(obj.msg);
                }
              }catch(error){
                alert('Ocorreu um problema no envio dos data, tente novamente mais tarde!');
                console.log(error.message);
              }
            },
            complete : function(response){
              jQuery('.loader').hide();
            },
            error : function(response){
              console.log(response.responseText);
            }
          });
  
        });
      }catch(error){
        console.log(error.message);
      }
  
    }
  
  })(jQuery);
  
  /**
  **
  $("#form_1").AjaxRequest({
      type_event : 'submit',
      type : 'POST',
      fields : {
          'email' : 'email@email.com',
          'senha' : '123456'
      },
      retorno : function(date){
      console.log(date);
      }
  });
  **
  **/
  
  (function($) {
      $.fn.AjaxRequest = function(options) {
      var settings = $.extend({
        type_event : 'click', // submit, click, change
        type : 'POST',
        fields : function(){},
        success : function(){return true},
        error : function(){return true},
        conditional : function(){return false}
      }, options );
  
        var objClick = $(this);
  
        try{
          objClick.on(settings.type_event, function( event ) {
            jQuery('.loader').show();
            event.preventDefault();
  
            fields = settings.fields();
            action = '';
            if(settings.type_event == 'submit'){
              var formData = new FormData($(this)[0]);
              formData.append($(this).attr('id'), 'true');
              action = $(this).attr('action');
            }else{
              var formData = new FormData(fields);
              action = window.location.href;
            }
            if(fields != null){
              $.each(fields, function( key, value ) {
                formData.append(key, value);
              });
            }
  
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $("#csrf_token").val()
                }
            });
            
            $.ajax({
              type: settings.type,
              url: action,
              data: formData,
              processData: false,
              contentType: false,
              success: function(obj) {
                try{
                  if(obj.status){
                  //if(settings.type_event == 'submit'){
                    if(obj.redirect && obj.redirect != ''){
                      if(obj.msg){
                        Swal.fire({
                          type: 'success',
                          title: obj.msg,
                          confirmButtonColor: '#367fa9',
                        }).then((result) => {
                          if (result.value) {
                            window.location = obj.redirect;
                          }
                        });
                      }else{
                        window.location = obj.redirect;
                      }
                    }else
                    if(obj.reload){
                      if(obj.msg){
                        Swal.fire({
                          type: 'success',
                          title: obj.msg,
                          confirmButtonColor: '#367fa9',
                        }).then((result) => {
                          if (result.value) {
                            location.reload();
                          }
                        });
                      }else{
                        location.reload();
                      }
                    }else{
                      Swal.fire({
                        type: 'success',
                        title: obj.msg,
                        confirmButtonColor: '#367fa9',
                      });
                    }
                    $(objClick)[0].reset();
                  //}
                  }else{
                    Swal.fire({
                      type: 'error',
                      title: obj.msg,
                    });
                    //alert(obj.msg);
                  }
                }catch(error){
                  alert('Ocorreu um problema no envio dos data, tente novamente mais tarde!');
                  console.log(error.message);
                }
              },
              complete : function(obj){
                jQuery('.loader').hide();
                settings.success.call(null,obj.responseJSON);
              },
              error : function(response){
                console.log('Error: Bad request 400');
                console.log(response.responseText);
              }
            });
            return false;
        });
      }catch(error){
        console.log(error.message);
      }
    }
  })(jQuery);
  
  
  function RequestPost(object){
      jQuery('.loader').show();
      if(object.headers){
        $.ajaxSetup({
          headers: object.headers
        });
      }

      $.ajax({
          type: 'POST',
          url: ((object.url)? object.url : window.location.href),
          data: object.fields,
          //processData: false,
          //contentType: false,
          success: function(obj) {
              try{
                  if(obj.status){
                      if(obj.redirect && obj.redirect != ''){
                          window.location = obj.redirect;
                      }else
                      if(obj.reload){
                          if(obj.msg)
                              alert(obj.msg);
                          location.reload();
                      }else{
                          alert(obj.msg);
                      }
                  }else{
                      alert(obj.msg);
                  }
              }catch(error){
                  alert('Ocorreu um problema no envio dos data, tente novamente mais tarde!');
                  console.log(error.message);
              }
          },
          complete : function(obj){
              jQuery('.loader').hide();
          },
          error : function(response){
              console.log(response.responseText);
          }
      });
  }