var mainAgenda = {

	docSeleccionado:0,
	fechaInicial:0,

	cargarAgenda:function(idDoctor){
		var _t = this;
		_t.docSeleccionado = idDoctor;

		$.ajax({
			url:'stores/agenda.php',
			data:'action=rt_agenda&iddoctor='+idDoctor+'&fechainicial'+_t.fechaInicial, dataType:'json', type:'POST',
			complete:function(datos){
				var T = jQuery.parseJSON(datos.responseText);
				var total = T.total;
				for(var i=0;i<total;i++){
					rec = T.citas[i];
					_t.crearEvento(rec.id_cita,rec.posicion,rec.texto_uno,rec.texto_dos);
				}
				//humane.log(T.msg)
				//if(T.success=='true') cargarTabla();
			}
		});

		/*
		_t.crearEvento(1,'h_5_d_1','Juan P&eacute;rez','Doc. Cerna');
		_t.crearEvento(2,'h_3_d_1','Manuel Salazar','Doc. Cerna');
		_t.crearEvento(3,'h_3_d_2','Carlos Perla','Doc. Cerna');
		_t.crearEvento(4,'h_4_d_3','Oscar Funes','Doc. Cerna');
		_t.crearEvento(5,'h_6_d_5','Sara Rodezno','Doc. Cerna');
		*/
	},

	obtenerEvento:function(id,texto_uno,texto_dos){
		return '<table id="contenedor_'+id+'" class="item-agenda has-events" height="90%" width="100%"><tr><td><div id="evento_'+id+'" p:id="'+id+'" class="has-events row-fluid practice">'+
		'<span class="title">'+texto_uno+'</span>'+
		'<span class="lecturer">'+texto_dos+'</span> '+
		'<span class="buttons">'+
		//	'<button class="btn btn-primary btn-hover" title="Editar" onClick="citas.editar('+i+')"><i class="icon-edit icon-white"></i></button>'+
			'<button class="btn btn-primary btn-hover" title="Cancelar" onClick="citas.borrar('+id+')"><i class="icon-remove icon-white"></i></button>'+
		'</span> '+
		'</div></td></tr></table>';
	},

	crearEvento:function(id,idObj,texto_uno,texto_dos){
		var _t = this;
		if(main.gO(idObj)){
			main.gO(idObj).innerHTML = _t.obtenerEvento(id,texto_uno,texto_dos);
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
	}


}

