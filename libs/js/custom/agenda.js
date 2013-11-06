var mainAgenda = {

	docSeleccionado:0,
	fechaInicial:0,

	cargarAgenda:function(idDoctor){
		var _t = this;
		_t.docSeleccionado = idDoctor;

		$.ajax({
			url:'stores/agenda.php',
			data:'action=rt_agenda&iddoctor='+idDoctor+'&fechainicial='+_t.fechaInicial, dataType:'json', type:'POST',
			complete:function(datos){
				var T = jQuery.parseJSON(datos.responseText);
				var total = T.total;
				for(var i=0;i<total;i++){
					rec = T.citas[i];
					_t.crearEvento(rec.id_cita,rec.posicion,rec.offset,rec.texto_uno,rec.texto_dos);
				}
				//humane.log(T.msg)
				//if(T.success=='true') cargarTabla();
			}
		});
	},

	obtenerEvento:function(id,offset,texto_uno,texto_dos){
		var ofs = (offset==0)?0:(offset+9);
		return '<table id="contenedor_'+id+'" class="item-agenda has-events" style="z-index:10;margin-top:'+ofs+'px" height="90%" width="100%"><tr><td><div id="evento_'+id+'" p:id="'+id+'" class="has-events row-fluid practice">'+
		'<span class="title">'+texto_uno+'</span>'+
		'<span class="lecturer">'+texto_dos+'</span> '+
		'<span class="buttons">'+
		//	'<button class="btn btn-primary btn-hover" title="Editar" onClick="citas.editar('+i+')"><i class="icon-edit icon-white"></i></button>'+
			'<button class="btn btn-primary btn-hover" title="Cancelar" onClick="citas.borrar('+id+')"><i class="icon-remove icon-white"></i></button>'+
		'</span> '+
		'</div></td></tr></table>';
	},

	crearEvento:function(id,idObj,offset,texto_uno,texto_dos){
		var _t = this;
		if(main.gO(idObj)){
			main.gO(idObj).innerHTML = _t.obtenerEvento(id,offset,texto_uno,texto_dos);
		}
	},

	removerEvento:function(id){
		var el = document.getElementById('contenedor_'+id);
		var parent = el.parentNode;
		parent.removeChild(el);
		var f = parent.attributes["p:fecha"].value;
		var h = parent.attributes["p:hora"].value;
		parent.innerHTML = "<span class='out-button'> <a href='#' onClick='citas.nueva("+f+",\""+h+"\")' title='Agregar'><i class='icon-plus'></i> </a> </span>"
		//Insertar lo otro
	},

	removerTodo:function(){
		var _t = this;
		$('.has-events .practice').each(function(index){
			var id = $(this).attr('p:id');
			console.log(id);
			_t.removerEvento(id);
		});
	}


}

