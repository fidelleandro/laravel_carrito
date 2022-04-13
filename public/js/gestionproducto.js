$('.reporte_productos').dataTable();
modal = $('#crearProductoModal');

function save_product(THIS){    
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('input[name="_token"]').val()
          }
      }); 
      form  = modal.find("form");
      var formData = new FormData(form[0]); 
       
      $.ajax({
         type:'POST',
         dataType: 'json',
         processData: false,
         contentType:  false,
         url:form.attr('action'),
         data: formData,
         success:function(data){
            if (data.status) { 
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