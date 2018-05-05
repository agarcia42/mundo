 
 

 function tac (sel) {                   
                     var nuevoalias = jQuery.noConflict();
                     nuevoalias(document).ready(function() {
                     var mat = nuevoalias('select[name=target]').val();
                     var materia = sel.value;
                     nuevoalias.ajax({
                             type: "POST",
                             url:  'esthor',
                             data: "materia=" + materia,
                             beforeSend: function () {
                                    nuevoalias("#horario").html("Procesando, espere por favor...");
                             },       
                             success: function(html){
                                      nuevoalias("#materias").html(html);
                                      }
                              })                        
                      })
              };

function getfecgra(acto) {                   
                     var nuevoalias = jQuery.noConflict();
                     nuevoalias(document).ready(function() {
                     var acto = nuevoalias('select[name=acto]').val();
                     nuevoalias.ajax({
                             type: "POST",
                             url:  'solicitudes/gradof/'+acto,
                             data: "acto ="+acto,
                             beforeSend: function () {
                                    nuevoalias("#fecgra").html("Procesando, espere por favor...");
                             },       
                             success: function(html){
                                      nuevoalias("#fecgra").html(html);
                                      }
                              })                        
                      })
              };

 function getestado(estado) {                   
                     var nuevoalias = jQuery.noConflict();
                     nuevoalias(document).ready(function() {
                     var pais_id = nuevoalias('select[name=pais]').val();
                     nuevoalias.ajax({
                             type: "POST",
                             url:  'origen/estado/'+pais_id,
                             data: "pais_id=" + pais_id,
                             success: function(html){
                                      nuevoalias("#estados").html(html);
                                      }
                              })                        
                      })
              };


 function getciudad(ciudad) {                   
                     var nuevoalias = jQuery.noConflict();
                     nuevoalias(document).ready(function() {
                     var entidad_id = nuevoalias('select[name=entidades]').val();
                     nuevoalias.ajax({
                             type: "POST",
                             url:  'origen/ciudades/'+ entidad_id,
                             data: "entidad_id=" + entidad_id,
                             success: function(html){
                                      nuevoalias("#ciudades").html(html);
                                      }
                              })                        
                      })
              };

 function getMunicipio(entidad) {                   
                     var nuevoalias = jQuery.noConflict();
                     nuevoalias(document).ready(function() {
                     var entidad_id = nuevoalias('select[name=ciudades]').val();
                     nuevoalias.ajax({
                             type: "POST",
                             url:  'origen/municipio/'+ entidad_id,
                             data: "entidad_id=" + entidad_id,
                             success: function(html){
                                      nuevoalias("#municipios").html(html);
                                      }
                              })                        
                      })
              };

 function getParroquia(ciudad) {                   
                     var nuevoalias = jQuery.noConflict();
                     nuevoalias(document).ready(function() {
                     var id_municip = nuevoalias('select[name=municipio]').val();
                     nuevoalias.ajax({
                             type: "POST",
                             url:  'origen/parroquia/'+id_municip,
                             data: "id_municip ="+id_municip,
                             success: function(html){
                                      nuevoalias("#parroquias").html(html);
                                      }
                              })                        
                      })
              };

function descuento(cedrep,codalu,codesq,codcon,accion,cantidad) {                   
                     var nuevoalias = jQuery.noConflict();
                     nuevoalias(document).ready(function() {
                     var id_municip = nuevoalias('input[name=desfac'+cantidad+']').val();
                    // alert(id_municip);
                     nuevoalias.ajax({
                             type: "POST",
                             url:  'representante/portal/'+cedrep+'/'+codalu+'/'+codesq+'/'+codcon+'/'+accion+'/'+id_municip,
                             data: "id_municip ="+id_municip,
                             success: function(html){
                                      nuevoalias("#page-wrapper").html(html);
                                      }
                              })                       
                      })
              };


