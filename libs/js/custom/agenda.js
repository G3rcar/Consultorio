var mainAgenda = {

	docSeleccionado:0,
	fechaInicial:0,
	fechaActual:0,
	numSemana:0,


	cargarAgenda:function(idDoctor){
		var _t = this;
		_t.docSeleccionado = idDoctor;

		$.ajax({
			url:'stores/agenda.php',
			data:'action=rt_agenda&iddoctor='+idDoctor+'&fechainicial='+_t.fechaActual, dataType:'json', type:'POST',
			complete:function(datos){
				var T = jQuery.parseJSON(datos.responseText);
				var total = T.total;
				_t.removerTodo();
				for(var i=0;i<total;i++){
					rec = T.citas[i];
					_t.crearEvento(rec.id_cita,rec.posicion,rec.offset,rec.texto_uno,rec.texto_dos);
				}
				_t.agregarListeners()
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
			'<button class="btn btn-primary btn-hover" title="Agregar cita" onClick="citas.nuevaConsulta('+id+')"><i class="icon-plus icon-white"></i></button>'+
			'<button class="btn btn-primary btn-hover" title="Editar" onClick="citas.editar('+id+')"><i class="icon-edit icon-white"></i></button>'+
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
	},

	cargarDatosSemanas:function(t){
		var _t = this;
		var fechaEnv;
		switch(t){
			case 'anterior': tipo = 'data_anterior'; fechaEnv=_t.fechaActual; break;
			case 'siguiente': tipo = 'data_siguiente'; fechaEnv=_t.fechaActual; break;
			default: tipo = 'data_actual'; fechaEnv=_t.fechaInicial; break;
		}
		$.ajax({
			url:'stores/agenda.php',
			data:{ action:'data_semanas', tipo_cambio:tipo, fecha:fechaEnv },
			dataType:'json', type:'POST',
			complete:function(datos){
				var T = jQuery.parseJSON(datos.responseText);
				_t.fechaActual = T.primerDia;
				_t.numSemana = T.numSemana;
				$("#txtSemana").html(T.textoInfo);
				_t.refrescarAgenda(T.dias);
			}
		});
	},

	refrescarAgenda:function(dias){
		var _t = this;
		for(var i=0;i<7;i++){
			$("#txt_dia_"+(i+1)).html(dias[i]);
		}
		$('.table-fixed-header').fixedHeader();
		_t.removerTodo();
		_t.cargarAgenda(_t.docSeleccionado);
	},

	agregarListeners:function(){
		$('.has-events .practice').click(function(){
			var id = $(this).attr('p:id');
			console.log(id);
		});
	}


}

