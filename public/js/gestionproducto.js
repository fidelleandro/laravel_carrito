$('.reporte_productos').dataTable();
modal = $('#crearProductoModal');

function save_product(THIS){    
    //La información se envia de forma segura con el token de laravel
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('input[name="_token"]').val()
          }
      }); 
      //Buscamos el formulario con find y lo asignamos a la variable form
      form  = modal.find("form"); //Buscamos la etiqueta html form.
      //Con FormData(form[0]) capturamos todos los elementos del formulario
      var formData = new FormData(form[0]); 
      //El ajax permite enviar la información a la ruta definida em action y evita la recarga de la página 
      $.ajax({
         type:        'POST', //Seleccionamos el tipo de request, en este caso POST
         dataType:    'json', //Especificamos como recibimos los datos. En este caso del tipo JSON
         processData:  false, // sin procesar data
         contentType:  false, // tipo de contenido en falso
         url:          form.attr('action'),//aqui mandamos la ruta del formulario usando la funcion attr (Esta funcion sirve para capturar los atributos de las etiquetas html) 
         data:         formData, //Aqui se envia los datos del formulario con la variable formData
         success:function(data){ //El success retorna la información del controlador - Producto controller
            if (data.status) { //Este if significa si es correcto o existe algun valor
                toastr.success(data.message, 'Mensaje exitoso', {timeOut: 5000}) 
                setTimeout(function(){ modal.modal('hide');location.reload(); }, 2000); 
            }
             else{
                toastr.error(data.message, 'Mensaje de error', {timeOut: 5000})
            } 
         }
      });
}
function imageChange(THIS,e){
    src = URL.createObjectURL(e.target.files[0]);
    modal.find("form .img_photo").attr('src',src);
}
function add_producto(THIS){
    modal.find("form .producto").val('');
}
function edit_producto(THIS,url){
    form = modal.find('form');
    id = $(THIS).parent().parent().find('td').first().attr('data-id');
    form.find('.producto').val(id);
    
    $.ajax({
        type:'GET',
        dataType: 'json',
        url:url,
        data: {id:id},
        success:function(data){
            console.log(data.data);
            if (data.status) {   
                form.find("#categoria").val(data.data['categ']); 
                form.find("#nombre").val(data.data['nombre']); 
                form.find("#precio").val(data.data['precio']); 
                form.find("#stock").val(data.data['stock']); 
                form.find("#descripcion").val(data.data['descripcion']); 
                form.find("img").attr('src',form.find("img").attr('data')+data.data['foto']); 
            }
            else{
                toastr.error(data.message, 'Mensaje de error', {timeOut: 5000})
            }   
        }
    }); 
}
function eliminar(THIS,url){
    input = $(THIS).parent().parent().find('td').first().attr('data-id');
    swal({
        title: "Estás seguro que deseas eliminar el registro?",
        text: "Al darle aceptar eliminarás el registro",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type:'GET',
                dataType: 'json',
                url:url,
                data: {id:input},
                success:function(data){
                    if (data.status) { 
                        swal("Listo! El registro fue eliminado!", {
                            icon: "success",
                        });
                        location.reload();
                    }
                    else{
                        toastr.error(data.message, 'Mensaje de error', {timeOut: 5000})
                    }   
                }
            }); 
        } else {
          swal("El registro sigue disponible!");
        }
      }); 
}