function pagoparcial(cedrep,codalu,codesq,codcon,accion,cantidad) {                   
                     var nuevoalias = jQuery.noConflict();
                     nuevoalias(document).ready(function() {
                     var id_municip = nuevoalias('input[name=desfac'+cantidad+']').val();
                     var id_mondet = nuevoalias('input[name=mondet'+cantidad+']').val();
                    // alert(id_municip);
                     nuevoalias.ajax({
                             type: "POST",
                             url:  'representante/portal/'+cedrep+'/'+codalu+'/'+codesq+'/'+codcon+'/'+accion+'/'+id_municip+'/'+id_mondet,
                             data: "id_municip ="+id_municip,
                             success: function(html){
                                      nuevoalias("#page-wrapper").html(html);
                                      }
                              })                       
                      })
              };


function elim_esthor(codmat, nommat){
        var nuevoalias = jQuery.noConflict();
        if(confirm('¿Deseas eliminar ' +nommat+'?')){
            nuevoalias.ajax({
                data:  'codmat=' + codmat,
                url:   'elim_esthor',
                type:  'POST',
                beforeSend: function () {
                        nuevoalias("#horario").html("Procesando, espere por favor...");
                },
                success:  function (response) {
                        nuevoalias("#materias").html(response);
                }
        });
        }
}

function elim_ceinse(codmat, nommat){
        var nuevoalias = jQuery.noConflict();
        if(confirm('¿Deseas eliminar ' +nommat+'?')){
            nuevoalias.ajax({
                data:  'codmat=' + codmat,
                url:   'elim_ceinse',
                type:  'POST',
                beforeSend: function () {
                        nuevoalias("#horario").html("Procesando, espere por favor...");
                },
                success:  function (response) {
                        nuevoalias("#materias").html(response);
                }
        });
        }
}

function validar(){
        var nas = jQuery.noConflict();
        if(confirm('¿Deseas Validar la Inscipcion?')){
            nas.ajax({
                url:   'validar',
                type:  'POST',
                beforeSend: function() { nas('#loader_gif').fadeIn("slow");
                                         nas("#horario").html("Procesando, espere por favor..."); 
                },
                success:  function (response) {
                            nas("#materias").html(response);
                },
        });
        }
}

function suma(){
var a=document.getElementById("efe").value*1;
var b=document.getElementById("deb").value*1;
var c=document.getElementById("dep").value*1;
var d=document.getElementById("che").value*1;
document.getElementById("total").value=a + b + c + d;
}


function cambiar(){
var a=document.getElementById("nombre").value;
document.getElementById("descri").value=a;
}

function solicitud_grado(){
        var nas = jQuery.noConflict();
        nas(document).ready(function() {
                    nas("#element").show()
                    nas("#boton_solicitud").hide()
                })
        if(confirm('¿Añadir Solicitud?')){
            nas.ajax({
                url:   'solicitud_grado',
                type:  'POST',
                beforeSend: function() { nas('#loader_gif').fadeIn("slow");
                                         nas("#element").html("Procesando, espere por favor..."); 
                },
                success:  function (response) {
                            nas("#element").html(response);
                },
        });
        }
}


function mas(mat){
        var nas = jQuery.noConflict();
        nas(document).ready(function() {
                    nas("#elemento"+mat).show()
                    nas("#hide"+mat).show()
                    nas("#show"+mat).hide()
        })
}

function menos(mat){
        var nas = jQuery.noConflict();
        nas(document).ready(function() {
                    nas("#elemento"+mat).hide()
                    nas("#hide"+mat).hide()
                    nas("#show"+mat).show()
        })
}

function can_sol() {
        var nas = jQuery.noConflict();
        if(confirm('¿Cancelar Solicitud?')){
            nas.ajax({
                url:   'cancelar_solicitud',
                type:  'POST',
                beforeSend: function() { nas('#loader_gif').fadeIn("slow");
                                         nas("#element").html("Procesando, espere por favor..."); 
                },
                success:  function (response) {
                            nas("#element").html(response);
                },
        });
        }
    }


function solicitudGrado()
    {
    var jq = jQuery.noConflict();
    jq(document).ready(function() {
        jq('#form_sol_gra, #fat, #fo3').submit(function() {
            jq.ajax({
                type: 'POST',
                url: jq(this).attr('action'),
                data: jq(this).serialize(),
          beforeSend: function () {
                jq('#spinner').show();
                            jq("#capa").html("<b>Procesando, espere por favor...</b>");
                    },
                success: function(response) {
                    jq('#sol_grado').html(response);
                }
            })     
            return false;
        });
        })
    }



